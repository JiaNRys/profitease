<?php
session_start();
include "connection.php"; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['account_name']) && !empty($_POST['account_type'])) {

        $account_name = mysqli_real_escape_string($conn, trim($_POST['account_name']));
        $account_type = strtolower(mysqli_real_escape_string($conn, trim($_POST['account_type'])));

        $allowed_types = ['asset', 'expense', 'equity', 'liability', 'income'];

        if (in_array($account_type, $allowed_types)) {
            $query = "INSERT INTO accounts (account_name, account_type) VALUES ('$account_name', '$account_type')";

            if (mysqli_query($conn, $query)) {
                $_SESSION['comfrim'] = "Account created successfully!";
                header('Location: accounts.php');
                exit();
            } else {
                $_SESSION['comfrim'] = "Database error: " . mysqli_error($conn);
                header('Location: accounts.php');
                exit();
            }

        } else {
            $_SESSION['comfrim'] = "Invalid account type selected.";
            header('Location: accounts.php');
            exit();
        }

    } else {
        $_SESSION['comfrim'] = "Account Name and Account Type are required.";
        header('Location: accounts.php');
        exit();
    }
} else {
    $_SESSION['comfrim'] = "Invalid form submission.";
    header('Location: accounts.php');
    exit();
}
?>
