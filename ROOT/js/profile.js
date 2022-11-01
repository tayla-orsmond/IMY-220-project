//Tayla Orsmond u21467456
//Path: js\profile.js
//Language: javascript, jquery
//Description: This file contains the javascript code for the profile page
//e.g., adding an event, adding a gallery (list), following, unfollowing, viewing your events and your reviewed events etc.

import { validate_event, validate_list, validate_edit_profile } from "./validate.js";
import { get_cookie } from "./cookie.js";
import { event_template, gallery_template, follower_template, following_template, error_template_blank } from "./template.js";

$(() => {
    //GLOBALS
    //Get the user id from the url
    const urlParams = new URLSearchParams(window.location.search);
    const user_id = urlParams.get('id');
    /**
     * 
     * FUNCTIONS FOR EVENTS ==========================================================
     * 
     */
    //load the user's events
    const load_events = () => {
        $.ajax({
            url: api_url,
            type: "POST",
            accept: "application/json",
            contentType: "application/json",
            username: user_name,
            password: api_key,
            dataType: "json",
            data: JSON.stringify({
                "type": "info",
                "user_id": get_cookie("user_id", document.cookie.split(";")) === "-1" ? null : get_cookie("user_id", document.cookie.split(";")),
                "return": "events",
                "scope": "self",
                "id": user_id,
            }),
            success: function (resp, status) {//succesful query
                populate_events(resp);
            },
            error: function (xhr, status, error) {//error handling
                error_handler(xhr, status, error);
            }
        })
    }
    //load reviewed events
    const load_reviewed = () => {
        $.ajax({
            url: api_url,
            type: "POST",
            accept: "application/json",
            contentType: "application/json",
            username: user_name,
            password: api_key,
            dataType: "json",
            data: JSON.stringify({
                "type": "info",
                "user_id": get_cookie("user_id", document.cookie.split(";")) === "-1" ? null : get_cookie("user_id", document.cookie.split(";")),
                "return": "reviewed",
                "id": user_id,
            }),
            success: function (resp, status) {//succesful query
                populate_events(resp);
            },
            error: function (xhr, status, error) {//error handling
                error_handler(xhr, status, error);
            }
        })
    }
    //load the user's galleries
    const load_galleries = () => {
        $.ajax({
            url: api_url,
            type: "POST",
            accept: "application/json",
            contentType: "application/json",
            username: user_name,
            password: api_key,
            dataType: "json",
            data: JSON.stringify({
                "type": "info",
                "user_id": get_cookie("user_id", document.cookie.split(";")) === "-1" ? null : get_cookie("user_id", document.cookie.split(";")),
                "return": "lists",
                "id": user_id,
            }),
            success: function (resp, status) {//succesful query
                populate_galleries(resp);
            },
            error: function (xhr, status, error) {//error handling
                error_handler(xhr, status, error);
            }
        })
    }
    //populate the events
    const populate_events = (resp) => {
        //clear events
        clear_events();
        if (resp.status == "success" && resp.data.return.length > 0) {
            //Load the events
            let events = resp.data.return;
            events.forEach((event, index) => {
                $("#events_inner").append(event_template(event, index));
            });
        }
        else {
            $("#error_e").show();
            $("#error_e").append(error_template_blank("It's a still life over here. " + resp.data.message));
        }
    }
    //populate galleries
    const populate_galleries = (resp) => {
        //clear galleries
        clear_galleries();
        if (resp.status == "success" && resp.data.return.length > 0) {
            //Load the galleries
            let galleries = resp.data.return;
            galleries.forEach((gallery) => {
                $("#galleries_inner").append(gallery_template(gallery));
            });
        }
        else {
            $("#error_g").show();
            $("#error_g").append(error_template_blank("It's a still life over here. " + resp.data.message));
        }
    }
    //add a new event
    const add_event = () => {
        //get the values from the form
        let e_name = $("#e_name").val();
        let e_desc = $("#e_desc").val();
        let e_date = $("#e_date").val();
        let e_time = $("#e_time").val();
        let e_location = $("#e_location").val();
        //get the image filename from the form
        let e_img = $("#e_img_input").val().split("\\").pop();
        let e_type = $("#e_type").val();
        //make the ajax call
        $.ajax({
            url: api_url,
            type: "POST",
            accept: "application/json",
            contentType: "application/json",
            username: user_name,
            password: api_key,
            dataType: "json",
            data: JSON.stringify({
                "type": "add",
                "user_id": get_cookie("user_id", document.cookie.split(";")) === "-1" ? null : get_cookie("user_id", document.cookie.split(";")),
                "username": get_cookie("user_name", document.cookie.split(";")) === "-1" ? null : get_cookie("user_name", document.cookie.split(";")),
                "add": "event",
                "e_name": e_name,
                "e_desc": e_desc,
                "e_date": e_date,
                "e_time": e_time,
                "e_location": e_location,
                "e_img": e_img === "" ? null : e_img,
                "e_type": e_type,
            }),
            success: function (resp, status) {//succesful query
                if (resp.status == "success") {
                    //submit the form
                    $("#event_form").submit();
                    //clear the form
                    $("#e_name").val("");
                    $("#e_desc").val("");
                    $("#e_date").val("");
                    $("#e_time").val("");
                    $("#e_location").val("");
                    $("#e_img").val("");
                    $("#e_type").val("");
                    //load the events
                    load_events();
                }
                else {
                    //append an error message
                    $("#event_form").append(error_template(resp.data.message));
                }
            },
            error: function (xhr, status, error) {//error handling
                error_handler(xhr, status, error);
            }
        })
    }
    //add a new gallery
    const add_list = () => {
        //get the values from the form
        let g_name = $("#l_name").val();
        let g_desc = $("#l_desc").val();
        //make the ajax call
        $.ajax({
            url: api_url,
            type: "POST",
            accept: "application/json",
            contentType: "application/json",
            username: user_name,
            password: api_key,
            dataType: "json",
            data: JSON.stringify({
                "type": "add",
                "user_id": get_cookie("user_id", document.cookie.split(";")) === "-1" ? null : get_cookie("user_id", document.cookie.split(";")),
                "username": get_cookie("user_name", document.cookie.split(";")) === "-1" ? null : get_cookie("user_name", document.cookie.split(";")),
                "add": "list",
                "l_name": g_name,
                "l_desc": g_desc,
            }),
            success: function (resp, status) {//succesful query
                if (resp.status == "success") {
                    //submit the form
                    $("#gallery_form").submit();
                    //clear the form
                    $("#g_name").val("");
                    $("#g_desc").val("");
                    //load the galleries
                    load_galleries();
                }
                else {
                    //append an error message
                    $("#gallery_form").append(error_template(resp.data.message));
                }
            },
            error: function (xhr, status, error) {//error handling
                error_handler(xhr, status, error);
            }
        })
    }
    //clear the events
    const clear_events = () => {
        $("#error").empty();
        $("#error").hide();
        $("#events_inner").empty();
        $("#events_inner").empty();
        $("#error_e").empty();
        $("#error_e").hide();
    };
    //clear the galleries
    const clear_galleries = () => {
        $("#error").empty();
        $("#error").hide();
        $("#error_g").empty();
        $("#error_g").hide();
        $("#galleries_inner").empty();
    };
    //error handler
    const error_handler = (xhr, status, error) => {
        //clear events
        clear_events();
        $("#error").show();
        $("#error").append(error_template_blank("An unexpected error occurred, please try again later."));
    }
    /**
     * 
     * FUNCTIONS FOR FOLLOWERS/ FOLLOWING ==========================================================
     */
    //follow / unfollow the user
    const follow_unfollow = (f) => {
        $.ajax({
            url: api_url,
            type: "POST",
            accept: "application/json",
            contentType: "application/json",
            username: user_name,
            password: api_key,
            dataType: "json",
            data: JSON.stringify({
                "type": "follow",
                "user_id": get_cookie("user_id", document.cookie.split(";")) === "-1" ? null : get_cookie("user_id", document.cookie.split(";")),
                "follow": f,
                "username": get_cookie("user_name", document.cookie.split(";")) === "-1" ? null : get_cookie("user_name", document.cookie.split(";")),
                "follow_id": user_id,
                "follow_name": $("#username").html(),
            }),
            success: function (resp, status) {//succesful query
                let count = $(".followers").html();
                if (f === "follow") {
                    $("#follow").addClass('d-none');
                    $("#unfollow").removeClass('d-none');
                    $("#DM").removeClass('d-none');
                    $(".followers").html(parseInt(count) + 1);
                    //replace the text after .followers and .following with a trigger
                    $(".followers-wrapper").html($(".followers-wrapper").html().replace('Followers', '<a href="" data-bs-toggle="modal" data-bs-target="#follow_modal" id="show_followers">Followers</a>'));
                    $(".following-wrapper").html($(".following-wrapper").html().replace('Following', '<a href="" data-bs-toggle="modal" data-bs-target="#follow_modal" id="show_following">Following</a>'));
                }
                else if (f === "unfollow") {
                    $("#follow").removeClass('d-none');
                    $("#unfollow").addClass('d-none');
                    $("#DM").addClass('d-none');
                    $(".followers").html(parseInt(count) - 1);
                    //replace the trigger with the text
                    $(".followers-wrapper").html($(".followers-wrapper").html().replace('<a href="" data-bs-toggle="modal" data-bs-target="#follow_modal" id="show_followers">Followers</a>', 'Followers'));
                    $(".following-wrapper").html($(".following-wrapper").html().replace('<a href="" data-bs-toggle="modal" data-bs-target="#follow_modal" id="show_following">Following</a>', 'Following'));
                }
            },
            error: function (xhr, status, error) {//error handling
                error_handler(xhr, status, error);
            }
        })
    }
    //load the user's followers / following in a modal
    const load_followers_following = (f) => {
        $.ajax({
            url: api_url,
            type: "POST",
            accept: "application/json",
            contentType: "application/json",
            username: user_name,
            password: api_key,
            dataType: "json",
            data: JSON.stringify({
                "type": "info",
                "user_id": get_cookie("user_id", document.cookie.split(";")) === "-1" ? null : get_cookie("user_id", document.cookie.split(";")),
                "return": f,
                "id": user_id,
            }),
            success: function (resp, status) {//succesful query     
                populate_followers_following(resp, f);
            },
            error: function (xhr, status, error) {//error handling
                error_handler(xhr, status, error);
            }
        })
    }
    //populate the modal with the user's followers / following
    const populate_followers_following = (resp, f) => {
        $("#follow_list").empty();
        $("#follow_modal_label").empty();
        $("#follow_modal_label").text("F" + f.slice(1));
        if (resp.status === "success" && resp.data.return.length > 0) {
            let follow = resp.data.return;
            if (f === "followers") {
                follow.forEach(user => {
                    $("#follow_list").append(follower_template(user));
                });
            }
            else {
                follow.forEach(user => {
                    $("#follow_list").append(following_template(user));
                });
            }
        }
        else {
            $("#follow_list").append(error_template_blank(resp.data.message));
        }
    }
    /**
     * 
     * FUNCTIONS FOR PROFILE EDITING ============================================
     * 
     */
    //populate the edit_profile modal with the user's info that we have on the page
    const populate_edit_profile = () => {
        if ($("#username").text() !== "") {
            $("#u_profile").text($(".profile-photo img").attr("src").split("/").pop());
            //make the background image the same as the profile photo
            $("#u_profile").css("background-image", "url(" + $(".profile-photo img").attr("src") + ")");
            $("#u_display_name").val($(".display-name").text());
            $("#u_bio").val($(".bio").text());
            $("#u_pronouns").val($(".pronouns").text());
            $("#u_location").val($(".location").text());
            $("#u_age").val(parseInt($(".age").text()));
        }
    }
    //edit the user's profile by sending a request to the api
    const edit_profile = () => {
        $.ajax({
            url: api_url,
            type: "POST",
            accept: "application/json",
            contentType: "application/json",
            username: user_name,
            password: api_key,
            dataType: "json",
            data: JSON.stringify({
                "type": "update",
                "update": "user",
                "user_id": get_cookie("user_id", document.cookie.split(";")) === "-1" ? null : get_cookie("user_id", document.cookie.split(";")),
                "username": get_cookie("user_name", document.cookie.split(";")) === "-1" ? null : get_cookie("user_name", document.cookie.split(";")),
                "u_display_name": $("#u_display_name").val(),
                "u_bio": $("#u_bio").val(),
                "u_pronouns": $("#u_pronouns").val(),
                "u_location": $("#u_location").val(),
                "u_age": $("#u_age").val(),
                "u_profile": $("#u_profile_input").val().split("\\").pop() === "" ?  $("#u_profile").text() : $("#u_profile_input").val().split("\\").pop(),
            }),
            success: function (resp, status) {//succesful query
                if (resp.status === "success") {
                    //submit the form to upload the profile picture
                    $("#edit_profile_form").submit();
                    //update the page with the new info
                    $(".display-name").text($("#u_display_name").val());
                    $(".bio").text($("#u_bio").val());
                    $(".pronouns").text($("#u_pronouns").val());
                    $(".location").text($("#u_location").val());
                    $(".age").text($("#u_age").val());
                    $(".profile-photo img").attr("src", "media/uploads/profiles/" + $("#u_profile").text());
                }
                else {
                    $("#edit_profile").modal("hide");
                }
            },
            error: function (xhr, status, error) {//error handling
                error_handler(xhr, status, error);
            }
        })
    }
    /**
     * 
     * EVENT HANDLERS ===========================================================
     * 
     */
    //when the page loads, load the user's events and galleries
    load_events();
    load_galleries();
    populate_edit_profile();
    //if the folios tab is clicked, load the user's events
    $("#folios").on("click", () => {
        $("#folios").addClass("active");
        $("#reviewed").removeClass("active");
        $("#add_event").show();
        load_events();
    });
    //if the reviewed tab is clicked, load the user's reviewed events
    $("#reviewed").on("click", () => {
        $("#reviewed").addClass("active");
        $("#folios").removeClass("active");
        $("#add_event").hide();
        load_reviewed();
    });
    //if the follow button is clicked, follow the user
    $("#follow").on("click", () => {
        follow_unfollow("follow");
    });
    $("#unfollow").on("click", () => {
        follow_unfollow("unfollow");
    });
    //if the following tab is clicked, load the user's following
    $("#show_following").on("click", () => {
        load_followers_following("following");
    });
    //if the followers tab is clicked, load the user's followers
    $("#show_followers").on("click", () => {
        load_followers_following("followers");
    });
    //if the submit_event button is clicked, validate and submit the event
    $("#submit_event").on("click", (e) => {
        if (validate_event()) {
            //hide the modal
            $("#event_modal").modal("hide");
            add_event();
        }
        e.preventDefault();
    });
    //if the submit_list button is clicked, validate and submit the gallery
    $("#submit_list").on("click", (e) => {
        if (validate_list()) {
            //hide the modal
            $("#list_modal").modal("hide");
            add_list();
        }
        e.preventDefault();
    });
    //if the submit_edit_profile button is clicked, validate and submit the profile edit
    $("#submit_edit_profile").on("click", (e) => {
        if (validate_edit_profile()) {
            //hide the modal
            $("#edit_profile_modal").modal("hide");
            edit_profile();
        }
        e.preventDefault();
    });
});