<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Tayla Orsmond">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--favicon-->
    <link rel="icon" href="media/favicon.png" type="image/png" sizes="32x32">
    <title>artfolio | Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/8ab8fd8eb6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/events.css">
    <link rel="stylesheet" href="css/form.css">
</head>

<body>
    <!-- Tayla Orsmond u21467456 -->
    <!-- Gallery page:
            If a user clicks on a gallery name, they are redirected to this page
            Used to display details on a specific list
            Includes all the events of the gallery
            Includes an edit form for the gallery
            Includes a delete button for the gallery
            If the current user is the owner of the list, they can edit the list
             -->
    <?php
    require_once 'php/header.php';
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
    }
    ?>
    <div class="container container-box">
        <?php
        //get the list id from the query parameters in the url
        $list_id = $_GET["id"];
        //get the list details from the database
        //this is a curl post request to the api

        //set post body (JSON data)
        $body = array(
            'type'   => 'info',
            'user_id' => $_SESSION['user_id'],
            'return'  => 'list',
            'id'     => $list_id,
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

        if (!$r) { //some kind of error occurred
            // echo "Error: " . curl_error($curl);
        }

        $result = null;
        try {
            $result = json_decode($r, true);
        } catch (Exception $e) {
            $result = null;
        }
        //close the request
        curl_close($curl);
        if ($result == null || $result['status'] != 'success') {
            echo '<h1 class="text-center">Gallery not Found</h1>
            <div class="d-flex flex-column align-items-center">
                <p>There was an error retrieving the Gallery. I hear van Gogh has a good one though if you want to try that</p>
                <img src="https://th-thumbnailer.cdn-si-edu.com/1G_5HsjRKwBpgSTymPMALv4-r_Q=/1000x750/filters:no_upscale():focal(2409x1653:2410x1654)/https://tf-cmsv2-smithsonianmag-media.s3.amazonaws.com/filer/f3/fa/f3fa8097-4f45-4555-96de-a6cc736e6587/van_gogh_angle1_starry_night_300dpi.jpg" alt="..." class="img-fluid">
            </div>';
        } else {
            //get the event details from the response
            $list = $result['data']['return'];
            echo '
                    <h1>gallery</h1>
                    <hr>
                    <div class="ps-3">
                        <h2 class="list-name">' . $list['l_name'] . '</h2>
                        <p class="small"><a href="profile.php?id=' . $_SESSION['user_id'] . '">@' . $_SESSION['user_name'] . '</a></p>
                        <p class="list-description text-secondary">' . $list['l_desc'] . '</p>
                    </div>
            <div class="border d-lg-flex flex-lg-wrap p-3 events-inner">';

            if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $list['u_rid'] || $_SESSION['user_admin'] == 1) {
                echo '<div class="w-100 d-flex justify-content-start justify-content-lg-end gap-3">
                            <div class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#list_modal" id="edit_list">Edit gallery</div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#delete_list_modal">Delete Gallery</button>
                        </div>';
            }
            //get all the event details from the list's events string
            //explode the comma separated string into an array
            $event_ids = explode(",", $list['l_events']);
            //loop through the array of event ids
            $hashtags = null;
            $locations = null;
            if ($event_ids == null || $event_ids[0] == "") { //if there are no events in the list
                echo '<p class="w-100 text-center">No events in this gallery</p>';
            } else {
                $hashtags = array();
                $locations = array();
                foreach ($event_ids as $event_id) {
                    //get the event details from the database
                    //this is a curl post request to the api

                    //set post body (JSON data)
                    $body = array(
                        'type'   => 'info',
                        'user_id' => $_SESSION['user_id'],
                        'return'  => 'event',
                        'id'     => $event_id,
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

                    if (!$r) { //some kind of error occurred
                        // echo "Error: " . curl_error($curl);
                    }

                    $result = json_decode($r, true);

                    //close the request
                    curl_close($curl);

                    //get the event details from the response
                    $event = $result['data']['return'];
                    //display the event details
                    if ($event != null) {
                        echo '
                                        <div>';
                        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $list['u_rid'] || $_SESSION['user_admin'] == 1) {
                            echo '<span class="btn btn-dark mt-2 mt-lg-0 align-self-start remove_event" id="remove_' . $event['e_id'] . '"><i class="fa fa-trash"></i></span>';
                        }
                        echo '                                        
                                <div class="card event-card" id="' . $event['e_id'] . '">
                                    <img src="media/uploads/events/' . $event['e_img'] . '" class="card-img-top img-fluid" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title text-truncate">' . $event['e_name'] . '</h5>
                                        <p class="card-text text-truncate">' . $event['e_location'] . '</p>
                                        <small class="card-text text-muted">' . $event['e_date'] . '</small>
                                        <a href="event.php?id=' . $event['e_id'] . '" class="stretched-link"></a>
                                    </div>
                                </div>
                            </div>';
                        //recommend events based on hashtags
                        //search the description for hashtags
                        preg_match_all('/#([^\s]+)/', $event['e_desc'], $hashtags);
                        //add the event location to the locations array
                        array_push($locations, $event['e_location']);
                    }
                }
            }
            echo '</div><hr/>
                    <h3> Recommended for You: </h3>
                    <div class="col-12 border scroller">
                        <div class="event-area-inner">';
            $recommend_count = 0;
            $recommended_events = array();
            if ($hashtags != null) {
                //sort the hashtags array by frequency
                $hashtags = array_count_values($hashtags[1]);
                arsort($hashtags);
                //search the database for events with the most common hashtags
                $i = 0;
                foreach ($hashtags as $hashtag => $count) {
                    if ($i < 10) {
                        //get the event details from the database
                        //this is a curl post request to the api

                        //set post body (JSON data)
                        $body = array(
                            'type'   => 'info',
                            'user_id' => $_SESSION['user_id'],
                            'return'  => 'search',
                            'search'  => $hashtag,
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

                        if (!$r) { //some kind of error occurred
                            // echo "Error: " . curl_error($curl);
                        }

                        $result = json_decode($r, true);

                        //close the request
                        curl_close($curl);

                        //get the event details from the response
                        $events = $result['data']['return'];
                        //display the event details (assuming the event is not already in the list)
                        if ($events != null) {
                            foreach ($events as $event) {
                                if (!in_array($event['e_id'], $event_ids) && !in_array($event['e_id'], $recommended_events)) {
                                    echo '
                                        <div>
                                            <div class="card event-card" id="' . $event['e_id'] . '">
                                                <img src="media/uploads/events/' . $event['e_img'] . '" class="card-img-top img-fluid" alt="...">
                                                <div class="card-body">
                                                    <h5 class="card-title text-truncate">' . $event['e_name'] . '</h5>
                                                    <p class="card-text text-truncate">' . $event['e_location'] . '</p>
                                                    <small class="card-text text-muted">' . $event['e_date'] . '</small>
                                                    <a href="event.php?id=' . $event['e_id'] . '" class="stretched-link"></a>
                                                </div>
                                            </div>
                                        </div>';
                                    $recommend_count++;
                                    array_push($recommended_events, $event['e_id']);
                                }
                            }
                        }
                    }
                }
            }
            if ($locations != null && $recommend_count < 15) {
                //if there are no hashtags, recommend events based on location
                //get the event details from the database
                //this is a curl post request to the api
                foreach ($locations as $location) {
                    //set post body (JSON data)
                    $body = array(
                        'type'   => 'info',
                        'user_id' => $_SESSION['user_id'],
                        'return'  => 'search',
                        'search'  => $location,
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

                    if (!$r) { //some kind of error occurred
                        // echo "Error: " . curl_error($curl);
                    }

                    $result = json_decode($r, true);

                    //close the request
                    curl_close($curl);

                    //get the event details from the response
                    $events = $result['data']['return'];
                    //display the event details (assuming the event is not already in the list)
                    if ($events != null) {
                        foreach ($events as $event) {
                            if (!in_array($event['e_id'], $event_ids) && !in_array($event['e_id'], $recommended_events)) {
                                echo '
                                    <div>
                                        <div class="card event-card" id="' . $event['e_id'] . '">
                                            <img src="media/uploads/events/' . $event['e_img'] . '" class="card-img-top img-fluid" alt="...">
                                            <div class="card-body">
                                                <h5 class="card-title text-truncate">' . $event['e_name'] . '</h5>
                                                <p class="card-text text-truncate">' . $event['e_location'] . '</p>
                                                <small class="card-text text-muted">' . $event['e_date'] . '</small>
                                                <a href="event.php?id=' . $event['e_id'] . '" class="stretched-link"></a>
                                            </div>
                                        </div>
                                    </div>';
                                $recommend_count++;
                                array_push($recommended_events, $event['e_id']);
                            }
                        }
                    }
                }
            }
            if ($recommend_count < 15) {
                //if there are no hashtags or locations, recommend any event that is not already in the list
                //get the event details from the database
                //this is a curl post request to the api
                //set post body (JSON data)
                $body = array(
                    'type'   => 'info',
                    'user_id' => $_SESSION['user_id'],
                    'return'  => 'events',
                    'scope'  => 'global',
                    'id' => $_SESSION['user_id']
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

                if (!$r) { //some kind of error occurred
                    // echo "Error: " . curl_error($curl);
                }

                $result = null;
                try {
                    $result = json_decode($r, true);
                } catch (Exception $e) {
                    $result = null;
                }
                //close the request
                curl_close($curl);

                //get the event details from the response
                $events = null;
                if ($result != null) {
                    $events = $result['data']['return'];
                } else {
                    $events = null;
                }

                //display the event details (assuming the event is not already in the list)
                if ($events != null) {
                    $e = 0;
                    foreach ($events as $event) {
                        if (!in_array($event['e_id'], $event_ids) || empty($event_ids) && !in_array($event['e_id'], $recommended_events)) {
                            echo '
                                <div>
                                    <div class="card event-card" id="' . $event['e_id'] . '">
                                        <img src="media/uploads/events/' . $event['e_img'] . '" class="card-img-top img-fluid" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title text-truncate">' . $event['e_name'] . '</h5>
                                            <p class="card-text text-truncate">' . $event['e_location'] . '</p>
                                            <small class="card-text text-muted">' . $event['e_date'] . '</small>
                                            <a href="event.php?id=' . $event['e_id'] . '" class="stretched-link"></a>
                                        </div>
                                    </div>
                                </div>';
                            $recommend_count++;
                            array_push($recommended_events, $event['e_id']);
                        }
                    }
                }
            }
            if ($recommend_count === 0) {
                echo '<p class="w-100 p-3 text-center text-muted">No events to recommend</p>';
            }
        }
        ?>
    </div>
    </div>
    </div>
    <?php
    require_once 'php/footer.php';
    ?>
    <script src="js/scroll.js"></script>
    <script src="js/gallery.js" type="module"></script>
</body>

</html>