<h2 class="models-title">View Models</h2>

<section id="view" class="models-section">
    <div class="table-container">
        <table class="models-table">
            <thead>
                <tr>
                    <th>Model ID</th>
                    <th>Model Name</th>
                    <th>Model Type</th>
                    <th>Date Trained</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $Call = new Enginess();
                    $result = $Call->fetch_models();
                    // echo rows here
                ?>
            </tbody>
        </table>
    </div>
</section>
