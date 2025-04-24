<?php
session_start();
$data = $_SESSION['eval_result'] ?? null;
if (!$data) {
   require_once 'View/test.php';
    exit;
}
?>

<div class="result-box">
    <h2>Authentication Evaluation</h2>
    <p><strong>User:</strong> <?= htmlspecialchars($data['username']) ?></p>
    <p><strong>Avg Keystroke Interval:</strong> <?= $data['inputAvg'] ?> ms</p>
    <h3><?= $data['resultLabel'] ?></h3>

    <div class="metrics">
        <div class="metric true-positive">TP: <?= $data['resultType'] == 'TP' ? 1 : 0 ?></div>
        <div class="metric true-negative">TN: <?= $data['resultType'] == 'TN' ? 1 : 0 ?></div>
    </div>
    <div class="metrics">
        <div class="metric false-positive">FP: <?= $data['resultType'] == 'FP' ? 1 : 0 ?></div>
        <div class="metric false-negative">FN: <?= $data['resultType'] == 'FN' ? 1 : 0 ?></div>
    </div>
</div>