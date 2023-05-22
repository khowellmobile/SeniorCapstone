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
$stmt = $conn->prepare("INSERT INTO HAEmployees (Employee_FirstName, Employee_LastName, PositionID, Employee_Email, Employee_PhoneNumber, isDeleted) VALUES (?, ?, ?, ?, ?, ?)");
// $sql = 'CALL spUsers_Add(?,?,?,?,?,?,?)';
// $stmt = $db2_prepare($conn, $sql);
// Bind the parameters to the SQL statement
$stmt->bind_param("sssssi", $Employee_FirstName, $Employee_LastName, $PositionID, $Employee_Email, $Employee_PhoneNumber, $isDeleted);
// Set the values of the parameters from the form submission
$Employee_FirstName = $_POST['firstName'];
$Employee_LastName = $_POST['lastName'];
$PositionID = $_POST['positionID'];
$Employee_Email = $_POST['email'];
$Employee_PhoneNumber = $_POST['number'];
$isDeleted = $_POST['isDeleted'];
// Execute the SQL statement
if(!$stmt->execute()) echo("<script>console.log('Error');</script>");
// Close the statement and the connection
$stmt->close();
$conn->close();

// Redirect the user to a success page
header("Location: login.php");
?>
