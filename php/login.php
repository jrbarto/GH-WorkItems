<?php
require 'db_config.php';

$email = $mysqli->escape_string($_POST['email']);
$result = $mysqli->query("SELECT * FROM users WHERE email='$email'");

// Return error if user doesn't exist
if ( $result->num_rows == 0 ) {
  $_SESSION['error'] = "No account matching the specified email address exists.";
  header("location: error.php");
}
else {
  $user = $result->fetch_assoc();
  // Check that the hashed password stored in the database matches the password
  if (password_verify($_POST['pass'], $user['pass'])) {
    $_SESSION['email'] = $user['email'];
    $_SESSION['github_auth'] = $user['github_auth'];
      
    header("location: account.php");
  }
  else {
    $_SESSION['error'] = "The password entered is incorrect.";
    header("location: error.php");
  }
}
?>