 <h2>Users</h2>
    <section id="view">
        <h3>View Users</h3>
        <table>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Password</th>
                <th>Auth Type</th>
                <th>Action</th>
            </tr>
          <?php
        $Call = new Enginess();
        $result = $Call ->fetch_users();
        
        ?>
        </table>
    </section>
