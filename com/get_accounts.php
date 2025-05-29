<?php
require_once 'connection.php';

// Prepare the SQL statement to fetch account data from the Accounts table
$sql = "SELECT account_id, account_name FROM accounts ORDER BY account_name";

// Execute the SQL query
$result = $conn->query($sql);

// Check if there are any accounts in the database
if ($result->num_rows > 0) {
    // Loop through the result set and generate the account options for the dropdown select field
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . $row["account_id"] . '">' . $row["account_name"] . '</option>';
    }
} else {
    echo '<option value="">No accounts found</option>';
}

// Close the database connection
$conn->close();
?>
