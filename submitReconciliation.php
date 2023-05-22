<?php

//get relevant data from js page
$pdata = $_POST['data'];
$rowCount = $_POST['rowCount'];
$bankAccountID = $_POST['bankAccountID'];
$endingBalance = $_POST['endingBalance'];
$endingDate = $_POST['endingDate'];
$clientID = $_POST['clientID'];

// Parse the data into a json objecy
$pdata = rtrim($pdata, ",");
$pdata .= "]";

$jsonData = json_decode($pdata, true);

main();

// Main function to handle running of helper functions
function main() {
    $amounts = getTotals();
    $accountBalances = getPreviousBalances();
    $stmt = prepareSqlStatement($accountBalances, $amounts);
    runSqlStatement($stmt, true);
}

// Function to prepare totals of all transactions and get account changes
function getTotals() {

    global $jsonData, $rowCount;

    // Associative array to save accountIDs
    $accountIDs = array('Income' => '1', 'Expenses' => '2', 'Liabilities' => '3', 'Assets' => '4', 'Equity' => '5');

    // Associative array to track an accounts position (what increases them)
    $accPosition = array('Income' => 'Credit', 'Expenses' => 'Debit', 'Liabilities' => 'Credit', 'Assets' => 'Debit', 'Equity' => 'Credit');

    // Associative array to track accounts current totals
    $amounts = array('1' => '0', '2' => '0', '3' => '0', '4' => '0', '5' => '0');

    // For loop to track the account balance changes
    for ($i = 0; $i < $rowCount; $i++) {
        // If statement to handle when a item is not checked
        if ($jsonData[$i]['row' . $i . 'reconciled'] == 'false') {
            continue;
        }

        $accountName = $jsonData[$i]['Account'];
        $transAmount = $jsonData[$i]['Amount'];
        if ($transAmount < 0) {
            if ($accPosition[$accountName] == 'Debit') {
                $amounts[$accountIDs[$accountName]] = $amounts[$accountIDs[$accountName]] + abs($transAmount);
            } else {
                $amounts[$accountIDs[$accountName]] = $amounts[$accountIDs[$accountName]] - abs($transAmount);
            }
        } else {
            if ($accPosition[$accountName] == 'Credit') {
                $amounts[$accountIDs[$accountName]] = $amounts[$accountIDs[$accountName]] + abs($transAmount);
            } else {
                $amounts[$accountIDs[$accountName]] = $amounts[$accountIDs[$accountName]] - abs($transAmount);
            }
        }
    }
    return $amounts;
}

// Function to get previous account balances
function getPreviousBalances() {
    

    global $clientID;

    // Getting old balance queries
    $accountBalances;

    // Formatting sql select statement to get balances
    $getBalancesQuery = 'SELECT ClientAccounts.ClientAccountID, ClientAccounts.AccountTypeID, ClientAccounts.Balance
                         FROM ClientAccounts
                         JOIN Clients ON ClientAccounts.ClientID = Clients.ClientID
                         WHERE ClientAccounts.ClientID = '. $clientID . ';';

    // Running the query
    $result = runSqlStatement($getBalancesQuery, false);

    // Storing query results
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {

            $accountBalances[$row['AccountTypeID']] = $row['Balance'];

        }
    } else {
        echo "0 results";
    }

    return $accountBalances;
}


//Prepare the SQL statement
function prepareSqlStatement($accountBalances, $amounts) {
    global $jsonData, $endingBalance, $endingDate, $bankAccountID, $rowCount;

    $stmt;
    $isReconciled = null;

    for ($i = 1; $i < 6; $i++) {
        // Handles if there is no change in an accounts balance
        if ($amounts[$i] == 0) continue;

        $newBalance = $accountBalances[$i] + $amounts[$i];

        $stmt .= 'UPDATE ClientAccounts
                  SET ClientAccounts.Balance = ' . $newBalance .
                  ' WHERE ClientAccounts.CLientID = ' . $clientID . ' AND ClientAccounts.AccountTypeID = '. $i . ';';
    }

    for ($i = 0; $i < $rowCount; $i++) {
        if ($jsonData[$i]['row' . $i . 'reconciled'] == 'true') {
            $isReconciled = 1;
        } else {
            continue;
        }

        $stmt .= 'UPDATE Transactions SET isReconciled =' . $isReconciled . ' WHERE TransactionID = ' . $jsonData[$i]['TransactionID'] . ';';
    }

    if ($stmt != "") {
        $stmt .= 'UPDATE BankAccounts SET lastReconBalance = ' . $endingBalance . ', lastReconDate = \'' . $endingDate . '\' WHERE BankAccountID = ' . $bankAccountID . ';';
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

?>