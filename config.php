<?php
$host = 'sql207.infinityfree.com'; // replace with your host (shown in cPanel)
$db   = 'if0_39111481_profitease';
$user = 'if0_39111481';
$pass = 'riXpF73IpAhqGG';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
