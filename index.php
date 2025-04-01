<?php session_start();?>
<?php require_once "Model/function.php";?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keystroke Authentication</title>
    <link rel="stylesheet" href="View/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="menu-icon">☰</div>
        <ul>
            <li><a href="?action=users">Users</a>
                <ul>
                    <li><a href="?action=users">View</a></li>
                    <li><a href="?action=users">Edit</a></li>
                    <li><a href="?action=users">Delete</a></li>
                </ul>
            </li>
            <li><a href="?action=model">Model</a>
                <ul>
                    <li><a href="?action=model">Train</a></li>
                    <li><a href="?action=viewModel">View</a></li>
                    <li><a href="?action=performance">Performance</a></li>
                </ul>
            </li>
            <li><a href="?action=authentication">Authentication</a>
                <ul>
                    <li><a href="?action=authentication">List by Auth Type</a></li>
                    <li><a href="?action=authentication">Assign</a></li>
                </ul>
            </li>
            <li><a href="?action=test">Test</a></li>
        </ul>
    </nav>
   
    <?php require_once 'Controller/control.php';?>
    
     <script src="script.js"></script>
</body>
</html>
