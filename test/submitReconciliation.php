<?php

//get relevant data from js page
$pdata = $_POST['data'];
$rowCount = $_POST['rowCount'];
$bankAccountID = $_POST['bankAccountID'];
$endingBalance = $_POST['endingBalance'];
$endingDate = $_POST['endingDate'];

// Parse the data into a json objecy
$pdata = rtrim($pdata, ",");
$pdata .= "]";

$jsonData = json_decode($pdata, true);

//Create a connection to the database
$servername = "localhost";
$username = "debian-sys-maint";
$password = "lJzt0TVejdnMz50I";
$dbname = "ScribeDBTest";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    echo('connectionfailed');
}

//Prepare the SQL statement
$stmt;
$isReconciled = null;

for ($i = 0; $i < $rowCount; $i++) {
    if ($jsonData[$i]['row' . $i . 'reconciled'] == 'true') {
        $isReconciled = 1;
    } else {
        $isReconciled = 0;
    }

    $stmt .= 'UPDATE Transactions SET isReconciled =' . $isReconciled . ' WHERE TransactionID = ' . $jsonData[$i]['TransactionID'] . ';';
}

$stmt .= 'UPDATE BankAccounts SET lastReconBalance = ' . $endingBalance . ', lastReconDate = \'' . $endingDate . '\' WHERE BankAccountID = ' . $bankAccountID . ';';

echo $stmt;

//Runs all queries
mysqli_multi_query($conn, $stmt);

//Closing the connection
mysqli_close($conn);

// Redirect the user to a success page
//header("Location: index.php");

?>