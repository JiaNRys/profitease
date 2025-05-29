<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profit & Loss Account</title>
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
                     <h2>Profit & Loss Account</h2>   
                    </div>
                </div>              

                  <!-- Date Filter Form -->
                  <form method="get" action="" class="form-inline" style="margin-bottom: 20px;">
                      <div class="form-group">
                          <label for="start_date">From:</label>
                          <input type="date" id="start_date" name="start_date" class="form-control" 
                                 value="<?php echo isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01'); ?>">
                      </div>
                      <div class="form-group" style="margin-left: 10px;">
                          <label for="end_date">To:</label>
                          <input type="date" id="end_date" name="end_date" class="form-control" 
                                 value="<?php echo isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-t'); ?>">
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
        $start_date = $_GET['start_date'] ?? date('Y-m-01');
        $end_date = $_GET['end_date'] ?? date('Y-m-t');

        // Validate dates
        $start_date = date('Y-m-d', strtotime($start_date));
        $end_date = date('Y-m-d', strtotime($end_date));

        // Prepare the SQL statement to fetch income and expense accounts from the Accounts table
        $sql = "SELECT account_id, account_name, account_type FROM accounts 
                WHERE account_type = 'income' OR account_type = 'expense'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Initialize total revenues and total expenses
            $total_revenues = 0;
            $total_expenses = 0;

            // Display the table header
            echo '<table class="table table-striped table-bordered table-hover">';
            echo '<tr><th>Category</th><th>Amount</th></tr>';

            // Loop through the accounts and calculate the total revenues and total expenses
            while ($row = $result->fetch_assoc()) {
                $account_id = $row['account_id'];

                // Calculate the total debit and credit amounts for each account with date filtering
                $sql_amounts = "SELECT SUM(j.debit_amount) as total_debit, SUM(j.credit_amount) as total_credit 
                                FROM journalEntries j
                                JOIN transactions t ON j.transaction_id = t.transaction_id
                                WHERE j.account_id = $account_id
                                AND t.transaction_date BETWEEN '$start_date' AND '$end_date'";

                $result_amounts = $conn->query($sql_amounts);
                $row_amounts = $result_amounts->fetch_assoc();
 
                $debit_amount = $row_amounts['total_debit'] ?? 0;
                $credit_amount = $row_amounts['total_credit'] ?? 0;

                // Calculate the account balance
                $balance = $debit_amount - $credit_amount;

                // Update total revenues or total expenses based on the account type
                if ($row['account_type'] == 'income') {
                    $balance = $credit_amount - $debit_amount; // income = credits - debits
                    $total_revenues += $balance;
                } else {
                    $balance = $debit_amount - $credit_amount; // expenses = debits - credits
                    $total_expenses += $balance;
                }
                
                // Display the account name and balance in the table
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['account_name']) . '</td>';
                echo '<td>' . number_format($balance, 2) . '</td>';
                echo '</tr>';
            }

            // Calculate net income or loss
            $net_income_loss = $total_revenues - $total_expenses;

            // Display the total revenues, total expenses, and net income or loss
            echo '<tr>';
            echo '<td><strong>Revenue:</strong></td>';
            echo '<td></td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td>Sales Revenue</td>';
            echo '<td>' . number_format($total_revenues, 2) . '</td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td>Other Revenues</td>';
            echo '<td></td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td><strong>Total Revenue</strong></td>';
            echo '<td>' . number_format($total_revenues, 2) . '</td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td><strong>Expenses:</strong></td>';
            echo '<td></td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td>Cost of Goods Sold</td>';
            echo '<td>' . number_format($total_expenses, 2) . '</td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td>Gross Profit</td>';
            echo '<td>' . number_format($total_revenues - $total_expenses, 2) . '</td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td>Operating Expenses:</td>';
            echo '<td></td>';
            echo '</tr>';

            // Additional expense categories can be displayed here if needed

            echo '<tr>';
            echo '<td><strong>Total Operating Expenses</strong></td>';
            echo '<td>' . number_format($total_expenses, 2) . '</td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td><strong>Operating Income (or Loss)</strong></td>';
            echo '<td>' . number_format($total_revenues - $total_expenses, 2) . '</td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td><strong>Other Income</strong></td>';
            echo '<td></td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td><strong>Other Expenses</strong></td>';
            echo '<td></td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td><strong>Net Income (or Loss)</strong></td>';
            echo '<td>' . number_format($net_income_loss, 2) . '</td>';
            echo '</tr>';

            echo '</table>';
            
            // Show date range
            echo "<p class='text-muted'>Showing entries from " . date('d M Y', strtotime($start_date)) . " to " . date('d M Y', strtotime($end_date)) . "</p>";
        } else {
            echo '<div class="alert alert-warning">No income or expense accounts found for the selected period.</div>';
        }

        // Close the database connection
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
        newWindow.document.write('<html><head><title>Profit & Loss Account Report</title>');
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
