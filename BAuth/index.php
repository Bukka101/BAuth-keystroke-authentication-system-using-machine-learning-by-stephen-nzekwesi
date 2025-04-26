<?php session_start();?>
<?php require_once "Model/function.php";?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keystroke Authentication</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="View/style.css">
</head>
<body>
<nav class="navbar">
    <!-- Hamburger Menu Icon -->
    <div class="menu-icon" onclick="toggleMenu()">☰</div>

    <ul class="nav-links">
        <li class="nav-item">
            <a href="?action=home">Home</a>
        </li>
        <li class="nav-item">
            <a href="?action=users">Users</a>
            <ul class="dropdown">
                <li><a href="?action=users">View</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="?action=model">Model</a>
            <ul class="dropdown">
                <li><a href="?action=model">Train</a></li>
                <li><a href="?action=viewModel">View</a></li>
                <li><a href="?action=performance">Performance</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="?action=authentication">Authentication</a>
            <ul class="dropdown">
                <li><a href="?action=authentication">List by Auth Type</a></li>
                <li><a href="?action=assign_auth">Assign</a></li>
            </ul>
        </li>
        <li class="nav-item"><a href="?action=test">Test</a></li>
    </ul>
</nav>

    
    <main class="main-content">
        <?php require_once 'Controller/control.php';?>

    </main>
    
    <script src="View/script.js"></script>
</body>
</html>
