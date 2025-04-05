<?php
// Get the full directory path of where the model will be saved
$modelSavePath = realpath(__DIR__) . DIRECTORY_SEPARATOR . "trained_models" . DIRECTORY_SEPARATOR;

// Ensure directory exists
if (!file_exists($modelSavePath)) {
    mkdir($modelSavePath, 0777, true);
}
?>
<h2>Model Management</h2>

   <section id="train">
        <form method="post" enctype="multipart/form-data">
            <!-- Model Name -->
            <label for="modelName">Model Name:</label>
            <input type="text" id="modelName" name="model_name" placeholder="Enter model name" required><br><br>

            <!-- Select Dataset -->
            <label for="dataset">Select Dataset (CSV):</label>
            <input type="file" id="dataset" name="dataset_name" accept=".csv" required><br><br>

            <!-- Model Type -->
            <label for="modelType">Model Type:</label>
            <select id="modelType" name="type" required>
                <option value="SVM">Select Model Type</option>
                <option value="Random Forest">Random Forest</option>
                <option value="SVM">SVM</option>
            </select><br><br>

        <label for="file_path">Select Folder to Save Model:</label>
        <input type="text" id="file_path" name="file_path" placeholder="Browse to select folder" readonly>
        <button type="button" onclick="selectFolder()">Browse</button>
        <br><br>

            <!-- Train and Cancel Buttons -->
            <button type="submit" name="train">Train</button>
            <button type="reset">Cancel</button>
        </form>
    </section>

   <script>
        function selectFolder() {
            const input = document.createElement("input");
            input.type = "file";
            input.setAttribute("nwdirectory", ""); // Works in NW.js
            input.setAttribute("webkitdirectory", ""); // Works in Chrome-based browsers
            input.setAttribute("directory", ""); // Standard attribute

            input.onchange = function(event) {
                if (event.target.files.length > 0) {
                    let path = event.target.files[0].path || event.target.files[0].webkitRelativePath;
                    document.getElementById("file_path").value = path.substring(0, path.lastIndexOf("/"));
                }
            };

            input.click();
        }
    </script>

