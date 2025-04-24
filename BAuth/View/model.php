
<h2>Train Model</h2>

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

      <label>Choose Folder to Save Model:</label><br>
    <!-- Hidden folder picker -->
    <input type="file" id="folderInput" webkitdirectory directory style="display:none;" onchange="getFolderName(this)">
    
    <!-- Text input to display selected folder -->
    <input type="text" name="save_path" id="savePath" readonly required placeholder="Select a folder...">
    <button type="button" onclick="document.getElementById('folderInput').click()">Browse</button><br><br>


            <!-- Train and Cancel Buttons -->
            <button type="submit" name="train">Train</button>
            <button type="reset">Cancel</button>
        </form>
    </section>

 <script>
function getFolderName(input) {
    if (input.files.length > 0) {
        const relativePath = input.files[0].webkitRelativePath;
        const folder = relativePath.split('/')[0];
        document.getElementById('savePath').value = '/' + folder + '/';
    }
}
</script>

   

   
