@extends('layouts.app')

@section('content')
<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
  <h1 class="mb-4">Frequent Itemsets (Tabel)</h1>
    @foreach($frequentItemsets as $k => $itemsets)
        <h4>L{{ $k }} (itemset size: {{ $k }})</h4>
        <table class="table table-bordered table-striped mb-5">
            <thead class="table-dark">
                <tr>
                    <th>Itemset</th>
                    <th>Count</th>
                    <th>Support</th>
                </tr>
            </thead>
            <tbody>
            @php
                $totalTrans = \App\Models\Data::count();
            @endphp
            @foreach($itemsets as $itemsetKey => $count)
                @php
                    $support = $totalTrans == 0 ? 0 : $count / $totalTrans;
                    $items = explode('|', $itemsetKey);
                @endphp
                <tr>
                    <td>{{ implode(', ', $items) }}</td>
                    <td>{{ $count }}</td>
                    <td>{{ round($support, 3) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endforeach

    <h1 class="mb-4">Association Rules (Tabel)</h1>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Antecedent</th>
                <th>Consequent</th>
                <th>Support</th>
                <th>Confidence</th>
            </tr>
        </thead>
        <tbody>
            @foreach($associationRules as $rule)
                @php
                    $ante = implode(', ', $rule['antecedent']);
                    $cons = implode(', ', $rule['consequent']);
                    // support & confidence
                    $support = round($rule['support'], 3);
                    $confidence = round($rule['confidence'] * 100, 2);
                @endphp
                <tr>
                    <td>[{{ $ante }}]</td>
                    <td>[{{ $cons }}]</td>
                    <td>{{ $support }}</td>
                    <td>{{ $confidence }} %</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr class="my-5">

    {{-- 
        ======================================
        Bagian Visualisasi Chart.js
        ======================================
    --}}

    <h2 class="mb-4">Visualisasi Apriori</h2>

    <div class="mb-5">
        <h4>1. Top 10 Frequent Itemsets (Bar Chart)</h4>
        <canvas id="barChart" width="600" height="300"></canvas>
    </div>

    <div class="mb-5">
        <h4>2. Association Rules (Scatter Chart)</h4>
        <canvas id="scatterChart" width="600" height="300"></canvas>
    </div>

    @php
        // -------------------------
        // PERSIAPAN DATA UNTUK CHART
        // -------------------------

        // (A) Flatten all itemsets & urutkan by support desc
        $allItemsets = [];
        $totalTrans = \App\Models\Data::count();

        foreach ($frequentItemsets as $k => $Lk) {
            foreach ($Lk as $itemsetKey => $count) {
                $supportVal = ($totalTrans == 0) ? 0 : $count / $totalTrans;
                $allItemsets[] = [
                    'itemset' => $itemsetKey,
                    'count'   => $count,
                    'support' => $supportVal
                ];
            }
        }

        usort($allItemsets, function($a, $b) {
            return $b['support'] <=> $a['support'];
        });

        // top 10
        $topItemsets = array_slice($allItemsets, 0, 10);

        // (B) Scatter data: confidence vs support
        //     label = "antecedent => consequent"
        $scatterRules = [];
        foreach ($associationRules as $rule) {
            $ante = implode(',', $rule['antecedent']);
            $cons = implode(',', $rule['consequent']);
            $label = $ante.' => '.$cons;

            $scatterRules[] = [
                'label' => $label,
                'confidence' => $rule['confidence'],
                'support'    => $rule['support']
            ];
        }
    @endphp
</div>

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Ambil data dari blade (server) ke JS
  const topItemsets = @json($topItemsets);
  const scatterRules = @json($scatterRules);

  // === BAR CHART: TOP 10 FREQUENT ITEMSETS ===
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
              backgroundColor: 'rgba(54, 162, 235, 0.5)',
              borderColor: 'rgba(54, 162, 235, 1)',
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
                          // Tampilkan support (3 desimal)
                          return 'Support: ' + context.parsed.x.toFixed(3);
                      }
                  }
              }
          }
      }
  });

  // === SCATTER CHART: ASSOCIATION RULES ===
  // Format data => {x: confidence, y: support, label: ...}
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
              backgroundColor: 'rgba(255, 99, 132, 0.5)'
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


