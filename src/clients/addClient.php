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
</head>
<style>
		<?php include "index.css"; ?>
	</style>
<style>
body { font-family: 'Montserrat', sans-serif; font-size: 20px;}
* {box-sizing: border-box}

/* Full-width input fields */
input[type=text], input[type=password], input[type=email] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
  border-radius: 5px;
}

input[type=text]:focus, input[type=password]:focus, input[type=email]:focus {
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

/* Float cancel and signup buttons and add an equal width */
.signupbtn {
  width: 30%;
  border-radius: 5px;
}
/* Add padding to container elements */
.container {
  padding: 16px;
}

</style>
<body>

<form action="addClient.php" style="border:1px solid #ccc">
  <div class="container">
  <br>
        <div class="row">
            <div class="goback">
                <a href="clients.php">Go Back</a>
            </div>
            <div class="text-center">
                <h1 class="welcome">Add Client</h1>
            </div>
        </div>
    <p>Please fill in this form to add a client</p>
    <hr>
    <label for="clientName"><b>Client Name</b></label>
    <input class="form-control" type="text" placeholder="Enter Client Name" id="clientName" name="clientName" required>

    <label for="clientAddress"><b>Client Address</b></label>
    <input class="form-control" type="text" placeholder="Enter Client Address"id="clientAddress" name="clientAddress" required>

    <label for="clientEmail"><b>Client Email</b></label>
    <input class="form-control" type="email" placeholder="Enter Client Email" id="clientEmail" name="clientEmail" required><br>

    <label for="clientPhone"><b>Client Phone Number (format: xxx-xxx-xxxx):</b></label>
    <input class="form-control" type="text" placeholder="Enter Client Phone Number" id="clientPhone" name="clientPhone" pattern="^\d{3}-\d{3}-\d{4}$" required>

    <label for="description"><b>Client Description</b></label>
    <input class="form-control" type="text" placeholder="Enter Client Description" id="description" name="description" required>
   
    <div class="text-center">
      <a href="clients.php">
        <button type="submit" class="signupbtn btn-primary">Add Client</button>
      </a>
    </div>
  </div>
</form>

</body>
</html>
