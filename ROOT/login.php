<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Tayla Orsmond">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--favicon-->
    <link rel="icon" href="media/favicon.png" type="image/png" sizes="32x32">
    <title>artfolio | Log in</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/8ab8fd8eb6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/form.css">
</head>

<body>
    <!-- Tayla Orsmond u21467456 -->
    <!-- Login page:
            Display page that will be handled by the login components.
            Client-side validation will be handled by login.js
            Server-side validation will be handled by login-handler.php.
            If the user is logged in, they will be redirected to the home page.
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
        if (isset($_SESSION['logged_in'])) {
            if ($_SESSION['logged_in']) {
                header("Location: home.php");
            }
        }
        //if there was a login error, display it
        if (isset($_SESSION['login_err'])) {
            $err = $_SESSION['login_err'];
            echo '
                    <div id="error" class="invalid bg-danger p-3">
                        <p class="fw-bold h3">Login Failed</p>
                        <p>' . $err . '</p>
                    </div>';
            unset($_SESSION["login_err"]);
        }
        ?>
        <div class="d-lg-flex d-block col-12 justify-content-around border">
            <form action="php/login-handler.php" method="post" class="d-flex flex-column flex-fill p-5">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control border-0 border-bottom" id="email" name="email" placeholder="Jean-Honoré-Fragonard@gmail.com" required>
                    <label for="email">Email address</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control border-0 border-bottom" id="password" name="password" placeholder="(Shhh... this is secret)" required>
                    <label for="password">password</label>
                </div>
                <p class="text-primary">Don't have an account? <a class="text-secondary" href="signup.php">Sign up</a>.</p>
                <button type="submit" class="btn submit-btn align-self-end" name="login" id="login"><span class="h1">log in.</span></button>
            </form>
            <img src="https://images.unsplash.com/photo-1604140193916-187755174ecf?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=692&q=80" alt="..." class="img-fluid col-12 col-lg-6" />
        </div>
    </div>
    <?php
    require_once 'php/footer.php';
    ?>
    <script src="js/login.js" type="module"></script>
</body>

</html>