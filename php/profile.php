<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Tayla Orsmond">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>artfolio | myfolio</title>
        <link rel="stylesheet" href="../css/global.css">
        <link rel="stylesheet" href="../css/events.css">
        <link rel="stylesheet" href="../css/profile.css">
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
            require_once 'components/header.php';
        ?>
        <div class="container px-5">
            <div class="row">
                <div class="col-12"><h1>myfolio.</h1></div><!--Title-->
                <div class="col-9 p-5 d-flex border"><!--Profile Header card -> show details of the user-->
                    <div class="flex-fill profile-photo">
                        <img src="https://images.unsplash.com/photo-1548811579-017cf2a4268b?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=389&q=80" alt="" class="img-fluid rounded-circle">
                    </div>
                    <div class="flex-fill p-3 m-1">
                        <h2>Tayla Orsmond</h2>
                        <p class="pb-2 border-bottom">@taylawantsasnack</p>
                        <div class="d-flex justify-content-start gap-3">
                            <p>she/her</p>
                            <p><i class="fa fa-calendar-alt"></i> 19</p>
                            <p><i class="fa fa-map-marker-alt"></i> Pretoria, South Africa</p>
                        </div>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis laborum porro ducimus. Sint blanditiis nesciunt debitis excepturi a, quas neque sequi quod tempore, unde nemo aliquid possimus asperiores adipisci nulla!</p>
                        <p><i class="fa fa-address-book"></i> <a href="mailto:tayla.orsmond@gmail.com">tayla.orsmond@gmail.com</a></p>
                    </div>
                </div><!--End Profile Header card-->
                <div class="col-3 d-flex flex-column align-items-start justify-content-start gap-3 py-2"><!--Actions (follow, DM, edit etc.) -->
                    <div class="btn btn-dark">Follow</div>
                    <div class="btn btn-light">Following</div>
                    <div class="btn btn-dark">Edit Profile</div>
                    <div class="">
                        <p><span class="fw-bold">14</span> <a href="">Followers</a></p>
                        <p><span class="fw-bold">14</span> <a href="">Following</a></p>
                    </div>
                    <div class="btn btn-outline-light"><i class="fa fa-paper-plane"></i></div>
                </div><!--End Actions -->
                <div class="col-12 row mt-2">
                    <div class="col-12">
                        <nav class="d-flex justify-content-between align-items-center px-3"><!--Nav-->
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="#"><span class="h5">my folios.</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="#"><span class="h5">my reviews</span></a>
                                </li>
                            </ul>
                        </nav><!--End Nav-->
                    </div>
                </div>
                <div class="col-10 d-flex flex-wrap p-3 gap-2 border event-inner"><!--Event area -> for user's events-->
                    <div class="w-100">
                        <div class="btn btn-dark">Add Event</div>
                    </div>
                    <div class="card event-card">
                        <img src="https://images.unsplash.com/photo-1456086272160-b28b0645b729?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1332&q=80" class="card-img-top img-fluid" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Artpop Celebration</h5>
                            <p class="card-text">Pirate's Sports Club</p>
                        </div>
                    </div>
                    <div class="card event-card">
                        <img src="https://images.unsplash.com/photo-1456086272160-b28b0645b729?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1332&q=80" class="card-img-top img-fluid" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Artpop Celebration</h5>
                            <p class="card-text">Pirate's Sports Club</p>
                        </div>
                    </div>
                    <div class="card event-card">
                        <img src="https://images.unsplash.com/photo-1456086272160-b28b0645b729?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1332&q=80" class="card-img-top img-fluid" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Artpop Celebration</h5>
                            <p class="card-text">Pirate's Sports Club</p>
                        </div>
                    </div>
                    <div class="card event-card">
                        <img src="https://images.unsplash.com/photo-1456086272160-b28b0645b729?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1332&q=80" class="card-img-top img-fluid" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Artpop Celebration</h5>
                            <p class="card-text">Pirate's Sports Club</p>
                        </div>
                    </div>
                    <div class="card event-card">
                        <img src="https://images.unsplash.com/photo-1456086272160-b28b0645b729?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1332&q=80" class="card-img-top img-fluid" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Artpop Celebration</h5>
                            <p class="card-text">Pirate's Sports Club</p>
                        </div>
                    </div>
                    <div class="card event-card">
                        <img src="https://images.unsplash.com/photo-1456086272160-b28b0645b729?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1332&q=80" class="card-img-top img-fluid" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Artpop Celebration</h5>
                            <p class="card-text">Pirate's Sports Club</p>
                        </div>
                    </div>
                    <div class="card event-card">
                        <img src="https://images.unsplash.com/photo-1456086272160-b28b0645b729?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1332&q=80" class="card-img-top img-fluid" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Artpop Celebration</h5>
                            <p class="card-text">Pirate's Sports Club</p>
                        </div>
                    </div>
                </div><!--End Event area-->
                <div class="col-2 p-3">
                    <p><span class="h5">my galleries.</span></p>
                    <div class="list-group list-group-flush my-2 galleries-inner"><!--lists of user's galleries (event lists)-->
                        <a href="#" class="list-group-item list-group-item-action">Summer 2022</a>
                        <a href="#" class="list-group-item list-group-item-action">SOHO</a>
                        <a href="#" class="list-group-item list-group-item-action">December 2020</a>
                    </div>
                    <div class="btn btn-dark">Add Gallery</div>
                </div><!--End galleries-->
            </div>
        </div>
        <?php 
            require_once 'components/footer.php';
        ?>
    </body>
</html>