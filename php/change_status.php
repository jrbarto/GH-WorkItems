<?php
require 'db_config.php';

$ticket_table = "tickets";
$repo_table = "repositories";
$id = $_POST['id'];
$status = $_POST['status'];

/* Delete ticket if it has been marked as completed or invalid */
if (strcmp($status, "complete") == 0 || strcmp($status, "invalid") == 0) {
  $sql = "SELECT organization, repository FROM $ticket_table WHERE id=$id";
  $result = $mysqli->query($sql);
  
  $row = $result->fetch_assoc();
  $org = $row['organization'];
  $repo = $row['repository'];
  
  $sql = "UPDATE $repo_table 
    SET ticket_count = ticket_count - 1 
    WHERE organization = '$org' AND repo_name = '$repo'";
  
  if ($mysqli->query($sql) !== TRUE) {
    $message = "Failed to update table: $mysqli->error";
    echo $message;
  }

  $sql = "DELETE FROM $ticket_table WHERE id = $id";

  if ($mysqli->query($sql) !== TRUE) {
    $message = "Failed to delete ticket from database.";
    echo $message;
  }
}
/* Otherwise, update the ticket to the chosen status */
else {
  $sql = "UPDATE $ticket_table SET status = '$status' WHERE id = $id";

  if ($mysqli->query($sql) !== TRUE) {
    $message = "Failed to update table: $mysqli->error";
    echo $message;
  }
}
?>