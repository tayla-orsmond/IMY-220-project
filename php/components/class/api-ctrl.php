<?php
require_once("config.php");
class API{
    /*
        Tayla Orsmond - u21467456
        ---------------------------------------------------------------------
        This class handles requests and formulates responses using JSON data
        It makes use of the Database singleton class in the config file for 
        database connection
        It handles:
        *********************************************************************
        -> Recieving the request and error handling of bad requests
        -> Search = search DB for query
        -> Signup = validate user and insert new user into DB
        -> Login = validate user and get user
        *********************************************************************
    */
    /*
        Database table for users looks like:
        CREATE TABLE users(
            u_id INT PRIMARY KEY AUTO_INCREMENT not null, 
            u_name TINYTEXT not null,
            u_display_name TINYTEXT DEFAULT "Jane Doe",
            u_email TINYTEXT not null,
            u_psw TEXT not null,
            u_profile TEXT DEFAULT "profile.png",
            u_bio TEXT DEFAULT "",
            u_pronouns TINYTEXT DEFAULT "",
            u_age TINYINT not null,
            u_location TINYTEXT DEFAULT "",
            u_admin BOOLEAN not null DEFAULT false
        );
    */
    /*
        Database table for events looks like:
        CREATE TABLE events(
            e_id BIGINT PRIMARY KEY AUTO_INCREMENT not null,
            u_rid INT not null,
            FOREIGN KEY (u_rid) REFERENCES users(u_id),
            u_rname TINYTEXT not null,
            FOREIGN KEY (u_rname) REFERENCES users(u_name),
            e_name VARCHAR(255) not null,
            e_desc VARCHAR(255) DEFAULT "No description",
            e_date DATE not null,
            e_time TIME not null,
            e_location VARCHAR(255) not null,
            e_type VARCHAR(255) not null,
            e_tag1 TINYTEXT DEFAULT "",
            e_tag2 TINYTEXT DEFAULT "",
            e_tag3 TINYTEXT DEFAULT "",
            e_tag4 TINYTEXT DEFAULT "",
            e_tag5 TINYTEXT DEFAULT "",
            e_img TEXT DEFAULT "event.png",
            e_rating TINYINT not null DEFAULT 0
        );
    */
    /*
        Database table for reviews looks like:
        CREATE TABLE reviews(
            r_id BIGINT PRIMARY KEY AUTO_INCREMENT not null,
            u_rid INT not null,
            FOREIGN KEY (u_rid) REFERENCES users(u_id),
            u_rname TINYTEXT not null,
            FOREIGN KEY (u_rname) REFERENCES users(u_name),
            e_rid BIGINT not null,
            FOREIGN KEY (e_rid) REFERENCES events(e_id)
            r_rating TINYINT not null,
            r_name VARCHAR(255) not null,
            r_comment TEXT not null
            r_img TEXT DEFAULT "review.png"
        );
    */
    /*
        Database table for lists looks like:
        CREATE TABLE lists(
            l_id BIGINT PRIMARY KEY AUTO_INCREMENT not null,
            u_rid INT not null,
            FOREIGN KEY (u_rid) REFERENCES users(u_id),
            l_name TINYTEXT not null,
            l_desc TEXT DEFAULT "No description",
            l_events TEXT DEFAULT ""
        );
    */
    /*
        Database table for followers looks like:
        CREATE TABLE followers(
            f_id BIGINT PRIMARY KEY AUTO_INCREMENT not null,
            u_rid INT not null,
            FOREIGN KEY (u_rid) REFERENCES users(u_id),
            u_rname TINYTEXT not null,
            FOREIGN KEY (u_rname) REFERENCES users(u_name),
            u_fid INT not null,
            FOREIGN KEY (u_fid) REFERENCES users(u_id),
            u_fname TINYTEXT not null,
            FOREIGN KEY (u_fname) REFERENCES users(u_name)
        );
    */
    //connection
    public $inst;
    public $conn;
    //common errors
    public $processing_err = "Error: error processing request";
    public $user_dne_err = "Error: user does not exist";

    //response and resp error JSON objects
    public $curr_time;//curr time of request
    public $response = array(
        "status" => "",
        "timestamp" =>"",//time of request
        "data" => array(
            //response data here
            "message" => "", //message to send if error/success
        )
    );

    //constructor
    public function __construct()
    {
        $this->inst = DBH::getInstance();
        $this->conn = $this->inst->connect();
        $date = date_create("",timezone_open("Africa/Johannesburg"));
        $this->curr_time = date_format($date,"Y-m-d H:i");
    }

    /*
    
        RECIEVE REQUEST AND HANDLE ERRORS/ HANDLE BASED ON TYPE
        ========================================================================================================================
    */
    public function recieve($req){
        //Description: API Recieve and handle request (error handling)
        //Route request to correct function to handle
        /*
            Request Looks like:
            {
                [req] "type" : "info" (Type of request. Can be of type: info, add, delete, update, login, signup, rate, chat, follow or unfollow)
                [req] "user_id" : "1" (User id of user making request -> Not required for login and signup)

                INFO REQ{
                    [req] "return" : "profile" (Thing to return. Can be of type: profile, search, events, event, lists, list, followers, following, reviews, reviewed, review, chats, chat)
                    [opt] "scope" : "global" (Range of things to return. Can be of type: local, self or global)
                    [opt] "id" : "1" (Id of thing to return. Alt., Id of profile or event referenced (for getting lists, follows etc. of a specific user that may not be the current user). Not required for search and global)
                    [opt] "search" : "search term" (Search terms to search for)
                }
                ADD REQ{
                    [req] "add" : "event" (Add type. Can be of type: event, list)
                    [req] -> All parameters for adding events
                    OR [req] -> All parameters for adding lists
                }
                DELETE REQ{
                    [req] "delete": "event" (Delete type. Can be of type: event, list, review, profile)
                    [req] "event_id": "12"  (Event's e_id in the events database table)
                    [req] "list_id": "12"  (List's l_id in the list database table)
                    [req] "review_id": "12"  (Rating's r_id in the review database table)
                    -> user_id already required
                }
                LOGIN REQ{
                    [req] "email" : "jane.doe@email.com" (Email for login request)
                    [req] "password" : "ValidPassword123#" (Password for login request)
                }
                SIGNUP REQ{
                    [req] "username" : "jane.doe" (Username for signup request)
                    [req] "email" : "jane.doe@email.com" (Email for signup request)
                    [req] "password" : "ValidPassword123#" (Password for signup request)
                }
                UPDATE REQ{
                    [req] "update" : "profile" (Update type. Can be of type: profile, event, list) 
                    [opt] -> Any (all) of the profile parameters
                    [opt] -> Any (all) of the event parameters
                    [opt] -> Any (all) of the list parameters
                }
                RATE REQ{
                    [req] "event_id" : "15" (Event's e_id in the events database table)
                    [req] "rating" : "4" (The event's new added rating)
                    [req] -> All parameters for adding reviews
                }
                CHAT REQ{

                }
                FOLLOW REQ{
                    [req] "follow" : "follow" (Follow type. Can be of type: follow, unfollow)
                    [req] "user_name" : "jane.doe" (User's u_name in the users database table)
                    [req] "follow_id" : "2" (User's u_id in the users database table)
                    [req] "follow_name" : "jane.doe" (User's u_name in the users database table)
                }
            }
        */

        //handle if req has what it needs
        if(empty($req) || !in_array($req["type"], $req) || $req["type"] === "" || !in_array($req["user_id"], $req) || $req["user_id"] === "" ){
            $this->respond("error", null, "Error: Bad Request - Required parameters missing or empty");
            return;//don't continue
        }
        //check required request type
        if($req["type"] === "info"){
            //INFO REQ 
            if(!in_array($req["return"], $req)){
                //required return parameter not set
                $this->respond("error", null, "Error: Bad Request - No return parameter specified");
            }
            else if($req["return"] === "search"){
                $this->search($req);
            }
            else if($req["return"] === "profile" || $req["return"] === "event" || $req["return"] === "list" || $req["return"] === "review" || $req["return"] === "chat"){
                //single object get request (a profile, an event, a list, a review or a chat)
                $this->get($req);
            }
            else if($req["return"] === "events"){
                //get multiple event's for a user's home / global feed OR for a specific profile
                $this->getFeed($req);
            }
            else if($req["return"] === "reviewed"){
                //get multiple events a user has reviewed for their profile
                $this->getReviewedEvents($req);
            }
            else if($req["return"] === "lists"){
                //get multiple lists for a specific user's profile
                $this->getLists($req);
            }
            else if($req["return"] === "reviews"){
                //get multiple review's for a specifc event
                $this->getReviews($req);
            }
            else if($req["return"] === "chats"){
                //get multiple chats for a user
                //$this->getChats($req);
            }
            else if($req["return"] === "followers"){
                //get followers for a specific user profile
                $this->getFollowers($req);
            }
            else if($req["return"] === "following"){
                //get following for a specific user profile
                $this->getFollowing($req);
            }
            else{
                //invalid return parameter
                $this->respond("error", null, "Error: Bad Request - Invalid return parameter");
            }
        }
        else if($req["type"] === "login"){
            //LOGIN REQ
            $this->getUser($req);
        }
        else if($req["type"] === "signup"){
            //SIGNUP REQ
            $this->setUser($req);
        }
        else if($req["type"] === "add"){
            if(!in_array($req["add"], $req)){
                //required add parameter not set
                $this->respond("error", null, "Error: Bad Request - No add parameter specified");
            }
            else{
                $this->add($req);
            }
        }
        else if($req["type"] === "delete"){
            if(!in_array($req["delete"], $req)){
                //required delete parameter not set
                $this->respond("error", null, "Error: Bad Request - No delete parameter specified");
            }
            else{
                $this->delete($req);
            }
        }
        else if($req["type"] === "update"){
            //UPDATE REQ
            if(!in_array($req["update"], $req)){
                //required update parameter not set
                $this->respond("error", null, "Error: Bad Request - No update parameter specified");
            }
            else{
                $this->update($req);
            }
        }
        else if($req["type"] === "rate"){
            //RATE REQ
            if((!in_array($req["event_id"], $req) || empty($req["event_id"])) && (!in_array($req["rating"], $req) || empty($req["rating"]))){
                $this->respond("error", null, "Nothing to rate.");
            }
            else{
                $this->rate($req);
            }
        }
        else if($req["type"] === "chat"){
            //CHAT REQ
            $this->respond("error", null, "The API type chat does not exist yet");
        }
        else{
            //random/bad request
            $this->respond("error", null, "Error: Bad Request - Invalid Request Type");
        }
    }

    /*
        
        SIGNUP - SET USER + CHECK USER DNE ALREADY
        ===========================================================================================================================
    */
    public function userExists($req){
        //Description: check if user already exists (for signup)
        $email = $req["email"];
        $username = $req["username"];
        $result = true;//assume user already exists
        //prepare statement 
        $query = $this->conn->prepare('SELECT u_id FROM users WHERE u_email = ? OR u_name = ?;');
        if(!$query->execute(array($email, $username))){ 
            $query = null;
            $result = true;//don't allow user in if there was internal error
        }
        else if($query->rowCount() > 0){
            $result = true;
        }
        else {$result = false;}
        return $result;
    }
    public function setUser($req){
        //Description: Make SQL queries for signing up a user (insert into DB) if all validation passes
        //Error handling for server-side form validation done by signup-ctrl class which is used by signup-handler
        
        $name = $req["username"];
        $display_name = isset($req["display_name"]) ? $req["display_name"] : "Jane Doe";
        $email = $req["email"];
        $psw = $req["password"];
        $age = $req["age"];
        $location = isset($req["location"]) ? $req["location"] : "";
        $pronouns = isset($req["pronouns"]) ? $req["pronouns"] : "";
        $profile = isset($req["profile"]) ? $req["profile"] : "profile.png";
        $bio = isset($req["bio"]) ? $req["bio"] : "";
        $admin = isset($req["admin"]) ? $req["admin"] : false;

        //prepare statement -> separate data from query with ? that prevents SQL injections
        $query = $this->conn->prepare('INSERT INTO users (u_name, u_display_name, u_email, u_psw, u_profile, u_bio, u_pronouns, u_age, u_location, u_admin) VALUES (?,?,?,?,?,?,?,?,?,?);');
        //hash password
        $hashed_psw = password_hash($psw, PASSWORD_DEFAULT);
        //create array
        $user_array = array($name, $display_name, $email, $hashed_psw, $profile, $bio, $pronouns, $age, $location, $admin);
        //error handling
        if(!$query->execute($user_array)){ 
            $query = null;
            return;
        }
        $query = null;
        $this->getUser($req);
    }

    /*
    
        LOGIN - GET USER + CHECK USER EXISTS AND VALID CREDENTIALS GIVEN
        ===========================================================================================================================
    */
    public function getUser($req){
        //Description: Make SQL queries for logging in a user (get from DB) if all validation passes
        //Error handling for server-side form validation done by login-ctrl class which is used by login-handler

        $email = $req["email"];
        $psw = $req["password"];
        //prepare statement
        $query = $this->conn->prepare('SELECT u_psw FROM users WHERE `u_email` = ?;');
        //error handling
        if(!$query->execute(array($email))){ 
            $query = null;
            $this->respond("error", null, $this->processing_err);
            return;
        }
        //check if user exists
        if($query->rowCount() === 0){
            $query = null;
            $this->respond("error", null, $this->user_dne_err);
            return;
        }

        //If user exists, check password is valid (matches whatis stored in db)
        //Get password from successful query (no email duplicates allowed) 
        //-> FETCH_ASSOC set in DBH class so returns associative array
        $hashed_psw = $query->fetchAll();
        $matched = password_verify($psw, $hashed_psw[0]["u_psw"]);//get first index with users hashed password col
        if(!$matched){
            $query = null;
            $this->respond("error", null, "Authentication Error, Incorrect Email or Password");
            return;
        }
        else{
            $user_q = $this->conn->prepare('SELECT * FROM users WHERE `u_email` = ? AND `u_psw` = ?;');//grab user
            //error handling
            if(!$user_q->execute(array($email, $hashed_psw[0]["u_pass"]))){ 
                $query = null;
                $this->respond("error", null, $this->processing_err);
                return;
            }
            //check if user returned
            if($user_q->rowCount() == 0){
                $query = null;
                $this->respond("error", null, $this->user_dne_err);
                return;
            }
            //get user and set session
            $user = $user_q->fetchAll();
            $user_array = array(
                "u_id" => $user[0]["u_id"],
                "u_name" => $user[0]["u_name"],
                "u_display_name" => $user[0]["u_display_name"],
                "u_email" => $user[0]["u_email"],
                "u_profile" => $user[0]["u_profile"],
                "u_bio" => $user[0]["u_bio"],
                "u_pronouns" => $user[0]["u_pronouns"],
                "u_age" => $user[0]["u_age"],
                "u_location" => $user[0]["u_location"],
                "u_admin" => $user[0]["u_admin"]
            );

            $this->respond("success", $user_array, "User logged in successfully");
            
            $user_q = null;
        }
        $query = null;
    }
    /*
    
        GET - HANDLE GET REQUESTS FOR PROFILE, EVENTS, LISTS, REVIEWS, ETC -> SINGLE OBJECT
        ===========================================================================================================================
    */
    public function get($req){
        //Description: Handle GET requests for profile, events, lists, reviews, etc
        //This is a single object request (not multiple objects)
        $return = $req["return"];
        //get return type
        $db_name = "";
        $id = "";
        switch($return){
            case "profile":
                $db_name = "users";
                $id = "u_id";
                break;
            case "event":
                $db_name = "events";
                $id = "e_id";
                break;
            case "list":
                $db_name = "lists";
                $id = "l_id";
                break;
            case "review":
                $db_name = "reviews";
                $id = "r_id";
                break;
            default:
                $this->respond("error", null, "Invalid GET request");
                return;
        }
        //make get request
        $query = $this->conn->prepare('SELECT * FROM '.$db_name.' WHERE '. $id .'= ?;');
        //error handling
        if(!$query->execute(array($req["id"]))){ 
            $query = null;
            $this->respond("error", null, $this->processing_err);
            return;
        }
        //check if object exists
        if($query->rowCount() == 0){
            $query = null;
            $this->respond("error", null, $return." does not exist");
            return;
        }
        //get object
        $object = $query->fetchAll();
        $object_array = $object[0];//only want the first result (if ever there were more than one)
        $this->respond("success", $object_array, $return." returned successfully");
    }
    /*
    
        GET MULTIPLE - HANDLE GET REQUESTS FOR ALL EVENTS, LISTS, REVIEWS, ETC -> MULTIPLE OBJECTS
        ===========================================================================================================================
    */
    public function getFeed($req){
        //Description: Get events for local or global feed
        //This is a multiple object request (not single object)
        $scope = $req["scope"];
        $user_id = $req["user_id"];
        if($scope == "global"){
            //global feed -> events from all users
            $query = $this->conn->prepare('SELECT * FROM events WHERE 1 ORDER BY e_date DESC;');
            //error handling
            if(!$query->execute()){ 
                $query = null;
                $this->respond("error", null, $this->processing_err);
                return;
            }
            $this->respond("success", $query->fetchAll(), "Global feed returned successfully");
        }
        else if($scope == "local"){
            //local feed -> events and attended events from current user and all users they follow
            //get all followers of user
            $query = $this->conn->prepare('SELECT u_fid FROM followers WHERE u_rid = ?;');
            //error handling
            if(!$query->execute(array($user_id))){ 
                $query = null;
                $this->respond("error", null, $this->processing_err);
                return;
            }
            //check if user has followers
            if($query->rowCount() == 0){
                $query = null;
                $this->respond("error", null, "User has no followers");
                return;
            }
            //get all events from user and all followers
            $followers = $query->fetchAll();
            $query = null;
            $events = array();
            foreach($followers as $follower){
                //get all follower's events
                $query = $this->conn->prepare('SELECT * FROM events WHERE u_id = ? ORDER BY e_date DESC;');
                //error handling
                if(!$query->execute(array($follower["u_fid"]))){ 
                    $query = null;
                    $this->respond("error", null, $this->processing_err);
                    return;
                }
                $events = array_merge($events, $query->fetchAll());
                $query = null;

                //get all follower's attended events
                $query = $this->conn->prepare('SELECT e_rid FROM reviews WHERE u_rid =?;');
                //error handling
                if(!$query->execute(array($follower["u_fid"]))){ 
                    $query = null;
                    $this->respond("error", null, $this->processing_err);
                    return;
                }
                $e = $query->fetchAll();
                $query = null;
                foreach($e as $event){
                    //grab each event
                    $query = $this->conn->prepare('SELECT * FROM events WHERE e_id = ? ORDER BY e_date DESC;');
                    //error handling
                    if(!$query->execute(array($event["e_rid"]))){ 
                        $query = null;
                        $this->respond("error", null, $this->processing_err);
                        return;
                    }
                    $events = array_merge($events, $query->fetchAll());
                    $query = null;
                }
            }
            //finally get all user's events
            $query = $this->conn->prepare('SELECT * FROM events WHERE u_id = ? ORDER BY e_date DESC;');
            //error handling
            if(!$query->execute(array($user_id))){ 
                $query = null;
                $this->respond("error", null, $this->processing_err);
                return;
            }
            $events = array_merge($events, $query->fetchAll());
            $query = null;
            //get all user's attended events
            $query = $this->conn->prepare('SELECT e_rid FROM reviews WHERE u_rid =?;');
            //error handling
            if(!$query->execute(array($user_id))){ 
                $query = null;
                $this->respond("error", null, $this->processing_err);
                return;
            }
            $e = $query->fetchAll();
            $query = null;
            foreach($e as $event){
                //grab each event
                $query = $this->conn->prepare('SELECT * FROM events WHERE e_id = ? ORDER BY e_date DESC;');
                //error handling
                if(!$query->execute(array($event["e_rid"]))){ 
                    $query = null;
                    $this->respond("error", null, $this->processing_err);
                    return;
                }
                $events = array_merge($events, $query->fetchAll());
                $query = null;
            }
            //sort events by date
            usort($events, function($a, $b) {
                return $a['e_date'] <=> $b['e_date'];
            });
            $this->respond("success", $events, "Local feed returned successfully");
        }
        else if($scope == "self"){
            //user feed -> events from current user
            $query = $this->conn->prepare('SELECT * FROM events WHERE u_id = ? ORDER BY e_date DESC;');
            //error handling
            if(!$query->execute(array($user_id))){ 
                $query = null;
                $this->respond("error", null, $this->processing_err);
                return;
            }
            $this->respond("success", $query->fetchAll(), "User feed returned successfully");
        }
        else{
            $this->respond("error", null, "Invalid GET request");
            return;
        }
    }
    public function getReviewedEvents($req){
        //Description: Get all events reviewed by user
        $user_id = $req["id"];
        $query = $this->conn->prepare('SELECT e_rid FROM reviews WHERE u_rid = ?;');
        //error handling
        if(!$query->execute(array($user_id))){ 
            $query = null;
            $this->respond("error", null, $this->processing_err);
            return;
        }
        //check if user has reviewed any events
        if($query->rowCount() == 0){
            $query = null;
            $this->respond("error", null, "User has not reviewed any events");
            return;
        }
        //get all events reviewed by user
        $events = $query->fetchAll();
        $query = null;
        $event_array = array();
        foreach($events as $event){
            //grab each event
            $query = $this->conn->prepare('SELECT * FROM events WHERE e_id = ? ORDER BY e_date DESC;');
            //error handling
            if(!$query->execute(array($event["e_rid"]))){ 
                $query = null;
                $this->respond("error", null, $this->processing_err);
                return;
            }
            $event_array = array_merge($event_array, $query->fetchAll());
            $query = null;
        }
        $this->respond("success", $event_array, "User's reviewed events returned successfully");
    }
    public function getLists($req){
        //Description: Get all lists from user
        $user_id = $req["id"];
        $query = $this->conn->prepare('SELECT * FROM lists WHERE u_id = ?;');
        //error handling
        if(!$query->execute(array($user_id))){ 
            $query = null;
            $this->respond("error", null, $this->processing_err);
            return;
        }
        //check if user has any lists
        if($query->rowCount() == 0){
            $query = null;
            $this->respond("error", null, "User has no lists");
            return;
        }
        $this->respond("success", $query->fetchAll(), "User's lists returned successfully");
    }
    public function getReviews($req){
        //Description: Get all reviews for a specific event
        $event_id = $req["id"];
        $query = $this->conn->prepare('SELECT * FROM reviews WHERE e_rid = ?;');
        //error handling
        if(!$query->execute(array($event_id))){ 
            $query = null;
            $this->respond("error", null, $this->processing_err);
            return;
        }
        //check if event has any reviews
        if($query->rowCount() == 0){
            $query = null;
            $this->respond("error", null, "Event has no reviews");
            return;
        }
        $this->respond("success", $query->fetchAll(), "Event's reviews returned successfully");
    }
    public function getFollowers($req){
        //Description: Get all followers for a specific user
        $user_id = $req["id"];
        $query = $this->conn->prepare('SELECT f_id FROM followers WHERE u_id = ?;');
        //error handling
        if(!$query->execute(array($user_id))){ 
            $query = null;
            $this->respond("error", null, $this->processing_err);
            return;
        }
        //check if user has any followers
        if($query->rowCount() == 0){
            $query = null;
            $this->respond("error", null, "User has no followers");
            return;
        }
        $this->respond("success", $query->fetchAll(), "User's followers returned successfully");
    }
    public function getFollowing($req){
        //Description: Get all users a specific user is following
        $user_id = $req["id"];
        $query = $this->conn->prepare('SELECT u_id FROM followers WHERE f_id = ?;');
        //error handling
        if(!$query->execute(array($user_id))){ 
            $query = null;
            $this->respond("error", null, $this->processing_err);
            return;
        }
        //check if user is following anyone
        if($query->rowCount() == 0){
            $query = null;
            $this->respond("error", null, "User is not following anyone");
            return;
        }
        $this->respond("success", $query->fetchAll(), "User's following returned successfully");
    }
    /*
        
        ADD - ADD EVENT, ADD LIST
        ============================================================================================================================
    */
    public function add($req){
        //Description: Add event or list to database
        $add = $req["add"];
        $user_id = $req["user_id"];
        $user_name = $req["user_name"];
        if($add == "event"){
            $event_array = array(
                "e_name" => $req["e_name"],
                "e_desc" => isset($req["e_desc"]) ? $req["e_desc"] : "No description",
                "e_date" => $req["e_date"],
                "e_time" => $req["e_time"],
                "e_location" => $req["e_location"],
                "e_type" => $req["e_type"],
                "e_tag1" => isset($req["e_tag1"]) ? $req["e_tag1"] : "",
                "e_tag2" => isset($req["e_tag2"]) ? $req["e_tag2"] : "",
                "e_tag3" => isset($req["e_tag3"]) ? $req["e_tag3"] : "",
                "e_tag4" => isset($req["e_tag4"]) ? $req["e_tag4"] : "",
                "e_tag5" => isset($req["e_tag5"]) ? $req["e_tag5"] : "",
                "e_img" => isset($req["e_img"]) ? $req["e_img"] : "event.png",
                "e_rating" => 0
            );
            $query = $this->conn->prepare('INSERT INTO events (u_rid, u_rname, e_name, e_desc, e_date, e_time, e_location, e_type, e_tag1, e_tag2, e_tag3, e_tag4, e_tag5, e_img, e_rating) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);');
            //error handling
            if(!$query->execute(array($user_id, $user_name, $event_array["e_name"], $event_array["e_desc"], $event_array["e_date"], $event_array["e_time"], $event_array["e_location"], $event_array["e_type"], $event_array["e_tag1"], $event_array["e_tag2"], $event_array["e_tag3"], $event_array["e_tag4"], $event_array["e_tag5"], $event_array["e_img"], $event_array["e_rating"]))){ 
                $query = null;
                $this->respond("error", null, $this->processing_err);
                return;
            }
            $this->respond("success", $event_array, "Event added successfully");
        }
        else if($add == "list"){
            $list_array = array(
                "l_name" => $req["l_name"],
                "l_desc" => isset($req["l_desc"]) ? $req["l_desc"] : "No description",
                "l_events" => ""
            );
            $query = $this->conn->prepare('INSERT INTO lists (u_rid, u_rname, l_name, l_desc, l_events) VALUES (?, ?, ?, ?, ?);');
            //error handling
            if(!$query->execute(array($user_id, $user_name, $list_array["l_name"], $list_array["l_desc"], $list_array["l_events"]))){ 
                $query = null;
                $this->respond("error", null, $this->processing_err);
                return;
            }
            $this->respond("success", $list_array, "List added successfully");
        }
        else{
            $this->respond("error", null, "Invalid ADD request");
            return;
        }
    }
    /*

        DELETE - DELETE EVENT, DELETE LIST, DELETE REVIEW
        ============================================================================================================================
    */
    public function delete($req){
        //Description: Delete event, review or list from database
        $delete = $req["delete"];
        $user_id = $req["user_id"];
        if($delete == "event"){
            $event_id = $req["e_id"];
            $query = $this->conn->prepare('DELETE FROM events WHERE e_id = ? AND u_rid = ?;');
            //error handling
            if(!$query->execute(array($event_id, $user_id))){ 
                $query = null;
                $this->respond("error", null, $this->processing_err);
                return;
            }
            $this->respond("success", null, "Event deleted successfully");
        }
        else if($delete == "list"){
            $list_id = $req["l_id"];
            $query = $this->conn->prepare('DELETE FROM lists WHERE l_id = ? AND u_rid = ?;');
            //error handling
            if(!$query->execute(array($list_id, $user_id))){ 
                $query = null;
                $this->respond("error", null, $this->processing_err);
                return;
            }
            $this->respond("success", null, "List deleted successfully");
        }
        else if($delete == "review"){
            $review_id = $req["r_id"];
            $query = $this->conn->prepare('DELETE FROM reviews WHERE r_id = ? AND u_rid = ?;');
            //error handling
            if(!$query->execute(array($review_id, $user_id))){ 
                $query = null;
                $this->respond("error", null, $this->processing_err);
                return;
            }
            $this->respond("success", null, "Review deleted successfully");
        }
        else{
            $this->respond("error", null, "Invalid DELETE request");
            return;
        }
    }
    /*
    
        UPDATE - UPDATE USER, EVENT OR LIST
        ===========================================================================================================================
    */
    public function update($req){
        //Description: Make SQL queries for updating a user, event or list (update in DB) if all validation passes
        //Find user (already checked if valid)
        if(!$this->userExists($req)){
            //user DNE
            $this->respond("error", null, $this->user_dne_err);
            return;
        }
        $update = $req["update"];
        if($update === "user"){
            //update user
            $query = $this->conn->prepare('UPDATE `users` SET `u_display_name`=?, `u_profile`=?, `u_bio`=?, `u_pronouns`=?, `u_location`=?, WHERE u_email=?;');
            if(!$query->execute(array($req["display_name"], $req["profile"], $req["bio"], $req["pronouns"], $req["location"], $req["email"]))){ 
                $query = null;
                $this->respond("error", null, $this->processing_err);
                return;
            }
        }
        else if($update === "event"){
            //update event
            $query = $this->conn->prepare('UPDATE `events` SET `e_name`=?, `e_desc`=?, `e_date`=?, `e_time`=?, `e_location`=?, `e_type`=?, `e_img`=?, `e_tag1`=?, `e_tag2`=?, `e_tag3`=?, `e_tag4`=?, `e_tag5`=? WHERE e_id=?;');
            if(!$query->execute(array($req["name"], $req["desc"], $req["date"], $req["time"], $req["location"], $req["type"], $req["img"], $req["tag1"], $req["tag2"], $req["tag3"], $req["tag4"], $req["tag5"], $req["id"]))){ 
                $query = null;
                $this->respond("error", null, $this->processing_err);
                return;
            }
        }
        else if($update === "list"){
            //update list
            $query = $this->conn->prepare('UPDATE `lists` SET `l_name`=?, `l_desc`=?, `l_evens`=? WHERE l_id=?;');
            if(!$query->execute(array($req["name"], $req["desc"], $req["events"], $req["id"]))){ 
                $query = null;
                $this->respond("error", null, $this->processing_err);
                return;
            }
        }
        else{
            $this->respond("error", null, "Invalid Update Type");
        }

        $this->respond("success", $req, "Successfully updated '. $update .'");
        $query = null;
    }
    /*
    
        FOLLOW AND UNFOLLOW - FOLLOW AND UNFOLLOW USER
        ============================================================================================================================
    */
    public function follow($req){
        //Description: Follow or unfollow a user
        $follow = $req["follow"];
        $user_id = $req["user_id"];
        $user_name = $req["user_name"];
        $follow_id = $req["follow_id"];
        $follow_name = $req["follow_name"];
        if($follow == "follow"){
            $query = $this->conn->prepare('INSERT INTO followers (u_rid, u_rname, u_fid, u_fname) VALUES (?, ?);');
            //error handling
            if(!$query->execute(array($user_id, $user_name, $follow_id, $follow_name))){ 
                $query = null;
                $this->respond("error", null, $this->processing_err);
                return;
            }
            $this->respond("success", null, "Successfully followed user");
        }
        else if($follow == "unfollow"){
            $query = $this->conn->prepare('DELETE FROM followers WHERE u_rid = ? AND u_fid = ?;');
            //error handling
            if(!$query->execute(array($user_id, $follow_id))){ 
                $query = null;
                $this->respond("error", null, $this->processing_err);
                return;
            }
            $this->respond("success", null, "Successfully unfollowed user");
        }
        else{
            $this->respond("error", null, "Invalid Follow Type");
        }
    }
    /* 

        SEARCH DB - HANDLE SEARCH REQ
        ===========================================================================================================================
    */
    public function search($req){
        //Description: Search DB for events matching query parameters (if any)
        //Only a single search bar with text input so only one parameter to search for
        //get parameters
        $params = $req["search"];
        
        //make query with params
        $query = $this->conn->prepare('SELECT DISTINCT * FROM events WHERE e_name LIKE "%" ? "%" OR u_rname=? OR e_location=? OR e_type=? OR e_tag1=? OR e_tag2=? OR e_tag3=? OR e_tag4=? OR e_tag5=? ORDER BY e_date DESC;');
        //error handling
        if(!$query->execute(array($params, $params, $params, $params, $params, $params, $params, $params, $params))){ 
            $query = null;
            $this->respond("error", null, $this->processing_err);
            return;
        }

        $result = null;
        if($query->rowCount() > 0){
            $result = $query->fetchAll();
            $this->respond("search", $result, "Search results - success");

            $query = null;
            return;
        }
        else{
            $this->respond("error", null, "No events found");
            $query = null;
        }  
    }
    /*
    
        RATE - UPDATE EVENT RATING - HANDLE RATE REQ
        ===========================================================================================================================
    
    */
    public function rate($req){
        //Description: Add user review to event and update event rating
        //check user exists
        if(!$this->userExists($req)){
            //user DNE
            $this->respond("error", null, $this->user_dne_err);
            return;
        }
        //insert into reviews table with new review
        //check user hasn't already reviewed event
        $query = $this->conn->prepare('SELECT r_id FROM reviews WHERE u_rid=? AND e_rid=?;');
        //error handling
        if(!$query->execute(array($req['user_id'], $req['event_id']))){ 
            $query = null;
            $this->respond("error", null, $this->processing_err);
            return;
        }
        //if has rated, update reviews table with new review
        $rated = false;
        foreach($query as $r){
            if($r['u_id'] == $req['user_id'] && $r['e_id'] == $req['event_id']){
                $q = $this->conn->prepare('UPDATE `reviews` SET `r_rating`=?, `r_comment`=?, `r_name`=?, `r_img`=? WHERE u_id=? AND e_id=?;');
                //error handling
                if(!$q->execute(array($req['rating'], $req['comment'], $req['name'], $req['img'], $req['user_id'], $req['event_id']))){ 
                    $q = null;
                    $this->respond("error", null, $this->processing_err);
                    return;
                }
                $q = null;
                $rated = true;
                break;
            }
        }
        //if user has not yet reviewed, insert new review into reviews table
        if(!$rated){
            $q = $this->conn->prepare('INSERT INTO `reviews`(`r_rating`, `r_comment`, `r_name`, `r_img`, `u_rid`, `u_rname`, `e_rid`) VALUES (?,?,?,?,?,?,?;');
            //error handling
            if(!$q->execute(array($req['rating'], $req['comment'], $req['name'], $req['img'], $req['user_id'], $req['user_name'], $req['event_id']))){ 
                $q = null;
                $this->respond("error", null, $this->processing_err);
                return;
            }
            $q = null;
            $rated = true;
        }
        //compute average rating for event
        $query = $this->conn->prepare('SELECT ROUND(AVG(r_rating)) as avg_rating FROM reviews WHERE e_rid=?;');
        if(!$query->execute(array($req['event_id'])) || $query->rowCount() == 0){ 
            $query = null;
            $this->respond("error", null, $this->processing_err);
            return;
        }
        $result = $query->fetchAll();
        $query = null;
        //update event rating in article table
        $rate_q = $this->conn->prepare('UPDATE `events` SET `e_rating`=? WHERE e_id=?;');
        if(!$rate_q->execute(array($result[0]['avg_rating'], $req['e_id'])) || $rate_q->rowCount() == 0){ 
            $rate_q = null;
            $this->respond("error", null, $this->processing_err);
            return;
        }
        $rate_q = null;
        //return event's new rating + user's review
        $review_array = array(
            "avg_rating" => $result[0]['avg_rating'], 
            "comment" => $req['comment'], 
            "name" => $req['name'], 
            "img" => $req['img'],
            "rating" => $req['rating']
        );
        $this->respond("success", $review_array, "Successfully rated event");
    }

    /*
        
        RESPOND - CREATE AND RETURN RESPONSE JSON OBJECT

    */
    public function respond($type, $return, $msg){
        //Description: Create (set) and return response JSON object
        //response = response parameter in this class 
        /*
        
            SEARCH RESPONSE JSON OBJECT
        
        */
        if($type ==="search" && $return != null){ 
            $this->response["status"] = "success";
            $this->response["timestamp"] = $this->curr_time;
            foreach($return as $row)
            {
                //add event object to events array
                array_push($this->response["data"], $row);
            }
            $this->response["data"]["message"] = $msg;
        }
        /*
        
            SUCCESS / ERROR RESPONSE JSON OBJECT
        
        */
        else{
            $this->response["status"] = $type;
            $this->response["timestamp"] = $this->curr_time;
            array_push($this->response["data"], $return);
            $this->response["data"]["message"] = $msg;
        }
    }
    public function getResponse(){
        //return response parameter
        return json_encode($this->response);
    }
}
