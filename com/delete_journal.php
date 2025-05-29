<?php
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $conn = new mysqli("localhost", "root", "", "profitease");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $id = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM journalentries WHERE entry_id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: journal.php?msg=deleted");
        exit(); // Good practice after header redirection
    } else {
        echo "Error deleting record: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "No valid entry ID specified for deletion.";
}
?>
