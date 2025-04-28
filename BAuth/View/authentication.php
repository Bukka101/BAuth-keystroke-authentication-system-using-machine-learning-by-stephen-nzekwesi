<h2 class="auth-title">List Users by Authentication Type</h2>

<section id="list">
    <p class="auth-description">Displaying users categorized by authentication type...</p>
    
    <div class="model-select">
    <!-- Dropdown to select auth type -->
    <label for="authTypeDropdown"><strong>Filter by Auth Type:</strong></label>
    <select id="authTypeDropdown" onchange="filterUsers()" class="auth-dropdown">
        <option value="">All</option>
        <option value="Password">Password Only</option>
        <option value="Password + ks">Password + Keystroke</option>
    </select>
    </div>
    <br><br>

    <table class="auth-table" id="usersTable">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Authentication Type</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $Call = new Enginess();
            $users = $Call->list_users_by_auth_type(); // make sure this returns an array of users

            if (!empty($users)) {
                foreach ($users as $user) {
                    echo "<tr data-auth-type='".htmlspecialchars($user['auth_type'])."'>";
                    echo "<td>".htmlspecialchars($user['user_id'])."</td>";
                    echo "<td>".htmlspecialchars($user['username'])."</td>";
                    echo "<td>".htmlspecialchars($user['auth_type'])."</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No users found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</section>

<!-- JS to handle filtering -->
<script>
function filterUsers() {
    const selectedAuth = document.getElementById('authTypeDropdown').value;
    const rows = document.querySelectorAll('#usersTable tbody tr');

    rows.forEach(row => {
        const authType = row.getAttribute('data-auth-type');
        if (selectedAuth === "" || authType === selectedAuth) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
