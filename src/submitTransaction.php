<?php

// get relevant data from js page
$pdata = $_POST['data'];
$rowCount = $_POST['rowCount'];
$bankAccountID = $_POST["BankAccountID"];

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

// Prepare the SQL statement
$stmt;
$amount;

for ($i = 0; $i < $rowCount; $i++) {
    // Does not generate query in the case of empty debit and credit values
    if ($arr["row-{$i}-debit"] == NULL && $arr["row-{$i}-credit"] == NULL) continue;

    // If-Else to handle changing debits to negative
    if ($arr["row-{$i}-debit"] == NULL){
        $amount = $arr["row-{$i}-credit"];
    } else {
        $amount = -$arr["row-{$i}-debit"];
    }

    $stmt .= 'CALL spTransactions_Add(' . $bankAccountID . ', \'2000-01-01\',\'' .  $arr["row-{$i}-date"] . '\',' . $amount . ',\'' . 
            $arr["row-{$i}-memo"] . '\',\'' . $arr["row-{$i}-transNum"] . '\',1,' . $arr["row-{$i}-account"] . ',0,0);';
 
}

echo $stmt;

//Should run all queries
mysqli_multi_query($conn, $stmt);

//Closing the connection
mysqli_close($conn);

// Redirect the user to a success page
//header("Location: index.php");

echo 'success';

?>
