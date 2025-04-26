<div class="chart-container">
    <h2 class="chart-title">Model Performance Metrics</h2>
    <canvas id="performanceChart"></canvas>
</div>

    <script>
        const ctx = document.getElementById('performanceChart');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['True Positive', 'True Negative', 'False Positive', 'False Negative'],
                datasets: [{
                    label: 'Model Predictions',
                    data: [<?= $chartData['tp'] ?>, <?= $chartData['tn'] ?>, <?= $chartData['fp'] ?>, <?= $chartData['fn'] ?>],
                    backgroundColor: ['#4CAF50', '#2196F3', '#FFC107', '#F44336']
                }]
            }
        });
    </script>
