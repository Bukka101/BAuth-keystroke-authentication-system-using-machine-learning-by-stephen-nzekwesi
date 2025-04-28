<h2 class="edit-user-title">Edit User</h2>

<form class="edit-user-form" action="" method="POST">
    <!-- User ID (Read-only) -->
    <label for="userID" class="form-label">User ID:</label>
    <input type="text" id="userID" name="user_id" value="<?php echo $info['user_id']; ?>" readonly class="form-input"><br><br>

    <!-- Username -->
    <label for="username" class="form-label">Username:</label>
    <input type="text" id="username" name="username" value="<?php echo $info['username']; ?>" required class="form-input"><br><br>

    <!-- Password -->
    <label for="password" class="form-label">Password:</label>
    <input type="password" id="password" name="password" value="<?php echo $info['password']; ?>" required class="form-input"><br><br>

    <!-- Authentication Type Dropdown -->
    <label for="authType" class="form-label">Auth Type:</label>
    <select id="authType" name="auth_type" class="form-select">
        <option value="Password" <?php if ($info['auth_type'] == 'Password') echo 'selected'; ?>>Password</option>
        <option value="Password + ks" <?php if ($info['auth_type'] == 'Password + ks') echo 'selected'; ?>>Password + ks</option>
    </select><br><br>

    <!-- Save & Clear Buttons -->
    <button type="submit" name="update" class="form-btn save-btn">Save</button>
    <button type="reset" name="back" class="form-btn reset-btn">Clear</button>
</form>
