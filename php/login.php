<?php
require 'db_config.php';

$email = $mysqli->escape_string($_POST['email']);
$result = $mysqli->query("SELECT * FROM users WHERE email='$email'");

/* Return error if user doesn't exist */
if ( $result->num_rows == 0 ) {
  $message = "No account matching the specified email address exists.";
  errorRedirect($message);
}
else {
  $user = $result->fetch_assoc();
  /* Check that the hashed password stored in the database matches the password */
  if (password_verify($_POST['pass'], $user['pass'])) {
    $_SESSION['email'] = $user['email'];
    $_SESSION['github_auth'] = $user['github_auth'];
      
    /* Redirect to account page */
    header("location: /GH-WorkItems/account.html");
  }
  else {
    $message = "The password entered is incorrect.";
    errorRedirect($message);
  }
}
?>
