<!-- Page displayed to file a new ticket in the database -->
<?php
  require 'db_config.php';

  $org_table = "organizations";
  $sql = "SELECT org_name FROM $org_table";
  $result = $mysqli->query($sql);
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
        <a class="brand-logo center">Ticket</a>
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
        <form action="/GH-WorkItems/php/insert_ticket.php" method="post">
          <div class="row indigo-text">
            <div class="input-field col s12">
              <select id="org" name="org">
                <?php
                /* Fill the select options with organizations */
                while ($row = $result->fetch_assoc()) {
                  $org_name = $row['org_name'];
                  echo "<option value='$org_name'>$org_name</option>";
                }
                ?>
              </select>
              <label>Organization</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <select id="repo" name="repo">
              </select>
              <label>Repository</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
            <input type="text" id="contact" name="contact" class="validate"></input>
            <label for="contact">Contact Email</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
            <textarea id="description" name="description" class="materialize-textarea"></textarea>
            <label for="description">Description</label>
            </div>
          </div>
          <div class="row center">
              <button class="btn waves-effect waves-light indigo" type="submit">Submit Ticket
                <i class="material-icons right">send</i>
              </button>
          </div>
        </form>
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
    <script type="text/javascript" src="/GH-WorkItems/js/ticket.js"></script>
  </body>
</html>