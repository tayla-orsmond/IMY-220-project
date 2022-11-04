<!-- Tayla Orsmond u21467456 -->
<!-- 
    ---------------------------------------------------------
    This is for all the modals that are used in the application
    -> modal to add / edit / delete an event 
    -> modal to add / edit / delete a list
    -> modal to add / edit / delete a review
    -> modal to edit a profile (delete)
    -> modal to view followers
    -> modal to view following
    -> modal to add / delete events from a list

    ---------------------------------------------------------
-->
<!-- Bootstrap Modal to add / edit an event -->
<div class="modal modal-lg fade modal-fullscreen-sm" data-bs-backdrop="static" data-bs-keyboard="false" id="event_modal" tabindex="-1" role="dialog" aria-labelledby="event_modal_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="event_modal_label">Customize Your Event</h5>
            </div>
            <div class="modal-body">
                <form id="event_form" method="post" action="upload.php" enctype="multipart/form-data">
                    <div class="form-group mb-3">
                        <label for="e_name">Name *</label>
                        <input type="text" class="form-control" id="e_name" name="e_name" placeholder="Monet En-Plein-Air Event" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="e_desc">Description (Add your funky <span class="text-primary">#tags</span> here)</label>
                        <textarea class="form-control" id="e_desc" name="e_desc" rows="1" placeholder="A Lovely day of painting outdoors"></textarea>
                        <div id="e_desc_val" class="mt-1"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="e_date">Date *</label>
                        <input type="date" class="form-control" id="e_date" name="e_date" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="e_time">Time *</label>
                        <input type="time" class="form-control" id="e_time" name="e_time" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="e_location">Location *</label>
                        <input type="text" class="form-control" id="e_location" name="e_location" placeholder="Rue Laffitte, Paris, France" required>
                        <span class="map-location" id="map"></span>
                        <button type="button" class="btn btn-primary mt-2" id="e_location_btn">Use My Location</button>
                    </div>
                    <div class="form-group mb-3">
                        <label for="e_type">Type *</label>
                        <select class="form-select" id="e_type" name="e_type" required>
                            <option value="" selected disabled>Select an event type</option>
                            <?php
                                $types = json_decode(file_get_contents("json/event_types.json"), true);
                                foreach ($types as $type) {
                                    echo '<option value="'.$type.'" '. ($type == $types[0] ? "selected" : "") .'>'.$type.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="e_img">Cover Image</label>
                        <!-- add an image using drag and drop or file input -->
                        <p>Drag and drop an image here or click to select an image</p>
                        <div class="dropzone text-center bg-light p-5 m-1" id="e_img"><i class="text-primary fa fa-image fa-2xl"></i></div>
                        <input type="file" class="form-control" id="e_img_input" name="e_img_input" accept="image/*" size="50" style="display: none;" required>
                    </div>
                    <input type="hidden" id="e_hidden_id" name="e_hidden_id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-dark" form="event_form" id="submit_event">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Modal to delete an event -->
<div class="modal fade" id="delete_event_modal" tabindex="-1" role="dialog" aria-labelledby="delete_event_modal_label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delete_event_modal_label">Delete Event</h5>
            </div>
            <div class="modal-body">
                <form id="delete_event_form" method="post" action="php/delete-handler.php">
                    <input type="hidden" id="e_id" name="e_id" value="<?= $_GET['id'] ?>">
                    <p>Are you sure you want to delete this event? This action cannot be undone.</p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="delete_event_form" id="delete_event" name="delete_event">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Modal to add / edit a list -->
<div class="modal modal-lg fade modal-fullscreen-sm" data-bs-backdrop="static" data-bs-keyboard="false" id="list_modal" tabindex="-1" role="dialog" aria-labelledby="list_modal_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="list_modal_label">Customize Gallery</h5>
            </div>
            <div class="modal-body">
                <form id="list_form" method="post" action="../profile.php?id=<?= $_SESSION['user_id'] ?>">
                    <div class="form-group mb-3">
                        <label for="l_name">Name *</label>
                        <input type="text" class="form-control" id="l_name" name="l_name" placeholder="Romanticism Sightseeing trip" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="l_desc">Description (optional)</label>
                        <textarea class="form-control" id="l_desc" name="l_desc" rows="3" placeholder="A girl's trip all over Europe to see some of the most romantic works"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-dark" form="list_form" id="submit_list">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Modal to add an event to a list -->
<!-- Display all of the lists a user has so they can select one to add the event to -->
<div class="modal modal-lg fade modal-fullscreen-sm" id="add_to_list_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="add_to_list_modal_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_to_list_modal_label">Add to a Gallery</h5>
            </div>
            <div class="modal-body">
                <form id="add_to_list_form" method="post" action="event.php?id=<?= $_GET['id'] ?>">
                    <div class="form-group mb-3">
                        <label for="l_id">Galleries</label>
                        <select class="form-select" id="l_id" name="l_id" required>
                            <option value="" selected disabled>Select a Gallery</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-dark" form="add_to_list_form" id="add_to_list">Add to Gallery</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Modal to delete a list -->
<div class="modal modal-lg fade modal-fullscreen-sm" id="delete_list_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="delete_list_modal_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delete_list_modal_label">Delete Gallery</h5>
            </div>
            <div class="modal-body">
                <form id="delete_list_form" method="post" action="php/delete-handler.php">
                    <input type="hidden" id="l_rid" name="l_rid" value="<?= $_GET['id'] ?>">
                    <p>Are you sure you want to delete this gallery? This action cannot be undone.</p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="delete_list_form" id="delete_list" name="delete_list">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Modal to add /edit a review -->
<div class="modal modal-lg fade modal-fullscreen-sm" data-bs-backdrop="static" data-bs-keyboard="false" id="review_modal" tabindex="-1" role="dialog" aria-labelledby="review_modal_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="review_modal_label">Add Review</h5>
            </div>
            <div class="modal-body">
                <form id="review_form" method="post" action="upload.php" enctype="multipart/form-data">
                    <div class="form-group mb-3">
                        <label for="r_name">Title *</label>
                        <input type="text" class="form-control" id="r_name" name="r_name" placeholder="The best event I've ever been to!!!" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="r_comment">Comment *</label>
                        <textarea class="form-control" id="r_comment" name="r_desc" rows="3" placeholder="I seriously loved this event. It was the best!"></textarea>
                    </div>
                    <div class="mb-3" id="rate">
                        <i class="fa-solid fa-star fa-2xl" data-index="0"></i>
                        <i class="fa-solid fa-star fa-2xl" data-index="1"></i>
                        <i class="fa-solid fa-star fa-2xl" data-index="2"></i>
                        <i class="fa-solid fa-star fa-2xl" data-index="3"></i>
                        <i class="fa-solid fa-star fa-2xl" data-index="4"></i>
                    </div>
                    <input type="hidden" id="r_rating" name="r_rating" value="0">
                    <div class="form-group mb-3">
                        <label for="r_img">Image</label>
                        <!-- add an image using drag and drop or file input -->
                        <p>Drag and drop an image here or click to select an image</p>
                        <div class="dropzone text-center bg-light p-5 m-1" id="r_img"><i class="text-primary fa fa-image fa-2xl"></i></div>
                        <input type="file" class="form-control" id="r_img_input" name="r_img_input" accept="image/*" size="50" style="display: none;" required>
                    </div>
                    <input type="hidden" id="r_hidden_id" name="r_hidden_id" value="<?= $_GET['id'] ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-dark" form="review_form" id="submit_review">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Modal to delete a review -->
<div class="modal fade" id="delete_review_modal" tabindex="-1" role="dialog" aria-labelledby="delete_review_modal_label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delete_review_modal_label">Delete Review</h5>
            </div>
            <div class="modal-body">
                <form id="delete_review_form" method="post" action="php/delete-handler.php">
                    <input type="hidden" id="e_rid" name="e_rid" value="<?= $_GET['id'] ?>">
                    <p>Are you sure you want to delete this review? This action cannot be undone.</p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="delete_review_form" id="delete_review" name="delete_review">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Modal to view all reviews for an event -->
<div class="modal modal-lg fade modal-fullscreen-sm" data-bs-backdrop="static" data-bs-keyboard="false" id="view_reviews_modal" tabindex="-1" role="dialog" aria-labelledby="view_reviews_modal_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="view_reviews_modal_label">Reviews</h5>
            </div>
            <div class="modal-body">
                <div id="reviews">
                    <!--Reviews go here-->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Modal to edit a profile -->
<div class="modal modal-lg fade modal-fullscreen-sm" data-bs-backdrop="static" data-bs-keyboard="false" id="edit_profile_modal" tabindex="-1" role="dialog" aria-labelledby="edit_profile_modal_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit_profile_modal_label">Edit Profile</h5>
            </div>
            <div class="modal-body">
                <form id="edit_profile_form" method="post" action="upload.php" enctype="multipart/form-data">
                    <!-- Profile Picture -->
                    <div class="form-group mb-3">
                        <label for="u_profile">Profile Picture *</label>
                        <!-- add an image using drag and drop or file input -->
                        <p>Drag and drop an image here or click to select an image</p>
                        <div class="dropzone text-center bg-light p-5 m-1" id="u_profile"><i class="text-primary fa fa-image fa-2xl"></i></div>
                        <input type="file" class="form-control" id="u_profile_input" name="u_profile_input" accept="image/*" size="50" style="display: none;" required>
                    </div>
                    <!-- Display Name -->
                    <div class="form-group mb-3">
                        <label for="u_display_name">Display Name *</label>
                        <input type="text" class="form-control" id="u_display_name" name="u_display_name" placeholder="Vermeer" required>
                    </div>
                    <!-- Bio -->
                    <div class="form-group mb-3">
                        <label for="u_bio">Bio</label>
                        <textarea class="form-control" id="u_bio" name="u_bio" rows="3" placeholder="I love art!"></textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <!-- age -->
                        <div class="form-group mb-3 me-3">
                            <label for="u_age">Age</label>
                            <input type="number" class="form-control" id="u_age" name="u_age" placeholder="25">
                        </div>
                        <!--pronouns -->
                        <div class="form-group mb-3">
                            <label for="u_pronouns">Pronouns</label>
                            <input type="text" class="form-control" id="u_pronouns" name="u_pronouns" placeholder="she/her">
                        </div>
                    </div>
                    <!-- Location -->
                    <div class="form-group mb-3">
                        <label for="u_location">Location</label>
                        <input type="text" class="form-control" id="u_location" name="u_location" placeholder="Amsterdam, Netherlands">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-dark" form="edit_profile_form" id="submit_edit_profile">Save</button>
                <!--delete profile button -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#delete_profile_modal">Delete Profile</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Modal to delete a profile -->
<div class="modal modal-lg fade modal-fullscreen-sm" data-bs-backdrop="static" data-bs-keyboard="false" id="delete_profile_modal" tabindex="-1" role="dialog" aria-labelledby="delete_profile_modal_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delete_profile_modal_label">Delete Profile</h5>
            </div>
            <div class="modal-body">
                <form id="delete_profile_form" method="post" action="php/delete-handler.php">
                    <input type="hidden" id="p_id" name="p_id" value="<?= $_GET['id'] ?>">
                    <p>Are you sure you want to delete this profile? This action cannot be undone.</p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="delete_profile_form" id="delete_profile" name="delete_profile">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Modal to view a users followers / following (list of usernames which are links to their profiles) -->
<div class="modal modal-lg fade modal-fullscreen-sm" id="follow_modal" tabindex="-1" role="dialog" aria-labelledby="follow_modal_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="follow_modal_label"></h5>
            </div>
            <div class="modal-body">
                <ul class="list-group" id="follow_list">
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script src="js/validate.js" type="module"></script>
<script src="js/location.js" type="module"></script>