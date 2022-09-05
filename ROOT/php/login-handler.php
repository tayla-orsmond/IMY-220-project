<?php
    /*
        Tayla Orsmond u21467456
        ---------------------------------------------------
        This php file uses login-controller and API classes
        -> login controller is the interface for login that does
        all the error handling for form validation and calls API
        -> API class makes the sql query to DB (user exists and get user)
        -> Config.php singleton (DBH) handles the database connection
    */
    if(isset($_POST["login"])){//check form was submitted
        //set variables from form data
        $email = $_POST["email"];
        $psw = $_POST["password"];

        //create login controller
        require_once "class/login-ctrl.php";

        $login = new LoginCtrl($email, $psw);

        //error handling + login
        $success = $login->login();
        //return errors if applicable
        if(!$success){
            //error occurred
            header("Location: ../login.php?login=error");
            die();
        }  
        header("Location: ../home.php?login=success");//jump to home.php if no error
    }