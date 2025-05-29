<?php
session_start();
$conn = new mysqli("localhost", "root", "", "profitease");
$documents = $conn->query("SELECT * FROM documents ORDER BY created_at DESC");

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Dashboard - ProfitEase</title>
  <link rel="stylesheet" href="../Login-Register/asset/dashboardstyle.css">
  <link rel="icon" type="image/x-icon" href="../ProfitEasez/favicon-32x32.png">
</head>
<body>
<?php if (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
  <div style="background-color: #000dff; color: white; padding: 15px; text-align: center; font-weight: bold;">
    Document deleted successfully.
  </div>
<?php endif; ?>
<div class="background">
    <nav>
      <div class="nav-logo">ProfitEase</div>
      <div class="nav-links">
        <a href="../Login-Register/login.php">Sign Out</a>
      </div>
    </nav>
        <div class="overlay"></div>
         <div class="landing-content">

            <h1>Welcome to Your Dashboard<?php if(isset($_SESSION['username'])) { echo  ' '. htmlspecialchars($_SESSION['username']) ; } ?></h1>
            <h2>Manage Your Finances</h2>
        </div>

  <!-- Main Section -->
  <section class="about-section">
    <div class="tiles">
      <div class="tile" onclick="window.location.href='../com/transaction.php'" style="cursor:pointer;">
        <img src="https://img.icons8.com/ios-filled/50/document.png" alt="Transaction">
        <h3>Transaction</h3>
      </div>

      <div class="tile" onclick="window.location.href='../com/journal.php'" style="cursor:pointer;">
        <img src="https://img.icons8.com/ios-filled/50/book.png" alt="Journal">
        <h3>Journal</h3>
      </div>
      
      <div class="tile" onclick="window.location.href='../com/ledger.php'" style="cursor:pointer;">
        <img src="https://img.icons8.com/ios-filled/50/ledger.png" alt="Ledger">
        <h3>Ledger</h3>
      </div>
    </div>
  </section>

    <footer>
    &copy; <?php echo date("Y"); ?> ProfitEase. All rights reserved.
  </footer>
</div>
</body>
</html>
