<?php

use Livewire\Component;

new class extends Component {
    public $brands, $title, $class, $id;
};
?>

<div class="bg-white shadow rounded-md p-4 {{ $class }}" >
    <h5 class="text-2xl font-medium mb-6">{{ $title }}</h5>
    <canvas id="{{ $id }}"></canvas>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        (() => {
            let chartId = "{{ $id }}";
            let rawsLabel = @json($brands);
            
            let ctx = document.getElementById(chartId);
            
            let datasets = [{
                label: 'Total Siswa',
                data: Object.values(rawsLabel),
                backgroundColor: [ 'rgb(255, 99, 132)', 'rgb(75, 192, 192)', 'rgb(255, 205, 86)', 'rgb(201, 203, 207)', 'rgb(54, 162, 235)' ]
            }]
            let chart = new Chart(ctx, setDataChart('polarArea', { labels: Object.keys(rawsLabel), datasets }))
        })()
        
            
        function setDataChart(types, datas, opts = {}){
            let data = {
                type: types,
                data: {
                    labels: datas.labels,
                    datasets: datas.datasets
                },
                options: opts
            }
    
            return data
        }
    </script>
</div>
