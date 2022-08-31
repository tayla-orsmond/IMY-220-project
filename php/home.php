<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Tayla Orsmond">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>artfolio | Home</title>
        <link rel="stylesheet" href="../css/global.css">
        <link rel="stylesheet" href="../css/events.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/8ab8fd8eb6.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <!-- Tayla Orsmond u21467456 -->
        <!-- Home page:
            Acts like a home feed / explore page.
            If the user is not logged in, they will be redirected to the splash / login page.
            The home feed will display a user's events and their friends' events.
            The explore (global) feed will display a user's events and all events in the database.
             -->
        <?php 
            require_once 'components/header.php';
        ?>
        <div class="container">
            <div class="row">
                <div class="col-12"><h1>home.</h1></div><!--Title-->
            </div>
            <div class="row">
                <div class="col-12">
                    <nav class="d-flex justify-content-between align-items-center px-3"><!--Nav-->
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#"><span class="h5">your folios.</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="#"><span class="h5">global folios.</span></a>
                            </li>
                        </ul>
                        <form><!--Search-->
                            <div class="input-group">
                                <input type="text" class="form-control" id="search" placeholder="search">
                                <button type="submit" class="btn btn-outline-secondary"><i class="fa fa-search"></i></button>
                            </div>
                        </form><!--End Search-->
                    </nav><!--End Nav-->
                </div>
            </div>
            <div class="row p-3 border" id="event-area"><!--EVENT AREA-->
                <div class="col-4"><!--Primary event (featured)-->
                    <div class="card text-bg-dark" id="event-primary">
                        <img src="https://images.unsplash.com/photo-1549887534-1541e9326642?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=765&q=80" class="card-img" alt="...">
                        <div class="card-img-overlay d-flex flex-column justify-content-between">
                            <div class="card-header">Featured</div>
                            <div>
                                <h5 class="card-title">New age art festival</h5>
                                <p class="card-text h6">Fairview Walk | 26 November 2022</p>
                                <p class="card-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Libero facilis iure dolore earum enim soluta, itaque molestias perferendis impedit exercitationem?</p>
                                <div class="d-flex justify-content-center">
                                    <a href="." class="btn btn-dark">#newage</a>
                                    <a href="." class="btn btn-dark">#festival</a>
                                    <a href="." class="btn btn-dark">#live</a>
                                </div>
                                <a href="event.php" class="stretched-link"></a>
                            </div>
                        </div>
                    </div>
                </div><!--End Primary event-->
                <div class="col-8 event-area-outer"><!--EVENT AREA OUTER (holder for event rows + scrollable container)-->
                    <div id="ea-1" class="align-items-center event-area-inner"><!--EVENT AREA INNER 1 (where the 1st row of events are loaded-->
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
                    </div><!--END EA INNER 1-->
                    <div id="ea-2" class="align-items-center event-area-inner"><!--EVENT AREA INNER 2 (where the 1st row of events are loaded-->
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
                    </div><!--END EA INNER 2-->
                </div><!--END EA OUTER-->
            </div><!--END EA-->
        </div>
        <?php 
            require_once 'components/footer.php';
        ?>
    </body>
</html>