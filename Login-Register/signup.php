<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up - ProfitEase</title>
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
            <h1>Sign Up</h1>

            <?php if (!empty($error)): ?>
                <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
            <?php elseif (!empty($success)): ?>
                <p style="color: lightgreen;"><?php echo $success; ?></p>
            <?php endif; ?>

            <form method="POST" action="">
                <input type="text" name="email" placeholder="Business Email Address" required>
                <input type="text" name="username" placeholder="Business Name" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm password" required>

                <button type="submit">Sign Up</button>

                <div class="signup">
                    <p>Already have an account? <a href="login.php">Sign in</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

<?php
session_start();

// Database connection
$connect = new mysqli('localhost', 'root', '', 'profitease');
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim(mysqli_real_escape_string($connect, $_POST['email']));
    $username = trim(mysqli_real_escape_string($connect, $_POST['username']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Check if username already exists
        $stmt = mysqli_prepare($connect, "SELECT user_id FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $error = "Username already taken.";
        } else {
            // Insert new user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert_stmt = mysqli_prepare($connect, "INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($insert_stmt, "sss", $username, $email, $hashed_password);

            if (mysqli_stmt_execute($insert_stmt)) {
                $success = "Account created successfully! You can now <a href='login.php'>log in</a>.";
            } else {
                $error = "Failed to create account. Please try again.";
            }

            mysqli_stmt_close($insert_stmt);
        }

        mysqli_stmt_close($stmt);
    }
    header("Location: ../Login-Register/sms-otp-verification/index.html");
    exit;
}
?>
