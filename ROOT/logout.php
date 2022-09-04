<?php
    //Tayla Orsmond u21467456
    //This file handles logout functionality
    //-> destroys session and redirects to splash page
    //start session in order to destroy session
    session_start();
    session_unset();
    session_destroy();
    //go back to front page
    header("Location: index.php?");

