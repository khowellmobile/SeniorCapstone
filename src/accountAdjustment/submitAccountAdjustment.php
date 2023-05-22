<?php
main();

function main() {
    // parse into associative array
    parse_str($_POST['data'], $arr);

    $accountBalances = getAccountBalances();
    $bankAccountID = getBankAccount();
    $amounts = recordAdjustments($arr, $bankAccountID);
    postToAccounts($accountBalances, $amounts);
}

// Function to get the current account balances for the client
function getAccountBalances() {
    $accountBalances;

    // Formatting sql select statement to get balances
    $getBalancesQuery = 'SELECT ClientAccounts.ClientAccountID, ClientAccounts.AccountTypeID, ClientAccounts.Balance
                         FROM ClientAccounts
                         JOIN Clients ON ClientAccounts.ClientID = Clients.ClientID
                         WHERE ClientAccounts.ClientID = '. $_POST['clientID'] . ';';

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

// Function to get a bank account of the client to store in the database
function getBankAccount() {
    // Formatting sql select statement to get bankAccounts
    $getClientBankAccountQuery = 'SELECT BankAccounts.BankAccountID
                                  FROM BankAccounts
                                  JOIN Clients ON BankAccounts.ClientID = Clients.ClientID
                                  WHERE BankAccounts.ClientID = ' . $_POST['clientID'] . ';';

    // Running the query
    $result = runSqlStatement($getClientBankAccountQuery, false);

    // Storing query results
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {

        $bankAccountID = $row['BankAccountID'];

        }
    } else {
        echo "0 results";
    }

    return $bankAccountID;
}

// Function to record each adjustment in the transactions table
function recordAdjustments($arr, $bankAccountID) {
    $stmt;
    $amount;
    $adjustmentDate = $_POST['adjustmentDate'];
    $adjustmentName = $_POST['adjustmentName'];
    $rowCount = $_POST['rowCount'];

    // Associate array to handle totaling of debits/credits for each account
    // NOTE: 1 = Income, 2 = Expenses, 3 = Liabilities, 4 = Assets, 5 = Equity
    $amounts = array('1' => '0', '2' => '0', '3' => '0', '4' => '0', '5' => '0');

    // Loop to total debits and credits for each account
    for ($i = 0; $i < $rowCount; $i++) {
        // Does not generate query in the case of empty debit and credit values
        if ($arr["row-{$i}-debit"] == NULL && $arr["row-{$i}-credit"] == NULL) continue;

        // Handles if credits and debits are put in the same row
        if ($arr["row-{$i}-debit"] != NULL && $arr["row-{$i}-credit"] != NULL) {
            $amount = abs(intval($arr["row-{$i}-debit"]) - intval($arr["row-{$i}-credit"]));
        } else {
            // If-Else to handle changing debits to negative
            if ($arr["row-{$i}-debit"] == NULL) {
                $amount = $arr["row-{$i}-credit"];
            } else {
                $amount = -$arr["row-{$i}-debit"];
            }
        }

        $amounts[$arr["row-{$i}-account"]] = $amounts[$arr["row-{$i}-account"]] + incOrDec($arr["row-{$i}-account"], $amount);

        $memo = $adjustmentName . ":" . $arr["row-{$i}-memo"];

        // Query to add the adjustment to the transactions table
        $stmt .= 'CALL spTransactions_Add(' . $bankAccountID . ',\'' . $adjustmentDate . '\' ,\'' . $adjustmentDate . '\' , ' .
                   $amount . ' , \'' . $memo . '\' , \'ACCADJ:' . $_POST['clientID'] . '\' , 1 , ' . $arr["row-{$i}-account"] . ' , 1, 0);';
    }

    runSqlStatement($stmt, true);

    return $amounts;
}

// Function to take adjustment totals and post them to appropriate accounts
function postToAccounts($accountBalances, $amounts) {
    $stmt;

    // Loop to create the queries for each account
    for ($i = 1; $i < 6; $i++) {

        // Handles if there is no change in an accounts balance
        if ($amounts[$i] == 0) continue;

        $prevBalance = $accountBalances[$i];

        $newBalance = $prevBalance + $amounts[$i];

        $stmt .= 'UPDATE ClientAccounts
                  SET ClientAccounts.Balance = ' . $newBalance .
                  ' WHERE ClientAccounts.CLientID = ' . $_POST['clientID'] . ' AND ClientAccounts.AccountTypeID = '. $i . ';';
    }

    runSqlStatement($stmt, true);
}

// Function to determine if a debit/credit should increase or decrease an account
function incOrDec($accountsID, $amount) {
    // Accounts 1,3,and 5 increase with credits and decrease with debits
    if ($accountsID == 1 || $accountsId == 3 || $accountsID == 5) {
        if ($amount < 0) {
            return $amount;
        } else {
            return $amount;
        }
    } else {
        if ($amount < 0) {
            return abs($amount);
        } else {
            return $amount * -1;
        }
    }
}

// Function to run the sql queries held in $stmt
// $runMulti is true when $stmt holds multiple queries and false
function runSqlStatement($stmt, $runMulti) {

    // handles empty queries
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
