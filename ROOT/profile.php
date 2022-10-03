<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Tayla Orsmond">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>artfolio | myfolio</title>
        <link rel="stylesheet" href="css/global.css">
        <link rel="stylesheet" href="css/events.css">
        <link rel="stylesheet" href="css/profile.css">
        <link rel="stylesheet" href="css/form.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/8ab8fd8eb6.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <!-- Tayla Orsmond u21467456 -->
        <!-- Profile page:
            Display a user's profile.
            If the user is not logged in, they will be redirected to the splash / login page.
            Some components are only available to a user who's uid matches the profile uid.
            (edit, delete, etc.)

            Some components are only available to a user who's uid is not the current profile's uid.
            (DM, follow, unfollow, etc.)
             -->
        <?php 
            require_once 'php/header.php';
        ?>
        <div class="container px-5">
            <div id="error"></div>
            <?php
                //echo out the appropriate profile page for the user dpending on the user id in the url
                //if the id is blank, then the user is viewing their own profile
                //so use the cookie to get the user id
                //and the session as a last resort
                //if the user id is not set at all, redirect to the splash page
                if (isset($_GET['id']) || isset($_COOKIE['user_id']) || isset($_SESSION['user_id'])) {
                    $user_id = null;
                    if (isset($_GET['id'])) {
                        $user_id = $_GET['id'];
                    } else if(isset($_COOKIE['user_id'])){
                        $user_id = $_COOKIE['user_id'];
                    } else{//last resort
                        $user_id = $_SESSION['user_id'];
                    }
                    //make a curl request to the api to get the profile data
                    $body = array(
                        'type'   => 'info',
                        'user_id' => $_SESSION['user_id'],
                        'return'  => 'profile',
                        'id'     => $user_id,
                    );
    
                    //make post request to API using curl
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => $api_url,
                        CURLOPT_POST => TRUE,
                        CURLOPT_RETURNTRANSFER => TRUE,
                        CURLOPT_HTTPHEADER => $api_headers,
                        CURLOPT_POSTFIELDS => json_encode($body),
                        CURLOPT_USERPWD => $api_key,
                    ));
                    //Send the request
                    $r = curl_exec($curl);
                    
                    if(!$r){//some kind of error occurred
                        echo "Error: " . curl_error($curl);
                    }
    
                    $result = json_decode($r, true);
    
                    //close the request
                    curl_close($curl);
    
                    //get the event details from the response
                    $profile = $result['data']['return'];

                    //display the profile
                    if(empty($profile)){
                        echo '<h1 class="text-center">User not found</h1>'. '<p class="text-center">'. $result["data"]["message"] . '</p>';
                    }else{
                        echo '
                        <div class="row">
                        <div class="col-12"><h1>myfolio.</h1></div><!--Title-->
                        <div class="col-9 p-5 d-flex border"><!--Profile Header card -> show details of the user-->
                            <div class="flex-fill profile-photo">
                                <img src="media/uploads/profiles/'. $profile['u_profile'] .'" alt="..." class="img-fluid rounded-circle">
                            </div>
                            <div class="flex-fill p-3 m-1">
                                <h2>' . $profile['u_display_name'] . '</h2>
                                <p class="pb-2 border-bottom">@<span id="username">' . $profile['u_name'] . '</span></p>
                                <div class="d-flex justify-content-start gap-3">';
                                if($profile['u_pronouns'] != ""){
                                    echo '<p>' . $profile['u_pronouns'] . '</p>';
                                }
                                if($profile['u_age'] != ""){
                                    echo '<p><i class="fa fa-calendar-alt"></i>' . $profile['u_age'] . '</p>';
                                }
                                if($profile['u_location'] != ""){
                                    echo '<p><i class="fa fa-map-marker-alt"></i>' . $profile['u_location'] . '</p>';
                                }
                                echo '</div>
                                <p> ' . $profile['u_bio'] .' </p>
                                <p><i class="fa fa-address-book"></i> <a href="mailto:' . $profile['u_email'] . '">' . $profile['u_email'] . '</a></p>
                            </div>
                        </div><!--End Profile Header card-->
                        <div class="col-3 d-flex flex-column align-items-start justify-content-start gap-3 py-2"><!--Actions (follow, DM, edit etc.) -->';
                            if(isset($_SESSION['user_id']) && $user_id == $_SESSION['user_id']){
                                echo '<a href="" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#edit_profile_modal">Edit Profile</a>';
                            }
                            //====================get the profile's followers
                            $body = array(
                                'type'   => 'info',
                                'user_id' => $_SESSION['user_id'],
                                'return'  => 'followers',
                                'id'     => $user_id
                            );
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => $api_url,
                                CURLOPT_POST => TRUE,
                                CURLOPT_RETURNTRANSFER => TRUE,
                                CURLOPT_HTTPHEADER => $api_headers,
                                CURLOPT_POSTFIELDS => json_encode($body),
                                CURLOPT_USERPWD => $api_key,
                            ));
                            //Send the request
                            $r = curl_exec($curl);
                            
                            if(!$r){//some kind of error occurred
                                echo "Error: " . curl_error($curl);
                            }

                            $result = json_decode($r, true);

                            //close the request
                            curl_close($curl);

                            if(!empty($result) && $result['status'] == "success"){
                                $followers = $result['data']['return'];
                            }else{
                                $followers = array();
                            }

                            //====================get the profile's following
                            $body = array(
                                'type'   => 'info',
                                'user_id' => $_SESSION['user_id'],
                                'return'  => 'following',
                                'id'     => $user_id
                            );
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => $api_url,
                                CURLOPT_POST => TRUE,
                                CURLOPT_RETURNTRANSFER => TRUE,
                                CURLOPT_HTTPHEADER => $api_headers,
                                CURLOPT_POSTFIELDS => json_encode($body),
                                CURLOPT_USERPWD => $api_key,
                            ));
                            //Send the request
                            $r = curl_exec($curl);

                            if(!$r){//some kind of error occurred
                                echo "Error: " . curl_error($curl);
                            }

                            $result = json_decode($r, true);

                            //close the request
                            curl_close($curl);
                            if(!empty($result) && $result['status'] == "success"){
                                $following = $result['data']['return'];
                            }else{
                                $following = array();
                            }

                            //check if the user is following the profile
                            $is_follower = false;
                            if(!empty($followers)){
                                foreach($followers as $follower){
                                    if($follower['u_fid'] == $_SESSION['user_id']){
                                        $is_follower = true;
                                    }
                                }
                            }
                            //check if the user logged in is not the current profile
                            if(isset($_SESSION['user_id']) && $user_id != $_SESSION['user_id']){
                                //check if the user is following the profile
                                echo '<div class="btn btn-light ' . ($is_follower ? "" : "d-none") . '" id="unfollow">Following</div>
                                <a href="message.php?chat="'. $profile['u_id'] .'" class=" ' . ($is_follower ? "" : "d-none") . '" id="DM"><i class="fa fa-paper-plane fa-xl"></i></a>
                                <div class="btn btn-dark ' . ($is_follower ? "d-none" : "") . '" id="follow">Follow</div>';
                            }
                        echo '<div class="">
                                <p><span class="fw-bold followers">' . count($followers) . ' </span> <a href="" data-bs-toggle="modal" data-bs-target="#follow_modal" id="show_followers">Followers</a></p>
                                <p><span class="fw-bold following">' . count($following) . '</span> <a href="" data-bs-toggle="modal" data-bs-target="#follow_modal" id="show_following">Following</a></p>
                            </div>
                        </div><!--End Actions -->
                        <div class="col-12 row mt-2">
                            <div class="col-12">
                                <nav class="d-flex justify-content-between align-items-center px-3"><!--Nav-->
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link active" aria-current="page" href="#" id="folios"><span class="h5">myfolios.</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" aria-current="page" href="#" id="reviewed"><span class="h5">myreviews.</span></a>
                                        </li>
                                    </ul>
                                </nav><!--End Nav-->
                            </div>
                        </div>
                        <div class="col-10 d-flex flex-wrap p-3 gap-2 border event-area-inner"><!--Event area -> for users events-->';
                            if(isset($_SESSION['user_id']) && $user_id == $_SESSION['user_id']){
                                echo'
                                <div class="w-100">
                                    <div class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#event_modal" id="add_event">Add Event</div>
                                </div>';
                            }
                        echo '<div id="events-inner"></div>
                            <div class="w-100" id="error-area"></div>
                        </div><!--End Event area-->
                        <div class="col-2 p-3">
                            <p><span class="h5">my galleries.</span></p>
                            <div class="list-group list-group-flush my-2 galleries-area-inner"><!--lists of users galleries (event lists)-->
                                <div id="error-area-g"></div>
                            </div>
                            <div id="galleries-inner"></div>';
                                if(isset($_SESSION['user_id']) && $user_id == $_SESSION['user_id']){
                                    echo '<div class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#list_modal" id="add_gallery">Add Gallery</div>';
                                }
                            echo'
                            </div><!--End galleries-->
                        </div>';
                    }
                } else {
                    //if the user id is not set, redirect to the splash page
                    header("Location: index.php");
                }
            ?>
        </div>
        <?php 
            require_once 'php/footer.php';
        ?>
        <script src="js/profile.js" type="module"></script>
    </body>
</html>