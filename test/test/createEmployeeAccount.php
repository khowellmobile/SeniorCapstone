<!DOCTYPE html>
<html>
<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
</head>
<style>
body { font-family: 'Montserrat', sans-serif; font-size: 20px;}
* {box-sizing: border-box}

/* Full-width input fields */
input[type=text], input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
}

input[type=text]:focus, input[type=password]:focus {
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
}

button:hover {
  opacity:1;
}

/* Extra styles for the cancel button */
.cancelbtn {
  padding: 14px 20px;
  background-color: #f44336;
}

/* Float cancel and signup buttons and add an equal width */
.cancelbtn, .signupbtn {
  float: left;
  width: 50%;
}

/* Add padding to container elements */
.container {
  padding: 16px;
}

/* Clear floats */
.clearfix::after {
  content: "";
  clear: both;
  display: table;
}

/* Change styles for cancel button and signup button on extra small screens */
@media screen and (max-width: 300px) {
  .cancelbtn, .signupbtn {
     width: 100%;
  }
}
</style>
<body>

<form action="/action_page.php" style="border:1px solid #ccc">
  <div class="container">
    <h1>Howell Associate Employee Sign Up</h1>
    <p>Please fill in this form to create an account.</p>
    <hr>

    <label for="firstName"><b>First Name</b></label>
    <input type="text" placeholder="Enter First Name" name="firstName" required>

    <label for="lastName"><b>Last Name</b></label>
    <input type="text" placeholder="Enter Last Name" name="lastName" required>

    <label for="email"><b>Email</b></label><br>
    <input type="email" placeholder="Enter Your Email" name="email" required><br>

    <label for="number"><b>Phone Number</b></label>
    <input type="text" placeholder="Enter Your Phone Number" name="number" required>

    <div class="clearfix">
      <a href="login.php">
        <button type="button" class="cancelbtn">Cancel</button>
      </a>
      <a href="login.php">
        <button type="button" class="signupbtn">Sign Up</button>
      </a>
    </div>
  </div>
</form>

</body>
</html>