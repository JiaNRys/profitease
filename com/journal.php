<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>General Journal</title>
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
                     <h2>GENERAL JOURNAL</h2>   
                    </div>
                </div>    
                
                <!-- Simple Date Filter Form -->
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

                    // Initialize filter condition
                    $filterCondition = '';

                    // Check if dates are provided
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
                        
                        $filterCondition = "WHERE t.transaction_date BETWEEN '$startDate' AND '$endDate'";
                    }

                    // Build final SQL query
                    $sql = "SELECT 
                            j.entry_id,
                            t.transaction_id, t.transaction_date, j.description, 
                            j.account_id, j.debit_amount, j.credit_amount, a.account_name
                            FROM transactions t
                            INNER JOIN journalEntries j ON t.transaction_id = j.transaction_id
                            INNER JOIN accounts a ON j.account_id = a.account_id
                            $filterCondition
                            ORDER BY t.transaction_date DESC, t.transaction_id DESC";

                    // Run the query
                    $result = $conn->query($sql);

                    // Display results
                    if ($result->num_rows > 0) {
                        echo '<table class="table table-striped table-bordered table-hover">';
                        echo '<tr><th>Date</th><th>Description</th><th>Account</th><th>Debit</th><th>Credit</th></tr>';

                        while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($row['transaction_date']) . '</td>';
    echo '<td>' . htmlspecialchars($row['description']) . '</td>';
    echo '<td>' . htmlspecialchars($row['account_name']) . '</td>';
    echo '<td>' . ($row['debit_amount'] != "0.00" ? number_format($row['debit_amount'], 2) : '') . '</td>';
    echo '<td>' . ($row['credit_amount'] != "0.00" ? number_format($row['credit_amount'], 2) : '') . '</td>';
    echo '<td><a href="delete_journal.php?id=' . $row['entry_id'] . '" onclick="return confirm(\'Are you sure?\');">🗑 Delete</a></td>';
    echo '</tr>';
}
                        echo '</table>';
                    } else {
                        echo '<div class="alert alert-warning">No journal entries found';
                        if (isset($filterCondition)) {
                            echo ' for the selected date range';
                        }
                        echo '.</div>';
                    }

                    // Close database connection
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
        newWindow.document.write('<html><head><title>General Journal Report</title>');
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
