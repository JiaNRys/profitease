<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ledger</title>
    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
   <link rel="icon" type="image/x-icon" href="../ProfitEasez/favicon-32x32.png">
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
                     <h2>LEDGER ACCOUNTS</h2>   
                    </div>
                </div>              
                
                <!-- Date Filter Form -->
                <form method="get" action="" class="form-inline" style="margin-bottom: 20px;">
                    <div class="form-group">
                        <label for="start_date">From:</label>
                        <input type="date" id="start_date" name="start_date" class="form-control" 
                               value="<?php echo isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>" style="margin-right: 10px;">
                    </div>
                    <div class="form-group">
                        <label for="end_date">To:</label>
                        <input type="date" id="end_date" name="end_date" class="form-control" 
                               value="<?php echo isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>" style="margin-right: 10px;">
                    </div>
                    <button type="submit" class="btn btn-primary" style="margin-right: 5px;">Filter</button>
                    <button type="button" onclick="window.location.href='?'" class="btn btn-default">Clear</button>
                </form>
                
                <hr />
                
                <div>
                    <?php
                    // Connect to the database
                    require_once 'connection.php';

                    // Initialize date filter condition
                    $dateFilter = '';
                    if (isset($_GET['start_date']) && isset($_GET['end_date']) && 
                        !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
                        
                        $startDate = $_GET['start_date'];
                        $endDate = $_GET['end_date'];
                        
                        // Validate dates
                        if ($startDate > $endDate) {
                            // Swap if wrong order
                            $temp = $startDate;
                            $startDate = $endDate;
                            $endDate = $temp;
                        }
                        
                        $dateFilter = " AND t.transaction_date BETWEEN '$startDate' AND '$endDate'";
                    }

                    // Fetch all unique account IDs and names from the Accounts table
                    $sql_accounts = "SELECT account_id, account_name, account_type FROM accounts";
                    $result_accounts = $conn->query($sql_accounts);

                    if ($result_accounts->num_rows > 0) {
                        // Loop through each account and display its ledger details in a separate table
                        while ($row_account = $result_accounts->fetch_assoc()) {
                            $account_id = $row_account['account_id'];
                            $account_name = $row_account['account_name'];
                            $account_type = $row_account['account_type'];

                            // Determine whether to show Dr (Debit) side or Cr (Credit) side based on the account type
                            $is_debit_account = ($account_type === 'asset' || $account_type === 'expense') ? true : false;

                            // Prepare the SQL statement to fetch transactions for the specified account with date filter
                            $sql = "SELECT t.transaction_date, j.description, j.debit_amount, j.credit_amount
                                    FROM transactions t
                                    INNER JOIN journalEntries j ON t.transaction_id = j.transaction_id
                                    WHERE j.account_id = $account_id $dateFilter
                                    ORDER BY t.transaction_date";

                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                // Display the ledger account details in a table
                                echo '<div class="ledger-account">';
                                echo '<h3>' . htmlspecialchars($account_name) . ' (' . strtoupper($account_type) . ')</h3>';
                                echo '<table class="table table-striped table-bordered table-hover">';
                                echo '<tr><th>Date</th><th>Description</th><th>Debit</th><th>Credit</th></tr>';

                                $balance = 0;

                                while ($row = $result->fetch_assoc()) {
                                    $debit_amount = $row['debit_amount'];
                                    $credit_amount = $row['credit_amount'];
                                    $balance += ($is_debit_account ? ($debit_amount - $credit_amount) : ($credit_amount - $debit_amount));

                                    echo '<tr>';
                                    echo '<td>' . htmlspecialchars($row['transaction_date']) . '</td>';
                                    echo '<td>' . htmlspecialchars($row['description']) . '</td>';
                                    echo '<td>' . ($debit_amount > 0 ? number_format($debit_amount, 2) : '') . '</td>';
                                    echo '<td>' . ($credit_amount > 0 ? number_format($credit_amount, 2) : '') . '</td>';
                                    echo '</tr>';
                                }

                                // Display the final balance on the Dr (Debit) or Cr (Credit) side
                                echo '<tr class="total-row">';
                                echo '<td colspan="2" align="right"><strong>Total ' . ($is_debit_account ? 'Debit' : 'Credit') . '</strong></td>';
                                echo '<td>' . ($is_debit_account ? number_format($balance, 2) : '') . '</td>';
                                echo '<td>' . (!$is_debit_account ? number_format($balance, 2) : '') . '</td>';
                                echo '</tr>';

                                echo '</table>';
                                echo '</div>';
                            }
                        }
                    } else {
                        echo '<div class="alert alert-warning">No accounts found.</div>';
                    }
                        
                    // Close the database connection
                    $conn->close();
                    ?>
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
        newWindow.document.write('<html><head><title>Ledger Report</title>');
        newWindow.document.write('<link rel="stylesheet" href="assets/css/bootstrap.css">');
        newWindow.document.write('<style>');
        newWindow.document.write('table { width: 100%; border-collapse: collapse; }');
        newWindow.document.write('th, td { border: 1px solid #000; padding: 8px; text-align: left; }');
        newWindow.document.write('.ledger-account { margin-bottom: 30px; }');
        newWindow.document.write('.total-row { font-weight: bold; background-color: #f5f5f5; }');
        newWindow.document.write('</style>');
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
