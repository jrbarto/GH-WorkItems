<?php
/* Free all session variables and any data registered to the session */
session_start();
session_unset();
session_destroy(); 

header('location: /GH-WorkItems/index.html')
?>
