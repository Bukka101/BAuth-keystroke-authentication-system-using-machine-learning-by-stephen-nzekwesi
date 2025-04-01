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
                <option value="default">Select Model Type</option>
                <option value="keystroke">Keystroke-based</option>
                <option value="mouse">Mouse Movement-based</option>
            </select><br><br>

            <!-- File Path -->
            <label for="filePath">File Path:</label>
            <input type="text" id="filePath" name="path" readonly required>
            <button type="button" onclick="browseFile()">Browse</button><br><br>

            <!-- Train and Cancel Buttons -->
            <button type="submit" name="train">Train</button>
            <button type="reset">Cancel</button>
        </form>
    </section>

    <script>
        function browseFile() {
            const fileInput = document.createElement("input");
            fileInput.type = "file";
            fileInput.onchange = (event) => {
                document.getElementById("filePath").value = event.target.files[0].name;
            };
            fileInput.click();
        }
    </script>
