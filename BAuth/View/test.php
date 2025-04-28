  <section class="test-section">
    <h2 class="test-title">Test Login</h2>
    
    <form class="test-form" action="" method="POST">
        <div class="form-group">
            <label>Username:</label>
            <input type="text" name="username" required>
        </div>

        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>

        <div class="form-group">
            <label>Keystroke JSON Data:</label>
            <textarea name="json_data" rows="10"  placeholder='{"H.period": 0.062, ...}'></textarea>
        </div>

        <button class="btn" type="submit" name="test_login">Login</button>

        <div id="result-metrics" class="result-metrics"></div>
    </form>
</section>
