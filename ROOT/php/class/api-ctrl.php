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
            u_id BIGINT PRIMARY KEY AUTO_INCREMENT not null, 
            u_name VARCHAR(255) UNIQUE not null,
            u_display_name VARCHAR(255) DEFAULT "New User",
            u_email VARCHAR(255) UNIQUE not null,
            u_psw VARCHAR(1000) not null,
            u_profile VARCHAR(1000) DEFAULT "profile.png",
            u_bio VARCHAR(1000) DEFAULT "",
            u_pronouns VARCHAR(255) DEFAULT "",
            u_age TINYINT DEFAULT 0,
            u_location VARCHAR(255) DEFAULT "",
            u_admin BOOLEAN not null DEFAULT false
        );
    */
    /*
        Database table for events looks like:
        CREATE TABLE events(
            e_id BIGINT PRIMARY KEY AUTO_INCREMENT not null,
            u_rid BIGINT not null,
            FOREIGN KEY (u_rid) REFERENCES users(u_id) ON DELETE CASCADE,
            u_rname VARCHAR(255) not null,
            FOREIGN KEY (u_rname) REFERENCES users(u_name) ON DELETE CASCADE,
            e_name VARCHAR(255) not null,
            e_desc VARCHAR(255) DEFAULT "No description",
            e_date DATE not null,
            e_time TIME not null,
            e_location VARCHAR(255) not null,
            e_type VARCHAR(255) not null,
            e_img VARCHAR(1000) DEFAULT "event.png",
            e_rating TINYINT not null DEFAULT 0
        );
    */
    /*
        Database table for reviews looks like:
        CREATE TABLE reviews(
            r_id BIGINT PRIMARY KEY AUTO_INCREMENT not null,
            u_rid BIGINT not null,
            FOREIGN KEY (u_rid) REFERENCES users(u_id) ON DELETE CASCADE,
            u_rname VARCHAR(255) not null,
            FOREIGN KEY (u_rname) REFERENCES users(u_name) ON DELETE CASCADE,
            e_rid BIGINT not null,
            FOREIGN KEY (e_rid) REFERENCES events(e_id) ON DELETE CASCADE,
            r_rating TINYINT not null,
            r_name VARCHAR(255) not null,
            r_comment VARCHAR(1000) not null,
            r_img VARCHAR(1000) DEFAULT "review.png"
        );
    */
    /*
        Database table for lists looks like:
        CREATE TABLE lists(
            l_id BIGINT PRIMARY KEY AUTO_INCREMENT not null,
            u_rid BIGINT not null,
            FOREIGN KEY (u_rid) REFERENCES users(u_id) ON DELETE CASCADE,
            u_rname VARCHAR(255) not null,
            FOREIGN KEY (u_rname) REFERENCES users(u_name) ON DELETE CASCADE,
            l_name VARCHAR(255) not null,
            l_desc VARCHAR(1000) DEFAULT "No description",
            l_events VARCHAR(1000) DEFAULT ""
        );
    */
    /*
        Database table for followers looks like:
        CREATE TABLE followers(
            f_id BIGINT PRIMARY KEY AUTO_INCREMENT not null,
            u_rid BIGINT not null,
            FOREIGN KEY (u_rid) REFERENCES users(u_id) ON DELETE CASCADE,
            u_rname VARCHAR(255) not null,
            FOREIGN KEY (u_rname) REFERENCES users(u_name) ON DELETE CASCADE,
            u_fid BIGINT not null,
            FOREIGN KEY (u_fid) REFERENCES users(u_id) ON DELETE CASCADE,
            u_fname VARCHAR(255) not null,
            FOREIGN KEY (u_fname) REFERENCES users(u_name) ON DELETE CASCADE
        );
    */
    //connection
    public $inst;
    public $conn;
    //common errors
    public $user_dne_err = "user does not exist";
    public $no_events_err = "No events found";
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
        $date = date_create("", timezone_open("Africa/Johannesburg"));
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

                LOGIN REQ{
                    [req] "email" : "jane.doe@email.com" (Email for login request)
                    [req] "password" : "ValidPassword123#" (Password for login request)
                }
                SIGNUP REQ{
                    [req] "username" : "jane.doe" (Username for signup request)
                    [req] "email" : "jane.doe@email.com" (Email for signup request)
                    [req] "password" : "ValidPassword123#" (Password for signup request)
                }
                INFO REQ{
                    [req] "return" : "profile" (Thing to return. Can be of type: profile, search, events, event, lists, list, followers, following, reviews, reviewed, review, chats, chat)
                    [req] "scope" : "global" (Range of things to return. Can be of type: local, self or global)
                    [req] "id" : "1" (Id of thing to return. Alt., Id of profile or event referenced (for getting lists, follows etc. of a specific user that may not be the current user). Not required for search and global)
                    [req] "search" : "search term" (Search terms to search for)
                }
                ADD REQ{
                    [req] "add" : "event" (Add type. Can be of type: event, list)
                    [req] "username" : "jane.doe" (User's u_name in the users database table)
                    [req] -> All parameters for adding events (name* , desc (w/tags), date* , time* , location*, type*, img)
                    OR [req] -> All parameters for adding lists (name *, desc)
                }
                DELETE REQ{
                    [req] "delete": "event" (Delete type. Can be of type: event, list, review, user)
                    [req] "event_id": "12"  (Event's e_id in the events database table)
                    [req] "list_id": "12"  (List's l_id in the list database table)
                    [req] "review_id": "12"  (Review's r_id in the reviews database table)
                    [req] "profile_id": "12"  (User's u_id in the users database table)
                }
                UPDATE REQ{
                    [req] "update" : "profile" (Update type. Can be of type: user, event, list)
                    [req] "event_id": "12"  (Event's e_id in the events database table)
                    [req] "list_id": "12"  (List's l_id in the list database table)
                    [opt] -> Any (all) of the profile parameters (display name, bio, age, location, pronouns, img)
                    [opt] -> Any (all) of the event parameters (name, desc (w/tags), date, time, location, type, img)
                    [opt] -> Any (all) of the list parameters (name, desc)
                }
                RATE REQ{
                    [req] "username" : "jane.doe" (User's u_name in the users database table)
                    [req] "event_id" : "15" (Event's e_id in the events database table)
                    [req] -> All parameters for adding reviews (name *, comment *, image *, rating*)
                }
                CHAT REQ{
                    [req] "chat_id": 12 (User u_id with which you wanna chat)
                    [req] "message" : "hello" (the message you want to send)
                }
                FOLLOW REQ{
                    [req] "follow" : "follow" (Follow type. Can be of type: follow, unfollow)
                    [req] "username" : "jane.doe" (User's u_name in the users database table)
                    [req] "follow_id" : "2" (User's u_id in the users database table)
                    [req] "follow_name" : "jane.doe" (User's u_name in the users database table)
                }
            }
        */

        //handle if req has what it needs
        if(empty($req) || !in_array($req["type"], $req) || empty($req["type"]) || !in_array($req["user_id"], $req) || empty($req["user_id"])){
            $this->respond("error", null, "Bad Request - Required parameters missing or empty");
            return;//don't continue
        }
        //check required request type
        if($req["type"] === "info"){
            //INFO REQ 
            if(!in_array($req["return"], $req) || empty($req["return"])){
                //required return parameter not set
                $this->respond("error", null, "Bad Request - No return parameter specified");
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
                $this->respond("error", null, "Bad Request - Invalid return parameter");
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
            if(!in_array($req["add"], $req) || empty($req["add"])){
                //required add parameter not set
                $this->respond("error", null, "Bad Request - No add parameter specified");
            }
            else{
                $this->add($req);
            }
        }
        else if($req["type"] === "delete"){
            if(!in_array($req["delete"], $req) || empty($req["delete"])){
                //required delete parameter not set
                $this->respond("error", null, "Bad Request - No delete parameter specified");
            }
            else{
                $this->delete($req);
            }
        }
        else if($req["type"] === "update"){
            //UPDATE REQ
            if(!in_array($req["update"], $req) || empty($req["update"])){
                //required update parameter not set
                $this->respond("error", null, "Bad Request - No update parameter specified");
            }
            else{
                $this->update($req);
            }
        }
        else if($req["type"] === "rate"){
            //RATE REQ
            if((!in_array($req["username"], $req) || empty($req["username"])) || (!in_array($req["event_id"], $req) || empty($req["event_id"])) || (!in_array($req["r_rating"], $req) || empty($req["r_rating"])) || (!in_array($req["r_name"], $req) || empty($req["r_name"])) || (!in_array($req["r_comment"], $req) || empty($req["r_comment"])) || (!in_array($req["r_img"], $req) || empty($req["r_img"]))){
                $this->respond("error", null, "Nothing to rate, or review parameters missing.");
            }
            else{
                $this->rate($req);
            }
        }
        else if($req["type"] === "chat"){
            //CHAT REQ
            $this->respond("error", null, "The API type chat does not exist yet");
        }
        else if($req["type"] === "follow"){
            if((!in_array($req["follow"], $req) || empty($req["follow"])) && (!in_array($req["user_name"], $req) || empty($req["user_name"])) && (!in_array($req["follow_id"], $req) || empty($req["follow_id"])) && (!in_array($req["follow_name"], $req) || empty($req["follow_name"]))){
                $this->respond("error", null, "Bad Request - Required follow parameters missing or empty");
            }
            else{
                $this->follow($req);
            }
        }
        else{
            //random/bad request
            $this->respond("error", null, "Bad Request - Invalid Request Type");
        }
    }

    public function userExists($email, $username){
        //Description: check if user already exists (for signup / login)
        $result = true;//assume user already exists
        //prepare statement 
        $stmt = $username != NULL ? "u_email = ? OR u_name = ?" : "u_email = ?";
        $query = $this->conn->prepare('SELECT u_id FROM users WHERE '. $stmt);
        //error handling
        try{
            if($username != NULL){
                $query->execute(array($email, $username));
            }
            else{
                $query->execute(array($email));
            }
            $result = $query->rowCount() > 0 ? true : false;
        }
        catch(PDOException $e){
            $this->respond("error", null,  $e->getMessage());
            $query = null;
            $result = true;//don't allow user in if there was internal error
        }
        $query = null;
        return $result;
    }

    /*
        
        SIGNUP - SET USER + CHECK USER DNE ALREADY
        ===========================================================================================================================
    */
    public function setUser($req){
        //Description: Make SQL queries for signing up a user (insert into DB) if all validation passes
        //Error handling for server-side form validation done by signup-ctrl class which is used by signup-handler
        
        $name = $req["username"];
        $display_name = isset($req["display_name"]) ? $req["display_name"] : "user" . rand(0, 9999);
        $email = $req["email"];
        $psw = $req["password"];
        $age = isset($req["age"]) ? $req["age"] : 0;
        $location = isset($req["location"]) ? $req["location"] : "";
        $pronouns = isset($req["pronouns"]) ? $req["pronouns"] : "";
        $profile = isset($req["profile"]) ? $req["profile"] : "profile.png";
        $bio = isset($req["bio"]) ? $req["bio"] : "";
        $admin = isset($req["admin"]) ? $req["admin"] : 0;        

        $query = $this->conn->prepare('INSERT INTO users (u_name, u_display_name, u_email, u_psw, u_profile, u_bio, u_pronouns, u_age, u_location, u_admin) VALUES (?,?,?,?,?,?,?,?,?,?);');

        //create array
        $user_array = array($name, $display_name, $email, $psw, $profile, $bio, $pronouns, $age, $location, $admin);
        //error handling
        try{
            $query->execute($user_array);
        }
        catch(PDOException $e){
            $this->respond("error", null,  $e->getMessage());
        }
        $query = null; 
        $this->getUser($req);//get user info and send back
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
        $query = $this->conn->prepare('SELECT * FROM users WHERE `u_email` = ?;');
        //error handling
        try{
            $query->execute(array($email));
            $result = $query->fetchAll();
            if(!empty($result)){
                //If user exists, check password is valid (matches what is stored in db)
                //Get password from successful query (no email duplicates allowed) and compare to given password
                if($psw !== $result[0]["u_psw"]){
                    $query = null;
                    $this->respond("error", null, "Authentication Error, Incorrect Email or Password");
                    return;
                }
                $user_array = array(
                    "u_id" => $result[0]["u_id"],
                    "u_name" => $result[0]["u_name"],
                    "u_display_name" => $result[0]["u_display_name"],
                    "u_email" => $result[0]["u_email"],
                    "u_profile" => $result[0]["u_profile"],
                    "u_bio" => $result[0]["u_bio"],
                    "u_pronouns" => $result[0]["u_pronouns"],
                    "u_age" => $result[0]["u_age"],
                    "u_location" => $result[0]["u_location"],
                    "u_admin" => $result[0]["u_admin"]
                );
                $this->respond("success", $user_array, "User logged in successfully");
                $query = null;
            }
            else{
                //User doesn't exist
                $this->respond("error", null, $this->user_dne_err);
                $query = null;
            }
        }
        catch(PDOException $e){
            $this->respond("error", null,  $e->getMessage());
        }
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
        $query = $this->conn->prepare('SELECT * FROM '. $db_name .' WHERE '. $id .'= ?;');
        //error handling
        try{
            $query->execute(array($req["id"]));
            $object = $query->fetchAll();
            if(!empty($object)){
                //get object
                $object_array = $object[0];//only want the first result (if ever there were more than one)
                $this->respond("success", $object_array, $return." returned successfully");
            }
            else{
                $this->respond("error", null, $return." does not exist");
            }
            $query = null;
        }
        catch(PDOException $e){
            $this->respond("error", null,  $e->getMessage());
            $query = null;
        }
    }
    /*
    
        GET MULTIPLE - HANDLE GET REQUESTS FOR ALL EVENTS, LISTS, REVIEWS, ETC -> MULTIPLE OBJECTS
        ===========================================================================================================================
    */
    public function getFeed($req){
        //Description: Get events for local or global feed
        //This is a multiple object request (not single object)
        $scope = $req["scope"];
        $user_id = $req["id"];
        if($scope == "global"){
            //global feed -> events from all users
            $query = $this->conn->prepare('SELECT * FROM events WHERE 1 ORDER BY e_date DESC;');
            //error handling
            try{
                $query->execute();
                $events = $query->fetchAll();
                if(!empty($events)){
                    //get events
                    $this->respond("success", $events, "Global feed returned successfully");
                }
                else{
                    $this->respond("error", null, $this->no_events_err);
                }
                $query = null;
            }
            catch(PDOException $e){
                $this->respond("error", null,  $e->getMessage());
                $query = null;
            }
        }
        else if($scope == "local"){
            //local feed -> events and attended events from current user and all users they follow
            //make one query that gets all a user's events and events from all users they follow, also get all of the events the user has reviewed and all users they follow have reviewed
            $query = $this->conn->prepare('SELECT * FROM events WHERE e_id IN (SELECT e_id FROM events WHERE u_rid = ? UNION SELECT e_id FROM events WHERE u_rid IN (SELECT u_id FROM users WHERE u_id IN (SELECT u_rid FROM followers WHERE u_fid = ?))) ORDER BY e_date DESC;');
            //error handling
            try{
                $query->execute(array($user_id, $user_id));
                $events = $query->fetchAll();
                if(!empty($events)){
                    //get events
                    //remove duplicates
                    $events = array_map("unserialize", array_unique(array_map("serialize", $events)));
                    $this->respond("success", $events, "Local feed returned successfully");
                }
                else{
                    $this->respond("error", null, $this->no_events_err);
                }
                $query = null;
            }
            catch(PDOException $e){
                $this->respond("error", null,  $e->getMessage());
                $query = null;
            }
        }
        else if($scope == "self"){
            //user feed -> events from current user
            $query = $this->conn->prepare('SELECT * FROM events WHERE u_rid = ? ORDER BY e_date DESC;');
            //error handling
            try{
                $query->execute(array($user_id));
                $events = $query->fetchAll();
                if(!empty($events)){
                    //get events
                    $this->respond("success", $events, "User feed returned successfully");
                }
                else{
                    $this->respond("error", null, $this->no_events_err);
                }
                $query = null;
            }
            catch(PDOException $e){
                $this->respond("error", null,  $e->getMessage());
                $query = null;
            }
        }
        else{
            $this->respond("error", null, "Invalid GET request");
        }
    }
    public function getReviewedEvents($req){
        //Description: Get all events reviewed by user
        //This is a multiple object request (not single object)
        $user_id = $req["id"];
        //make one query that gets all a user's events and events that user has reviewed
        $query = $this->conn->prepare('SELECT * FROM events WHERE e_id IN (SELECT e_rid FROM reviews WHERE u_rid = ?) ORDER BY e_date DESC;');
        //error handling
        try{
            $query->execute(array($user_id));
            $events = $query->fetchAll();
            if(!empty($events)){
                //get events
                $this->respond("success", $events, "Reviewed events returned successfully");
            }
            else{
                $this->respond("error", null, $this->no_events_err);
            }
            $query = null;
        }
        catch(PDOException $e){
            $this->respond("error", null,  $e->getMessage());
            $query = null;
        }
    }
    public function getLists($req){
        //Description: Get all lists from user
        $user_id = $req["id"];
        $query = $this->conn->prepare('SELECT * FROM lists WHERE u_rid = ?;');
        //error handling
        try{
            $query->execute(array($user_id));
            $lists = $query->fetchAll();
            if(!empty($lists)){
                //get all lists from user
                $this->respond("success", $lists, "User's lists returned successfully");
            }
            else{
                $this->respond("error", null, "No galleries found");
            }
            $query = null;
        }
        catch(PDOException $e){
            $this->respond("error", null,  $e->getMessage());
            $query = null;
        }
    }
    public function getReviews($req){
        //Description: Get all reviews for a specific event
        $event_id = $req["id"];
        $query = $this->conn->prepare('SELECT * FROM reviews WHERE e_rid = ?;');
        //error handling
        try{
            $query->execute(array($event_id));
            $reviews = $query->fetchAll();
            if(!empty($reviews)){
                //get all reviews for event
                $this->respond("success", $reviews, "Event's reviews returned successfully");
            }
            else{
                $this->respond("error", null, "No reviews for this event");
            }
            $query = null;
        }
        catch(PDOException $e){
            $this->respond("error", null,  $e->getMessage());
            $query = null;
        }
    }
    public function getFollowers($req){
        //Description: Get all followers for a specific user
        $user_id = $req["id"];
        $query = $this->conn->prepare('SELECT u_fid, u_fname FROM followers WHERE u_rid = ?;');
        //error handling
        try{
            $query->execute(array($user_id));
            $followers = $query->fetchAll();
            if(!empty($followers)){
                //get all followers for user
                $this->respond("success", $followers, "User's followers returned successfully");
            }
            else{
                $this->respond("error", null, "No followers");
            }
            $query = null;
        }
        catch(PDOException $e){
            $this->respond("error", null,  $e->getMessage());
            $query = null;
        }
    }
    public function getFollowing($req){
        //Description: Get all users a specific user is following
        $user_id = $req["id"];
        $query = $this->conn->prepare('SELECT u_rid, u_rname FROM followers WHERE u_fid = ?;');
        //error handling
        try{
            $query->execute(array($user_id));
            $following = $query->fetchAll();
            if(!empty($following)){
                //get all users user is following
                $this->respond("success", $following, "User's following returned successfully");
            }
            else{
                $this->respond("error", null, "No following");
            }
            $query = null;
        }
        catch(PDOException $e){
            $this->respond("error", null,  $e->getMessage());
            $query = null;
        }
    }
    /*
        
        ADD - ADD EVENT, ADD LIST
        ============================================================================================================================
    */
    public function add($req){
        //Description: Add event or list to database
        //if the name, 
        $add = $req["add"];
        $user_id = $req["user_id"];
        $user_name = $req["username"];
        //if user name is not set, return error
        if($user_name == null){
            $this->respond("error", null, "Username not set");
            return;
        }
        if($add == "event"){
            //if the event name is not set, return error
            if(!isset($req["e_name"])){
                $this->respond("error", null, "Event name not set");
                return;
            }
            //if the event date is not set, return error
            if(!isset($req["e_date"])){
                $this->respond("error", null, "Event date not set");
                return;
            }
            //if the event time is not set, return error
            if(!isset($req["e_time"])){
                $this->respond("error", null, "Event time not set");
                return;
            }
            //if the event type is not set, return error
            if(!isset($req["e_type"])){
                $this->respond("error", null, "Event type not set");
                return;
            }
            //if the event location is not set, return error
            if(!isset($req["e_location"])){
                $this->respond("error", null, "Event location not set");
                return;
            }
            $event_array = array(
                "e_name" => $req["e_name"],
                "e_desc" => isset($req["e_desc"]) ? $req["e_desc"] : "No description",
                "e_date" => $req["e_date"],
                "e_time" => $req["e_time"],
                "e_location" => $req["e_location"],
                "e_type" => isset($req["e_type"]) ? $req["e_type"] : "Other",
                "e_img" => isset($req["e_img"]) ? $req["e_img"] : "event.png",
                "e_rating" => 0
            );
            $query = $this->conn->prepare('INSERT INTO events (u_rid, u_rname, e_name, e_desc, e_date, e_time, e_location, e_type, e_img, e_rating) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);');
            //error handling
            try{
                $query->execute(array($user_id, $user_name, $event_array["e_name"], $event_array["e_desc"], $event_array["e_date"], $event_array["e_time"], $event_array["e_location"], $event_array["e_type"], $event_array["e_img"], $event_array["e_rating"]));
                $this->respond("success", $event_array, "Event added successfully");
            }
            catch(PDOException $e){
                $this->respond("error", null,  $e->getMessage());
            }
            $query = null;
        }
        else if($add == "list"){
            //if the list name is not set, return error
            if(!isset($req["l_name"])){
                $this->respond("error", null, "List name not set");
                return;
            }
            $list_array = array(
                "l_name" => $req["l_name"],
                "l_desc" => isset($req["l_desc"]) ? $req["l_desc"] : "No description",
                "l_events" => ""
            );
            $query = $this->conn->prepare('INSERT INTO lists (u_rid, u_rname, l_name, l_desc, l_events) VALUES (?, ?, ?, ?, ?);');
            //error handling
            try{
                $query->execute(array($user_id, $user_name, $list_array["l_name"], $list_array["l_desc"], $list_array["l_events"]));
                $this->respond("success", $list_array, "List added successfully");
                $query = null;
            }
            catch(PDOException $e){
                $this->respond("error", null,  $e->getMessage());
                $query = null;
            }
        }
        else if($add == "event_to_list"){
            //update the l_events of the specific list with the event id followed by a comma
            if(!isset($req['l_id']) || !isset($req['e_id'])){
                $this->respond("error", null, "List id or event id not given");
                return;
            }
            //get the l_events of the list with a specific list id and add the event id to the end of the string if it is not already there all in one query
            $query = $this->conn->prepare('UPDATE lists SET l_events = CONCAT(l_events, ?) WHERE l_id = ? AND NOT FIND_IN_SET(?, l_events);');
            //error handling
            try{
                $query->execute(array($req['e_id'] . ",", $req['l_id'], $req['e_id']));
                $this->respond("success", null, "Event added to list successfully");
                $query = null;
            }
            catch(PDOException $e){
                $this->respond("error", null,  $e->getMessage());
                $query = null;
            }
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
        //Description: Delete event, review, list or user profile from database
        $delete = $req["delete"];
        $user_id = $req["user_id"];
        if($delete == "event"){
            $event_id = $req["event_id"];
            $query = $this->conn->prepare('DELETE FROM events WHERE e_id = ? AND u_rid = ?;');
            //error handling
            try{
                $query->execute(array($event_id, $user_id));
                $this->respond("success", null, "Event deleted successfully");
                $query = null;
            }
            catch(PDOException $e){
                $this->respond("error", null,  $e->getMessage());
                $query = null;
            }
        }
        else if($delete == "list"){
            $list_id = $req["list_id"];
            $query = $this->conn->prepare('DELETE FROM lists WHERE l_id = ? AND u_rid = ?;');
            //error handling
            try{
                $query->execute(array($list_id, $user_id));
                $this->respond("success", null, "List deleted successfully");
                $query = null;
            }
            catch(PDOException $e){
                $this->respond("error", null,  $e->getMessage());
                $query = null;
            }
        }
        else if($delete == "review"){
            $review_id = $req["event_id"];
            $query = $this->conn->prepare('DELETE FROM reviews WHERE e_rid = ? AND u_rid = ?;');
            //error handling
            try{
                $query->execute(array($review_id, $user_id));
                $this->respond("success", null, "Review deleted successfully");
                $query = null;
            }
            catch(PDOException $e){
                $this->respond("error", null,  $e->getMessage());
                $query = null;
            }
        }
        else if($delete == "user"){
            $profile_id = $req["profile_id"];
            $query = $this->conn->prepare('DELETE FROM users WHERE u_id = ?;');
            //error handling
            try{
                $query->execute(array($profile_id));
                $this->respond("success", null, "User deleted successfully");
                //set session to indicate the user has been deleted
                $_SESSION["deleted"] = true;
                $_SESSION["deleted_id"] = $profile_id;
                $query = null;
            }
            catch(PDOException $e){
                $this->respond("error", null,  $e->getMessage());
                $query = null;
            }
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
        $update = $req["update"];
        if($update === "user"){
            //update user
            $query = $this->conn->prepare('UPDATE `users` SET `u_display_name`=?, `u_profile`=?, `u_bio`=?, `u_pronouns`=?, `u_location`=?, u_age=? WHERE u_id=?;');
            //error handling
            try{
                $query->execute(array($req["u_display_name"], $req["u_profile"], $req["u_bio"], $req["u_pronouns"], $req["u_location"], $req["u_age"], $req["user_id"]));
                $this->respond("success", null, "User updated successfully");
            }
            catch(PDOException $e){
                $this->respond("error", null,  $e->getMessage());
            }
            $query = null;
        }
        else if($update === "event"){
            //update event
            $query = $this->conn->prepare('UPDATE `events` SET `e_name`=?, `e_desc`=?, `e_date`=?, `e_time`=?, `e_location`=?, `e_type`=?, `e_img`=? WHERE `e_id`=? AND `u_rid`=?;');
            //error handling
            try{
                $event_array = array(
                    "e_name" => $req["e_name"],
                    "e_desc" => isset($req["e_desc"]) ? $req["e_desc"] : "No description",
                    "e_date" => $req["e_date"],
                    "e_time" => $req["e_time"],
                    "e_location" => $req["e_location"],
                    "e_type" => $req["e_type"],
                    "e_img" => isset($req["e_img"]) ? $req["e_img"] : "event.png"
                );
                $query->execute(array($req["e_name"], $req["e_desc"], $req["e_date"], $req["e_time"], $req["e_location"], $req["e_type"], $req["e_img"], $req["event_id"], $req["user_id"]));
                $this->respond("success", $event_array, "Event updated successfully");
            }
            catch(PDOException $e){
                $this->respond("error", null,  $e->getMessage());
            }
            $query = null;
        }
        else if($update === "list"){
            //update list
            $query = $this->conn->prepare('UPDATE `lists` SET `l_name`=?, `l_desc`=?, `l_events`=? WHERE l_id=? AND u_rid=?;');
            //error handling
            try{
                $list_array = array(
                    "l_name" => $req["l_name"],
                    "l_desc" => $req["l_desc"], 
                    "l_events" => $req["l_events"], 
                    "l_id" => $req["l_id"]
                );
                $query->execute(array($req["l_name"], $req["l_desc"], $req["l_events"], $req["l_id"], $req["user_id"]));
                $this->respond("success", $list_array, "List updated successfully");
            }
            catch(PDOException $e){
                $this->respond("error", null,  $e->getMessage());
            }
            $query = null;
        }
        else{
            $this->respond("error", null, "Invalid Update Type");
        }
    }
    /*
    
        FOLLOW AND UNFOLLOW - FOLLOW AND UNFOLLOW USER
        ============================================================================================================================
    */
    public function follow($req){
        //Description: Make SQL queries for following and unfollowing a user (update in DB) if all validation passes
        $follow = $req["follow"];
        if($follow == "follow"){
            //check user is not already following
            $query = $this->conn->prepare('SELECT * FROM `followers` WHERE u_rid=? AND u_fid=?;');
            //error handling
            try{
                $query->execute(array($req["follow_id"], $req["user_id"]));
                $result = $query->fetchAll();
                $query = null;
                if(count($result) > 0){
                    //user is already following
                    $this->respond("error", null, "User is already following");
                    return;
                }
                else{
                    //user is not following, follow
                    $query = $this->conn->prepare('INSERT INTO `followers`(`u_rid`, `u_rname`, `u_fid`, `u_fname`) VALUES (?, ?, ?, ?);');
                    //error handling
                    try{
                        $query->execute(array($req["follow_id"], $req["follow_name"], $req["user_id"],  $req["username"]));
                        $this->respond("success", null, "Successfully followed user");
                    }
                    catch(PDOException $e){
                        $this->respond("error", null,  $e->getMessage());
                        $query = null;
                        return;
                    }
                    $query = null;
                }
            }
            catch(PDOException $e){
                $this->respond("error", null,  $e->getMessage());
                $query = null;
            }
        }
        else if($follow == "unfollow"){
            $query = $this->conn->prepare('DELETE FROM followers WHERE u_rid = ? AND u_fid = ?;');
            //error handling
            try{
                $query->execute(array($req["follow_id"], $req["user_id"]));
                $this->respond("success", null, "Successfully unfollowed user");
            }
            catch(PDOException $e){
                $this->respond("error", null,  $e->getMessage());
                $query = null;
                return;
            }
            $query = null;
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
        //Only a single search bar with VARCHAR(1000) input so only one parameter to search for
        //get parameters
        if(!isset($req["search"]) || empty($req["search"])){
            $this->respond("error", null, "Invalid Search Request");
            return;
        }
        $params = $req["search"];
        $params = "%" . $params . "%";
        //make query with params
        $query = $this->conn->prepare('SELECT * FROM `events` WHERE e_name LIKE ? OR e_desc LIKE ? OR e_location LIKE ? OR e_type LIKE ? OR u_rname LIKE ? ORDER BY e_date DESC;');
        //error handling
        try{
            $query->execute(array($params, $params, $params, $params, $params));
            $result = $query->fetchAll();
            if(empty($result)){
                $this->respond("error", null, "No results found");
                $query = null;
                return;
            }
            $this->respond("success", $result, "Search successful");
            $query = null;
        }
        catch(PDOException $e){
            $this->respond("error", null,  $e->getMessage());
            $query = null;
            return;
        } 
    }
    /*
    
        RATE - UPDATE EVENT RATING - HANDLE RATE REQ
        ===========================================================================================================================
    
    */
    public function rate($req){
        //Description: Add user review to event and update event rating
        //insert into reviews table with new review/update existing review
        //check if user has already reviewed event
        $query = $this->conn->prepare('SELECT r_id FROM reviews WHERE u_rid=? AND e_rid=?;');
        //error handling
        try{
            $query->execute(array($req["user_id"], $req["event_id"]));
            $result = $query->fetchAll();
            if(!empty($result)){
                //user has already reviewed event
                //find user's previous review and update it
                $query = $this->conn->prepare('UPDATE `reviews` SET `r_rating`=?, `r_name`=?, `r_comment`=?, `r_img`=? WHERE u_rid=? AND e_rid=?;');
                //error handling
                try{
                    $query->execute(array($req["r_rating"], $req["r_name"], $req["r_comment"], $req["r_img"], $req["user_id"], $req["event_id"]));
                    $query = null;
                }
                catch(PDOException $e){
                    $this->respond("error", null,  $e->getMessage());
                    $query = null;
                    return;
                }
            }
            else{
                //user has not reviewed event
                //insert new review
                $query = $this->conn->prepare('INSERT INTO reviews (u_rid, u_rname, e_rid, r_name, r_rating, r_comment, r_img) VALUES (?, ?, ?, ?, ?, ?, ?);');
                //error handling
                try{
                    $query->execute(array($req["user_id"], $req["username"], $req["event_id"], $req["r_name"], $req["r_rating"], $req["r_comment"], $req["r_img"]));
                    $query = null;
                }
                catch(PDOException $e){
                    $this->respond("error", null,  $e->getMessage());
                    $query = null;
                    return;
                }
            }
        }
        catch(PDOException $e){
            $this->respond("error", null,  $e->getMessage());
            $query = null;
            return;
        }
        //compute average rating for event
        $query = $this->conn->prepare('SELECT ROUND(AVG(r_rating)) as avg_rating FROM reviews WHERE e_rid=?;');
        //error handling
        try{
            $query->execute(array($req["event_id"]));
            $result = $query->fetchAll();
            if(empty($result)){
                $this->respond("error", null, "No reviews found for event");
                $query = null;
                return;
            }
            $avg_rating = $result[0]["avg_rating"];
            //update event rating
            $query = $this->conn->prepare('UPDATE `events` SET `e_rating`=? WHERE e_id=?;');
            //error handling
            try{
                $query->execute(array($avg_rating, $req["event_id"]));
                //return event's new rating + review success
                $this->respond("success", $avg_rating, "Successfully rated event");
                $query = null;
                return;
            }
            catch(PDOException $e){
                $this->respond("error", null,  $e->getMessage());
                $query = null;
                return;
            }
        }
        catch(PDOException $e){
            $this->respond("error", null,  $e->getMessage());
            $query = null;
            return;
        }
    }

    /*
        
        RESPOND - CREATE AND RETURN RESPONSE JSON OBJECT

    */
    public function respond($type, $return, $msg){
        //Description: Create (set) and return response JSON object
        //response = response parameter in this class (set in constructor)
        /*
        
            SUCCESS / ERROR RESPONSE JSON OBJECT
        
        */
        $this->response["status"] = $type;
        $this->response["timestamp"] = $this->curr_time;
        $this->response["data"]["return"] = $return;
        $this->response["data"]["message"] = $msg;
    }
    public function getResponse(){
        //return response parameter
        return json_encode($this->response);
    }
}
