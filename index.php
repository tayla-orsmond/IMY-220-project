<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Tayla Orsmond">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>artfolio | Home</title>
        <link rel="stylesheet" href="../css/global.css">
        <link rel="stylesheet" href="../css/splash.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/8ab8fd8eb6.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <!-- Tayla Orsmond u21467456 -->
        <!-- Splash page:
            Available to user if not logged in
            Available to user if logged in
            Available to user if logged in and admin
            Give background info on website
            Entice users to sign up / log in
         -->

        <?php 
            require_once 'php/components/header.php';
        ?>
        <!-- Splash screen component -->
        <div class="container-fluid ps-5 splash-outer">
            <div class="splash-txt">
                <h1 class="display-1">artfolio.</h1>
                <p class="lead">the latest in art and pop culture events.</p>
            </div>
            <div class="splash mt-5">
                <div class="splash-content"></div>
                <div class="splash-content"></div>
            </div>
        </div><!--End splash screen -->
        <!-- Features parallax scroll -->
        <div class="container features d-flex flex-column">
            <div class="feature d-flex p-3">
                <p class="display-2 fw-bold">Create your own <i>folio</i></p>
                <img src="https://images.unsplash.com/photo-1545989253-02cc26577f88?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80" alt="..." class="img-fluid"/>
            </div>
            <div class="feature d-flex p-3">
                <img src="https://images.unsplash.com/photo-1545989253-02cc26577f88?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80" alt="..." class="img-fluid"/>
                <p class="display-2 fw-bold">Discover others' events</p>
            </div>
            <div class="feature d-flex p-3">
                <p class="display-2 fw-bold">Follow your favourite creators</p>
                <img src="https://images.unsplash.com/photo-1545989253-02cc26577f88?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80" alt="..." class="img-fluid"/>
            </div>
            <div class="feature d-flex p-3">
                <img src="https://images.unsplash.com/photo-1545989253-02cc26577f88?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80" alt="..." class="img-fluid"/>
                <p class="display-2 fw-bold">Join in the culture</p>
            </div>
        </div><!--End features-->
        <div class="spacer"></div><!-- Spacer helper div defined in global.css -->
        <!-- Final logo component -->
        <div class="container my-5 p-5">
            <h1 class="display-1 text-center">artfolio.</h1>
            <div class="d-flex justify-content-center">
                <a class="btn btn-light mx-2" aria-current="page" href="php/signup.php">Sign up</a>
                <a class="btn btn-light mx-2" aria-current="page" href="php/login.php">Log in</a>
            </div>
        </div><!--End logo component-->
        <div class="spacer"></div><!-- Spacer helper div defined in global.css -->
        <?php 
            require_once 'php/components/footer.php';
        ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
        <script src="js/scroll.js"></script>
    </body>
</html>