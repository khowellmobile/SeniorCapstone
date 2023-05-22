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
            <form method="POST" action="" id="ReconInfo">
                <div class="row">
                    <div class="col-sm-6">
                        <label for="adjustmentDate">Adjustment Date:</label><br>
                        <input type="text" class="date form-control input-sm" type="date" id="adjustmentDate" name="adjustmentDate" required>
                    </div>
                    <div class="col-sm-6">
                        <label for="adjustmentName">Adjustment Name:</label><br>
                        <input type="text" class="form-control input-sm" id="adjustmentName" name="adjustmentName" required>
                    </div>
                </div>
            </form>
            <div id="tableDiv">
                <button style="margin-top: 15px" class="sb" id="addRow">Add new row</button>
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
                        <tfoot>
                            <tr>
                              <td></td>
                              <td>Totals:</td>
                              <td id="debitsTotal">0.00</td>
                              <td id="creditsTotal">(0.00)</td>
                              <td id="difference">Difference: 0.00</td>
                            </tr>
                        </tfoot>
                    </table>
                <button class="sb" id="sumbitButton">Submit</button>

                <input type="hidden" id="clientID" name="clientID" value='<?php echo $_SESSION['ClientID'] ?>'>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript">
      $(".date").datepicker({
        format: "yyyy-mm-dd",
      });

    var jq16 = jQuery.noConflict(true); 

    (function ($) {
        $(document).ready(function () {
            console.log($.fn.jquery);
        });
    })(jq16);

    console.log($.fn.jquery);

</script>
</html>
<?php
}else{
     header("Location: login.php");
     exit();
}
?>
