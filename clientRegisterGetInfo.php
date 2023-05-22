<?php

// Needed Connection Information
$servername = "localhost";
$username = "debian-sys-maint";
$password = "lJzt0TVejdnMz50I";
$dbname = "ScribeDBTest";

if (strcmp($_POST['function'],'getTransactions') == 0) {
    getTransactions();
}


if (strcmp($_POST['function'],'deleteTransactions') == 0) {
    $stmt = prepareDeleteTransStatement();
    runSqlStatement($stmt, true);
    echo $stmt;
}

function getTransactions() {
    $clientID = $_POST["clientID"];

    $sql = 'SELECT Transactions.TransactionID, Transactions.Date_Processed, Transactions.Amount,
                Transactions.TransNum, Transactions.Description, AccountTypes.AccountTypeName, Transactions.isReconciled,
                BankAccounts.AccountNumber, Banks.BankName
            FROM Transactions 
            JOIN AccountTypes ON Transactions.AccountTypeID = AccountTypes.AccountTypeID 
            JOIN BankAccounts ON Transactions.BankAccountID = BankAccounts.BankAccountID 
            JOIN Clients ON BankAccounts.ClientID = Clients.ClientID
            JOIN Banks ON BankAccounts.BankID = Banks.BankID
            WHERE Clients.ClientID = '. $clientID . '
            ORDER BY Transactions.Date_Processed DESC;';

    $result = runSqlStatement($sql, false);

    // Needed Variables
    $data = "[";

    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {

        $data .= '{"TransactionID": "' . $row["TransactionID"] . '", "Date_Processed": "' . $row["Date_Processed"] .
                '", "Amount": "' . $row["Amount"] . '", "TransNum": "' . $row["TransNum"] . '", "Description": "' . $row["Description"] .
                '", "AccountTypeName": "' . $row["AccountTypeName"] . '", "isReconciled": "' . $row["isReconciled"] .
                '", "AccountNumber": "' . $row["AccountNumber"] . '", "BankName": "' . $row["BankName"] . '"},';
      }
    } else {
      echo "0 results";
    }

    $data = rtrim($data, ",");
    echo $data .= "]";
}

function prepareDeleteTransStatement() {
    $pdata = $_POST['data'];

    // Parse the data into a json objecy
    $pdata = rtrim($pdata, ",");
    $pdata .= "]";

    $jsonData = json_decode($pdata, true);
    
    //Prepare the SQL statement
    $stmt = "";
    $isDeleted = null;
    $rowCount = count($jsonData);
    
    for ($i = 0; $i < $rowCount; $i++) {
        if ($jsonData[$i]['row' . $i . 'deleted'] == 'true') {
            $isDeleted = 1;
        } else {
            continue;
        }
    
        $stmt .= 'UPDATE Transactions SET isDeleted =' . $isDeleted . ' WHERE TransactionID = ' . $jsonData[$i]['TransactionID'] . ';';
    }
    return $stmt;
}

// Function to run the sql queries held in $stmt
function runSqlStatement($stmt, $runMulti) {

    if ($stmt == "") return;
    
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

    if ($runMulti) {
        // Running the query
        mysqli_multi_query($conn, $stmt);
    } else {
        $result = $conn->query($stmt);
    }

    mysqli_close($conn);

    return $result;
}

 // Redirect the user to a success page
//header("Location: index.php");

?>