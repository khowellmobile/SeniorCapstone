<?php?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
  <link 
	href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" 
	integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" 
	crossorigin="anonymous">
  <style>
      .scribeButton {
        background-color: Transparent;
        border: none;
        font-size: 35px;
        font-family: 'Montserrat', sans-serif;
        margin-top: 5px;
        margin-left: 10px;
      }
      .logoutButton {
        text-align: right;
        padding: 1px;
        width: 100px;
        background-image: linear-gradient(#f7f8fa ,#e7e9ec);
        border-color: #adb1b8 #a2a6ac #8d9096;
        border-style: solid;
        border-width: 1px;
        border-radius: 3px;
        box-shadow: rgba(255,255,255,.6) 0 1px 0 inset;
        box-sizing: border-box;
        color: #0f1111;
        cursor: pointer;
        display: inline-block;
        font-family: 'Montserrat', sans-serif;
        font-size: 14px;
        height: 29px;
        font-size: 16px;
        outline: 0;
        overflow: hidden;
        padding: 0 11px;
        text-align: center;
        text-decoration: none;
        text-overflow: ellipsis;
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
        white-space: nowrap;
        margin-top: 15px;
        margin-right: 10px;
      }

      #client {
        text-align: right;
        padding: 1px;
        width: 30%;
        background-image: linear-gradient(#f7f8fa ,#e7e9ec);
        border-color: #adb1b8 #a2a6ac #8d9096;
        border-style: solid;
        border-width: 1px;
        border-radius: 3px;
        box-shadow: rgba(255,255,255,.6) 0 1px 0 inset;
        box-sizing: border-box;
        color: #0f1111;
        cursor: pointer;
        display: inline-block;
        font-family: 'Montserrat', sans-serif;
        font-size: 14px;
        height: 29px;
        font-size: 16px;
        outline: 0;
        overflow: hidden;
        padding: 0 11px;
        text-align: center;
        text-decoration: none;
        text-overflow: ellipsis;
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
        white-space: nowrap;
        margin-top: 15px;
        margin-right: 10px;
      }

      #selection, #clientselected {
        color: #0f1111;
        display: inline-block;
        font-family: 'Montserrat', sans-serif;
        font-size: 14px;
        height: 29px;
        font-size: 16px;
        outline: 0;
        overflow: hidden;
        text-align: center;
        text-decoration: none;
        text-overflow: ellipsis;
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
        white-space: nowrap;
      }
      img {
        float: center;
      }
    </style>
</head>
<body>
<div class="container">
 <div class="navigation-bar">
    <div id="navigation-container">
      <a href="logout.php">
        <button type="button" class="logoutButton" style="float: right;"> Log Out </button>
      </a>
    <br>
    <div class="text-center">
      <a href="index.php">
      <img src="../Images/scribe-logo.png" alt="Scribe Logo" width="180" height="130">
      </a>
      </div>
      <br>
        <form method="post" action="clientSession.php" style="float: center;"> 
          <select name="client" id="client">
            <option value="none"> None </option>
              <?php
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
              $sql = "SELECT ClientID, ClientName FROM Clients";
              $result = mysqli_query($conn, $sql);

              // Output data of each row
              while($row = mysqli_fetch_assoc($result)) {
                echo "<option class='form-control' value=" . $row['ClientName'] . ">" . $row['ClientName'] . "</option>";
              }

              // Close MySQL connection
              mysqli_close($conn);
            ?>
         </select>

         <input type="submit" class="logoutButton" value="Submit">
        </form>
      <br>
      <table>
        <tr>
          <td id="selection">Client selected: </td><td id="clientselected"><?php echo $_SESSION["ClientChosen"] ?></td>
        </tr>
      </table>
      </div>
  </div>
  </div>
</body>
</html>
