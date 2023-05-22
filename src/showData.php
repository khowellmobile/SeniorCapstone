<?php
 
// Username is root
$user = 'debian-sys-maint';
$password = 'lJzt0TVejdnMz50I';
 
$database = 'HADB';
 
// Server is localhost with
// port number 3306
$servername='localhost:3306';
$mysqli = new mysqli($servername, $user,
                $password, $database);
 
// Checking for connections
if ($mysqli->connect_error) {
    die('Connect Error (' .
    $mysqli->connect_errno . ') '.
    $mysqli->connect_error);
}

//grab start and end date filter
$start = $_POST['startDate'];
$end = $_POST['endDate'];
 
// SQL query to select data from database
$sql = " SELECT * FROM Transactions WHERE Date_Made between '$start' and '$end'";
$result = $mysqli->query($sql);
$mysqli->close();
?>

<!-- HTML code to display data in tabular format -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Display Data</title>
    <link rel="stylesheet" href="home.css">
    <!-- CSS FOR STYLING THE PAGE -->
    <style>
        table {
            margin: 0 auto;
            font-size: large;
            border: 1px solid black;
        }

        h1 {
            text-align: center;
            color: #006600;
            font-size: xx-large;
            font-family: 'Gill Sans', 'Gill Sans MT',
            ' Calibri', 'Trebuchet MS', 'sans-serif';
        }

        td {
            background-color: #E4F5D4;
            border: 1px solid black;
        }

        th,
        td {
            font-weight: bold;
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }

        td {
            font-weight: lighter;
        }
    </style>
</head>

<body>
<div class ="row">
	<div>
	<a href="reports.php">Go Back</a>
	</div>
</div>
    <section>
        <h1>Transactions</h1>
        <!-- TABLE CONSTRUCTION -->
        <table>
            <tr>
                <th>ID</th>
		<th>Bank Account ID</th>
		<th>Date Made</th>
		<th>Date Processed</th>
		<th>Amount</th>
		<th>Description</th>
		<th>Transaction Type</th>
		<th>Deleted</th>
            </tr>
            <!-- PHP CODE TO FETCH DATA FROM ROWS -->
            <?php
                // LOOP TILL END OF DATA
                while($rows=$result->fetch_assoc())
                {
            ?>
            <tr>
                <!-- FETCHING DATA FROM EACH
                    ROW OF EVERY COLUMN -->
                <td><?php echo $rows['ID'];?></td>
		<td><?php echo $rows['BankAccountID'];?></td>
		<td><?php echo $rows['Date_Made'];?></td>
		<td><?php echo $rows['Date_Processed'];?></td>
		<td><?php echo $rows['Amount'];?></td>
		<td><?php echo $rows['Description'];?></td>
		<td><?php echo $rows['TransactionTypeID'];?></td>
		<td><?php echo $rows['isDeleted'];?></td>
            </tr>
            <?php
                }
            ?>
        </table>
    </section>
</body>

</html>
