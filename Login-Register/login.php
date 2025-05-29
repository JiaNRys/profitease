<?php
session_start();

// Database connection
$connect = new mysqli('localhost', 'root', '', 'profitease');
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

// Handle login logic
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password = $_POST['password'];

    $stmt = mysqli_prepare($connect, "SELECT user_id, password_hash FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password_hash'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $username;
            header("Location: ../Login-Register/sms-otp-verification/index.html");
            exit;
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "Username not found.";
    }

    mysqli_stmt_close($stmt);
    
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="../ProfitEasez/favicon-32x32.png">
    <title>Sign In - ProfitEase</title>
    <link rel="stylesheet" href="../Login-Register/style.css">
</head>
<body>
    <a href="../Landing-Page/landing.php" class="back-button-fa" aria-label="Go back">
  <i class="fas fa-circle-arrow-left"></i>
</a>
    <div class="background">
        <div class="overlay"></div>
        <div class="login-box">
            <h1>Sign In</h1>

            <?php if (!empty($error)): ?>
                <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <form method="POST" action="">
                <input type="text" name="username" placeholder="Business" required>
                <input type="password" name="password" placeholder="Password" required>

                <div class="options">
                    <label><input type="checkbox" name="remember"> Remember me</label>
                    <a href="reset.php">Forgot password?</a>
                </div>

                <button type="submit">Sign In</button>

                <div class="signup">
                    <p>New to ProfitEase? <a href="signup.php">Sign up now</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
