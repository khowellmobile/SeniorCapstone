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
<form method="post" action="submitTransaction.php">
<div class="form-group">
  <label for="BankAccountID">Bank Account ID:</label><br>
  <div class="col-sm-4">
  <input class="form-control input-sm" type="number" id="BankAccountID" name="BankAccountID" required>
  </div><br>
  <label for="Date_Made">Date Made:</label><br>
  <div class="col-sm-4">
  <input class="form-control input-sm" type="date" id="Date_Made" name="Date_Made" required>
  </div><br>
  <label for="Date_Processed">Date Processed:</label><br>
  <div class="col-sm-4">
  <input class="form-control input-sm" type="date" id="Date_Processed" name="Date_Processed" required>
  </div><br>
  <label for="amount">Amount:</label><br>
  <div class="input-group col-sm-4">
            <div class="input-group-prepend">
            <span class="input-group-text">$</span>
            </div>
            <input type="number" id="amount" name="amount" required class="form-control input-sm" aria-label="Amount (to the nearest dollar)">
            <div class="input-group-append">
            <span class="input-group-text">.00</span>
            </div>
  </div><br>
  <label for="Description">Description:</label><br>
  <div class="col-sm-4">
  <input class="form-control input-sm" type="text" id="Description" name="Description" required>
  </div><br>
  <label for="TransactionTypeID">Transaction Type: (Number)</label><br>
  <div class="col-sm-4">
  <input class="form-control input-sm" type="number" id="TransactionTypeID" name="TransactionTypeID" required>
  </div><br>
  <label for="isDeleted">Deleted:</label><br>
  <div class="col-sm-4">
  <input class="form-control input-sm" type="number" id="isDeleted" name="isDeleted" required>
  </div><br>
  <div class="text-center">
        <input class="sb" type="submit" value="Submit">
    </div>
</div>
</form>
</div>
<br>
<!-- Div to hold the input table and not effect previous input functionality-->
<div id="tableDiv">
    <button id="addRow">Add new row</button>
    <table id="inputTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Date</th>
                <th>Amount</th>
                <th>Memo</th>
                <th>Account</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <button id="sumbitButton">Submit</button>
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
