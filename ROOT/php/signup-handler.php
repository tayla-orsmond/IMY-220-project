<?php
    /*
        Tayla Orsmond u21467456
        ---------------------------------------------------------
        This php file uses signup-controller and API classes
        -> signup controller is the interface for signup that does
        all the error handling for form validation and calls API
        -> API class makes the sql query to DB (user DNE and set user)
        -> Config.php singleton (DBH) handles the database connection
    */
    if(isset($_POST["signup"])){//check form was submitted
        //set variables from form data
    
        $name = $_POST["username"];
        $email = $_POST["email"];
        $psw = $_POST["password"];
        $repeat_psw = $_POST["confirm"];
        
        //create signup controller
        require_once "class/signup-ctrl.php";

        $signup = new SignupCtrl($name, $email, $psw, $repeat_psw);
        
        //error handling + signup
        $success = $signup->signup();
        //return errors if applicable
        if(!$success){
            //error occurred
            header('Location: ../signup.php?signup=error');
            die();
        }
        header("Location: ../home.php?id=". $_SESSION['user_id']);//jump to home.php if no error
    }