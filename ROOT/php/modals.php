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
<!-- Bootstrap Modal to add / edit / delete an event -->
<div class="modal modal-lg fade modal-fullscreen-sm" data-bs-backdrop="static" data-bs-keyboard="false"  id="event_modal" tabindex="-1" role="dialog" aria-labelledby="event_modal_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="event_modal_label">Add Event</h5>
            </div>
            <div class="modal-body">
                <form id="add_event_form" method="post" action="php/profile.php">
                    <div class="form-group mb-3">
                        <label for="e_name">Name *</label>
                        <input type="text" class="form-control" id="e_name" name="e_name" placeholder="Monet En-Plein-Air Event" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="e_desc">Description (Add your funky <span class="text-primary">#tags</span> here)</label>
                        <textarea class="form-control" id="e_desc" name="e_desc" rows="3" placeholder="A Lovely day of painting outdoors"></textarea>
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
                        <label for="event_location">Location *</label>
                        <input type="text" class="form-control" id="event_location" name="event_location" placeholder="Rue Laffitte, Paris, France" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="e_type">Type *</label>
                        <select class="form-control" id="e_type" name="e_type" required>
                            <option value="Event">Event</option>
                            <option value="Solo Exhibition">Solo Exhibition</option>
                            <option value="Collective Exhibition">Collective Exhibition</option>
                            <option value="Temporary Exhibition">Temporary Exhibition</option>
                            <option value="Online Exhibition">Online Exhibition</option>
                            <option value="Viewing">Viewing</option>
                            <option value="Class">Class</option>
                            <option value="Performance">Performance</option>
                            <option value="Play">Play</option>
                            <option value="Competition">Competition</option>
                            <option value="Festival">Festival</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="e_img">Cover Image</label>
                        <input type="file" class="form-control-file" id="e_img" name="e_img" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-dark" form="add_event_form">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Modal to add / edit / delete a list -->
<div class="modal modal-lg fade modal-fullscreen-sm" data-bs-backdrop="static" data-bs-keyboard="false"  id="list_modal" tabindex="-1" role="dialog" aria-labelledby="list_modal_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="list_modal_label">Add Gallery</h5>
            </div>
            <div class="modal-body">
                <form id="add_list_form" method="post" action="php/profile.php">
                    <div class="form-group mb-3">
                        <label for="l_name">Name *</label>
                        <input type="text" class="form-control" id="l_name" name="l_name" placeholder="Vermeer Girl's trip" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="l_desc">Description (Add your funky <span class="text-primary">#tags</span> here)</label>
                        <textarea class="form-control" id="l_desc" name="l_desc" rows="3" placeholder="A girl's trip all over the Netherlands"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-dark" form="add_list_form">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Modal to add /edit / delete a review -->
<div class="modal modal-lg fade modal-fullscreen-sm" data-bs-backdrop="static" data-bs-keyboard="false"  id="review_modal" tabindex="-1" role="dialog" aria-labelledby="review_modal_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="review_modal_label">Add Review</h5>
            </div>
            <div class="modal-body">
                <form id="add_review_form" method="post" action="php/profile.php">
                    <div class="form-group mb-3">
                        <label for="r_name">Name *</label>
                        <input type="text" class="form-control" id="r_name" name="r_name" placeholder="The best event I've ever been to!!!" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="r_comment">Comment *</label>
                        <textarea class="form-control" id="r_comment" name="r_desc" rows="3" placeholder="I seriously loved this event. It was the best!"></textarea>
                    </div>
                    <div class="rate mb-3">
                        <i class="fa-solid fa-star fa-2xl" data-index="0"></i>
                        <i class="fa-solid fa-star fa-2xl" data-index="1"></i>
                        <i class="fa-solid fa-star fa-2xl" data-index="2"></i>
                        <i class="fa-solid fa-star fa-2xl" data-index="3"></i>
                        <i class="fa-solid fa-star fa-2xl" data-index="4"></i>
                    </div>
                    <input type="hidden" id="r_rating" name="r_rating" value="0">
                    <div class="form-group mb-3">
                        <label for="r_img">Image</label>
                        <input type="file" class="form-control-file" id="r_img" name="r_img" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-dark" form="add_review_form">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Modal to edit a profile -->
<div class="modal modal-lg fade modal-fullscreen-sm" data-bs-backdrop="static" data-bs-keyboard="false"  id="edit_profile_modal" tabindex="-1" role="dialog" aria-labelledby="edit_profile_modal_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit_profile_modal_label">Edit Profile</h5>
                
            </div>
            <div class="modal-body">
                <form id="edit_profile_form" method="post" action="php/profile.php">
                    <!-- Profile Picture -->
                    <div class="form-group mb-3">
                        <label for="p_img">Profile Picture</label>
                        <input type="file" class="form-control-file" id="p_img" name="p_img" required>
                    </div>
                    <!-- Display Name -->
                    <div class="form-group mb-3">
                        <label for="p_name">Display Name *</label>
                        <input type="text" class="form-control" id="p_name" name="p_name" placeholder="Vermeer" required>
                    </div>
                    <!-- Bio -->
                    <div class="form-group mb-3">
                        <label for="p_bio">Bio</label>
                        <textarea class="form-control" id="p_bio" name="p_bio" rows="3" placeholder="I love art!"></textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <!-- age -->
                        <div class="form-group mb-3 me-3">
                            <label for="p_age">Age</label>
                            <input type="number" class="form-control" id="p_age" name="p_age" placeholder="25">
                        </div>
                        <!--pronouns -->
                        <div class="form-group mb-3">
                            <label for="p_pronouns">Pronouns</label>
                            <input type="text" class="form-control" id="p_pronouns" name="p_pronouns" placeholder="she/her">
                        </div>
                    </div>
                    <!-- Location -->
                    <div class="form-group mb-3">
                        <label for="p_location">Location</label>
                        <input type="text" class="form-control" id="p_location" name="p_location" placeholder="Amsterdam, Netherlands">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-dark" form="edit_profile_form">Save</button>
                <!--delete profile button -->
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-target="#delete_profile_modal">Delete Profile</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Modal to delete a profile -->
<div class="modal modal-lg fade modal-fullscreen-sm" data-bs-backdrop="static" data-bs-keyboard="false"  id="delete_profile_modal" tabindex="-1" role="dialog" aria-labelledby="delete_profile_modal_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delete_profile_modal_label">Delete Profile</h5>
                
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete your profile? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="delete_profile_btn">Delete</button>
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

<!-- Bootstrap Modal to add an event to a list -->
<!-- Display all of the lists a user has so they can select one to add the event to -->
<div class="modal fade" id="add_to_list_modal" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1" role="dialog" aria-labelledby="add_to_list_modal_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_to_list_modal_label">Add to a Gallery</h5>
                
            </div>
            <div class="modal-body">
                <form id="add_to_list_form" method="post" action="php/profile.php">
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
                <button type="submit" class="btn btn-dark" form="add_to_list_form">Add to Gallery</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Modal to add / edit / delete events out of a list -->
<!-- Display all of the events in a list so they can be edited / deleted -->
<!-- These events are displayed as bootstrap cards -->
<div class="modal fade" id="list_events_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="list_events_modal_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="list_events_modal_label">Edit Gallery</h5>
                
            </div>
            <div class="modal-body">
                <div class="card-columns" id="list_events_card_columns">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Loading...</h5>
                        </div>
                        <!--remove from list button-->
                        <div class="card-footer">
                            <button type="button" class="btn btn-danger btn-sm" id="remove_from_list_btn">Remove from Gallery</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <!--delete list button-->
                <button type="button" class="btn btn-danger" id="delete_list_btn">Delete Gallery</button>
            </div>
        </div>
    </div>
</div>
