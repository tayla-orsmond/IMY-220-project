<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Tayla Orsmond">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>artfolio | myfolio</title>
        <link rel="stylesheet" href="../css/global.css">
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
        <div class="container"></div>
        <?php 
            require_once 'components/footer.php';
        ?>
    </body>
</html>