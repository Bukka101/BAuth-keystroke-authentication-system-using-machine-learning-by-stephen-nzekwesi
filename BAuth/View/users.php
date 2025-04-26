<h2 class="users-title">Users</h2>

<section id="view" class="users-section">
    <h3 class="users-subtitle">View Users</h3>

    <div class="table-container">
        <table class="users-table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Auth Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $Call = new Enginess();
                    $result = $Call->fetch_users();
                    // Assume each row is printed here dynamically
                ?>
            </tbody>
        </table>
    </div>
</section>
