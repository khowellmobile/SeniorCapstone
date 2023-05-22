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

    <!-- Links for jquery, table plugin, and .js file-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script> 
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.js"></script>
    <script src="statementInput.js"></script>


    <title>Statement Input</title>
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
<br>
<div class="container">
    <div class="row">
        <div class="goback">
            <a href="index.php">Go Back</a>
        </div>
        <div class="text-center">
        <h1 class="welcome">Statement Input</h1>
        </div>
    </div>
</div>
<br>
<form method="POST" action="" id="ReconInfo">
    <div class="row">
        <div class="col-sm-4">
        </div>
        <div class="col-sm-4">
            <label for="BankAccount">Bank Account:</label><br>
            <select class="form-control input-sm" id="BankAccount" name="BankAccount" required>
            </select>
        </div>
        <div class="col-sm-4">
        </div>
    </div>
</form>
<!-- Div to hold the input table and not effect previous input functionality-->
<div id="tableDiv">
    <button class="sb" id="addRow">Add new row</button>
    <table id="inputTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Date</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Trans. No</th>
                <th>Memo</th>
                <th>Account</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <button class="sb" id="sumbitButton">Submit</button>
</div>
<br>
</body>

</html>
<?php
}else{
     header("Location: login.php");
     exit();
}
?>
