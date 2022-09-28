<?php
    /*
        Tayla Orsmond u21467456
        ---------------------------------------------------------
        This class controls signup and handles errors server-side
        -> This class uses the API (ctrl class) to handle
        queries to the DB regarding signup validation and actually
        signing up a user to the DB
    */
    require_once("api-ctrl.php");
    class SignupCtrl{
        //signup parameters
        private $name;
        private $email;
        private $psw;
        private $repeat_psw;
        private $api;

        //constructor
        public function __construct($name, $email, $psw, $repeat_psw)
        {
            $this->name = $name;
            $this->email = $email;
            $this->psw = $psw;
            $this->repeat_psw = $repeat_psw;
            $this->api = new API();
        }

        /*
        
            ERROR HANDLING BEFORE REQ
        
        */
        //empty inputs
        private function isEmpty(){
            return ( empty($this->name) || empty($this->email) || empty($this->psw) || empty($this->repeat_psw) );
        }
        //correct username
        private function validName(){
            /*
                username must be alphanumeric
                username must be between 3-20 characters
                username may not start or end with _ or .
                username may not contain .. or __ or _. or ._ between characters
            */
            $rg = "/^(?=[a-zA-Z0-9._]{3,20}$)(?!.*[_.]{2}).*$/";
            //validate
            return preg_match($rg, $this->name) === 1;
        }
        //correct email
        private function validEmail(){
            $result = false;
            //get rid of illegal chars
            $this->email = filter_var($this->email, FILTER_SANITIZE_EMAIL);
            //validate
            if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){$result = false;}
            else {$result = true;}
            return $result;
        }
        //correct password
        private function validPass(){
            /*
                password must have a min length of 8
                password must contain one uppercase and one lowercase letter
                password must contain one digit
                password must contain one special character
            */
            $rg = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+=~`-])[A-Za-z\d!@#$%^&*()_+=~`-]{8,}$/";
            //validate
            return preg_match($rg, $this->psw) === 1;
        }
        //passwords match
        private function match(){
            return $this->psw === $this->repeat_psw;
        }
        //user already exists
        private function exist(){
            return $this->api->userExists($this->email, $this->name);
        }
        
        /*
        
            SIGNUP USER
        
        */
        //signup user if user DNE + valid
        public function signup(){
            $success = true;
            $error = array(
                "Please ensure all form inputs are filled in before submitting",
                "Invalid UserName",
                "Invalid Email Address",
                "Invalid Password",
                "Passwords do not match",
                "User Already Exists",
                "Signup Failed, "
            );
            //error handle
            if($this->isEmpty()){
                //echo "All form inputs must be filled in"
                $_SESSION["signup_err"] = $error[0];
                $success = false;
            }
            else if(!$this->validName()){
                //echo "Invalid Name"
                $_SESSION["signup_err"] = $error[1];
                $success = false;
            }
            else if(!$this->validEmail()){
                //echo "Invalid Email Address"
                $_SESSION["signup_err"] = $error[2];
                $success = false;
            }
            else if(!$this->validPass()){
                //echo "Invalid Password"
                $_SESSION["signup_err"] = $error[3];
                $success = false;
            }
            else if(!$this->match()){
                //echo "Passwords do not match"
                $_SESSION["signup_err"] = $error[4];
                $success = false;
            }
            else if($this->exist()){
                //echo "User Already exists"
                $_SESSION["signup_err"] = $error[5];
                $success = false;
            }
            if(!$success){//guard
                return $success;
            }
            //signup user
            //direct function
            $req = array(
                "username" => $this->name,
                "email" => $this->email,
                "password" => $this->psw
            );
            $this->api->setUser($req);
            $result = json_decode($this->api->getResponse(), true);
            
            //check if signup was successful
            if($result["status"] === "error"){
                $_SESSION["signup_err"] = $error[6] . " " . $result["data"]["message"];
                $success = false;
            }
            if(!$success){//guard
                return $success;
            }

            //set session if signup was a success
            $_SESSION["logged_in"] = true;
            $_SESSION["user_id"] = $result["data"]["return"]["u_id"];
            $_SESSION["user_name"] = $result["data"]["return"]["u_name"];
            $_SESSION["user_display_name"] = $result["data"]["return"]["u_display_name"];
            $_SESSION["user_admin"] = $result["data"]["return"]["u_admin"];

            //set cookies if signup was a success
            setcookie("logged_in", true, time() + (86400 * 30), "/");
            setcookie("user_id", $result["data"]["return"]["u_id"], time() + (86400 * 30), "/");
            setcookie("user_name", $result["data"]["return"]["u_name"], time() + (86400 * 30), "/");
            setcookie("user_display_name", $result["data"]["return"]["u_display_name"], time() + (86400 * 30), "/");
            setcookie("user_admin", $result["data"]["return"]["u_admin"], time() + (86400 * 30), "/");
            
            return $success;
        }
    }