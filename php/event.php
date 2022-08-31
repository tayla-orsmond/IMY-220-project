<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Tayla Orsmond">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>artfolio | Events</title>
        <link rel="stylesheet" href="../css/global.css">
        <link rel="stylesheet" href="../css/events.css">
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
            require_once 'components/header.php';
        ?>
        <div class="container">
            <div class="row">
                <div class="col-8 p-3 d-flex flex-column">
                    <img src="https://images.unsplash.com/photo-1549887534-1541e9326642?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=765&q=80" class="img-fluid w-100" alt="...">
                    <div class="btn btn-dark my-2 justify-self-end align-self-end">Edit Event</div>
                    <div class="w-75">
                        <p><a href="#">@katewantsasnack</a></p>
                        <p><i class="fa fa-star fa-xl"></i><i class="fa fa-star fa-xl"></i><i class="fa fa-star fa-xl"></i><i class="fa fa-star fa-xl"></i><i class="fa fa-star fa-xl"></i></p>
                        <h2>New age art festival</h2>
                        <p class="h4">Fairview Walk | 26 November 2022</p>
                        <p class="h5">10:00am - 1:00pm</p>
                        <p class="p-2"><span class="bg-light p-2">Festival</span></p>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sequi dolorum atque incidunt libero rerum, iste porro commodi quisquam rem cumque et aspernatur ut eaque esse alias, itaque nemo totam saepe, obcaecati iure repellat dignissimos inventore sint. Placeat, distinctio aliquam tempora sunt nobis ad id, dignissimos corporis quo natus fuga consequatur.</p>
                        <div class="d-flex justify-content-start gap-1">
                            <a href="." class="btn btn-dark">#newage</a>
                            <a href="." class="btn btn-dark">#festival</a>
                            <a href="." class="btn btn-dark">#live</a>
                        </div>
                        <p class="mt-2"><a href="">Add this event to a list</a></p>
                    </div>
                </div>
                <div class="col-4">
                    <div class="d-flex justify-content-between p-2 border-bottom">
                        <h3>Reviews and Ratings</h3>
                        <div class="btn btn-dark">Add Review</div>
                    </div>
                    <div class="d-flex flex-column p-3">
                        <div class="p-1 mt-2 review-box">
                            <p class="h5">Lorem Ipsum</p>
                            <div class="d-flex justify-content-between">
                                <p>@katewantsasnack</p>
                                <p><i class="fa fa-star fa-xl"></i><i class="fa fa-star fa-xl"></i><i class="fa fa-star fa-xl"></i><i class="fa fa-star fa-xl"></i><i class="fa fa-star fa-xl"></i></p>
                            </div>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quidem.</p>
                        </div>
                        <div class="p-1 mt-2 review-box">
                            <p class="h5">Lorem Ipsum</p>
                            <div class="d-flex justify-content-between">
                                <p>@katewantsasnack</p>
                                <p><i class="fa fa-star fa-xl"></i><i class="fa fa-star fa-xl"></i><i class="fa fa-star fa-xl"></i><i class="fa fa-star fa-xl"></i><i class="fa fa-star fa-xl"></i></p>
                            </div>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quidem.</p>
                        </div>
                        <div class="p-1 mt-2 review-box">
                            <p class="h5">Lorem Ipsum</p>
                            <div class="d-flex justify-content-between">
                                <p>@katewantsasnack</p>
                                <p><i class="fa fa-star fa-xl"></i><i class="fa fa-star fa-xl"></i><i class="fa fa-star fa-xl"></i><i class="fa fa-star fa-xl"></i><i class="fa fa-star fa-xl"></i></p>
                            </div>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quidem.</p>
                        </div>
                        <div class="p-1 mt-2 review-box">
                            <p class="h5">Lorem Ipsum</p>
                            <div class="d-flex justify-content-between">
                                <p>@katewantsasnack</p>
                                <p><i class="fa fa-star fa-xl"></i><i class="fa fa-star fa-xl"></i><i class="fa fa-star fa-xl"></i><i class="fa fa-star fa-xl"></i><i class="fa fa-star fa-xl"></i></p>
                            </div>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quidem.</p>
                        </div>
                        <div class="p-1 mt-2 review-box">
                            <p class="h5">Lorem Ipsum</p>
                            <div class="d-flex justify-content-between">
                                <p>@katewantsasnack</p>
                                <p><i class="fa fa-star fa-xl"></i><i class="fa fa-star fa-xl"></i><i class="fa fa-star fa-xl"></i><i class="fa fa-star fa-xl"></i><i class="fa fa-star fa-xl"></i></p>
                            </div>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quidem.</p>
                        </div>
                        <div class="p-1 mt-2 review-box">
                            <p class="h5">Lorem Ipsum</p>
                            <div class="d-flex justify-content-between">
                                <p>@katewantsasnack</p>
                                <p><i class="fa fa-star fa-xl"></i><i class="fa fa-star fa-xl"></i><i class="fa fa-star fa-xl"></i><i class="fa fa-star fa-xl"></i><i class="fa fa-star fa-xl"></i></p>
                            </div>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quidem.</p>
                        </div>
                        <p class="mt-2"><a href="">More reviews</a></p>
                        <div class="btn btn-dark">Edit Reviews</div>
                    </div>
                    <hr>
                    <div class="">
                        <h3>Images</h3>
                        <div id="event-images" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="https://images.unsplash.com/photo-1548811579-017cf2a4268b?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=389&q=80" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="https://images.unsplash.com/photo-1548811579-017cf2a4268b?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=389&q=80" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="https://images.unsplash.com/photo-1548811579-017cf2a4268b?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=389&q=80" class="d-block w-100" alt="...">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <?php 
            require_once 'components/footer.php';
        ?>
    </body>
</html>