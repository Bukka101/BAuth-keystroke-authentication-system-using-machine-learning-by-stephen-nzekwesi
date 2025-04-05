
 <h2>Edit User</h2>

    <form action="" method="POST">
        <!-- User ID (Read-only) -->
        <label for="userID">User ID:</label>
        <input type="text" id="userID" name="user_id" value="<?php echo $info['user_id']; ?>" readonly><br><br>

        <!-- Username -->
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo $info['username']; ?>" required><br><br>

        <!-- Password -->
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" value="<?php echo $info['password']; ?>" required><br><br>

        <!-- Authentication Type Dropdown -->
        <label for="authType">Auth Type:</label>
        <select id="authType" name="auth_type">
            <option value="Password" <?php if ($info['auth_type'] == 'Password') echo 'selected'; ?>>Password</option>
            <option value="Keystroke" <?php if ($info['auth_type'] == 'Keystroke') echo 'selected'; ?>>Keystroke</option>
            <option value="Password + ks" <?php if ($info['auth_type'] == 'Password + ks') echo 'selected'; ?>>Password + ks</option>
        </select><br><br>

        <!-- Save & Clear Buttons -->
        <button type="submit" name="update">Save</button>
        <button type="reset">Clear All</button>
    </form>