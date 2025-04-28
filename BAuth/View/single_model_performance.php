<h2>Performance for Model ID: <?= htmlspecialchars($modelId) ?></h2>

<div class="chart-container">
    <canvas id="performanceChart"></canvas>
</div>

<div class="back-button">
    <a href="?action=viewModel">← Back to Models</a>
</div>

<script>
const ctx = document.getElementById('performanceChart').getContext('2d');
const performanceChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['True Positive', 'True Negative', 'False Positive', 'False Negative'],
        datasets: [{
            label: 'Performance Counts',
            data: [
                <?= $performance['true_positive'] ?>,
                <?= $performance['true_negative'] ?>,
                <?= $performance['false_positive'] ?>,
                <?= $performance['false_negative'] ?>
            ],
            backgroundColor: [
                '#28a745',
                '#17a2b8',
                '#ffc107',
                '#dc3545'
            ],
            borderColor: [
                '#218838',
                '#117a8b',
                '#e0a800',
                '#c82333'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>