<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Balance Sheet</title>
    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
   <link rel="icon" type="image/x-icon" href="../ProfitEasez/favicon-32x32.png">
</head>
<body>
     
      <!-- /. NAV BAR  -->
      <?php include '../com/includes/navheader.php'; 
        include '../com/includes/navtop.php';
    ?>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" class="content">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <h2>BALANCE SHEET</h2>   
                    </div>
                </div>              

                  <!-- Date Filter Form -->
                  <form method="get" action="" class="form-inline" style="margin-bottom: 20px;">
                      <div class="form-group">
                          <label for="bs_start_date">From:</label>
                          <input type="date" id="bs_start_date" name="bs_start_date" class="form-control" 
                                 value="<?php echo isset($_GET['bs_start_date']) ? $_GET['bs_start_date'] : date('Y-m-01'); ?>">
                      </div>
                      <div class="form-group" style="margin-left: 10px;">
                          <label for="bs_end_date">To:</label>
                          <input type="date" id="bs_end_date" name="bs_end_date" class="form-control" 
                                 value="<?php echo isset($_GET['bs_end_date']) ? $_GET['bs_end_date'] : date('Y-m-t'); ?>">
                      </div>
                      <button type="submit" class="btn btn-primary" style="margin-left: 10px;">Filter</button>
                      <button type="button" onclick="window.location.href='?'" class="btn btn-default" style="margin-left: 10px;">
                          Clear
                      </button>
                  </form>
                   <!-- /. ROW  -->
                  <hr />

                  <div>
       <?php
// Connect to the database
require_once 'connection.php';

// Get date filter values (with defaults to current month)
$start_date = $_GET['bs_start_date'] ?? date('Y-m-01');
$end_date = $_GET['bs_end_date'] ?? date('Y-m-t');

// Validate dates
$start_date = date('Y-m-d', strtotime($start_date));
$end_date = date('Y-m-d', strtotime($end_date));

// Fetch asset, liability, and equity accounts
$sql_assets = "SELECT account_id, account_name FROM accounts WHERE account_type = 'asset'";
$sql_liabilities = "SELECT account_id, account_name FROM accounts WHERE account_type = 'liability'";
$sql_equity = "SELECT account_id, account_name FROM accounts WHERE account_type = 'equity'";

$result_assets = $conn->query($sql_assets);
$result_liabilities = $conn->query($sql_liabilities);
$result_equity = $conn->query($sql_equity);

// Totals
$total_assets = 0;
$total_liabilities = 0;
$total_equity = 0;

echo '<table class="table table-striped table-bordered table-hover">';
echo '<tr><th>Assets</th><th>Amount</th><th>Liabilities and Equity</th><th>Amount</th></tr>';

// ========== ASSETS ==========
while ($row_assets = $result_assets->fetch_assoc()) {
    $account_id = $row_assets['account_id'];
    $account_name = $row_assets['account_name'];

    $sql_amount = "SELECT SUM(j.debit_amount - j.credit_amount) AS total_amount 
                   FROM journalEntries j
                   JOIN transactions t ON j.transaction_id = t.transaction_id
                   WHERE j.account_id = $account_id
                   AND t.transaction_date BETWEEN '$start_date' AND '$end_date'";
    $result_amount = $conn->query($sql_amount);
    $amount = $result_amount->fetch_assoc()['total_amount'];

    if ($amount != 0) {
        echo '<tr><td>' . htmlspecialchars($account_name) . '</td><td>' . number_format($amount, 2) . '</td><td></td><td></td></tr>';
        $total_assets += $amount;
    }
}

// ========== LIABILITIES ==========
$rows_liab = [];
while ($row_liabilities = $result_liabilities->fetch_assoc()) {
    $account_id = $row_liabilities['account_id'];
    $account_name = $row_liabilities['account_name'];

    $sql_amount = "SELECT SUM(j.credit_amount - j.debit_amount) AS total_amount 
                   FROM journalEntries j
                   JOIN transactions t ON j.transaction_id = t.transaction_id
                   WHERE j.account_id = $account_id
                   AND t.transaction_date BETWEEN '$start_date' AND '$end_date'";
    $result_amount = $conn->query($sql_amount);
    $amount = $result_amount->fetch_assoc()['total_amount'];

    if ($amount != 0) {
        $rows_liab[] = ['name' => $account_name, 'amount' => $amount];
        $total_liabilities += $amount;
    }
}

// ========== EQUITY ==========
$rows_equity = [];
while ($row_equity = $result_equity->fetch_assoc()) {
    $account_id = $row_equity['account_id'];
    $account_name = $row_equity['account_name'];

    $sql_amount = "SELECT SUM(j.credit_amount - j.debit_amount) AS total_amount 
                   FROM journalEntries j
                   JOIN transactions t ON j.transaction_id = t.transaction_id
                   WHERE j.account_id = $account_id
                   AND t.transaction_date BETWEEN '$start_date' AND '$end_date'";
    $result_amount = $conn->query($sql_amount);
    $amount = $result_amount->fetch_assoc()['total_amount'];

    if ($amount != 0) {
        $rows_equity[] = ['name' => $account_name, 'amount' => $amount];
        $total_equity += $amount;
    }
}

// Combine liabilities and equity for display
$combined_rows = array_merge($rows_liab, $rows_equity);
$max_rows = max(count($combined_rows), 0);

// Print liabilities/equity in separate cells aligned with empty asset cells
for ($i = 0; $i < $max_rows; $i++) {
    $name = htmlspecialchars($combined_rows[$i]['name']);
    $amount = number_format($combined_rows[$i]['amount'], 2);
    echo '<tr><td></td><td></td><td>' . $name . '</td><td>' . $amount . '</td></tr>';
}

// ========== TOTALS ==========
echo '<tr>';
echo '<th>Total Assets</th><th>' . number_format($total_assets, 2) . '</th>';
echo '<th>Total Liabilities and Equity</th><th>' . number_format($total_liabilities + $total_equity, 2) . '</th>';
echo '</tr>';

echo '</table>';

// Show date range
echo "<p class='text-muted'>Showing entries from " . date('d M Y', strtotime($start_date)) . " to " . date('d M Y', strtotime($end_date)) . "</p>";

// Close DB connection
$conn->close();
?>

    </div>         
                 <!-- /. ROW  -->           
    </div>
             <!-- /. PAGE INNER  -->

            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
        <!-- /. Footer  -->
    <?php include 'footer.php'; ?>
   <?php include '../com/includes/scripts.php'; ?>
    <script>
    function printTable() {
        var newWindow = window.open('', '_blank');
        newWindow.document.write('<html><head><title>Balance Sheet Report</title>');
        newWindow.document.write('<link rel="stylesheet" href="assets/css/bootstrap.css">');
        newWindow.document.write('<style>table { width: 100%; border-collapse: collapse; } th, td { border: 1px solid #000; padding: 8px; text-align: left; }</style>');
        newWindow.document.write('</head><body>');
        newWindow.document.write(document.querySelector('.content').innerHTML);
        newWindow.document.write('</body></html>');
        newWindow.document.close();
        newWindow.focus();
        newWindow.print();
        newWindow.close();
    }
    </script>
</html>
