 <h2>Authentication</h2>

    <section id="list">
        <h3>List by Authentication Type</h3>
        <p>Displaying users categorized by authentication type...</p>
         <table>
            <tr>
                <th>User ID</th>
                <th>Authentication Type</th>
                
            </tr>
          <?php
        $Call = new Enginess();
        $result = $Call ->list_auth_type();
        
        ?>
        </table>
    </section>
