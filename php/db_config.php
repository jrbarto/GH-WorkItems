<?php
/* Database connection settings */
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'gh_workitems';

/* The MYSQL database driver */
$mysqli = new mysqli($host, $user, $pass) or die($mysqli->error);

/* Ensure that the database exists before you start using it */
$sql = "CREATE DATABASE IF NOT EXISTS $db";

$mysqli = new mysqli($host, $user, $pass, $db);

/* Start a new session to store data in $_SESSION array */
session_start();

/* An error has occurred, redirect to an error page */
if ($mysqli->connect_errno) {
  $_SESSION['error'] = "The database connection failed: $mysqli->connect_error";
  header('location: error.php');
}
?>