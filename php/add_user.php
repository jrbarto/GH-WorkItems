<?php
/* PHP script to insert a new user in the database */

/* Initial database setup and configuration */
require 'db_config.php';

$table_name = "users";
$error_return = '/GH-WorkItems/register.html'; // Page to return to after error redirect

if (trim($_POST['username']) == '') {
  $message = "All fields must be filled out when creating an account.";
  errorRedirect($message, $error_return);
}

$username = $mysqli->escape_string($_POST['username']);
$pass = $mysqli->escape_string(password_hash($_POST['pass'], PASSWORD_BCRYPT));
$github_user = $_POST['github_user'];

/* Base64 encode the basic authorization header to use with the GitHub REST API */
$auth_header = base64_encode($github_user.":".$_POST['github_pass']);
$github_auth = $mysqli->escape_string($auth_header);

/* Query for existing table */
$sql = "SHOW TABLES LIKE '$table_name'";
$result = $mysqli->query($sql);

/* Create table if it doesn't exist */
if ($result->num_rows == 0) {
  $sql = "CREATE TABLE $table_name (
  username VARCHAR(100) NOT NULL,
  pass VARCHAR(100) NOT NULL,
  github_auth VARCHAR(100) NOT NULL,
  github_user VARCHAR(100) NOT NULL,
  PRIMARY KEY (username)
  )";
  
  if ($mysqli->query($sql) !== TRUE) {
    $message = "Failed to create table: $mysqli->error";
    errorRedirect($message, $error_return);
  }
}

/* Insert a new user */
$sql = "INSERT INTO $table_name (USERNAME, PASS, GITHUB_AUTH, GITHUB_USER)
VALUES ('$username', '$pass', '$github_auth', '$github_user')";

if ($mysqli->query($sql) !== TRUE) {
  $message = "Failed to insert into table: $mysqli->error";
  errorRedirect($message, $error_return);
}

header('location: /GH-WorkItems/login.html');
?>
