<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Tayla Orsmond">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--favicon-->
    <link rel="icon" href="media/favicon.png" type="image/png" sizes="32x32">
    <title>artfolio | Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/8ab8fd8eb6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/events.css">
    <link rel="stylesheet" href="css/form.css">
</head>

<body>
    <!-- Tayla Orsmond u21467456 -->
    <!-- Event page:
            If a user clicks on an event, they are redirected to this page
            Used to display details on a specific event
            Includes reviews and comments
            Includes a rating system for the event
            Includes a form to add a review
            If the current user is the owner of the event, they can edit the event
             -->
    <?php
    require_once 'php/header.php';
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
    }
    ?>
    <div class="container container-box">
        <div id="error"></div>
        <?php
        //get the event id from the id parameter in the URL
        $event_id = $_GET['id'];
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
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $api_headers,
            CURLOPT_POSTFIELDS => json_encode($body),
            CURLOPT_USERPWD => $api_key,
        ));
        //Send the request
        $r = curl_exec($curl);

        if (!$r) { //some kind of error occurred
            // echo "Error: " . curl_error($curl);
        }
        try {
            $result = json_decode($r, true);
        } catch (Exception $e) {
            $result = null;
        }

        //close the request
        curl_close($curl);

        $event = null;
        if (!empty($result)) {
            //get the event details from the response
            $event = $result['data']['return'];
        }

        if (empty($event)) {
            echo '
                <h1 class="text-center">Event not found</h1> 
                <p class="text-center">Maybe try another one?</p>
                <div class="d-flex flex-column align-items-center">
                    <img src="https://th-thumbnailer.cdn-si-edu.com/FAKqirNoh8pPiBSf8iK8mgOkhcA=/1000x750/filters:no_upscale():focal(588x426:589x427)/https://tf-cmsv2-smithsonianmag-media.s3.amazonaws.com/filer_public/60/4f/604fad7f-b3a1-4d46-8f6e-546e2888659e/gettyimages-1243970412.jpg" alt="..." class="img-fluid">
                    <a href="index.php" class="btn btn-primary">Go home</a>
                </div>';
        } else {
            //echo out the event data
            echo '
                <div class="row">
                    <div class="col-12 col-lg-8 p-3 d-flex flex-column">
                    <img src="media/uploads/events/' . $event["e_img"] . '" class="img-fluid w-100 event-img" alt="...">';
            if ($event["u_rid"] == $_SESSION['user_id'] || $_SESSION['user_admin'] == 1) {
                echo '
                    <div class="d-flex justify-content-end">
                        <div class="btn btn-dark align-self-end mt-3" data-bs-toggle="modal" data-bs-target="#event_modal" id="edit_event">Edit Event</div>
                        <div class="btn btn-primary align-self-end mt-3" data-bs-toggle="modal" data-bs-target="#delete_event_modal" id="delete_event">Delete Event</div>
                    </div>';
            }
            echo '  <div class="w-100 w-lg-75">
                        <p class="mt-2">';
            for ($i = 0; $i < $event["e_rating"]; $i++) {
                echo '      <i class="fa fa-star fa-xl"></i>';
            }
            for ($i = 0; $i < 5 - $event["e_rating"]; $i++) {
                echo '      <i class="fa fa-star-o fa-xl"></i>';
            }
            //make a curl request to get the reviews for this event
            $body = array(
                'type'   => 'info',
                'user_id' => $_SESSION['user_id'],
                'return'  => 'reviews',
                'id'     => $event_id,
            );
            //make post request to API using curl
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $api_url,
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => $api_headers,
                CURLOPT_POSTFIELDS => json_encode($body),
                CURLOPT_USERPWD => $api_key
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
            $reviews = null;
            if (!empty($result)) {
                $reviews = $result['data']['return'];
            }

            if(!empty($reviews)){
                //find the review closest to the average rating of the event
                $closest = null;
                foreach($reviews as $review){
                    if($closest == null){
                        $closest = $review;
                    }else{
                        if(abs($review['r_rating'] - $event['e_rating']) < abs($closest['r_rating'] - $event['e_rating'])){
                            $closest = $review;
                        }
                    }
                }
                echo '<p class="text-muted small ms-3">"'. $closest['r_comment'] .'" - <a href="profile.php?id='. $closest['u_rid'] .'">@'. $closest['u_rname'] .'</a></p>';
            }
            echo '      </p>
                        <h2 class="event-name">' . $event["e_name"] . '</h2> 
                        <p><a href="profile.php?id=' . $event["u_rid"] . '"> @' . $event["u_rname"] . '</a></p>
                        <hr/>
                        <p class="h5"><i class="fa-solid fa-location-dot fa-xs"></i> <span class="event-location">' . $event["e_location"] . '</span> | <i class="fa-solid fa-calendar-days fa-xs"></i> <span class="event-date">' . date("D - d M Y", strtotime($event["e_date"])) . '</span> | <i class="fa-solid fa-clock fa-xs"></i> <span class="event-time">' .  date("h:m", strtotime($event["e_date"]))  . '</span></p>
                        <p class="h5 badge bg-primary event-type">' . $event["e_type"] . '</p>
                        <p class="event-description d-none">' . $event["e_desc"] . '</p>
                        <p class="p-5 border">' .
                            //search the event description for hashtags
                            //if there are any, replace them with a link to the home page
                            //with the hashtag as the search term / parameter in the url
                            preg_replace('/#([^\s]+)/', '<a href="home.php?search=$1">#$1</a>', $event["e_desc"]);
                            $event["e_desc"]
                        . '</p>
                        <div class="d-flex justify-content-start gap-1">';
            echo '          <p class="mt-2"><a href="#" data-bs-toggle="modal" data-bs-target="#add_to_list_modal" id="add_event_to_list"> &gt; Add this event to a gallery</a></p>
                        </div>
                    </div>';
            

            //if there are no reviews, display a message
            //echo out the reviews
            echo '<hr class="d-lg-none"/>
                    <div class="col-12 col-lg-4">
                        <div class="p-2 border">
                            <h3>Reviews and Ratings</h3>';
            if ((isset($_SESSION['user_id']) && $_SESSION['user_id'] != $event["u_rid"]) || $_SESSION['user_admin'] == 1) {
                echo '      <div class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#review_modal" id="add_review">Add Review</div>';
            }
            echo '      </div>
                        <div class="d-flex flex-column p-3">';
            if (empty($reviews)) {
                echo '      <div class="p-1 mt-2 review-box">
                                <p>There are no reviews for this event yet.</p>
                            </div>';
            } else {
                for ($i = 0; $i < count($reviews) && $i < 4; $i++) {
                    echo '  <div class="p-1 mt-2 review-box" id="r-' . $reviews[$i]["u_rid"] . '">
                                <p class="h5 review-name">' . $reviews[$i]["r_name"] . '</p>
                                <div class="d-flex justify-content-between">
                                <p><a href="profile.php?id=' . $reviews[$i]["u_rid"] . '">@' . $reviews[$i]["u_rname"] . '</a></p>
                                <p>';
                    //use a for loop to display the correct number of stars
                    for ($j = 0; $j < $reviews[$i]["r_rating"]; $j++) {
                        echo '      <i class="fa fa-star fa-xl"></i>';
                    }
                    for ($j = 0; $j < 5 - $reviews[$i]["r_rating"]; $j++) {
                        echo '      <i class="fa fa-star-o fa-xl"></i>';
                    }
                    echo '      </p>
                                <span class="d-none review-rating">' . $reviews[$i]["r_rating"] . '</span>
                            </div>
                            <p class="review-comment">' . $reviews[$i]["r_comment"] . '</p>';
                    if ($reviews[$i]["u_rid"] == $_SESSION['user_id'] || $_SESSION['user_admin'] == 1) {
                        echo '
                            <div class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#review_modal" id="edit_review">Edit Review</div>';
                    }
                    if ($reviews[$i]["u_rid"] == $_SESSION['user_id'] || $_SESSION['user_admin'] == 1 || $event["u_rid"] == $_SESSION['user_id']) {
                        echo '
                            <div class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#delete_review_modal" id="delete_review_btn" data-rid="'. $reviews[$i]["u_rid"] .'">Delete Review</div>';
                    }
                    echo '</div>';
                }
                if (count($reviews) > 3) {
                    //display reviews modal toggle
                    echo '<div class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#view_reviews_modal" id="view_reviews">View More Reviews</div>';
                }
                echo '
                    </div>';
            }
            //echo out the review images
            echo '
                    <hr>
                    <div>
                        <h3>Images</h3>';
            //if there are no reviews, display a message
            if (empty($reviews)) {
                echo '<p>There are no images for this event yet.</p>
                    </div>';
            } else {
                echo '
                    <div id="event_images" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">';
                for ($i = 0; $i < count($reviews); $i++) {
                    echo '
                        <div class="carousel-item '. ($i == 0 ? "active" : "") .'">
                            <img id="ri-'. $reviews[$i]["u_rid"] .'" src="media/uploads/reviews/' . $reviews[$i]["r_img"] . '" class="d-block w-100" alt="...">
                        </div>';
                }
                echo '
                    </div>';
                if (count($reviews) > 1) {
                    echo '
                    <button class="carousel-control-prev" type="button" data-bs-target="#event_images" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#event_images" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>';
                }
            }
            echo '</div></div></div></div>';
        }
        ?>
    </div>
    <?php
    require_once 'php/footer.php';
    ?>
    <script src="js/event.js" type="module"></script>
</body>

</html>
