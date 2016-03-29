<?php
  session_start();
  if(!isset($_SESSION['username'])) {
    header('Location: login.php');
  }
?>
<!DOCTYPE html>
<html>
<head>
  <!--Import Google Icon Font-->
  <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!--Import materialize.css-->
  <link type="text/css" rel="stylesheet" href="static/materialize.min.css"  media="screen,projection"/>

  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body>
<nav>
  <div class="nav-wrapper">
    <a href="#" class="brand-logo">YO!YO!</a>
    <ul id="nav-mobile" class="right hide-on-med-and-down">
    </ul>
  </div>
</nav>

<div class="row">
  <div class="col s12 m12">

    <div class="card-panel blue-grey" style="margin-top:5em; height: 20em; ">
      <div class="form-wrapper">
        <form>
          <div class="input-field" style="width:80%; margin-left: 7em; margin-top: 5.5em">
            <input id="search" type="search" required>
            <label for="search"><i class="material-icons">search</i></label>
            <i class="material-icons">close</i>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<footer class="page-footer">
  <div class="container">
    <div class="row">
      <div class="col l6 s12">
        <h5 class="white-text">Something Important</h5>
        <p class="grey-text text-lighten-4">Version - <span id="version"></span></p>
      </div>
      <div class="col l4 offset-l2 s12">
        <h5 class="white-text">Links</h5>
        <ul>
          <li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>
          <li><a class="grey-text text-lighten-3" href="#!">Link 2</a></li>
          <li><a class="grey-text text-lighten-3" href="#!">Link 3</a></li>
          <li><a class="grey-text text-lighten-3" href="#!">Link 4</a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="footer-copyright">
    <div class="container">
      © 2014 Copyright Text
      <a class="grey-text text-lighten-4 right" href="#!">More Links</a>
    </div>
  </div>
</footer>

<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="static/materialize.min.js"></script>
<script>
  $.ajax('.git/refs/heads/master').done(function(version){$('#version').html(version.substring (0,6))});
</script>

</body>
</html>
