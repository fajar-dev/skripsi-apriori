<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Services\AprioriService;
use Illuminate\Http\Request;

class AnalystController extends Controller
{
    public function index(){
        $data = [
            'title' => 'Analyst',
            'subTitle' => null,
        ];
        return view('pages.analyst',  $data);
    }

    public function apriori(Request $request)
    {
        $data = Data::all();

        $transactions = [];
        foreach ($data as $row) {
            $itemset = [];

            if (!empty($row->income)) {
                $itemset[] = "Income=" . $row->income;
            }
            if (!empty($row->spending)) {
                $itemset[] = "Spending=" . $row->spending;
            }
            if (!empty($row->job)) {
                $itemset[] = "Job=" . $row->job;
            }
            if (!empty($row->disability_type)) {
                $itemset[] = "Disability yype=" . $row->disability_type;
            }
            if (!empty($row->residence_condition)) {
                $itemset[] = "Residence condition=" . $row->residence_condition;
            }
            if (!empty($row->electricity_capacity)) {
                $itemset[] = "Electricity capacity=" . $row->electricity_capacity;
            }

            $transactions[] = $itemset;
        }

        $minSupport = $request->input('minSupport');     
        $minConfidence = $request->input('minConfidence');  
        $apriori = new AprioriService($transactions, $minSupport, $minConfidence);
        $apriori->run();

        $data = [
            'title' => 'Analyst',
            'subTitle' => null,
            'frequentItemsets' => $apriori->getFrequentItemsets(),
            'associationRules' => $apriori->getAssociationRules()
        ];        

        return view('pages.apriori', $data);
    }
}
