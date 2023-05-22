<?php
session_start();
// Setup connection.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'debian-sys-maint';
$DATABASE_PASS = 'lJzt0TVejdnMz50I';
$DATABASE_NAME = 'logins';

//Check if connection exists
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
        exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if ( !isset($_POST['username'], $_POST['password']) ) {
        exit('Please fill both the username and password fields!');
}
if ($stmt = $con->prepare('SELECT id, password FROM users WHERE username = ?')) {
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();

        $stmt->store_result();

        if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();

        if ($_POST['password'] === $password) {
                //Create Session
                session_regenerate_id();
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['name'] = $_POST['username'];
                $_SESSION['id'] = $id;
                $_SESSION["ClientChosen"] = "None";
                header("Location: index.php");
        } else {
                // Wrong password
                header("Location: login.php?error=Incorect User name or password");
        }
        } else {
                // Wrong username
                header("Location: login.php?error=Incorect User name or password");
        }
	$stmt.close();
}
?>
