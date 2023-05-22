<?php
// Create a connection to the database
$servername = "localhost";
$username = "debian-sys-maint";
$password = "lJzt0TVejdnMz50I";
$dbname = "HADB";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO Transactions (BankAccountID, Date_Made, Date_Processed, Amount, Description, TransactionTypeID, isDeleted) VALUES (?, ?, ?, ?, ?, ?, ?)");

// Bind the parameters to the SQL statement
$stmt->bind_param("issdssi", $BankAccountID, $Date_Made, $Date_Processed, $Amount, $Description, $TransactionTypeID, $isDeleted);

// Set the values of the parameters from the form submission
$BankAccountID = $_POST['BankAccountID'];
$Date_Made = $_POST['Date_Made'];
$Date_Processed = $_POST['Date_Processed'];
$Amount = $_POST['amount'];
$Description = $_POST['Description'];
$TransactionTypeID = $_POST['TransactionTypeID'];
$isDeleted = $_POST['isDeleted'];

// Execute the SQL statement
$stmt->execute();

// Close the statement and the connection
$stmt->close();
$conn->close();

// Redirect the user to a success page
header("Location: index.php");
?>
