<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Tayla Orsmond">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>artfolio | Sign up</title>
        <link rel="stylesheet" href="../css/global.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/8ab8fd8eb6.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <!-- Tayla Orsmond u21467456 -->
        <!-- Signup page:
            Display page that will be handled by the signup components.
            Client-side validation will be handled by validate.js
            Server-side validation will be handled by signupHandler.php.
            If the user is signed up, they will be redirected to the home page.
             -->
        <?php 
            require_once 'components/header.php';
        ?>
        <div class="container">
            <div class="d-flex justify-content-around flex-wrap border">
                <form action="components/signupHandler.php" method="post" class="d-flex flex-column flex-fill p-5">
                    <div class="d-flex flex-wrap justify-content-between mb-3">
                        <div class="form-floating flex-fill me-3">
                            <input type="text" class="form-control border-0 border-bottom" id="username" name="username" placeholder="Jean-Honoré Fragonard" required>
                            <label for="username">username</label>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please enter a valid username. Usernames must be at least 3 characters long.
                            </div>
                        </div>
                        <div class="form-floating flex-fill">
                            <input type="email" class="form-control border-0 border-bottom" id="email" name="email" placeholder="jean@example.com" required>
                            <label for="email">email</label>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please enter a valid email address.
                            </div>
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
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control border-0 border-bottom" id="confirm" name="confirm" placeholder="(Shhh... this is secret)" required>
                        <label for="confirm">confirm password</label>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please confirm your password. Passwords must match.
                        </div>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="" id="tscs" required>
                        <label class="form-check-label" for="invalidCheck">I agree to the <a href="https://www.lingscars.com/">terms and conditions</a>.</label>
                        <div class="invalid-feedback">
                            You must agree before submitting.
                        </div>
                    </div>
                    <p>Already have an account? <a href="login.php">Log in</a>.</p>
                    <button type="submit" class="btn submit-btn align-self-end"><span class="h1">sign up.</span></button>
                </form>
                <img src="https://images.unsplash.com/photo-1561839561-b13bcfe95249?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=379&q=80" alt="login" class="img-fluid">
            </div>
        </div>
        <?php 
            require_once 'components/footer.php';
        ?>
    </body>
</html>