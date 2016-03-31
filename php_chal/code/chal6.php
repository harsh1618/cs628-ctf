<?php

// HINT: Flag file is /flags/<username>.flag in the chroot
// HINT: The following binaries are available in the chroot
//       awk bash cat echo grep ls ping sed whoami

  session_start();
  if(!isset($_SESSION['username'])) {
    header('Location: login.php');
  }
  else {
    if(array_key_exists("ip", $_POST)) {
      $date = date("d H:i:s", time() + (330 * 60));
      file_put_contents('/var/www/html/chal6.log', $_SESSION['username'] . " " . $date . " " . $_POST['ip'] . "\n", FILE_APPEND);
      $sanitized_ip = str_replace("'", "", $_POST['ip']);
      $output = NULL;
      $retval = NULL;
      $command = "sudo /usr/sbin/chroot --userspec='". $_SESSION['username'] . ":" . $_SESSION['username'] . "' /var/www/html/chroot";
      $command .= " /bin/bash -c '/bin/ping -c 1 -W 1 \"" . $sanitized_ip . "\"' 2>&1";
      //echo $command;
      exec($command, $output, $retval);
      //var_dump($output);
      if($retval == 0) echo "<script>alert('Host is reachable')</script>";
      else echo "<script>alert('Host seems down')</script>";
    }
?>
<!DOCTYPE html>
<html>
<head>
  <!--Import Google Icon Font-->
  <link href="static/icon.css" rel="stylesheet">
  <!--Import materialize.css-->
  <link type="text/css" rel="stylesheet" href="static/materialize.min.css"  media="screen,projection"/>

  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body>
<nav>
  <div class="nav-wrapper">
    <a href="#" class="brand-logo">Challenge 6</a>
    <ul id="nav-mobile" class="right hide-on-med-and-down">
    </ul>
  </div>
</nav>

<div class="row">
  <div class="col s12 m12">
    <div class="card-panel" style="margin-top:5em; height: 20em; ">
        <div class="row">
          <div class="col s4" style="padding:2em;">
            Is it down for just me?
          </div>
          <form class="col s8", action='/chal6.php', method='POST'>
            <div class="row">
              <div class="input-field col s6">
                <input type="text" id="ip" name="ip" required>
                <label for="ip">Host</label>
              </div>
              <div class="input-field col s6">
                <button class="btn waves-effect waves-light", type="submit", name="submit">
                  Submit
                  <i class="material-icons right">send</i>
                </button>
              </div>
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
        <h5 class="white-text"></h5>
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
  $.ajax('.git/refs/heads/master').done(function(version){$('#version').html('Version: ' +  version.substring (0,6))});
</script>

</body>
</html>
<? } ?>
