<h2 class="edit-model-title">Edit Model</h2>

<form class="edit-model-form" action="" method="POST" enctype="multipart/form-data">
    <!-- Model ID (Read-only) -->
    <label for="modelID" class="form-label">Model ID:</label>
    <input type="text" id="model_id" name="model_id" value="<?php echo $info['model_id']; ?>" readonly class="form-input"><br><br>

    <!-- Model Name -->
    <label for="modelName" class="form-label">Model Name:</label>
    <input type="text" id="modelName" name="model_name" value="<?php echo $info['name']; ?>" class="form-input"><br><br>

    <!-- Model Type Dropdown -->
    <label for="modelType" class="form-label">Model Type:</label>
    <input type="text" id="modelType" name="modelType" value="<?php echo $info['type']; ?>" readonly class="form-input"><br><br><br><br>

    <!-- File Path (Browse Option) -->
    <label for="filePath" class="form-label">Dataset File:</label>
    <input type="text" id="filePathText" name="file_path" value="<?php echo $info['dataset_name']; ?>" readonly class="form-input"><br><br>

    <!-- Save & Reset Buttons -->
    <button type="submit" name="update_model" class="form-btn save-btn">Save</button>
    <button type="reset" class="form-btn reset-btn">Clear All</button>
</form>

<script>
    function updateFilePath() {
        var fileInput = document.getElementById('filePath');
        var filePathText = document.getElementById('filePathText');
        filePathText.value = fileInput.value.replace(/^.*[\\\/]/, ''); // Extracts only file name
    }
</script>
