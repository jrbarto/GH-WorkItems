<?php
session_start();
?>
<html lang="en">
  <head>
    <title>GH-WorkItems</title>
    <meta charset="utf-8">
    <!-- Set page width to device screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="/GH-WorkItems/css/materialize.min.css"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="/GH-WorkItems/css/style.css">
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
              <a target="_self" class="active" href="account.php">Account Details</a>
            </li>
            <li class="tab col s4">
              <a target="_self" href="repos.php">My Repos</a>
            </li>
            <li class="tab col s4">
              <a target="_self" href="ticket.php">File a Ticket</a>
            </li>
          </ul>
        </div>
      </div>
      <br>
      <div class="container">
        <table class="highlight">
          <tbody>
            <tr>
              <th class="indigo-text">Username</th>
              <td><?php echo $_SESSION['username'] ?></td>
            </tr>
            <tr>
              <th class="indigo-text">GitHub Username</th>
              <td><?php echo $_SESSION['github_user'] ?></td>
            </tr>
          <tbody>
        </table>
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
