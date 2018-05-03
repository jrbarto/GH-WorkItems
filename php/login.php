<?php
/* PHP script to verify user credentials upon login */

require 'db_config.php';

$error_return = '/GH-WorkItems/login.html'; // Page to return to after error redirect
$username = $mysqli->escape_string($_POST['username']);
$result = $mysqli->query("SELECT * FROM users WHERE username='$username'");

/* Return error if user doesn't exist */
if ( $result->num_rows == 0 ) {
  $message = "No account matching the specified username exists.";
  errorRedirect($message, $error_return);
}
else {
  $user = $result->fetch_assoc();
  /* Check that the hashed password stored in the database matches the password */
  if (password_verify($_POST['pass'], $user['pass'])) {
    $_SESSION['username'] = $user['username'];
    $_SESSION['github_auth'] = $user['github_auth'];
    $_SESSION['github_user'] = $user['github_user'];
      
    /* Redirect to account page */
    header("location: account.php");
  }
  else {
    $message = "The password entered is incorrect.";
    errorRedirect($message, $error_return);
  }
}
?>
