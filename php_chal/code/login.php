<?php
session_start();
if(isset($_SESSION['username']))  {
  header('Location: chal6.php');
}
else if(isset($_POST['username']) && isset($_POST['password'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $dbhost = 'db';
  $dbuser = 'root';
  $dbpass = 'alstest-climitation';
  $dbname = 'cs628';
  $db = new PDO('mysql:host='.$dbhost.';dbname='.$dbname, $dbuser, $dbpass);

  $stmt = $db->prepare('SELECT * FROM users WHERE username = :name and password = :password');
  $stmt->execute(array('name' => $username, 'password' => $password));
  $count = $stmt->rowCount();
  if($count > 0) {
    $_SESSION["username"] = $username;
    header('Location: chal6.php');
  }
}

?>


<!DOCTYPE html>
<html lang="en"><!--================================================================================
	Item Name: Materialize - Material Design Admin Template
	Version: 2.3
	Author: GeeksLabs
	Author URL: http://www.themeforest.net/user/geekslabs
================================================================================ --><head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="msapplication-tap-highlight" content="no">
  <meta name="description" content="CS628 Challenges">
  <title>Login Page | CS628 CTF</title>

  <!-- CORE CSS-->

  <link href="static/icon.css" rel="stylesheet">
  <link href="static/materialize.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="static/style.css" type="text/css" rel="stylesheet" media="screen,projection">
    <!-- Custome CSS-->
    <link href="static/custom-style.css" type="text/css" rel="stylesheet" media="screen,projection">
    <!-- CSS style Horizontal Nav (Layout 03)-->
    <link href="static/style-horizontal.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="static/page-center.css" type="text/css" rel="stylesheet" media="screen,projection">

  <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
  <link href="static/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="static/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">

</head>

<body class="cyan loaded">
  <!-- Start Page Loading -->
  <div id="loader-wrapper">
      <div id="loader"></div>
      <div class="loader-section section-left"></div>
      <div class="loader-section section-right"></div>
  </div>
  <!-- End Page Loading -->

  <div id="login-page" class="row">
    <div class="col s12 z-depth-4 card-panel">
      <form class="login-form" action="login.php" method="POST">
        <div class="row">
          <div class="input-field col s12 center">
            <!-- <img src="static/login-logo.png" alt="" class="circle responsive-img valign profile-image-login"> -->
            <p class="center login-form-text">CS628 CTF Login</p>
          </div>
        </div>
        <div class="row margin">
          <div class="input-field col s12">
            <i class="material-icons prefix">person_outline</i>
            <input id="username" type="text" name="username">
            <label for="username" class="center-align">Username</label>
          </div>
        </div>
        <div class="row margin">
          <div class="input-field col s12">
            <i class="material-icons prefix">lock_outline</i>
            <input id="password" type="password" name="password">
            <label for="password">Password</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <button type="submit" class="btn waves-effect waves-light col s12">Login</button>
          </div>
        </div>
      </form>
    </div>
  </div>



  <!-- ================================================
    Scripts
    ================================================ -->

  <!-- jQuery Library -->
  <script type="text/javascript" src="static/jquery-1.js"></script>
  <!--materialize js-->
  <script type="text/javascript" src="static/materialize.js"></script>
  <!--prism-->
  <script type="text/javascript" src="static/prism.js"></script>
  <!--scrollbar-->
  <script type="text/javascript" src="static/perfect-scrollbar.js"></script>

  <!--plugins.js - Some Specific JS codes for Plugin Settings-->
  <script type="text/javascript" src="static/plugins.js"></script>



<div class="hiddendiv common"></div></body></html>
