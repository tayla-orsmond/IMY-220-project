<?php
require_once 'class/config.php';
//Tayla Orsmond u21467456
//This file is used to upload an image to the server
//this file is called by the form in the event modal
//this file is called by the form in the profile modal

//check the file was uploaded
if (isset($_FILES['e_img_input'])) {
    //get the file name
    $filename = $_FILES['e_img_input']['name'];
    //get the file extension
    $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
    //set the file path
    $file_path = "media/uploads/events/" . $filename;
    //allowed file extensions
    $allowed = array('jpg', 'jpeg', 'png', 'gif');
    //check the file extension and the file size (<2MB)
    if (in_array($file_ext, $allowed) && $_FILES['e_img_input']['size'] < 2000000) {
        //check the file was uploaded
        if (move_uploaded_file($_FILES['e_img_input']['tmp_name'], $file_path)) {
            //success
            //go back to the profile page
            header('Location: ../profile.php?id=' . $_SESSION['user_id']);
        }
    } else {
        //return an error message
        $_SESSION['upload_error'] = "Invalid file type or file size";
    }
}
//do the same thing for the profile image
if (isset($_FILES['u_profile_input'])) {
    $filename = $_FILES['u_profile_input']['name'];
    $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
    $file_path = "media/uploads/profiles/" . $filename;
    $allowed = array('jpg', 'jpeg', 'png', 'gif');
    if (in_array($file_ext, $allowed) && $_FILES['u_profile_input']['size'] < 2000000) {
        if (move_uploaded_file($_FILES['u_profile_input']['tmp_name'], $file_path)) {
            //success
            //go back to the profile page
            header('Location: ../profile.php?id=' . $_SESSION['user_id']);
        }
    } else {
        //return an error message
        $_SESSION['upload_error'] = "Invalid file type or file size";
    }
}
header('Location: ../profile.php?id=' . $_SESSION['user_id']);
