
        <h2>Edit Model</h2>

    <form action="" method="POST" enctype="multipart/form-data">
        <!-- Model ID (Read-only) -->
        <label for="modelID">Model ID:</label>
        <input type="text" id="model_id" name="model_id" value="<?php echo $info['model_id']; ?>" readonly><br><br>

        <!-- Model Name -->
        <label for="modelName">Model Name:</label>
        <input type="text" id="modelName" name="model_name" value="<?php echo $info['name']; ?>" required><br><br>

        <!-- Model Type Dropdown -->
        <label for="modelType">Model Type:</label>
        <select id="modelType" name="modelType">
            <option value="keystroke" <?php if ($info['type'] == 'keystroke') echo 'selected'; ?>>Keystroke-based</option>
            <option value="mouse" <?php if ($info['type'] == 'mouse') echo 'selected'; ?>>Mouse Movement-based</option>
        </select><br><br>

        <!-- File Path (Browse Option) -->
        <label for="filePath">Dataset File:</label>
        <input type="file" id="filePath" name="dataset_name" accept=".csv" onchange="updateFilePath()" required>
        <input type="text" id="filePathText" name="file_path" value="<?php echo $info['dataset_name']; ?>" readonly><br><br>

        <!-- Save & Reset Buttons -->
        <button type="submit" name="update_model">Save</button>
        <button type="reset">Clear All</button>
    </form>

    <script>
        function updateFilePath() {
            var fileInput = document.getElementById('filePath');
            var filePathText = document.getElementById('filePathText');
            filePathText.value = fileInput.value.replace(/^.*[\\\/]/, ''); // Extracts only file name
        }
    </script>