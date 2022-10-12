<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Tayla Orsmond">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--favicon-->
        <link rel="icon" href="media/favicon.png" type="image/png" sizes="32x32">
        <title>artfolio | Home</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/8ab8fd8eb6.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="css/global.css">
        <link rel="stylesheet" href="css/events.css">
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
            require_once 'php/header.php';
        ?>
        <div class="container my-5">
            <div class="row">
                <div class="col-12"><h1>home.</h1></div><!--Title-->
            </div>
            <div class="row">
                <div class="col-12">
                    <nav class="d-flex justify-content-between align-items-center px-3"><!--Nav-->
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#" id="local"><span class="h5">your folios.</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="#" id="global"><span class="h5">global folios.</span></a>
                            </li>
                        </ul>
                        <form><!--Search-->
                            <div class="input-group">
                                <input type="text" class="form-control" id="search-input" placeholder="Search worldwide">
                                <button type="submit" class="btn btn-outline-dark" id="search"><i class="fa fa-search"></i></button>
                            </div>
                        </form><!--End Search-->
                    </nav><!--End Nav-->
                </div>
            </div>
            <div class="row p-3 border" id="event-area"><!--EVENT AREA-->
                <div class="col-6 offset-3" id="error_area"></div>
                <div class="col-4 primary-event-outer"><!--Primary event (featured)-->
                   <div id="event_primary"></div>
                </div><!--End Primary event-->
                <div class="col-8 scroller"><!--EVENT AREA OUTER (holder for event rows + scrollable container)-->
                    <div id="ea_1" class="align-items-center event-area-inner"><!--EVENT AREA INNER 1 (where the 1st row of events are loaded-->
                        
                    </div><!--END EA INNER 1-->
                    <div id="ea_2" class="align-items-center event-area-inner"><!--EVENT AREA INNER 2 (where the 2nd row of events are loaded-->
                        
                    </div><!--END EA INNER 2-->
                </div><!--END EA OUTER-->
            </div><!--END EA-->
        </div>
        <?php 
            require_once 'php/footer.php';
        ?>
        <script src="js/scroll.js"></script>
        <script src="js/load.js" type="module"></script>
    </body>
</html>