<?php
        $Call = new Enginess();
?>
<h2>Model Details</h2>

    <table border="1">
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

    <br>

    <!-- Action Buttons -->
    <a href="assign_auth.php?id=<?php echo $info['model_id']; ?>" class="button">Assign Auth</a> |
    <a href="?action=edit_model&&model_id=<?php echo $info['model_id']; ?>" class="button">Edit</a>
    <br><br>
    <a href="?action=viewModel">Back to Models</a>

    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this model?");
        }
    </script>
