<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - ProfitEase</title>
    <link rel="stylesheet" href="../Login-Register/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="../ProfitEasez/favicon-32x32.png">
</head>
<body>
    <a href="login.php" class="back-button-fa" aria-label="Go back">
  <i class="fas fa-circle-arrow-left"></i>
</a>
    <div class="background">
        <div class="overlay"></div>
        <div class="login-box">
            <h1>Reset Password</h1>
            <?php if (!empty($message)): ?>
                <p><?php echo $message; ?></p>
            <?php endif; ?>
            <form method="POST">
                <input type="text" name="username" placeholder="Enter your Business Name" required>
                <input type="password" name="new_password" placeholder="New password" required>
                <input type="password" name="confirm_password" placeholder="Confirm new password" required>
                <button type="submit">Reset Password</button>
            </form>
        </div>
    </div>
</body>
</html>

<?php
$connect = new mysqli('localhost', 'root', '', 'profitease');
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $message = "Passwords do not match.";
    } else {
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = mysqli_prepare($connect, "UPDATE users SET password_hash = ? WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "ss", $hashed, $username);
        if (mysqli_stmt_execute($stmt)) {
            $message = "Password reset successful. <a href='login.php'>Login now</a>.";
        } else {
            $message = "Error resetting password.";
        }
        mysqli_stmt_close($stmt);
    }
}
?>
