<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Accounts</title>

    <!-- BOOTSTRAP STYLES -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />

    <!-- FONTAWESOME STYLES -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />

    <!-- CUSTOM STYLES -->
    <link href="assets/css/custom.css" rel="stylesheet" />

    <!-- GOOGLE FONTS -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css" />
    <link rel="icon" type="image/x-icon" href="../ProfitEasez/favicon-32x32.png">
</head>
<body>

    <!-- NAVBAR -->
    <?php 
        include '../com/includes/navheader.php'; 
        include '../com/includes/navtop.php';
    ?>

    <!-- PAGE CONTENT -->
    <div id="page-wrapper">
        <div id="page-inner">

            <div class="row">
                <div class="col-md-12">
                    <h2>ACCOUNTS</h2>
                </div>
            </div>
            <hr />

            <!-- ALERT FOR SUCCESS -->
            <?php
            if (isset($_SESSION['comfrim'])) {
                ?>
                <div class="alert alert-success">
                    <?php echo $_SESSION['comfrim']; ?>
                </div>
                <?php
                unset($_SESSION['comfrim']);
            }
            ?>

            <div class="row">
                <!-- CREATE ACCOUNT FORM -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <h3>Create Account</h3>
                    <form action="create_account.php" method="post">
                        <div class="form-group">
                            <label for="account_name">Account Name:</label>
                            <input type="text" class="form-control" id="account_name" name="account_name" required>
                        </div>

                        <div class="form-group">
                            <label for="account_type">Account Type:</label>
                            <select class="form-control" id="account_type" name="account_type" required>
                                <option value="" disabled selected>Select account type</option>
                                <option value="asset">Asset</option>
                                <option value="expense">Expense</option>
                                <option value="equity">Equity</option>
                                <option value="liability">Liability</option>
                                <option value="income">Income</option>
                            </select>
                        </div>

                        <input type="submit" class="btn btn-primary" value="Create Account">
                        <input type="reset" class="btn btn-danger" value="Clear">
                    </form>
                </div>

                <!-- ACCOUNTS TABLE -->
                <div class="col-lg-6 col-md-6">
                    <h3>All Accounts</h3>
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Account Name</th>
                                <th>Account Type</th>
                                <th colspan="2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "connection.php";
                            $q = "SELECT * FROM accounts";
                            $result = mysqli_query($conn, $q);
                            $i = 0;
                            while ($row = mysqli_fetch_array($result)) {
                                $i++;
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo htmlspecialchars($row['account_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['account_type']); ?></td>
                                    <td><a href="delete_account.php?id=<?php echo $row['account_id']; ?>" onclick="return confirm('Are you sure?');">🗑 Delete</a></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div> <!-- /.ROW -->

        </div> <!-- /.PAGE INNER -->
    </div> <!-- /.PAGE WRAPPER -->

    <!-- FOOTER -->
    <?php include 'footer.php'; ?>
    <?php include '../com/includes/scripts.php'; ?>

</body>
</html>
