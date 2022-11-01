<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Tayla Orsmond">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--favicon-->
    <link rel="icon" href="media/favicon.png" type="image/png" sizes="32x32">
    <title>artfolio | myfolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/8ab8fd8eb6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/admin.css">
</head>

<body>
    <!-- Tayla Orsmond u21467456 -->
    <!-- Admin page:
        This is the admin dashboard where admins can manage users, lists and events.
        - Admin can view all users
        - Admin can view all events
        - Admin can view all galleries

        - Admin can delete users
        - Admin can delete events
        - Admin can delete galleries
        
        - Admin can view most popular hashtags and categories
        -->
    <?php
    require_once 'php/header.php';
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php");
        }
        if(!isset($_SESSION['user_admin']) || $_SESSION['user_admin'] == 0) {
            header("Location: index.php");
        }
    ?>
    <div class="container px-5 container-box">
        <div id="error"></div>
        <div class="row">
            <div class="col-12">
                <h1>Admin Dashboard</h1>
                <div class="lead">Here is where you can access all users, events and galleries on the site.<br/><strong class="text-primary">Proceed with caution if you want to delete something. You cannot go back!</strong></div>
                <p>It may take a few seconds for changes to reflect</p>
                <hr />
            </div>
            <div class="col-4">
                <img src="https://lh4.googleusercontent.com/tYeevzv-SPodmhPW2Q61Ej5Y5qsHEG72J38m5s85wcnVPvea_w8OuSC5hMdSKx4a15GtOMauytVLR3fk6XDCKtr3JTvipLQk8_OjbxQ2gM32UIGrbsdJKun08JbHSZlz-HTINSUt" alt="..." class="img-fluid">
            </div>
            <div class="col-8 d-flex flex-column bg-light p-3">
                <div class="col-12">
                    <h3>Most Popular Hashtags:</h3>
                    <div id="tags" class="d-flex flex-wrap justify-content-aorund gap-2">
                        <!-- Events sorted by most popular hashtag will be displayed here -->
                    </div>
                    <h3>Most Popular Event Types:</h3>
                    <div id="types">
                        <!-- Most popular event types will be displayed here -->
                    </div>
                </div>
                <div class="col-6">
                    <!--allow admins to write to the event_types json file
                        - add new event types
                        - delete event types
                        and write to this file in php
                    -->
                    <h3>Manage Event Types</h3>
                    <div class="d-flex flex-column gap-2">
                        <form action="" method="post" class="d-flex flex-row gap-2">
                            <input type="text" name="add_type" id="add_type" class="form-control" placeholder="New Event Type">
                            <button type="submit" id="add_type_btn" class="btn btn-dark" onClick="<?php 
                                //write to file
                                $types = json_decode(file_get_contents('json/event_types.json'), true);
                                $types[] = $_POST['add_type'];
                                file_put_contents('json/event_types.json', json_encode($types));
                            ?>">Add</button>
                        </form>
                        <form action="" method="post" class="d-flex flex-row gap-2">
                            <select name="delete_type" id="delete_type" class="form-select">
                                <option value="" selected disabled>Select Event Type to Delete</option>
                                <!-- Event types will be displayed here -->
                                <?php
                                    $types = json_decode(file_get_contents("json/event_types.json"), true);
                                    foreach ($types as $type) {
                                        if($type != "") {
                                            echo "<option value='$type'>$type</option>";
                                        }
                                    }
                                ?>
                            </select>
                            <button id="delete_type_btn" class="btn btn-primary" onClick="<?php
                                $types = json_decode(file_get_contents("json/event_types.json"), true);
                                //delete the type from the array if it's not empty
                                if($_POST['delete_type'] != "") {
                                    $types = array_diff($types, array($_POST['delete_type']));
                                }
                                //remove nulls or duplicates from the array
                                $types = array_values(array_filter($types));
                                //write to the file
                                file_put_contents("json/event_types.json", json_encode($types));
                            ?>">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-3">
            <div class="col-12">
                <h2 class="text-center">Users</h2>
            </div>
            <div class="col-12">
                <div class="accordion" id="usersAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="usersAccordionHeading">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                View All Users
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="usersAccordionHeading" data-bs-parent="#usersAccordion">
                            <div class="accordion-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <caption>List of users</caption>
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Profile Picture</th>
                                                <th scope="col">Username</th>
                                                <th scope="col">Display Name</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="users">
                                             <!-- Users are loaded here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-3">
            <div class="col-12">
                <h2 class="text-center">Events</h2>
            </div>
        </div>
        <div class="row p-3">
            <div class="col-12">
                <div class="accordion" id="eventsAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="eventsAccordionHeading">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                View All Events
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="eventsAccordionHeading" data-bs-parent="#eventsAccordion">
                            <div class="accordion-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <caption>List of events</caption>
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Image</th>
                                                <th scope="col">Title</th>
                                                <th scope="col">User</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Time</th>
                                                <th scope="col">Location</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="events">
                                            <!-- Events are loaded here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-8 p-3">
                <h2 class="text-center">Galleries</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-8 p-3">
                <div class="accordion" id="galleriesAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="galleriesAccordionHeading">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                View All Galleries
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="galleriesAccordionHeading" data-bs-parent="#galleriesAccordion">
                            <div class="accordion-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <caption>List of galleries</caption>
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Title</th>
                                                <th scope="col">User</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="galleries">
                                            <!-- Galleries are loaded here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <img src="https://payload.cargocollective.com/1/8/260231/13821093/Untitled-Session02916_kkedit-2-copy_912.jpg" alt="..." class="img-fluid">
            </div>
        </div>
    </div>
    <?php
    require_once 'php/footer.php';
    ?>
    <script src="js/admin.js" type="module"></script>
</body>