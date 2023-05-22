<!DOCTYPE html>
<html>
<head>
 <meta charset="UTF-8">
    <title>Clients</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link 
	href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" 
	integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" 
    crossorigin="anonymous">
    <style>
		<?php include "index.css"; ?>
	</style>
    <link rel="stylesheet" href="index.css">
    <!-- CSS FOR STYLING THE PAGE -->
    <style>
        table {
            margin: 0 auto;
            font-weight: bolder;
            border: 1px solid black;
            font-family: 'Montserrat', sans-serif;
        }

        td {
            background-color: #E4F5D4;
            border: 1px solid black;
            font-family: 'Montserrat', sans-serif;
        }

        th,
        td {
            font-weight: bold;
            border: 1px solid black;
            padding: 10px;
            text-align: center;
            font-family: 'Montserrat', sans-serif;
        }

        td {
            font-weight: lighter;
            font-family: 'Montserrat', sans-serif;
        }
    </style>
</head>

<body>
<br>
<div class="container">
    <div class="row">
        <div class="goback">
            <a href="index.php">Go Back</a>
        </div>
        <div class="goback" style="width:10%">
            <a href="addClient.php">Add Client</a>
        </div>
        <div class="text-center">
            <h1 class="welcome">Howell Associates Clients</h1>
        </div>
    </div>
        <table style="width:100%">
                <thead>
                        <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Description</th>
                                <th>Date Aquired</th>
                        </tr>
                </thead>
                <tbody>
                <?php
                        // Create a connection to the database
                        $servername = "localhost";
                        $username = "debian-sys-maint";
                        $password = "lJzt0TVejdnMz50I";
                        $dbname = "ScribeDB";

                        $conn = new mysqli($servername, $username, $password, $dbname);

                        // Check the connection
                        if ($conn->connect_error) 
				            die("Connection failed: " . $conn->connect_error);
                      
                            // Check connection
                        if (!$conn) 
                            die("Connection failed: " . mysqli_connect_error());

                        // Execute SELECT query
                        $sql = "SELECT ClientID, ClientName, ClientAddress, ClientEmail, Contact_PhoneNumber, Description, Date_Aquired FROM Clients";
                        $result = mysqli_query($conn, $sql);

                        // Output data of each row
                        while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row["ClientID"] . "</td>";
                                echo "<td>" . $row["ClientName"] . "</td>";
                                echo "<td>" . $row["ClientAddress"] . "</td>";
                                echo "<td>" . $row["ClientEmail"] . "</td>";
                                echo "<td>" . $row["Contact_PhoneNumber"] . "</td>";
                                echo "<td>" . $row["Description"] . "</td>";
                                echo "<td>" . $row["Date_Aquired"] . "</td>";
                                echo "</tr>";
                        }

                        // Close MySQL connection
                        mysqli_close($conn);    
                ?> 
            </tbody>
        </table>
</div>
</body>
</html>
