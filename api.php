<?php
    require_once('php/components/class/api-ctrl.php');
    /*
        Tayla Orsmond u21467456
        ---------------------------------------------------------------------
        This php file uses the api class (which makes use of a dbh singleton) 
        to handle requests and formulate responses using JSON data
        -> dbh handles the database connection
        -> api controller handles the request handling/ response creation
    */
    //headers for response
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With");
    header("Content-Type: application/json");
    //get raw data from POST request
    $data = json_decode(file_get_contents("php://input"), true);
    //instantiate API object
    $api = new API();
    //pass in + process data 
    $api->recieve($data);
    //get response (JSON object)
    $response = $api->getResponse();
    //send response
    echo $response;
