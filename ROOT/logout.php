<?php
    //Tayla Orsmond u21467456
    //This file handles logout functionality
    //-> destroys session and redirects to splash page
    //start session in order to destroy session
    session_start();
    session_unset();
    session_destroy();
    //delete cookies
    setcookie("logged_in", "", time() - 3600, "/");
    setcookie("user_id", "", time() - 3600, "/");
    setcookie("user_name", "", time() - 3600, "/");
    setcookie("user_display_name", "", time() - 3600, "/");
    setcookie("user_admin", "", time() - 3600, "/");
    //redirect to splash page
    header("Location: index.php");

