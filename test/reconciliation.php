<?php

session_start();

if ($_SESSION['loggedin'] == true) {
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

    <!-- Links for jquery, table plugin, .js file -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script> 
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.js"></script>
    <script src="reconciliation.js"></script>
    <link
        href=
        "https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        rel="stylesheet"
    />
    <link
        href=
        "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css"
        rel="stylesheet"
    />
    <script src=
        "https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js">
    </script>
    <script src=
        "https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js">
    </script>
    <script src=
        "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js">
    </script>

    <style>
       p {
        margin:0;
       } 
    </style>

     <title>Reconciliation</title>
</head>

<body>
    <div class="container">
        <br>
        <div class="row">
            <div class="goback">
                <a href="index.php">Go Back</a>
            </div>
            <div class="text-center">
                <h1 class="welcome">Reconciliation</h1>
            </div>
        </div>
        <form method="POST" action="" id="ReconInfo">
            <div class="row">
                <div class="col-sm-4">
                    <label for="BankAccount">Bank Account:</label><br>
                    <select class="form-control input-sm" id="BankAccount" name="BankAccount" required>
                    </select>
                </div>
                <div class="col-sm-4">
                    <label for="reconciliationDate">Date:</label><br>
                    <input type="text" class="date form-control input-sm" type="date" id="reconciliationDate" name="reconciliationDate" required>
                </div>
                <div class="col-sm-4">
                    <label for="endBalance">Ending balance:</label><br>
                    <input type="number" id="endBalance" name="endBalance" required class="form-control input-sm">
                </div>
            </div>
            <div class="text-center" style="margin-top:15px">
                    <input class="sb" id="ReconInfoSubmit" type="submit" value="Submit">
            </div>
        </form>
        <br>
        <div id="DiffTotalDisplay">
            <div class="row">
                <div class="col-sm-3 text-center">
                    <h2 id="PrevAccountTotal">0.00</h2>
                </div>
                <div class="col-sm-2 text-center">
                    <h2 id="MinusSign">-</h2>
                </div>
                <div class="col-sm-2 text-center">
                    <h2 id="CurrAccountTotal">0.00</h2>
                </div>
                <div class="col-sm-2 text-center">
                    <h2 id="EqualSign">=</h2>
                </div>
                <div class="col-sm-3 text-center">
                    <h2 id="DiffAccountTotal">0.00</h2>
                </div>
            </div>
        </div>
        <!-- Div for input table to preserve previous functionality -->
        <div id="tableDiv">
            <table id="inputTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Trans. No.</th>
                        <th>Account</th>
                        <th>Memo</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>CheckBox</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
    
            <button class="sb" id="sumbitButton">Submit</button>
        </div>
    </div>
</div>
<script type="text/javascript">
      $(".date").datepicker({
        format: "yyyy-mm-dd",
      });
</script>
<!-- fixing error with multiple js versions -->
<script>
    var jq16 = jQuery.noConflict(true); 

    (function ($) {
        $(document).ready(function () {
            console.log($.fn.jquery);
        });
    })(jq16);

    console.log($.fn.jquery);

</script>
</body>

</html>
<?php
} else {
    header("Location: login.php");
    exit();
}
?>
