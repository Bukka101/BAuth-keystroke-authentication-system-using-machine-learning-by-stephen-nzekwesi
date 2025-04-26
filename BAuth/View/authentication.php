<h2 class="auth-title">Authentication</h2>

<section id="list">
    <h3 class="list-title">List by Authentication Type</h3>
    <p class="auth-description">Displaying users categorized by authentication type...</p>

    <table class="auth-table">
        <tr>
            <th>User ID</th>
            <th>Authentication Type</th>
        </tr>
        <?php
            $Call = new Enginess();
            $result = $Call->list_auth_type();
        ?>
    </table>
</section>
