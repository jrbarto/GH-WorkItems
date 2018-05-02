<?php
/* PHP script to insert organizations and repositories into the database */

/* Initial database setup and configuration */
require 'db_config.php';

/* Decode JSON encoded string to get JSON object */
$json_data = json_decode($_POST['jsonData'], true);

$orgs_table = "organizations";
$repos_table = "repositories";

/* Create orgs table if it doesn't exist */
$sql = "CREATE TABLE $orgs_table (
  org_name VARCHAR(100) NOT NULL,
  PRIMARY KEY (org_name)
)";
createTable($orgs_table, $sql);

/* Create repos table if it doesn't exist */
$sql = "CREATE TABLE $repos_table (
  repo_name VARCHAR(100) NOT NULL,
  organization VARCHAR(100) NOT NULL,
  ticket_count int DEFAULT 0,
  PRIMARY KEY (repo_name, organization),
  FOREIGN KEY (organization) REFERENCES $orgs_table(org_name)
)";
createTable($repos_table, $sql);

for ($i = 0; $i < count($json_data); $i++) {
  $org = $json_data[$i];
  $org_name = $org['org_name'];

  /* Insert but ignore duplicate entries */
  $sql = "INSERT IGNORE INTO $orgs_table (ORG_NAME)
  VALUES ('$org_name')";
  
  if ($mysqli->query($sql) !== TRUE) {
    $message = "Failed to insert into table: $mysqli->error";
    echo ($message);
    exit(1);
  }

  $repos = $org['repos'];

  for ($j = 0; $j < count($repos); $j++) {
    $repo = $repos[$j];
    $repo_name = $repo['repo_name'];
    $ticket_count = 0;

    $sql = "SELECT * FROM $repos_table WHERE ORGANIZATION='$org_name' AND REPO_NAME='$repo_name'";
    $result = $mysqli->query($sql);

    /* Request repo and get current ticket count if it already exists in database */
    if ($row = $result->fetch_assoc()) {
      $ticket_count = $row['ticket_count'];
    }
    /* Insert repo if it doesn't exist */
    else {
      $sql = "INSERT INTO $repos_table (REPO_NAME, ORGANIZATION)
      VALUES ('$repo_name', '$org_name')";

      if ($mysqli->query($sql) !== TRUE) {
        $message = "Failed to insert into table: $mysqli->error";
        echo ($message);
        exit(1);
      }
    }

    /* Update the ticket count for this repository in the JSON data */
    $json_data[$i]['repos'][$j]['ticket_count'] = $ticket_count;
  }
}

/* Return JSON response with updated ticket count for each repo */
echo json_encode($json_data);
?>
