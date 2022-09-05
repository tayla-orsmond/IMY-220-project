<?php 
    session_start();
    ?>
<!-- Tayla Orsmond u21467456 -->
<!-- Header component
    Reflects login functionality
        if user is logged in - show profile and home (explore) page
                             - show log out button
        if user is not logged in - show sign up and log in page
     -->
<header>
    <nav class="navbar navbar-expand-lg p-4 w-100">
        <div class="container-fluid">
            <a class="navbar-brand h1" href="index.php">artfolio.</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-md-end" id="navbarSupportedContent">
                <?php
                    $logged_in = false;
                    if (isset($_SESSION['logged_in'])) {
                        $logged_in = true;
                    }
                    if ($logged_in) {
                        echo '<ul class="navbar-nav me-2 mb-2 mb-lg-0 align-items-center">
                                <li class="nav-item mx-2">
                                    Welcome @' . $_SESSION['user_name'] . '
                                </li>
                                <li class="nav-item mx-2">
                                    <a class="nav-link" aria-current="page" href="home.php">home.</a>
                                </li>
                                <li class="nav-item mx-2">
                                    <a class="nav-link" aria-current="page" href="profile.php">myfolio.</a>
                                </li>
                                <li class="nav-item mx-2">
                                    <a class="nav-link btn btn-secondary" href="logout.php">Log out</a>
                                </li>
                            </ul>';
                    } else {
                        echo '<ul class="navbar-nav me-2 mb-2 mb-lg-0">
                                <li class="nav-item mx-2">
                                    <a class="nav-link" aria-current="page" href="signup.php">Sign up</a>
                                </li>
                                <li class="nav-item mx-2">
                                    <a class="nav-link btn btn-secondary" href="login.php">Log in</a>
                                </li>
                            </ul>';
                    }

                ?>
            </div>
        </div>
    </nav>
</header>