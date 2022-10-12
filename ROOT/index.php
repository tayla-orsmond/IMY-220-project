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
        <link rel="stylesheet" href="css/splash.css">
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
            require_once 'php/header.php';
        ?>
        <div class="container-fluid">
            <!-- Splash screen component -->
            <div class="splash-outer">
                <div class="splash-txt">
                    <h1 class="display-1 m-0">artfolio.</h1>
                    <p class="lead">the latest in art and pop culture events.</p>
                </div>
                <div class="splash">
                    <div class="">
                        <div class="splash-content"></div>
                        <div class="splash-content">
                            <img src="media/img/the-swing.svg" alt="">
                        </div>
                    </div>
                </div>
            </div><!--End splash screen -->
            <!-- Features parallax scroll -->
            <div class="features w-100 d-flex flex-column">
                <div class="feature d-flex">
                    <p class="fw-bold">Create your own folio</p>
                    <img src="https://i.etsystatic.com/24634016/c/2645/2102/0/203/il/56f6d0/2581895112/il_680x540.2581895112_w7md.jpg" alt="..." class="img-fluid"/>
                </div>
                <div class="feature d-flex">
                    <img src="https://images.unsplash.com/photo-1632127258100-f8ae7c6c58c1?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80" SameSite="None" alt="Image by Diane Picchiottino on Unsplash" class="img-fluid"/>
                    <p class="fw-bold">Discover others' events</p>
                </div>
                <div class="feature d-flex">
                    <p class="fw-bold">Follow your favourite creators</p>
                    <img src="https://images.unsplash.com/photo-1547602469-79faa757dbef?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1074&q=80" SameSite="None" alt="Image by Jon Butterworth on Unsplash" class="img-fluid"/>
                </div>
                <div class="feature d-flex">
                    <img src="https://images.unsplash.com/photo-1645460497526-1d882d77e218?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1472&q=80" SameSite="None" alt="Image by Girl with red hat on Unsplash" class="img-fluid"/>
                    <p class="fw-bold">Join in the culture</p>
                </div>
            </div><!--End features-->
            <div class="spacer"></div><!-- Spacer helper div defined in global.css -->
            <!-- Final logo component -->
            <div class="container my-5 p-5">
                <h1 class="display-1 text-center">artfolio.</h1>
                <!--randomize the image shown-->
                <img src="https://lh4.googleusercontent.com/tYeevzv-SPodmhPW2Q61Ej5Y5qsHEG72J38m5s85wcnVPvea_w8OuSC5hMdSKx4a15GtOMauytVLR3fk6XDCKtr3JTvipLQk8_OjbxQ2gM32UIGrbsdJKun08JbHSZlz-HTINSUt" alt="" class="img-fluid mx-auto d-block rand">
                <script>
                    //array of images
                    let srcs = [
                        "https://lh4.googleusercontent.com/tYeevzv-SPodmhPW2Q61Ej5Y5qsHEG72J38m5s85wcnVPvea_w8OuSC5hMdSKx4a15GtOMauytVLR3fk6XDCKtr3JTvipLQk8_OjbxQ2gM32UIGrbsdJKun08JbHSZlz-HTINSUt",
                        "https://payload.cargocollective.com/1/8/260231/13678403/20180912_Catch_Sushi_Rolls_945_Main_1_912.jpg",
                        "https://payload.cargocollective.com/1/8/260231/13821093/Untitled-Session02916_kkedit-2-copy_912.jpg",
                        "https://payload.cargocollective.com/1/8/260231/13568186/miumiu-00063_912.jpg",
                        "https://payload.cargocollective.com/1/8/260231/13568178/20170309-Metropolitan-No-012_kkedit_912.jpg",
                        "https://payload.cargocollective.com/1/8/260231/12537740/Aleksandra-Kingo-36_855.jpg",
                        "https://payload.cargocollective.com/1/8/260231/12537723/Aleksandra-Kingo-27_855.jpg",
                        "https://i.pinimg.com/originals/ca/95/7e/ca957ee8a769873021f0919000ec92b1.jpg",
                        "https://payload.cargocollective.com/1/8/260231/14396833/211205_AK_KIDS_WORLD_RECORDS_SHOT_05_0496_kk-copy-2_1250.jpg",
                        "https://www.seegreatart.art/wp-content/uploads/2021/10/Mary-Sibande.jpg"
                    ]
                    //randomize the image shown
                    let random = Math.floor(Math.random() * srcs.length);
                    //set the image
                    let img = document.querySelector(".rand");
                    img.src = srcs[random];
                </script>
                <hr>
                <div class="d-flex justify-content-center mb-2">
                    <a class="btn btn-primary mx-2" aria-current="page" href="signup.php">Sign up</a>
                    <a class="btn btn-secondary mx-2" aria-current="page" href="login.php">Log in</a>
                </div>
                
            </div><!--End logo component-->
            <div class="spacer"></div><!-- Spacer helper div defined in global.css -->
        </div>
        <?php 
            require_once 'php/footer.php';
        ?>
        <script src="js/io.js"></script>
    </body>
</html>