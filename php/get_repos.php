<?php
/* PHP script to retrieve repositories from the database and return as JSON */
require 'db_config.php';

$repo_table = "repositories";
$org_name = $_POST['org'];
$sql = "SELECT repo_name FROM $repo_table WHERE ORGANIZATION='$org_name'";
$result = $mysqli->query($sql);

$json_data = [];

while ($row = $result->fetch_assoc()) {
  $repo_name = $row['repo_name'];
  $repo_json = [];
  $repo_json["repo_name"] = $repo_name;
  array_push($json_data, $repo_json);
}

/* Return JSON data of all repositories in the organization */
echo json_encode($json_data);
?>