<?php?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="header.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
  <style>
      .scribeButton {
        background-color: Transparent;
        border: none;
        font-size: 35px;
        font-family: 'Montserrat', sans-serif;
        margin-top: 5px;
        margin-left: 10px;
      }
      .logoutButton {
        text-align: right;
        padding: 1px;
        width: 100px;
        background-image: linear-gradient(#f7f8fa ,#e7e9ec);
        border-color: #adb1b8 #a2a6ac #8d9096;
        border-style: solid;
        border-width: 1px;
        border-radius: 3px;
        box-shadow: rgba(255,255,255,.6) 0 1px 0 inset;
        box-sizing: border-box;
        color: #0f1111;
        cursor: pointer;
        display: inline-block;
        font-family: 'Montserrat', sans-serif;
        font-size: 14px;
        height: 29px;
        font-size: 16px;
        outline: 0;
        overflow: hidden;
        padding: 0 11px;
        text-align: center;
        text-decoration: none;
        text-overflow: ellipsis;
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
        white-space: nowrap;
        margin-top: 15px;
        margin-right: 10px;
      }

    </style>
</head>
 <div class="navigation-bar">
    <div id="navigation-container">
      <a href="index.php">
        <button type="button" class="scribeButton"> Scribe </button>
      </a>
      <a href="login.php">
        <button type="button" class="logoutButton" style="float: right;"> Log Out </button>
      </a>
      </div>
  </div>
</body>
</html>
