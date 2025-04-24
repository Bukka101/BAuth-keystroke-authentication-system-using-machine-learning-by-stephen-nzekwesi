
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

     
            <!-- Train and Cancel Buttons -->
            <button type="submit" name="train">Train</button>
            <button type="reset">Cancel</button>
        </form>
    </section>



   

   
