<!--
session_start();
if(!isset($_SESSION['id']))
{
      header("Location: index.php");
}-->
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Trial Balance</title>
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
                     <h2>TRIAL BALANCE</h2>   
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

        // Main query to get trial balance
        $sql = "SELECT 
                    a.account_id,
                    a.account_name,
                    COALESCE(SUM(j.debit_amount), 0) as total_debit,
                    COALESCE(SUM(j.credit_amount), 0) as total_credit
                FROM accounts a
                LEFT JOIN journalEntries j ON a.account_id = j.account_id
                LEFT JOIN transactions t ON j.transaction_id = t.transaction_id
                WHERE t.transaction_date BETWEEN '$start_date' AND '$end_date'
                GROUP BY a.account_id, a.account_name
                HAVING (SUM(j.debit_amount) - SUM(j.credit_amount)) != 0
                ORDER BY a.account_name";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $total_debit = 0;
            $total_credit = 0;
            
            echo '<table class="table table-striped table-bordered table-hover">';
            echo '<tr><th>Account</th><th>Debit</th><th>Credit</th></tr>';

            while ($row = $result->fetch_assoc()) {
                $balance = $row['total_debit'] - $row['total_credit'];
                
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['account_name']) . '</td>';
                echo '<td>' . ($balance > 0 ? number_format($balance, 2) : '') . '</td>';
                echo '<td>' . ($balance < 0 ? number_format(abs($balance), 2) : '') . '</td>';
                echo '</tr>';
                
                if ($balance > 0) {
                    $total_debit += $balance;
                } else {
                    $total_credit += abs($balance);
                }
            }

            // Display totals
            echo '<tr class="total-row">';
            echo '<td><strong>Total</strong></td>';
            echo '<td>' . number_format($total_debit, 2) . '</td>';
            echo '<td>' . number_format($total_credit, 2) . '</td>';
            echo '</tr>';
            echo '</table>';

            // Show date range
            echo "<p class='text-muted'>Showing entries from " . date('d M Y', strtotime($start_date)) . " to " . date('d M Y', strtotime($end_date)) . "</p>";
        } else {
            echo '<div class="alert alert-warning">No transactions found for the selected period</div>';
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
    <?php
    include 'footer.php';
    ?>
    <?php
    include '../com/includes/scripts.php';
    ?>
    <script>
    function printTable() {
        var newWindow = window.open('', '_blank');
        newWindow.document.write('<html><head><title>Trial Balance Report</title>');
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
