<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Tayla Orsmond">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>artfolio | Sign up</title>
        <link rel="stylesheet" href="css/global.css">
        <link rel="stylesheet" href="css/form.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/8ab8fd8eb6.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <!-- Tayla Orsmond u21467456 -->
        <!-- Signup page:
            Display page that will be handled by the signup components.
            Client-side validation will be handled by signup.js
            Server-side validation will be handled by signup-handler.php.
            If the user is signed up, they will be redirected to the home page.
             -->
        <?php 
            require_once 'php/header.php';
        ?>
        <div class="container">
            <?php
                //if cookies are set, set the logged in session variable to true
                if (isset($_COOKIE['user_id']) && isset($_COOKIE['user_name'])) {
                    $_SESSION['logged_in'] = true;
                    $_SESSION['user_id'] = $_COOKIE['user_id'];
                    $_SESSION['user_name'] = $_COOKIE['user_name'];
                    $_SESSION['user_display_name'] = $_COOKIE['user_display_name'];
                    $_SESSION['user_admin'] = $_COOKIE['user_admin'];
                    header('Location: home.php');
                }
                //if user is logged in, redirect to home page
                if(isset($_SESSION['logged_in'])){
                    if($_SESSION['logged_in']){
                        header("Location: home.php");
                    }
                }
                //if there was a signup error, display it
                if(isset($_SESSION['signup_err'])){
                    $err = $_SESSION['signup_err'];
                    echo '
                    <div id="error" class="invalid bg-danger p-3 w-100">
                        <p class="fw-bold h3">Signup Failed</p>
                        <p>'. $err . '</p>
                    </div>';
                    unset($_SESSION["signup_err"]);
                }
            ?>
            <div class="d-flex justify-content-aroundborder">
                <form action="php/signup-handler.php" method="post" class="d-flex flex-column flex-fill p-5">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="form-floating me-3">
                            @<input type="text" class="form-control border-0 border-bottom" id="username" name="username" placeholder="@jeantheswinger" required>
                            <label for="username">username</label>
                        </div>
                        <div class="form-floating">
                            <input type="email" class="form-control border-0 border-bottom" id="email" name="email" placeholder="jean@example.com" required>
                            <label for="email">email address</label>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control border-0 border-bottom" id="display_name" name="display_name" placeholder="Jean-Honoré Fragonard">
                        <label for="display_name">display name (optional)</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control border-0 border-bottom" id="password" name="password" placeholder="(Shhh... this is secret)" required>
                        <label for="password">password</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control border-0 border-bottom" id="confirm" name="confirm" placeholder="(Shhh... this is secret)" required>
                        <label for="confirm">confirm password</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="true" id="tscs" required>
                        <label class="form-check-label" for="tscs">I agree to the <a href="https://www.lingscars.com/">terms and conditions</a>.</label>
                    </div>
                    <p>Already have an account? <a href="login.php">Log in</a>.</p>
                    <button type="submit" class="btn submit-btn align-self-end" name="signup" id="signup"><span class="h1">sign up.</span></button>
                </form>
                <img src="https://images.unsplash.com/photo-1631383591182-aa24205c089a?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=686&q=80" class="img-fluid" alt="Image by Girl with red hat on Unsplash">
            </div>
        </div>
        <?php 
            require_once 'php/footer.php';
        ?>
        <script src="js/signup.js" type="module"></script>
    </body>
</html>