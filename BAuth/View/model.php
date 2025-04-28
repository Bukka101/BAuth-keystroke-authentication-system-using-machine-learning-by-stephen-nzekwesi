<h2 class="train-title">Train Model</h2>

<section id="train" class="train-section">
    <form class="train-form" method="post" enctype="multipart/form-data">
        <!-- Model Name -->
        <div class="form-group">
            <label for="modelName">Model Name:</label>
            <input type="text" id="modelName" name="model_name" placeholder="Enter model name" required>
        </div>

        <!-- Select Dataset -->
        <div class="form-group">
            <label for="dataset">Select Dataset (CSV):</label>
            <input type="file" id="dataset" name="dataset_name" accept=".csv" required>
        </div>

        <!-- Model Type -->
        <div class="form-group">
            <label for="modelType">Model Type:</label>
            <select id="modelType" name="type" required>
                <option value="" disabled selected>Select Model Type</option> <!-- Empty value, disabled and selected -->
                <option value="RF">RF</option>
                <option value="SVM">SVM</option>
            </select>
        </div>


        <!-- Buttons -->
        <div class="form-buttons">
            <button class="btn" type="submit" name="train">Train</button>
            <button class="btn cancel" type="reset">Cancel</button>
        </div>
    </form>
</section>
