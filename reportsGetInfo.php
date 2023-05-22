<?php
// If else block to ensure proper function are called based on passed in information
if (strcmp($_POST['function'],'balanceSheet') == 0) {
    $data .= getTransactions(3);
    $data .= getTransactions(4);
    $data .= getTransactions(5);
    $data .= getIncome(true, true);
    $data .= getIncome(false, true);
    $data .= getExpenses(true, true);
    $data .= getExpenses(false, true);
    echo '{' . rtrim($data, ",") . '}';
} else if (strcmp($_POST['function'],'profitLoss') == 0) {
    $data .= getIncome(true, false);
    $data .= getExpenses(true, false);
    echo '{' . rtrim($data, ",") . '}';
}

// Gets all transactions after the end date passed to this file.
// $accountID is the accountID of the account to get the transactions for.
// returns an object holding an array in json format
function getTransactions($accountID) {

    // Creates and runs the sql query
    $stmt = 'SELECT Transactions.Amount 
             FROM Transactions
             JOIN AccountTypes ON Transactions.AccountTypeID = AccountTypes.AccountTypeID 
             JOIN BankAccounts ON Transactions.BankAccountID = BankAccounts.BankAccountID 
             JOIN Clients ON BankAccounts.ClientID = Clients.ClientID
             WHERE BankAccounts.ClientID = ' . $_POST['clientID'] . ' AND Transactions.AccountTypeID = ' . $accountID .
                ' AND Transactions.Date_Processed > "'. $_POST['endDate'] .'";';

    $result = runSqlStatement($stmt, false);

    $data = "";

    // Adds the proper label to the Json string
    if ($accountID == 5) {
        $data .= '"equity":';
    } else if ($accountID == 4) {
        $data .= '"assets":';
    } else {
        $data .= '"liabilities":';
    }

    // Adds the account balance to the json string
    $data .= '[' . getAccountBalance($accountID) . ',';

    // Parses through the result and adds the amounts of each of the transactions
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $data .= $row['Amount'] . ',';
        }
    } else {
        $data = rtrim($data, ",");
        return $data . '],';
    }

    $data = rtrim($data, ",");
    return $data . '],';
}

// Gets the balance of an account 
// $accountID is the accountID of the account to get the transactions for.
// returns the account balance
function getAccountBalance($accountID) {

    // Create and run query
    $stmt = 'SELECT Balance FROM ClientAccounts WHERE AccountTypeID = '. $accountID .' AND ClientID = ' . $_POST['clientID'] . ';';

    $result = runSqlStatement($stmt, false);

    // Parses the result
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $data .= $row['Balance'];
        }
    } else {
        echo "";
    }

    return $data;
}

// Gets income transactions between certain dates
// $isNetIncome is true for net income on a balance sheet and false for retained earnings on a balance sheet
// $isBalance sheet is true when the transactions are for a balance sheet and false otherwise
// Returns an object holding an array in json format
function getIncome($isNetIncome, $isBalanceSheet) {

    // Creating query
    $stmt = 'SELECT Transactions.Amount 
             FROM Transactions
             JOIN AccountTypes ON Transactions.AccountTypeID = AccountTypes.AccountTypeID 
             JOIN BankAccounts ON Transactions.BankAccountID = BankAccounts.BankAccountID 
             JOIN Clients ON BankAccounts.ClientID = Clients.ClientID
             WHERE BankAccounts.ClientID = ' . $_POST['clientID'] . ' AND Transactions.AccountTypeID = 1 ';

    // Uses parameters to ensure query is given the proper dates
    if ($isBalanceSheet) {
        if ($isNetIncome) {
            $stmt .= 'AND Transactions.Date_Processed >= "'. substr($_POST['endDate'], 0, 4) . '-01-01" AND Transactions.Date_Processed <= "' . $_POST['endDate']. '";';
        } else {
            $stmt .= 'AND Transactions.Date_Processed < "'. substr($_POST['endDate'], 0, 4) . '-01-01";';
        }    
    } else {
        $stmt .= 'AND Transactions.Date_Processed >= "' . $_POST['startDate'] . '" AND Transactions.Date_Processed <= "' . $_POST['endDate']. '";';
    }

    // Run the sql query
    $result = runSqlStatement($stmt, false);

    // Adds proper label for json object
    if ($isNetIncome) {
        $data = '"netIncome":[';
    } else {
        $data = '"retainedIncome":[';
    }

    $data .= 0 . ',';

    // Parses through the result and adds to json array
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $data .= $row['Amount'] . ',';
        }
    } else {
        echo "";
    }

    return rtrim($data, ",") . '],';
}

// Gets expense transactions between certain dates
// $isNetIncome is true for net income on a balance sheet and false for retained earnings on a balance sheet
// $isBalance sheet is true when the transactions are for a balance sheet and false otherwise
// Returns an object holding an array in json format
function getExpenses($isNetExpense, $isBalanceSheet) {
    // Creates the query
    $stmt = 'SELECT Transactions.Amount 
             FROM Transactions
             JOIN AccountTypes ON Transactions.AccountTypeID = AccountTypes.AccountTypeID 
             JOIN BankAccounts ON Transactions.BankAccountID = BankAccounts.BankAccountID 
             JOIN Clients ON BankAccounts.ClientID = Clients.ClientID
             WHERE BankAccounts.ClientID = ' . $_POST['clientID'] . ' AND Transactions.AccountTypeID = 2 ';

    // Uses parameters to ensure query is given the proper dates
    if ($isBalanceSheet) {
        if ($isNetExpense) {
            $stmt .= 'AND Transactions.Date_Processed >= "'. substr($_POST['endDate'], 0, 4) . '-01-01" AND Transactions.Date_Processed <= "' . $_POST['endDate']. '";';
        } else {
            $stmt .= 'AND Transactions.Date_Processed < "'. substr($_POST['endDate'], 0, 4) . '-01-01";';
        }    
    } else {
        $stmt .= 'AND Transactions.Date_Processed >= "' . $_POST['startDate'] . '" AND Transactions.Date_Processed <= "' . $_POST['endDate']. '";';
    }

    // Run the sql query
    $result = runSqlStatement($stmt, false);

    // Adds proper label for json object
    if ($isNetExpense) {
        $data = '"netExpense":[';
    } else {
        $data = '"retainedExpense":[';
    }

    $data .= 0 . ',';

    // Parses through the result and adds to json array
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $data .= $row['Amount'] . ',';
        }
    } else {
        echo "";
    }

    return rtrim($data, ",") . '],';
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