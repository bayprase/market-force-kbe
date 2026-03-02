<?php

use Livewire\Component;

new class extends Component {
    public $class, $data, $title;
};
?>

<div class="bg-white shadow rounded-md p-4 {{ $class }}">
    <h5 class="text-2xl font-medium mb-6">{{ $title }}</h5>
    <canvas id="bar_x"></canvas>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://www.chartjs.org/docs/latest/scripts/utils.js"></script>

    <script>
        
        const data = {
            labels: getMonths(12),
            datasets: [{
                axis: 'y',
                label: 'My First Dataset',
                data: [65, 59, 80, 81, 56, 55, 40, 70, 80, 88, 99, 100],
                fill: false,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',   // merah muda
                    'rgba(255, 159, 64, 0.2)',   // oranye
                    'rgba(255, 205, 86, 0.2)',   // kuning
                    'rgba(75, 192, 192, 0.2)',   // hijau toska
                    'rgba(54, 162, 235, 0.2)',   // biru
                    'rgba(153, 102, 255, 0.2)',  // ungu
                    'rgba(201, 103, 107, 0.2)',  // brown
                    'rgba(255, 0, 0, 0.2)',      // merah
                    'rgba(0, 255, 0, 0.2)',      // hijau
                    'rgba(0, 0, 255, 0.2)',      // biru tua
                    'rgba(255, 165, 0, 0.2)',    // oranye terang
                    'rgba(128, 0, 128, 0.2)'     // ungu tua
                ],
                borderColor: [
                    'rgb(255, 99, 132)',   // merah muda
                    'rgb(255, 159, 64)',   // oranye
                    'rgb(255, 205, 86)',   // kuning
                    'rgb(75, 192, 192)',   // hijau toska
                    'rgb(54, 162, 235)',   // biru
                    'rgb(153, 102, 255)',  // ungu
                    'rgb(201, 203, 207)',  // brown
                    'rgb(255, 0, 0)',      // merah
                    'rgb(0, 255, 0)',      // hijau
                    'rgb(0, 0, 255)',      // biru tua
                    'rgb(255, 165, 0)',    // oranye terang
                    'rgb(128, 0, 128)'     // ungu tua
                ],
                borderWidth: 1
            }]
        };

        const config = {
            type: 'bar',
            data,
            options: {
                indexAxis: 'y',
            }
        };

        let charts = new Chart(document.querySelector('#bar_x'), config)

        function getMonths(count) {
            const months = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];
            return months.slice(0, count);
        }

        const labels = getMonths(7);
    </script>
</div>
