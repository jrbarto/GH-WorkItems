<!-- Error page displayed when user experiences an error -->
<?php
session_start();
$return_page = $_SESSION['return'];

/* If no return page was specified in the session, simply return to root */
if ($return_page == '') {
  $return_page = "/GH-WorkItems/index.html";
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
  </head>
  <body>
    <nav>
      <div class="nav-wrapper red">
        <a class="brand-logo center">Error</a>
        <ul class="right">
          <li>
              <li><a class="btn blue darken-4" href="<?php echo $return_page ?>">Return</a></li>
          </li>
        </ul>
      </div>
    </nav>
    <main>
      <div class="container center">
        <h3>An error has occurred:</h3>
        <br>
        <h5>
          <?php
            /* Start session and retrieve error message */
            session_start();
            echo $_SESSION['error'];
          ?>
        </h5>
      </div>
    </main>
    <footer class="page-footer red">
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
