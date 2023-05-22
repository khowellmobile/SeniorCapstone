<?php
$pdata = $_POST['data'];
$rowCount = $_POST['rowCount'];
$clientID =  $_POST['clientID'];
$adjustmentDate = $_POST['adjustmentDate'];
$adjustmentName = $_POST['adjustmentName'];

// parse into associative array
parse_str($pdata, $arr);

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
$accountBalances;

// Formatting sql select statement to get balances
$getBalancesQuery = 'SELECT ClientAccounts.ClientAccountID, ClientAccounts.AccountTypeID, ClientAccounts.Balance
                     FROM ClientAccounts
                     JOIN Clients ON ClientAccounts.ClientID = Clients.ClientID
                     WHERE ClientAccounts.ClientID = '. $clientID . ';';

// Running the query
$result = $conn->query($getBalancesQuery);

// Storing query results
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {

        $accountBalances[$row['AccountTypeID']] = $row['Balance'];

    }
} else {
    echo "0 results";
}


// Formatting sql select statement to get bankAccounts
$getClientBankAccountQuery = 'SELECT BankAccounts.BankAccountID
                              FROM BankAccounts
                              JOIN Clients ON BankAccounts.ClientID = Clients.ClientID
                              WHERE BankAccounts.ClientID = ' . $clientID . ';';

// Running the query
$result = $conn->query($getClientBankAccountQuery);

// Storing query results
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {

        $bankAccountID = $row['BankAccountID'];

    }
} else {
    echo "0 results";
}


$stmt;
$amount;

// Associate array to handle totaling of debits/credits for each account
// NOTE: 1 = Income, 2 = Expenses, 3 = Liabilities, 4 = Assets, 5 = Equity
$amounts = array('1' => '0', '2' => '0', '3' => '0', '4' => '0', '5' => '0');

// Loop to total debits and credits for each account
for ($i = 0; $i < $rowCount; $i++) {
    // Does not generate query in the case of empty debit and credit values
    if ($arr["row-{$i}-debit"] == NULL && $arr["row-{$i}-credit"] == NULL) continue;

    // Handles if credits and debits are put in the same row
    if ($arr["row-{$i}-debit"] != NULL && $arr["row-{$i}-credit"] != NULL) {
        $amount = intval($arr["row-{$i}-debit"]) - intval($arr["row-{$i}-credit"]);
    } else {
        // If-Else to handle changing debits to negative
        if ($arr["row-{$i}-debit"] == NULL) {
            $amount = -$arr["row-{$i}-credit"];
        } else {
            $amount = $arr["row-{$i}-debit"];
        }
    }

    $amounts[$arr["row-{$i}-account"]] = intval($amounts[$arr["row-{$i}-account"]]) + intval($amount);

    $memo = $adjustmentName . ":" . $arr["row-{$i}-memo"];

    // Query to add the adjustment to the transactions table
    $stmt .= 'CALL spTransactions_Add(' . $bankAccountID . ',\'' . $adjustmentDate . '\' ,\'' . $adjustmentDate . '\' , ' .
               $amount . ' , \'' . $memo . '\' , \'ACCADJ:' . $clientID . '\' , 1 , ' . $arr["row-{$i}-account"] . ' , 1, 0);';
}

// Loop to create the queries for each account
for ($i = 1; $i < 6; $i++) {

    // Handles if there is no change in an accounts balance
    if ($amounts[$i] == 0) continue;

    $prevBalance = $accountBalances[$i];

    $newBalance = $prevBalance + $amounts[$i];

    $stmt .= 'UPDATE ClientAccounts
              SET ClientAccounts.Balance = ' . $newBalance .
              ' WHERE ClientAccounts.CLientID = ' . $clientID . ' AND ClientAccounts.AccountTypeID = '. $i . ';';
}

// Runs qeuries on database
mysqli_multi_query($conn, $stmt);

// Closes the connection
mysqli_close($conn);
?>