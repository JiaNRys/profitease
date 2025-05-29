<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - ProfitEase</title>
    <link rel="stylesheet" href="asset/style.css">
</head>
<body>
    <div class="background">
        <div class="overlay"></div>
        <div class="login-box">
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <p>This is your dashboard.</p>
            <a href="logout.php"><button>Logout</button></a>
        </div>
    </div>
</body>
</html>
