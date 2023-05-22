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
    <title>Reports</title>
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
        <h1 class="welcome">Reports</h1>
        </div>
    </div>
    <form method="POST" action="showData.php" onsubmit="return validateReportsForm()">
        <label for="startDate">Start Date:</label><br>
        <div class="col-sm-4">
        <input class="date form-control input-sm" type="text" id="startDate" name="startDate" required><br>
        </div>
        <label for="endDate">End Date:</label><br>
        <div class="col-sm-4">
        <input class="date form-control input-sm" type="text" id="endDate" name="endDate" required><br>
        </div>
        <label for="typeOfReport">Type of Report:</label> <br>
        <div class="col-sm-4">
        <select class="form-control input-sm" name="cars" id="cars" required>
	        <option value="profitLoss">Profit & Loss</option>
	        <option value='transactions'>Transactions</option>
            <option value="balanceSheet">Balance Sheet</option>
            <option value="custom">Custom</option>
        </select> <br>
        </div>
        <div class="text-center">
        <input class="sb" type="submit" value="Submit">
        </div>
    </form>
    </div>
    <script type="text/javascript">
      $(".date").datepicker({
        format: "yyyy-mm-dd",
      });
</script>
</body>

</html>
<?php
} else {
    header("Location: login.php");
    exit();
}
?>
