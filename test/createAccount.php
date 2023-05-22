<?php
// Create a connection to the database
$servername = "localhost";
$username = "debian-sys-maint";
$password = "lJzt0TVejdnMz50I";
$dbname = "ScribeDB";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    echo("<script>console.log('Error');</script>");
} else {
    echo("<script>console.log('No Error');</script>");
}
// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO Users (Username, Password, FirstName, LastName, userType, HAEmployeeID, isDeleted) VALUES (?, ?, ?, ?, ?, ?, ?)");
// $sql = 'CALL spUsers_Add(?,?,?,?,?,?,?)';
// $stmt = $db2_prepare($conn, $sql);
// Bind the parameters to the SQL statement
$stmt->bind_param("ssssssi", $Username, $Password, $FirstName, $LastName, $userType, $HAEmployeeID, $isDeleted);
// Set the values of the parameters from the form submission
$Username = $_POST['username'];
$Password = $_POST['psw'];
$FirstName = $_POST['firstName'];
$LastName = $_POST['lastName'];
$userType = $_POST['userType'];
$HAEmployeeID = $_POST['haEmployeeId'];
$isDeleted = $_POST['isDeleted'];
// Execute the SQL statement
if(!$stmt->execute()) echo $stmt->error;
// Close the statement and the connection
$stmt->close();
$conn->close();

// Redirect the user to a success page
header("Location: login.php");
?>
