<?php

session_start();

	if ($_SESSION['loggedin'] == true) {
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
	 <?php include "header.php"; ?>
	 <style>
		<?php include "index.css"; ?>
	</style>
	<meta charset="UTF-8">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link 
	href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" 
	integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" 
	crossorigin="anonymous">
	<title>Scribe landing page</title>
	<script defer src="index.js"></script>
</head>
<body>
	<div class="container">
	<br>
	<div class="row">
		<div class="welcome" id="welcome">
			<h1>Welcome!</h1>
		</div>
	</div>
	<br>
	<div class="buttons">
		<input class="block" id="statementInput" type="submit" name="statementInput" value="Statement Input" /> <br> <br>
		<input class= "block" id="reconciliation" type="submit" name="reconciliation" value="Reconciliation" /> <br> <br>
		<input class="block" id="accountAdjustment" type="submit" name="accountAdjustment" value="Account Adjustment" /> <br> <br>
		<input class="block" id="reports" type="submit" name="reports" value="Reports" /> <br> <br>
		<input class="block" id="clients" type="submit" name="clients" value="Clients" /> <br> <br>
	</div>
</div>
</body>
<br>
<footer class="foot">
	<p>Developed by Tom Deep, Kent Howell, Francie O'Neil, Emma Orazen, and Aaron Passalacqua</p>
</footer>
</html>
<?php
} else {
    header("Location: login.php");
	exit(); 
}
?>
