 <div class="login-container">
        <h2>Test Login</h2>
        <form action="" method="POST">
            <label>Username:</label>
            <input type="text" name="username" required><br>
            <label>Password:</label>
            <input type="password" name="password" required><br>

            <label>Keystroke Box (Type your password again):</label>
            <input type="text" name="keystroke_input" onkeydown="captureKeystrokes(event)" required><br>

            <input type="hidden" name="keystroke_data" id="keystroke_data">
            <button type="submit" name="test_login">Login</button>
        </form>
    </div>
    
    <script>
        let keystrokes = [];

        function captureKeystrokes(e) {
            const now = Date.now();
            keystrokes.push({ key: e.key, time: now });

            if (keystrokes.length > 1) {
                const interval = now - keystrokes[keystrokes.length - 2].time;
                keystrokes[keystrokes.length - 1].interval = interval;
            } else {
                keystrokes[keystrokes.length - 1].interval = 0;
            }

            document.getElementById("keystroke_data").value = JSON.stringify(keystrokes);
        }
    </script>
