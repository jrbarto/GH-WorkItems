<?php
require 'db_config.php';

$ticket_table = "tickets";
$org = $_POST['org'];
$repo = $_POST['repo'];

$sql = "SELECT * FROM $ticket_table WHERE ORGANIZATION='$org' AND REPOSITORY='$repo'";
$result = $mysqli->query($sql);
$json_data = [];

while ($row = $result->fetch_assoc()) {
  $id = $row['id'];
  $contact = $row['contact'];
  $description = $row['description'];
  $status = $row['status'];
  $ticket_json = array(
    'id' => $id,
    'contact' => $contact,
    'description' => $description,
    'status' => $status
  );

  array_push($json_data, $ticket_json);
}

$json_string = json_encode($json_data);

/* Pass json string as a parameter to javascript script to generate tickets in html */
echo "<script src='/GH-WorkItems/js/repo_tickets.js' json_string='$json_string'></script>";
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
  <body onload="generateTickets()">
    <nav>
      <div class="nav-wrapper orange">
        <a class="brand-logo center"><?php echo "$org/$repo"?></a>
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
              <a target="_self" class="active" href="repos.php">My Repos</a>
            </li>
            <li class="tab col s4">
              <a target="_self" href="ticket.php">File a Ticket</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="container">
        <div class="row center">
          <h3 class="indigo-text">Tickets</h3>
        </div>
        <ul class="collapsible" id="ticket-list">
        </ul>
      </div>
      <div class="row center">
        <a href="/GH-WorkItems/php/repos.php" class="btn waves-effect waves-light indigo">
          Return
          <i class="material-icons right">arrow_back</i>
        </a>
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