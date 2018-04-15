<?php
/* Initial database setup and configuration */
require 'db_config.php';

$table_name = "users";
echo "EMAIL IS " . $_POST['email'];
if (trim($_POST['email']) == '') {
  $_SESSION['error'] = "All fields must be filled out when creating an account.";
  header('location: error.php');
  exit(1); // Stop current script execution
}

$email = $mysqli->escape_string($_POST['email']);
$pass = $mysqli->escape_string(password_hash($_POST['pass'], PASSWORD_BCRYPT));
$SESSION['gh_auth'] = base64_encode($_POST['gh_user'].":".$_POST['gh_pass']);
$gh_auth = $mysqli->escape_string($SESSION['gh_auth']);

/* Query for existing table */
$sql = "SHOW TABLES LIKE '$table_name'";
$result = $mysqli->query($sql) or die($mysqli->error);

/* Create table if it doesn't exist */
if ($result->num_rows == 0) {
  $sql = "CREATE TABLE $table_name (
  email VARCHAR(100) NOT NULL,
  pass VARCHAR(100) NOT NULL,
  gh_auth VARCHAR(100) NOT NULL,
  PRIMARY KEY (email)
  )";
  
  if ($mysqli->query($sql) !== TRUE) {
    $_SESSION['error'] = "Failed to create table: $mysqli->error";
    header('location: error.php');
    exit(1);
  }
}

/* Insert a new user */
$sql = "INSERT INTO $table_name (EMAIL, PASS, GH_AUTH)
VALUES ('$email', '$pass', '$gh_auth')";

$mysqli->query($sql) or die($mysqli->error);

header('location: /GH-WorkItems/login.html');
?>