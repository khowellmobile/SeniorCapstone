<?php
// Needed Connection Information
$servername = "localhost";
$username = "debian-sys-maint";
$password = "lJzt0TVejdnMz50I";
$dbname = "ScribeDBTest";

// If block to get accounts to list for users
if (strcmp($_POST['function'],'getAccounts') == 0) {

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

// Needed Variables
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

} // End getAccounts

// If block to handle when user submits to get transactions
if (strcmp($_POST['function'],'getTransactions') == 0) {
  
  $bankAccountID = $_POST['BankAccountID'];

  $conn = mysqli_connect($servername, $username, $password, $dbname);

  // Check the connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
      echo('connectionfailed');
  }

  $sql = 'SELECT Transactions.TransactionID, Transactions.Date_Processed, Transactions.Amount, Transactions.Description,
                   Transactions.TransNum, AccountTypes.AccountTypeName, Transactions.isReconciled , BankAccounts.lastReconBalance
          FROM Transactions 
          JOIN AccountTypes ON Transactions.AccountTypeID = AccountTypes.AccountTypeID 
          JOIN BankAccounts ON Transactions.BankAccountID = BankAccounts.BankAccountID 
          WHERE BankAccounts.BankAccountID = ' . $bankAccountID . ' AND Transactions.isReconciled = 0
          ORDER BY Transactions.Date_Processed DESC';

  $result = $conn->query($sql);

  // Needed Variables
  $data = "[";

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $data .= '{"TransactionID": "' . $row["TransactionID"] . '", "Date_Processed": "' . $row["Date_Processed"] . '", "Amount":"' . $row["Amount"] . '", "Description": "' . $row["Description"] .
          '", "TransNum": "' . $row["TransNum"] . '", "AccountTypeName": "' . $row["AccountTypeName"] . '", "isReconciled":"' . $row["isReconciled"] .
          '", "lastReconBalance": "' . $row["lastReconBalance"] . '"},';
    }
  } else {
    echo "0 results";
  }

  $data = rtrim($data, ",");
  echo $data .= "]";

}

 // Redirect the user to a success page
//header("Location: index.php");

?>
