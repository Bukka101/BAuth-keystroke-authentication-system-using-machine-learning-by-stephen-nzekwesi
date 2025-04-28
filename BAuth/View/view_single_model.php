<h2 class="model-details-title">Model Details</h2>

<table class="model-details-table">
    <tr>
        <th>Model ID</th>
        <td><?php echo $info['model_id']; ?></td>
    </tr>
    <tr>
        <th>Model Name</th>
        <td><?php echo htmlspecialchars($info['name']); ?></td>
    </tr>
    <tr>
        <th>Model Type</th>
        <td><?php echo htmlspecialchars($info['type']); ?></td>
    </tr>
    <tr>
        <th>Date Trained</th>
        <td><?php echo htmlspecialchars($info['date_trained']); ?></td>
    </tr>
    <tr>
        <th>Dataset File</th>
        <td><?php echo htmlspecialchars($info['dataset_name']); ?></td>
    </tr>
</table>

<div class="action-buttons">
    <a href="?action=turn_active&&model_id=<?php echo $info['model_id']; ?>" class="button assign">Activate</a> |
    <a href="?action=edit_model&&model_id=<?php echo $info['model_id']; ?>" class="button edit">Edit</a> |
    <a href="?action=delete_model&&model_id=<?php echo $info['model_id']; ?>" onclick='return confirm("Are you sure you want to delete this model?")' class="button back">Delete</a> |
    <a href="?action=model_performance&&model_id=<?php echo $info['model_id']; ?>" class="button edit">View Performance</a>
    <br><br>
    
</div>

<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this model?");
    }
</script>
