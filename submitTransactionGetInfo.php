<?php
// Needed Connection Information
$servername = "localhost";
$username = "debian-sys-maint";
$password = "lJzt0TVejdnMz50I";
$dbname = "ScribeDBTest";

$ClientID = $_POST['ClientID'];

$jsonClientData = json_decode($ClientID, true);

// Establish Connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    echo('connectionfailed');
}

$sql = 'SELECT BankAccounts.BankAccountID, BankAccounts.AccountNumber, Banks.BankName
        FROM BankAccounts
        JOIN Banks ON BankAccounts.BankID = Banks.BankID
        JOIN Clients ON BankAccounts.ClientID = Clients.ClientID
        Where Clients.ClientID = ' . $jsonClientData['ClientID'];
$result = $conn->query($sql);

$data = "[";

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $data .= '{"BankAccountID": "' . $row["BankAccountID"] . '", "AccountNumber": "' . $row["AccountNumber"] . '", "BankName": "' . $row["BankName"] . '"},';
  }

} else {
  echo "0 results";
}

$data = rtrim($data, ",");
echo $data .= "]";

// Redirect the user to a success page
//header("Location: index.php");

?>