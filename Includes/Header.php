<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Styles/createnewstyle.css">
    <title>Header</title>
</head>
<body>
<form method="post" onsubmit="return saveContentBeforeSubmit();">
    <div class="editor">
        <div class="top-buttons">
            <a href="dashboard.php"><button type="button" onclick="confirmExit()">🔙 Back to Dashboard</button></a>
            <button type="submit">💾 Save Document</button>
            <a href="../com/icomeStatement.php"><button type="button"> Income Statement</button></a>
            <a href="../com/balanceSheet.php"><button type="button"> Balance Sheet</button></a>
            <button type="button"> Cash Flow Statement</button>
            <a href="journal.php"><button type="button">Hi</button></a>
            <a href="../com/transaction.php"><button type="button">Hello</button></a>
        </div>
    </div>
</form>

</body>
</html>
