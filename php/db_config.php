<?php
/* Configuration script for the database */

/* Database connection settings */
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'gh_workitems';

/* Start a new session to store data in $_SESSION array */
session_start();

/* The MYSQL database driver */
$mysqli = new mysqli($host, $user, $pass);

if ($mysqli->connect_errno) {
  $message = "The database connection failed: $mysqli->connect_error";
  errorRedirect($message);
}

/* Ensure that the database exists before you start using it */
$sql = "CREATE DATABASE IF NOT EXISTS $db";

if ($mysqli->query($sql) !== TRUE) {
  $message = "Database creation has failed: $mysqli->error";
  errorRedirect($message);
}

$mysqli = new mysqli($host, $user, $pass, $db);


if ($mysqli->connect_errno) {
  $message = "The database connection failed: $mysqli->connect_error";
  errorRedirect($message);
}

/* An error has occurred, redirect to an error page, return page is optional */
function errorRedirect($message, $return = null) {
  $_SESSION['error'] = $message;

  /* Set the return session variable if supplied */
  if ($return != null) {
    $_SESSION['return'] = $return;
  }

  header('location: error.php');
  exit(1);
}

function createTable($table_name, $sql) {
  global $mysqli; // Cause references to refer to global variable

  /* Query for existing table */
  $check = "SHOW TABLES LIKE '$table_name'";
  $result = $mysqli->query($check);

  /* Create table if it doesn't exist */
  if ($result->num_rows == 0) {
    if ($mysqli->query($sql) !== TRUE) {
      $message = "Failed to create table: $mysqli->error";
      errorRedirect($message);
    }
  }
}
?>
