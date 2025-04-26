<div class="auth-assign-container">
    <h2 class="auth-assign-title">Assign Keystroke Authentication</h2>
    <table class="auth-assign-table">
        <tr>
            <th>User ID</th>
            <th>Authentication Type</th>
            <th>Action</th>
        </tr>
        <?php
            $Call = new Enginess();
            $result = $Call->auth_keystroke();
        ?>
    </table>
</div>
