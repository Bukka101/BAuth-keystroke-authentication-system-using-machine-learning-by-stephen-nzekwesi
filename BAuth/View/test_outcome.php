<?php

$Call = new Enginess();

// Check if session data is available
if (!isset($_SESSION['performance_output'])) {
    echo "<script>alert('No test result found. Please run a test first.'); window.location.href='?action=test';</script>";
    exit;
}

// Show the performance outcome
$data = $_SESSION['performance_output'];
$actualUsername = $data['actual_username'];
$predictedUsername = $Call->get_username($data['predicted_user_id']);
?>
<section class="test-outcome">
    <h3>Test Prediction Outcome</h3>
    <div class="user-results">
        <p><strong>Actual Username:</strong> <?= htmlspecialchars($actualUsername) ?></p>
        <p><strong>Predicted Username:</strong> <?= htmlspecialchars($predictedUsername) ?></p>
    </div>

    <form method="POST">
        <input type="hidden" name="model_id" value="<?= htmlspecialchars($data['model_id']) ?>">
        <input type="hidden" name="actual_user_id" value="<?= htmlspecialchars($data['actual_user_id']) ?>">

        <button type="submit" name="performance" value="true_positive" class="btn-performance tp">True Positive</button>
        <button type="submit" name="performance" value="true_negative" class="btn-performance tn">True Negative</button>
        <button type="submit" name="performance" value="false_positive" class="btn-performance fp">False Positive</button>
        <button type="submit" name="performance" value="false_negative" class="btn-performance fn">False Negative</button>
    </form>
</section>