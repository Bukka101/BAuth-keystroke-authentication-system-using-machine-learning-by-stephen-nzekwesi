
<h2>Model Performance</h2>

<!-- 🔥 The dropdown always at top -->
<div class="model-select">
    <form id="modelForm" method="GET" action="">
        <input type="hidden" name="action" value="model_performance">
        <select name="model_id" onchange="document.getElementById('modelForm').submit();">
            <?php foreach ($modelList as $model): ?>
                <option value="<?= htmlspecialchars($model['model_id']) ?>"
                    <?= ($model['model_id'] == $selectedModelId) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($model['name']) ?> (ID: <?= htmlspecialchars($model['model_id']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </form>
</div>

<!-- Display selected model name and type -->
<h3><?= htmlspecialchars($activeModelInfo['name']) ?> (<?= htmlspecialchars($activeModelInfo['type']) ?>)</h3>

<!-- The chart -->
<div class="chart-container">
    <canvas id="performanceChart"></canvas>
</div>

<div class="back-button">
    <a href="?action=viewModel">← Back to Models</a>
</div>

<!-- Chart.js setup -->
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
        animation: {
            duration: 1500, // ⏳ 1.5 seconds animation
            easing: 'easeOutBounce' // 🎢 smooth bounce effect
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

</script>
