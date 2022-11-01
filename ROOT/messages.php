<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Tayla Orsmond">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--favicon-->
    <link rel="icon" href="media/favicon.png" type="image/png" sizes="32x32">
    <title>artfolio | Chats</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/8ab8fd8eb6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/events.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/messages.css">
</head>

<body>
    <!-- Tayla Orsmond u21467456 -->
    <!-- Messages page:
            - Displays all messages sent to the user
            - Displays all messages sent by the user
            - Displays all chats
            A user can only chat with another user if they are following them and vice versa
             -->
    <?php
    require_once 'php/header.php';
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
    }
    ?>
    <div class="container p-5 container-box">
        <div id="error"></div>
        <div class="row">
            <div class="col-12 col-lg-4">
                <h2>Friends</h2>
                <hr>
                <div id="chats">
                    <!-- Chats will be displayed here -->
                </div>
            </div>
            <div class="col-12 col-lg-8">
                <div id="chat_header">
                    <!-- Chat header > user details will be displayed here -->
                    <?php if (isset($_GET['chat']) && $_GET['chat'] != $_SESSION['user_id']) {
                        echo '<h3 id="' . $_GET['chat'] . '"><i class="fa-regular fa-comments"></i> <a href="profile.php?id=' . $_GET['chat'] . '">@' . $_GET['chatn'] . '</a></h3>';
                    } else {
                        echo '<h3 id="' . $_SESSION['user_id'] . '"><i class="fa-regular fa-comments"></i> Select a chat to start messaging</h3>';
                    } ?>
                </div>
                <div id="chat_messages">
                    <!-- Chat messages will be displayed here -->
                </div>
                <hr>
                <div id="chat_input">
                    <!-- Chat input will be displayed here -->
                    <form id="chat_form">
                        <div class="form-floating d-flex gap-2">
                            <input type="text" class="form-control" placeholder="Say something" id="chat_message">
                            <label for="chat_message" class="text-muted small">Say something</label>
                            <button class="btn btn-primary" type="submit" id="chat_send"><i class="fas fa-paper-plane fa-xl"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    require_once 'php/footer.php';
    ?>
    <script src="js/messages.js" type="module"></script>
</body>

</html>