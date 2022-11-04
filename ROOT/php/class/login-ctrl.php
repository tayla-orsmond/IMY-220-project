<?php
/*
        Tayla Orsmond u21467456
        ---------------------------------------------------
        This class controls login and handles errors server-side
        -> This class uses the API (ctrl class) to handle
        queries to the DB regarding login validation and actually
        logging in a user and fetching data from the DB
    */
require_once("api-ctrl.php");
class LoginCtrl
{
    //signup parameters
    private $email;
    private $psw;
    private $api;
    //constructor
    public function __construct($email, $psw)
    {
        $this->email = $email;
        $this->psw = $psw;
        $this->api = new API();
    }

    /*
        
            FORM VALIDATION + ERROR HANDLING BEFORE REQ
        
        */
    //empty inputs
    private function isEmpty()
    {
        return (empty($this->email) || empty($this->psw));
    }
    //correct email
    private function validEmail()
    {
        $result = false;
        //get rid of illegal chars
        $this->email = filter_var($this->email, FILTER_SANITIZE_EMAIL);
        //validate
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }
    //correct password
    private function validPass()
    {
        //password min length of 8
        //must contain one uppercase and one lowercase letter
        //must contain one digit
        //must contain one character
        $rg = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+=~`-])[A-Za-z\d!@#$%^&*()_+=~`-]{8,}$/";
        //validate
        return preg_match($rg, $this->psw) === 1;
    }
    //user exists (using API call to DB)
    private function exist()
    {
        return $this->api->userExists($this->email, null);
    }

    /*
        
            LOGIN USER
        
        */
    //login user if user exists + valid
    public function login()
    {
        $success = true;
        //error array
        $error = array(
            "Please ensure all form inputs are filled in before submitting",
            "Invalid Email Address",
            "Invalid Password",
            "User Does Not Exist, please sign up first before logging in",
            "Login Failed, "
        );
        //error handle
        if ($this->isEmpty()) {
            //echo "All form inputs must be filled in"
            $_SESSION["login_err"] = $error[0];
            $success = false;
        }
        if (!$this->validEmail()) {
            //echo "Invalid Email Address"
            $_SESSION["login_err"] = $error[1];
            $success = false;
        }
        if (!$this->validPass()) {
            //echo "Invalid Password"
            $_SESSION["login_err"] = $error[2];
            $success = false;
        }
        if (!$this->exist()) {
            //echo "User Does Not Exist"
            $_SESSION["login_err"] = $error[3];
            $success = false;
        }
        if (!$success) { //guard
            return $success;
        }
        //login user
        //direct function
        $req = array(
            "email" => $this->email,
            "password" => $this->psw
        );

        $this->api->getUser($req);
        try {
            $result = json_decode($this->api->getResponse(), true);

        } catch (Exception $e) {
            $result = array(
                "status" => "error",
                "data" => array(
                    "message" => "Signup Failed, " . $e->getMessage()
                )
            );
        }
        
        //check if login was successful
        if ($result["status"] === "error") {
            $_SESSION["login_err"] = $error[4] . ' ' . $result["data"]["message"];
            $success = false;
        }
        if (!$success) { //guard
            return $success;
        }

        //set session if login was a success
        $_SESSION["logged_in"] = true;
        $_SESSION["user_id"] = $result["data"]["return"]["u_id"];
        $_SESSION["user_name"] = $result["data"]["return"]["u_name"];
        $_SESSION["user_display_name"] = $result["data"]["return"]["u_display_name"];
        $_SESSION["user_admin"] = $result["data"]["return"]["u_admin"];

        //set cookies if login was a success
        setcookie("logged_in", true, time() + (86400 * 30), "/");
        setcookie("user_id", $result["data"]["return"]["u_id"], time() + (86400 * 30), "/");
        setcookie("user_name", $result["data"]["return"]["u_name"], time() + (86400 * 30), "/");
        setcookie("user_display_name", $result["data"]["return"]["u_display_name"], time() + (86400 * 30), "/");
        setcookie("user_admin", $result["data"]["return"]["u_admin"], time() + (86400 * 30), "/");

        return $success;
    }
}
