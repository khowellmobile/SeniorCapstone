<?php
  session_start();
    if (isset($_POST['client'])) {
        $client = $_POST['client'];
    }

  $_SESSION["ClientChosen"] = $client;

  // Create a connection to the database
  $servername = "localhost";
  $username = "debian-sys-maint";
  $password = "lJzt0TVejdnMz50I";
  $dbname = "ScribeDB";

  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check the connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Check connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Execute SELECT query
  $sql = "SELECT ClientID FROM Clients WHERE ClientName='".$client."'";
  $result = mysqli_query($conn, $sql);

  $row = mysqli_fetch_assoc($result);

  $_SESSION["ClientID"] = $row['ClientID'];

  // Close MySQL connection
  mysqli_close($conn);

  header("Location: index.php");
?>
