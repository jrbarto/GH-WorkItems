<!-- Page displayed after user files a new ticket -->
<?php
require 'db_config.php';

$ticket_table = "tickets";
$repo_table = "repositories";
$org = $_POST['org'];
$repo = $_POST['repo'];
$contact = $mysqli->escape_string($_POST['contact']);
$description = $mysqli->escape_string($_POST['description']);

/* Check for invalid contact email */
if (!filter_var($contact, FILTER_VALIDATE_EMAIL)) {
  $message = "The contact email address '$contact' is not valid.";
  errorRedirect($message);
}

/* Create tickets table if it doesn't exist */
$sql = "CREATE TABLE $ticket_table (
  id INT NOT NULL AUTO_INCREMENT,
  organization VARCHAR(100) NOT NULL,
  repository VARCHAR(100) NOT NULL,
  contact VARCHAR(100) NOT NULL,
  description VARCHAR(300),
  status VARCHAR(20) DEFAULT 'new',
  FOREIGN KEY (organization, repository) REFERENCES Repositories (organization, repo_name),
  PRIMARY KEY (id)
)";
createTable($ticket_table, $sql);

$sql = "INSERT INTO $ticket_table (ORGANIZATION, REPOSITORY, CONTACT, DESCRIPTION)
VALUES ('$org', '$repo', '$contact', '$description')";

if ($mysqli->query($sql) !== TRUE) {
  $message = "Failed to insert into table: $mysqli->error";
  errorRedirect($message);
}

$sql = "UPDATE $repo_table 
  SET ticket_count = ticket_count + 1 
  WHERE organization = '$org' AND repo_name = '$repo'";

if ($mysqli->query($sql) !== TRUE) {
  $message = "Failed to update table: $mysqli->error";
  errorRedirect($message);
}
?>

<html lang="en">
  <head>
    <title>GH-WorkItems</title>
    <meta charset="utf-8">
    <!-- Set page width to device screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="/GH-WorkItems/css/materialize.min.css"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="/GH-WorkItems/css/style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  </head>
  <body>
    <nav>
      <div class="nav-wrapper orange">
        <a class="brand-logo center">Account</a>
        <ul class="right">
          <li><a class="btn blue darken-4" href="logout.php">Logout</a></li>
        </ul>
      </div>
    </nav>
    <main>
      <div class="row">
        <div class="col s12">
          <ul class="tabs">
            <li class="tab col s4">
              <!-- target required or else Google Materialize tabs ignoring default anchor behavior -->
              <a target="_self" href="account.php">Account Details</a>
            </li>
            <li class="tab col s4">
              <a target="_self" href="repos.php">My Repos</a>
            </li>
            <li class="tab col s4">
              <a target="_self" class="active" href="ticket.php">File a Ticket</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="container">
        <div class="row center">
          <div class="input-field col s12">
            <h3>Your Ticket Has Been Filed Successfully</h3>
          </div>
        </div>
        <div class="row center">
            <a href="/GH-WorkItems/php/ticket.php" class="btn waves-effect waves-light indigo">
              Return
              <i class="material-icons right">arrow_back</i>
            </a>
        </div>
      </div>
    </main>
    <footer class="page-footer orange">
      <div class="container">
        <div class="row">
          <div class="col l6 s12">
            <h5>Group Members</h5>
            <ul>
              <li>
                <a class="white-text" href="mailto:bartorobjeff@gmail.com">
                  Jeffrey Barto - bartorobjeff@gmail.com
                </a>
              </li>
              <li>
                <a class="white-text" href="mailto:radumocean2007@gmail.com">
                  Radu Mocean - radumocean2007@gmail.com
                </a>
              </li>
            </ul>
          </div>
          <div class="col l6 s12">
            <h5>Project Source Code</h5>
            <ul>
              <li>
                <a class="white-text" href="https://github.com/jrbarto/GH-WorkItems">
                  GH-WorkItems on Github
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer>
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="/GH-WorkItems/js/materialize.min.js"></script>
    <script type="text/javascript" src="/GH-WorkItems/js/init.js"></script>
  </body>
</html>