<?php 

session_start();

if ( $_SESSION['loggedin'] == true) {
?>

<!DOCTYPE html>
<html>

<head>
    <?php include "header.php"; ?>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link
	href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
	integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
	crossorigin="anonymous">
    <link rel="stylesheet" href="index.css">
    <script defer src="pages.js"></script>

    <!-- Links to jquery, table plugin, and .js file -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script> 
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.js"></script>
    <script src="accountAdjustment.js"></script>

    <title>Account Adjustment</title>
    <link
      href=
"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <script src=
"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js">
    </script>
</head>

<body>
    <div class="container">
        <br>
        <div class="row">
            <div class="goback">
                <a href="index.php">Go Back</a>
            </div>
            <div class="text-center">
                <h1 class="welcome">Account Adjustment</h1>
            </div>
            <div id="tableDiv">
                <button id="addRow">Add new row</button>
                    <table id="inputTable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Account</th>
                            <th>Debits</th>
                            <th>Credits</th>
                            <th>Memo</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    </table>
    
                <div style="white-space: nowrap;">
                    <p id="creditsTotal" style="display: inline-block;">Credits Total = 0</p>
                    <p id="debitsTotal" style="display: inline-block;">Debits Total = 0</p>
                </div>
    
                <button id="sumbitButton">Submit</button>
            </div>
        </div>
    </div>
</body>

</html>
<?php
}else{
     header("Location: login.php");
     exit();
}
?>
