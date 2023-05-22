<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link 
  href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css
  " rel="stylesheet" integrity="sha384-
  1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" 
  crossorigin="anonymous">
  <title>Login</title>
  <link rel="stylesheet" href="login-page.css">
<!--
  <script defer src="login-page.js"></script>
//-->
</head>

<body>
  <main id="main-holder" class="container">
  <img src="scribe-logo.png" alt="Scribe Logo" width="180" height="130">
  <!-- <img class="img-fluid" src="https://www.howellassociates.com/siteAssets/site7965/images/SCS_576logo_certified[1].jpg" width="200px" alt="Howell Associates"> -->
    <form id="login-form" action="authenticate.php" method="post" validate>
      <h2 id="header">Login to Scribe</h2>
      <input type="text" name="username" id="username-field" class="login-form-field" placeholder="Username" required>
      <input type="password" name="password" id="password-field" class="login-form-field" placeholder="Password" required>
      <input type="submit" value="Login" id="login-form-submit">
      <br>
      <div id="login-error-msg-holder">
      <p id="login-error-msg">Invalid username <span id="error-msg-second-line">	and/or password</span></p>
      </div>
    </form>
    <a href="createUserAccount.php">
      <button type="button" class="btn btn-link">Create User Account</button>
    </a>
    <a href="createEmployeeAccount.php">
      <button type="button" class="btn btn-link">Create Howell Associate Account</button>
    </a>
    </main>
</body>

</html>
