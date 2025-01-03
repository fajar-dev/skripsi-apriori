@extends('layouts.app')

@section('content')
<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
    @foreach($frequentItemsets as $k => $itemsets)
        <div class="col-lg-12">
            <div class="card card-flush h-xl-100">
                <div class="card-header pt-7">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-gray-800">Frequent Itemsets</span>
                        <span class="text-gray-500 mt-1 fw-semibold fs-6">
                            L{{ $k }} (itemset size: {{ $k }})
                        </span>
                    </h3>
                </div>
                <div class="card-body pt-2 table-responsive">
                    @php
                        $totalTrans = \App\Models\Data::count();
                        $sortedItemsets = collect($itemsets)->sortByDesc(function($count, $itemsetKey) use ($totalTrans){
                            return ($totalTrans == 0) ? 0 : $count / $totalTrans;
                        });
                    @endphp
                    <table class="table align-middle table-row-dashed fs-6 gy-3">
                        <thead>
                            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-200px">Itemset</th>
                                <th class="text-end min-w-50px">Count</th>
                                <th class="text-end min-w-50px">Support</th>
                            </tr>
                        </thead>
                        <tbody class="fw-bold text-gray-600">
                        @foreach($sortedItemsets as $itemsetKey => $count)
                            @php
                                $items   = explode('|', $itemsetKey);
                                $support = ($totalTrans == 0) ? 0 : $count / $totalTrans;
                            @endphp
                            <tr>
                                <td>
                                    <span class="text-gray-800">
                                        {{ implode(', ', $items) }}
                                    </span>
                                </td>
                                <td class="text-end">{{ $count }}</td>
                                <td class="text-end">{{ round($support, 3) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach

    <div class="col-lg-12">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Association Rules</span>
                </h3>
            </div>
            <div class="card-body pt-2 table-responsive">
                @php
                    $sortedRules = collect($associationRules)->sortByDesc('confidence');
                @endphp

                <table class="table align-middle table-row-dashed fs-6 gy-3">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-200px">Antecedent</th>
                            <th class="min-w-200px">Consequent</th>
                            <th class="text-end min-w-50px">Support</th>
                            <th class="text-end min-w-50px">Confidence</th>
                            <th class="text-end min-w-50px">Leverage</th>
                        </tr>
                    </thead>
                    <tbody class="fw-bold text-gray-600">
                        @foreach($sortedRules as $rule)
                            @php
                                $ante       = implode(', ', $rule['antecedent']);
                                $cons       = implode(', ', $rule['consequent']);
                                $support    = round($rule['support'], 3);
                                $confidence = round($rule['confidence'] * 100, 2);
                                $leverage   = isset($rule['leverage'])
                                                ? round($rule['leverage'], 4)
                                                : 0; // default 0 jika tidak ada
                            @endphp
                            <tr>
                                <td>
                                    <span class="text-gray-800">
                                        [{{ $ante }}]
                                    </span>
                                </td>
                                <td>
                                    <span class="text-gray-800">
                                        [{{ $cons }}]
                                    </span>
                                </td>
                                <td class="text-end">{{ $support }}</td>
                                <td class="text-end">{{ $confidence }} %</td>
                                <td class="text-end">{{ $leverage }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bagian Chart -->
    <div class="col-lg-12">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">
                        Top 10 Frequent Itemsets (Bar Chart)
                    </span>
                </h3>
            </div>
            <div class="card-body pt-2">
                <canvas id="barChart" width="600" height="300"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">
                        Association Rules (Scatter Chart)
                    </span>
                </h3>
            </div>
            <div class="card-body pt-2">
                <canvas id="scatterChart" width="600" height="300"></canvas>
            </div>
        </div>
    </div>

    @php
        // Flatten semua itemsets => disatukan dalam array $allItemsets
        $allItemsets = [];
        $totalTrans = \App\Models\Data::count();

        foreach ($frequentItemsets as $level => $Lk) {
            foreach ($Lk as $itemsetKey => $count) {
                $supportVal = ($totalTrans == 0) ? 0 : $count / $totalTrans;
                $allItemsets[] = [
                    'itemset' => $itemsetKey,
                    'count'   => $count,
                    'support' => $supportVal
                ];
            }
        }

        // Urutkan $allItemsets berdasarkan support descending
        usort($allItemsets, function($a, $b) {
            return $b['support'] <=> $a['support'];
        });

        // Ambil top 10
        $topItemsets = array_slice($allItemsets, 0, 10);

        // Data scatter (confidence vs support)
        // label = "antecedent => consequent"
        $scatterRules = [];
        foreach ($sortedRules as $rule) {
            $ante = implode(',', $rule['antecedent']);
            $cons = implode(',', $rule['consequent']);
            $label = $ante.' => '.$cons;

            $scatterRules[] = [
                'label'      => $label,
                'confidence' => $rule['confidence'],
                'support'    => $rule['support']
            ];
        }
    @endphp
</div>

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // ===== BAR CHART: top 10 frequent itemsets ====
    const topItemsets = @json($topItemsets);
    const barLabels = topItemsets.map(d => d.itemset);
    const barSupports = topItemsets.map(d => d.support);

    const ctxBar = document.getElementById('barChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: barLabels,
            datasets: [{
                label: 'Support',
                data: barSupports,
                backgroundColor: '#1E2129',
                borderColor: '#1E2129',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y', // horizontal bar
            scales: {
                x: {
                    min: 0,
                    max: 1,
                    ticks: {
                        callback: function(value) {
                            return value;
                        }
                    }
                }
            },
            responsive: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Support: ' + context.parsed.x.toFixed(3);
                        }
                    }
                }
            }
        }
    });

    // ===== SCATTER CHART: association rules (confidence vs support) ====
    const scatterRules = @json($scatterRules);
    const scatterData = scatterRules.map(r => ({
        x: r.confidence,
        y: r.support,
        label: r.label
    }));

    const ctxScatter = document.getElementById('scatterChart').getContext('2d');
    new Chart(ctxScatter, {
        type: 'scatter',
        data: {
            datasets: [{
                label: 'Rules (confidence vs support)',
                data: scatterData,
                backgroundColor: '#1E2129'
            }]
        },
        options: {
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Confidence'
                    },
                    min: 0,
                    max: 1
                },
                y: {
                    title: {
                        display: true,
                        text: 'Support'
                    },
                    min: 0,
                    max: 1
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let lbl = context.raw.label || '';
                            let c = context.parsed.x.toFixed(3);
                            let s = context.parsed.y.toFixed(3);
                            return [
                                lbl,
                                'Confidence: ' + c,
                                'Support: ' + s
                            ];
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
@endsection
