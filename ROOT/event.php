<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Tayla Orsmond">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>artfolio | Events</title>
        <link rel="stylesheet" href="css/global.css">
        <link rel="stylesheet" href="css/events.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/8ab8fd8eb6.js" crossorigin="anonymous"></script>
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
        ?>
        <div class="container">
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
                $event = $result['data']['return'];

                //echo out the event data
                echo '<div class="row">
                <div class="col-8 p-3 d-flex flex-column">
                    <img src="media/uploads/'. $event["e_img"] .'" class="img-fluid w-100" alt="...">';
                    if($event["u_rid"] == $_SESSION['user_id']){
                        echo '<div class="btn btn-dark justify-self-end align-self-end">Edit Event</div>';
                    }
                    echo '<div class="w-75">
                        <p><a href="profile.php?id='. $event["u_rid"] .'">@'. $event["u_rname"] .'</a></p>';
                        for($i = 0; $i < $event["e_rating"]; $i++){
                            echo '<i class="fa fa-star fa-xl"></i>';
                        }
                        for($i = 0; $i < 5 - $event["e_rating"]; $i++){
                            echo '<i class="fa fa-star-o fa-xl"></i>';
                        }
                        echo '<h2>'. $event["e_name"] .'</h2>
                        <p class="h4">'. $event["e_location"] .' | '. date("D - d M Y", strtotime($event["e_date"])) .'</p>
                        <p class="h5">'.  date("h:m", strtotime($event["e_date"]))  .'</p>
                        <p class="p-2"><span class="bg-light p-2">'. $event["e_type"] .'</span></p>
                        <p>'. $event["e_desc"] .'</p>
                        <div class="d-flex justify-content-start gap-1">';
                            if($event["e_tag1"] != ""){
                                echo '<a href="home.php" class="btn btn-dark">'. $event["e_tag1"] .'</a>';
                            }
                            if($event["e_tag2"] != ""){
                                echo '<a href="home.php" class="btn btn-dark">'. $event["e_tag2"] .'</a>';
                            }
                            if($event["e_tag3"] != ""){
                                echo '<a href="home.php" class="btn btn-dark">'. $event["e_tag3"] .'</a>';
                            }
                        echo '</div>
                        <p class="mt-2"><a href="" id="add-event">> Add this event to a gallery</a></p>
                    </div>
                </div>';

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
                    CURLOPT_POST => TRUE,
                    CURLOPT_RETURNTRANSFER => TRUE,
                    CURLOPT_HTTPHEADER => $api_headers,
                    CURLOPT_POSTFIELDS => json_encode($body),
                    CURLOPT_USERPWD => $api_key
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
                $reviews = $result['data']['return'];

                //if there are no reviews, display a message
                //echo out the reviews
                echo'
                <div class="col-4">
                    <div class="d-flex justify-content-between p-2 border-bottom">
                        <h3>Reviews and Ratings</h3>
                        <div class="btn btn-dark" id="add-review">Add Review</div>
                    </div>
                    <div class="d-flex flex-column p-3">';
                        if(empty($reviews)){
                            echo '<div class="p-1 mt-2 review-box">
                                    <p>There are no reviews for this event yet.</p>
                                </div>';
                        }else{
                            for($i = 0; $i < count($reviews) && $i < 10; $i++){
                                echo '<div class="p-1 mt-2 review-box">
                                        <p class="h5">'. $reviews[$i]["r_name"] .'</p>
                                        <div class="d-flex justify-content-between">
                                            <p><a href="profile.php?id='. $reviews[$i]["u_rid"] .'">@'. $reviews[$i]["u_rname"] .'</a></p>
                                            <p>';
                                            //use a for loop to display the correct number of stars
                                            for($j = 0; $j < $reviews[$i]["r_rating"]; $j++){
                                                echo '<i class="fa fa-star fa-xl"></i>';
                                            }
                                            for($j = 0; $j < 5 - $reviews[$i]["r_rating"]; $j++){
                                                echo '<i class="fa fa-star-o fa-xl"></i>';
                                            }
                                        echo '</p>
                                        </div>
                                        <p>'. $reviews[$i]["r_comment"] .'</p>';
                                if($reviews[$i]["u_rid"] == $_SESSION['user_id']){
                                    echo '<div class="btn btn-dark" id="edit-review">Edit Review</div>';
                                }
                                echo '</div>';
                            }
                        }
                //echo out the review images
                echo '</div>
                <hr>
                <div class="">
                    <h3>Images</h3>';
                    //if there are no reviews, display a message
                    if(empty($reviews)){
                        echo '<p>There are no images for this event yet.</p>';
                    }else{
                        echo'<div id="event-images" class="carousel slide" data-bs-ride="carousel">';
                        for($i = 0; $i < count($reviews) && $i < 10; $i++){
                            if($i == 0){
                                echo '<div class="carousel-item active">
                                    <img src="media/uploads/'. $reviews[$i]["r_img"] .'" class="d-block w-100" alt="...">
                                </div>';
                            }else{
                                echo '<div class="carousel-item">
                                    <img src="media/uploads/'. $reviews[$i]["r_img"] .'" class="d-block w-100" alt="...">
                                </div>';
                            }
                        }
                        echo '</div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>';
                    }
                echo '</div>
                </div>
            </div>';
            ?>
        </div>
        <?php
            require_once 'php/footer.php';
        ?>
        <script src="js/event.js"></script>
    </body>
</html>