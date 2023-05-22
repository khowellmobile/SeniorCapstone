<!DOCTYPE html>
<html>
<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
<link 
	href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" 
	integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" 
	crossorigin="anonymous">
  <style>
		<?php include "index.css"; ?>
	</style>
</head>
<style>
body { font-family: 'Montserrat', sans-serif; font-size: 20px;}
* {box-sizing: border-box}

/* Full-width input fields */
input[type=text], input[type=password], [type=email] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
}

input[type=text]:focus, input[type=password]:focus, [type=email]:focus {
  background-color: #ddd;
  outline: none;
}

hr {
  border: 2px solid #f1f1f1;
  margin-bottom: 25px;
}

/* Set a style for all buttons */
button {
  background-color: #04AA6D;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
  border-radius: 5px;
}

button:hover {
  opacity:1;
}

/* Float cancel and signup buttons and add an equal width */
.signupbtn {
  width: 50%;
  border-radius: 5px;
}

/* Add padding to container elements */
.container {
  padding: 16px;
}

</style>
<body>
<div class="container">
<form method="post" action="createAccountHAEmployee.php">
    <div class="goback">
        <a href="login.php">Go Back</a>
    </div>
    <br>
    <h1>Howell Associate Employee Sign Up</h1>
    <p>Please fill out this form to create an account.</p>
    <hr>
    <label for="firstName"><b>First Name</b></label>
    <input class="form-control" type="text" placeholder="Enter First Name" name="firstName" required>

    <label for="lastName"><b>Last Name</b></label>
    <input class="form-control" type="text" placeholder="Enter Last Name" name="lastName" required>

    <label for="email"><b>Email</b></label><br>
    <input class="form-control" type="email" placeholder="Enter Your Email" name="email" required><br>

    <label for="number"><b>Phone Number (format: xxx-xxx-xxxx):</b></label>
    <input class="form-control" type="text" placeholder="Enter Your Phone Number" name="number" pattern="^\d{3}-\d{3}-\d{4}$" required>

    <input class="form-control" type="hidden" id="positionID" name="positionID" value="2">

    <input class="form-control" type="hidden" id="isDeleted" name="isDeleted" value="0">

    <div class="text-center">
      <a href="login.php">
        <button type="submit" class="signupbtn btn-primary">Sign Up</button>
      </a>
  </div>
</form>
</div>
</body>
</html>