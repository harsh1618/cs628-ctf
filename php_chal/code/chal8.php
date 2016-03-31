<?php
  session_start();
  if(!isset($_SESSION['username'])) {
    header('Location: login.php');
  }
  else {
      $secret = "Cj8MVcz9CIMcltbpCDzQ";
      if (array_key_exists("logged_in", $_COOKIE) && $_COOKIE["logged_in"] === "1") {
          if (array_key_exists("HTTP_REFERER", $_SERVER) && strstr($_SERVER["HTTP_REFERER"], "example.com")) {
              if (array_key_exists("HTTP_USER_AGENT", $_SERVER) && strstr($_SERVER["HTTP_USER_AGENT"], "CS628")) {
                  $flag = md5($secret . "8" . $_SESSION['username']);
                  header("X-HTTP-Flag: flag{". $flag . "}");
                  echo "Congratulations !! The flag has been sent.";
              }
              else {
                  echo "You should use the CS628 browser to view the flag.";
              }
          }
          else {
              echo "You should come to this site from example.com";
          }
      }

      else {
          setcookie("logged_in", "0");
          echo "You are not logged in";
      }
  }
?>
