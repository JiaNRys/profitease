<?php
if (isset($_GET['id'])) {
    // Create a new connection to the database
    $conn = new mysqli("localhost", "root", "", "profitease");

    // Check for connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize the 'id' value to ensure it's an integer
    $id = intval($_GET['id']);

    // Replace 'id' with the correct column name if necessary
    // Assuming the correct column name is 'account_id'
    $stmt = $conn->prepare("DELETE FROM accounts WHERE account_id = ?");

    // Bind the 'id' parameter as an integer to the SQL query
    $stmt->bind_param("i", $id);  // "i" means integer

    // Execute the prepared statement
    if ($stmt->execute()) {
        // Redirect to the dashboard page with a success message
        header("Location: accounts.php?msg=deleted");
    } else {
        // If there is an error, show an error message
        echo "Error deleting record: " . $stmt->error;
    }

    // Close the prepared statement and the database connection
    $stmt->close();
    $conn->close();
}
?>
