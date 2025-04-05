 <h2>View Models</h2>

 <section id="view">
       
        <table>
            <tr>
            <th>Model ID</th>
            <th>Model Name</th>
            <th>Model Type</th>
            <th>Date Trained</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>

        <?php
        $Call = new Enginess();
        $result = $Call ->fetch_models();
        
        ?>

    </table>
    </section>
