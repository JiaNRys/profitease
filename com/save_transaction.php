<?php
session_start();
require_once "connection.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $transaction_date = $_POST["transaction_date"];
    $description = $_POST["description"];
    $accounts = $_POST["accounts"];
    $debits = $_POST["debits"];
    $credits = $_POST["credits"];

    // Validate and sanitize the data
    $transaction_date = trim($transaction_date);
    $description = trim($description);

    // Start a transaction (ensure all or nothing)
    $conn->begin_transaction();

    try {
        // Prepare the SQL statement to insert the transaction data into the Transactions table
        $sql_transaction = "INSERT INTO transactions (transaction_date, description) VALUES (?, ?)";

        // Use prepared statements to prevent SQL injection
        $stmt_transaction = $conn->prepare($sql_transaction);
        $stmt_transaction->bind_param("ss", $transaction_date, $description);

        // Execute the statement and check for success
        if (!$stmt_transaction->execute()) {
            throw new Exception("Error saving transaction: " . $stmt_transaction->error);
        }

        // Get the transaction ID of the newly inserted transaction
        $transaction_id = $conn->insert_id;

        // Prepare the SQL statement to insert the journal entries into the JournalEntries table
        $sql_journal_entry = "INSERT INTO journalEntries (transaction_id, account_id, debit_amount, credit_amount, description) VALUES (?, ?, ?, ?, ?)";


        // Use prepared statements to prevent SQL injection
        $stmt_journal_entry = $conn->prepare($sql_journal_entry);

        // Loop through the accounts, debits, and credits arrays to insert each journal entry
        // Loop through the accounts, debits, credits, and descriptions arrays to insert each journal entry
for ($i = 0; $i < count($accounts); $i++) {
    $account_id = $accounts[$i];
    $debit_amount = $debits[$i];
    $credit_amount = $credits[$i];
    $description1 = $_POST["entry_descriptions"][$i];  // Get the description for this entry

    // Execute the statement and check for success
    $entry_description = isset($_POST["entry_descriptions"][$i]) ? trim($_POST["entry_descriptions"][$i]) : '';
    $stmt_journal_entry->bind_param("iidds", $transaction_id, $account_id, $debit_amount, $credit_amount, $entry_description);

    if (!$stmt_journal_entry->execute()) {
        throw new Exception("Error saving journal entry: " . $stmt_journal_entry->error);
    }
}


        // If all journal entries are saved successfully, commit the transaction
        $conn->commit();
        
        // Set success message in the session
        $_SESSION['confirm'] = "Transaction recorded successfully! Check your General Journal.";
        
        // Redirect to the General Journal page
        header("Location: transaction.php");
        exit();
    } catch (Exception $e) {
        // If there is an error, rollback the transaction to ensure data consistency
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }

    // Close the statements and the database connection
    $stmt_transaction->close();
    $stmt_journal_entry->close();
    $conn->close();
}
?>
<script>
    function updateTotals() {
        let debitInputs = document.querySelectorAll('input[name="debits[]"]');
        let creditInputs = document.querySelectorAll('input[name="credits[]"]');
        let totalDebit = 0;
        let totalCredit = 0;

        debitInputs.forEach(input => {
            let val = parseFloat(input.value);
            if (!isNaN(val)) totalDebit += val;
        });

        creditInputs.forEach(input => {
            let val = parseFloat(input.value);
            if (!isNaN(val)) totalCredit += val;
        });

        document.getElementById('total-debit').textContent = totalDebit.toFixed(2);
        document.getElementById('total-credit').textContent = totalCredit.toFixed(2);

        let status = document.getElementById('balance-status');
        let submitBtn = document.querySelector('input[type="submit"]');

        if (Math.abs(totalDebit - totalCredit) < 0.01) {
            status.textContent = "✅ Debits and Credits are balanced.";
            status.style.color = "green";
            submitBtn.disabled = false;
            debitInputs.forEach(input => input.style.borderColor = '');
            creditInputs.forEach(input => input.style.borderColor = '');
        } else {
            status.textContent = "❌ Debits and Credits do NOT match.";
            status.style.color = "red";
            submitBtn.disabled = true;
            debitInputs.forEach(input => input.style.borderColor = 'red');
            creditInputs.forEach(input => input.style.borderColor = 'red');
        }
    }

    // Listen to all changes on debit and credit inputs
    document.querySelectorAll('input[name="debits[]"], input[name="credits[]"]').forEach(input => {
        input.addEventListener('input', updateTotals);
    });

    // Run once on load
    window.addEventListener('DOMContentLoaded', updateTotals);
</script>

</body>
</html>
