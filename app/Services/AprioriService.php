<?php

namespace App\Services;

class AprioriService
{
    protected $transactions;
    protected $minSupport;
    protected $minConfidence;
    protected $frequentItemsets;
    protected $associationRules;

    public function __construct($transactions, $minSupport = 0.2, $minConfidence = 0.6)
    {
        $this->transactions = $transactions;
        $this->minSupport = $minSupport;
        $this->minConfidence = $minConfidence;
        $this->frequentItemsets = [];
        $this->associationRules = [];
    }

    public function run()
    {
        $itemsets = $this->createInitialItemsets();
        $L = [];
        $k = 1;

        // Mencari frequent itemset level 1,2,3,... dst
        while (!empty($itemsets)) {
            $counts = $this->countItemsets($itemsets);
            $filtered = [];

            foreach ($counts as $itemset => $count) {
                $support = $count / count($this->transactions);
                if ($support >= $this->minSupport) {
                    $filtered[$itemset] = $count;
                }
            }

            if (empty($filtered)) {
                break;
            }

            // Simpan frequent itemset (Lk)
            $L[$k] = $filtered;

            // Generate kandidat itemset selanjutnya (dari Lk)
            $itemsets = $this->aprioriGen(array_keys($filtered), $k + 1);
            $k++;
        }

        $this->frequentItemsets = $L;
        $this->generateAssociationRules();
        return $this;
    }

    public function getFrequentItemsets()
    {
        return $this->frequentItemsets;
    }

    public function getAssociationRules()
    {
        return $this->associationRules;
    }

    private function createInitialItemsets()
    {
        // Kumpulkan semua item unik
        $items = [];
        foreach ($this->transactions as $t) {
            foreach ($t as $item) {
                $items[$item] = true;
            }
        }
        // Setiap item dijadikan set tunggal
        $initial = [];
        foreach ($items as $item => $v) {
            $initial[] = [$item];
        }
        return $initial;
    }

    private function countItemsets($itemsets)
    {
        $counts = [];
        foreach ($itemsets as $itemset) {
            sort($itemset);
            $itemsetKey = implode('|', $itemset);
            $counts[$itemsetKey] = 0;

            foreach ($this->transactions as $transaction) {
                if ($this->isSubset($itemset, $transaction)) {
                    $counts[$itemsetKey]++;
                }
            }
        }
        return $counts;
    }

    private function isSubset($subset, $set)
    {
        return count(array_intersect($subset, $set)) == count($subset);
    }

    private function aprioriGen($frequentItemsets, $k)
    {
        $candidates = [];
        $n = count($frequentItemsets);
        for ($i = 0; $i < $n; $i++) {
            for ($j = $i + 1; $j < $n; $j++) {
                $itemset1 = explode('|', $frequentItemsets[$i]);
                $itemset2 = explode('|', $frequentItemsets[$j]);

                // gabungkan itemset jika prefix sama
                $merged = array_unique(array_merge($itemset1, $itemset2));
                sort($merged);

                if (count($merged) == $k && $this->checkSubsets($merged, $frequentItemsets, $k - 1)) {
                    $candidates[] = $merged;
                }
            }
        }
        // hilangkan duplikat
        $uniqueCandidates = [];
        foreach ($candidates as $candidate) {
            $key = implode('|', $candidate);
            $uniqueCandidates[$key] = $candidate;
        }
        return array_values($uniqueCandidates);
    }

    private function checkSubsets($candidate, $frequentItemsets, $k_1)
    {
        // cek apakah semua subset dari candidate ada di frequentItemsets (L_{k-1})
        $subsets = $this->getSubsets($candidate, $k_1);
        foreach ($subsets as $subset) {
            $subsetKey = implode('|', $subset);
            if (!in_array($subsetKey, $frequentItemsets)) {
                return false;
            }
        }
        return true;
    }

    private function getSubsets($set, $size)
    {
        $subsets = [];
        $this->subsetRec($set, [], 0, $size, $subsets);
        return $subsets;
    }

    private function subsetRec($set, $current, $index, $size, &$result)
    {
        if (count($current) == $size) {
            $subset = $current;
            sort($subset);
            $result[] = $subset;
            return;
        }
        for ($i = $index; $i < count($set); $i++) {
            $this->subsetRec($set, array_merge($current, [$set[$i]]), $i + 1, $size, $result);
        }
    }

    private function generateAssociationRules()
    {
        // Ambil seluruh frequent itemset (k > 1)
        foreach ($this->frequentItemsets as $k => $itemsets) {
            if ($k == 1) continue; // tidak perlu cari rule untuk itemset 1

            foreach ($itemsets as $itemsetKey => $count) {
                $itemsetArray = explode('|', $itemsetKey);
                // cari seluruh subset non-kosong
                $allSubsets = $this->getSubsets($itemsetArray, count($itemsetArray) - 1);
                foreach ($allSubsets as $subset) {
                    $remaining = array_diff($itemsetArray, $subset);
                    if (empty($remaining)) continue;

                    // hitung support & confidence
                    $subsetKey = implode('|', $subset);
                    $subsetCount = $this->getCountFromFrequentItemsets($subsetKey);
                    $confidence = ($subsetCount == 0) ? 0 : ($count / $subsetCount);

                    $supportItemset = $count / count($this->transactions);
                    if ($confidence >= $this->minConfidence) {
                        $this->associationRules[] = [
                            'antecedent' => $subset,
                            'consequent' => array_values($remaining),
                            'support' => $supportItemset,
                            'confidence' => $confidence
                        ];
                    }
                }
            }
        }
    }

    private function getCountFromFrequentItemsets($itemsetKey)
    {
        // cari di semua Lk
        foreach ($this->frequentItemsets as $k => $itemsets) {
            if (isset($itemsets[$itemsetKey])) {
                return $itemsets[$itemsetKey];
            }
        }
        return 0;
    }
}
