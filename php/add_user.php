<?php
/* Initial database setup and configuration */
require 'db_config.php';

$table_name = "users";
echo "EMAIL IS " . $_POST['email'];
if (trim($_POST['email']) == '') {
  $message = "All fields must be filled out when creating an account.";
  errorRedirect($message);
}

$email = $mysqli->escape_string($_POST['email']);
$pass = $mysqli->escape_string(password_hash($_POST['pass'], PASSWORD_BCRYPT));
$SESSION['gh_auth'] = base64_encode($_POST['gh_user'].":".$_POST['gh_pass']);
$gh_auth = $mysqli->escape_string($SESSION['gh_auth']);

/* Query for existing table */
$sql = "SHOW TABLES LIKE '$table_name'";
$result = $mysqli->query($sql);

/* Create table if it doesn't exist */
if ($result->num_rows == 0) {
  $sql = "CREATE TABLE $table_name (
  email VARCHAR(100) NOT NULL,
  pass VARCHAR(100) NOT NULL,
  gh_auth VARCHAR(100) NOT NULL,
  PRIMARY KEY (email)
  )";
  
  if ($mysqli->query($sql) !== TRUE) {
    $message = "Failed to create table: $mysqli->error";
    errorRedirect($message);
  }
}

/* Insert a new user */
$sql = "INSERT INTO $table_name (EMAIL, PASS, GH_AUTH)
VALUES ('$email', '$pass', '$gh_auth')";

if ($mysqli->query($sql) !== TRUE) {
  $message = "Failed to insert into table: $mysqli->error";
  errorRedirect($message);
}

header('location: /GH-WorkItems/login.html');
?>
