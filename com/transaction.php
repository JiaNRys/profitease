<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Transaction</title>

    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link rel="icon" type="image/x-icon" href="../ProfitEasez/favicon-32x32.png">
</head>
<body>
<div class="content">

    <?php 
        session_start();
        include '../com/includes/navheader.php'; 
        include '../com/includes/navtop.php';
        include '../com/includes/scripts.php';
    ?>


    <div id="page-wrapper">
        <div id="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <h2>TRANSACTION</h2>
                </div>
            </div>
            <hr />

            <!-- Check if a transaction confirmation exists in the session -->
            <?php if (isset($_SESSION['confirm'])): ?>
                <script>
                    // Show a pop-up alert with the success message
                    alert("<?php echo $_SESSION['confirm']; ?>");
                </script>
                <?php unset($_SESSION['confirm']); // Clear the session message after displaying ?>
            <?php endif; ?>

            <form action="save_transaction.php" method="post">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h4>Record Transaction</h4>

                        <div class="mb-3">
                            <label for="transaction_date" class="form-label">Transaction Date:</label>
                            <input type="date" class="form-control" id="transaction_date" name="transaction_date" required>
                        </div>

                    </div>
                </div>

                <div id="account-entries">
                    <div class="card mb-3 p-3 entry">
                        <h5 class="text-primary"><i class="fa fa-bank"></i> Account Entry</h5>

                        <div class="mb-2">
                            <label>Description:</label>
                            <textarea class="form-control" name="entry_descriptions[]"></textarea>
                        </div>

                        <div class="mb-2">
                            <label >Account:</label>
                            <select class="form-control" name="accounts[]" required>
                                <?php include '../com/get_accounts.php'; ?>
                            </select>
                        </div>

                        <div class="mb-2">
                            <label for="debit1">Debit:</label>
                            <input type="number" class="form-control" name="debits[]" min="0" step="0.01">
                        </div>

                        <div class="mb-2">
                            <label for="credit1">Credit:</label>
                            <input type="number" class="form-control" name="credits[]" min="0" step="0.01">
                        </div>
                        <button type="button" class="btn btn-danger btn-sm remove-entry">
                            <i class="fa fa-trash"></i> Remove
                        </button>
                    </div>
                </div>

                <button type="button" class="btn btn-success mb-4" onclick="addEntry()">
                    + Add Another Entry
                </button>
                
                <div class="row">
                    <div class="col-md-6">
                        <input type="submit" class="btn btn-primary" value="Record Transaction">
                    </div>
                    <div class="col-md-6">
                        <input type="reset" class="btn btn-danger" value="Clear">
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</div>

<script>
// Auto-fill today's date
document.getElementById('transaction_date').valueAsDate = new Date();

// Add entry row dynamically
function addEntry() {
    const container = document.getElementById('account-entries');
    const entry = container.querySelector('.entry');
    const clone = entry.cloneNode(true);

    // Clear all input values
    const inputs = clone.querySelectorAll('input');
    inputs.forEach(input => input.value = '');

    // Clear all select dropdowns
    const selects = clone.querySelectorAll('select');
    selects.forEach(select => select.selectedIndex = 0);

    // Clear all textarea values
    const textareas = clone.querySelectorAll('textarea');
    textareas.forEach(textarea => textarea.value = '');

    container.appendChild(clone);
}


// Validate debit and credit fields
document.querySelector("form").addEventListener("submit", function(e) {
    const entries = document.querySelectorAll('.entry');
    let valid = true;
    let totalDebit = 0;
    let totalCredit = 0;

    entries.forEach(entry => {
        const debit = parseFloat(entry.querySelector('input[name="debits[]"]').value) || 0;
        const credit = parseFloat(entry.querySelector('input[name="credits[]"]').value) || 0;

        // Validate that only Debit or Credit is filled
        if ((debit > 0 && credit > 0) || (debit === 0 && credit === 0)) {
            valid = false;
        }

        // Sum total debit and credit values
        totalDebit += debit;
        totalCredit += credit;
    });

    if (!valid) {
        alert("Each entry must have either a Debit or Credit (but not both or neither).");
        e.preventDefault();
    }

    if (Math.abs(totalDebit - totalCredit) > 0.009) { // Use precision-safe comparison
    alert("Debits and credits do not balance! Please ensure the totals are equal.");
    e.preventDefault();
}
});
// Listen for remove button clicks
document.getElementById('account-entries').addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-entry') || e.target.closest('.remove-entry')) {
        const entry = e.target.closest('.entry');
        if (document.querySelectorAll('.entry').length > 1) {
            entry.remove();
        } else {
            alert("At least one entry is required.");
        }
    }
});

</script>
<?php 
    include 'footer.php';
?>
</body>
</html>
