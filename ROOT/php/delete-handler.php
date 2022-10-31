<?php
/*
        Tayla Orsmond u21467456
        ---------------------------------------------------------
        This php file uses the API class to delete a profile from 
        the database as well as everything associated with it
        -> API class makes the sql query to DB (delete rows)
        -> Config.php singleton (DBH) handles the database connection
    */
require_once "class/api-ctrl.php";

if (isset($_POST['delete_profile'])) {
    $req = array(
        "type" => "delete",
        "delete" => "user",
        "user_id" => $_SESSION['user_id'],
        "profile_id" => $_POST['p_id']
    );
    $api = new API();
    $api->delete($req);
    $result = json_decode($api->getResponse(), true);
    if ($result['status'] == "success") {
        if ($_SESSION['user_id'] == $_POST['p_id']) {
            header("Location: ../logout.php");
        } else {
            header("Location: ../index.php?id=" . $_SESSION['user_id']);
        }
    } else {
        header("Location: ../profile.php?id=" . $_SESSION['user_id']);
    }
}
//do the same thing for deleting events
if (isset($_POST['delete_event'])) {
    $req = array(
        "type" => "delete",
        "delete" => "event",
        "user_id" => $_SESSION['user_id'],
        "event_id" => $_POST['e_id']
    );
    $api = new API();
    $api->delete($req);
    $result = json_decode($api->getResponse(), true);
    header("Location: ../profile.php?id=" . $_SESSION['user_id']);
}
//do the same thing for deleting reviews
if (isset($_POST['delete_review'])) {
    $req = array(
        "type" => "delete",
        "delete" => "review",
        "user_id" => $_SESSION['user_id'],
        "event_id" => $_POST['e_rid']
    );
    $api = new API();
    $api->delete($req);
    $result = json_decode($api->getResponse(), true);
    header("Location: ../event.php?id=" . $_POST['e_rid']);
}
//do the same thing for deleting lists
if (isset($_POST['delete_list'])) {
    $req = array(
        "type" => "delete",
        "delete" => "list",
        "user_id" => $_SESSION['user_id'],
        "list_id" => $_POST['l_rid']
    );
    $api = new API();
    $api->delete($req);
    $result = json_decode($api->getResponse(), true);
    header("Location: ../profile.php?id=" . $_SESSION['user_id']);
}
