    <div class="auth-assign-container">
        <h2>Assign Keystroke Authentication</h2>
        <table>
            <tr>
                <th>User ID</th>
                <th>Authentication Type</th>
                <th>Action</th>
                
            </tr>
          <?php
        $Call = new Enginess();
        $result = $Call ->auth_keystroke();
        
        ?>
        </table>
    </div>
