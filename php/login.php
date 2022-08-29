<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Tayla Orsmond">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>artfolio | Log in</title>
        <link rel="stylesheet" href="../css/global.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/8ab8fd8eb6.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <!-- Tayla Orsmond u21467456 -->
        <!-- Login page:
            Display page that will be handled by the login components.
            Client-side validation will be handled by validate.js
            Server-side validation will be handled by loginHandler.php.
            If the user is logged in, they will be redirected to the home page.
             -->
        <?php 
            require_once 'components/header.php';
        ?>
        <div class="container">
            <div class="d-flex justify-content-around flex-wrap border">
                <form action="components/loginHandler.php" method="post" class="d-flex flex-column flex-fill p-5">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control border-0 border-bottom" id="username" name="username" placeholder="Jean-Honoré Fragonard" required>
                        <label for="username">username or email address</label>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please enter a valid username or email address.
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control border-0 border-bottom" id="password" name="password" placeholder="(Shhh... this is secret)" required>
                        <label for="password">password</label>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please enter a valid password. Passwords must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, and one number.
                        </div>
                    </div>
                    <p>Don't have an account? <a href="signup.php">Sign up</a>.</p>
                    <button type="submit" class="btn submit-btn align-self-end"><span class="h1">log in.</span></button>
                </form>
                <img src="https://images.unsplash.com/photo-1561839561-b13bcfe95249?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=379&q=80" alt="login" class="img-fluid">
            </div>
        </div>
        <?php 
            require_once 'components/footer.php';
        ?>
    </body>
</html>