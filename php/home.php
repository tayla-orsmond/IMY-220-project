<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Tayla Orsmond">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>artfolio | Home</title>
        <link rel="stylesheet" href="../css/global.css">
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
                <div class="col-12">
                    <h1>home.</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <nav class="d-flex justify-content-between align-items-center px-3">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="."><span class="h5">your folios.</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="."><span class="h5">global folios.</span></a>
                            </li>
                        </ul>
                        <form>
                            <div class="input-group">
                                <input type="text" class="form-control" id="search" placeholder="search">
                                <button type="submit" class="btn btn-outline-secondary"><i class="fa fa-search"></i></button>
                            </div>
                        </form>
                    </nav>
                </div>
            </div>
            <div class="row border">
                <div class="col-6">
                    <div class="card"></div>
                </div>
                <div class="col-6">
                    <div class="card"></div>
                </div>
            </div>
        </div>
        <?php 
            require_once 'components/footer.php';
        ?>
    </body>
</html>