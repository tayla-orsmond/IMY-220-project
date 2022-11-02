//Tayla Orsmond u21467456
//Path: js\event.js
//Language: javascript, jquery
//Description: This file contains the code for the event page
//e.g., editing an event, adding / editing / deleting a review, adding an event to a gallery, etc.

import { validate_event, validate_review } from './validate.js';
import { review_template, error_template_blank } from './template.js';
import { get_cookie } from './cookie.js';

$(() => {
    //GLOBALS
    //get the event id from the url
    const urlParams = new URLSearchParams(window.location.search);
    const event_id = urlParams.get('id');
    /**
     * 
     * FUNCTIONS FOR EVENTS
     * 
     */
    //populate the edit_event modal with the event details that we have on the page
    const populate_edit_event = () => {
        //get the event details
        $('#e_img').text($('.event-img').attr("src").split("/").pop());
        $('#e_img').css("background-image", "url(" + $('.event-img').attr("src") + ")");
        $('#e_name').val($('.event-name').text());
        $('#e_desc').val($('.event-description').text());
        $('#e_date').val(new Date($('.event-date').text()).toISOString().split("T")[0]);
        $('#e_time').val(new Date($('.event-date').text()).toISOString().split("T")[1].split(".")[0]);
        $('#e_location').val($('.event-location').text());
        $('#e_type').val($('.event-type').text());
        $('#e_hidden_id').val(event_id);
    }
    //edit the event
    const edit_event = () => {
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
                "type": "update",
                "user_id": get_cookie("user_id", document.cookie.split(";")) === "-1" ? null : get_cookie("user_id", document.cookie.split(";")),
                "username": get_cookie("user_name", document.cookie.split(";")) === "-1" ? null : get_cookie("user_name", document.cookie.split(";")),
                "update": "event",
                "event_id": event_id,
                "e_name": e_name,
                "e_desc": e_desc,
                "e_date": e_date,
                "e_time": e_time,
                "e_location": e_location,
                "e_img": e_img === "" ? $("#e_img").text() : e_img,
                "e_type": e_type,
            }),
            success: function (resp, status) {//succesful query
                if (resp.status === "success") {
                    //submit the form to upload the profile picture
                    $("#event_form").submit();
                    //update the page with the new info
                    $('.event-img').attr("src", "media/uploads/events/" + e_img);
                    $('.event-name').text(e_name);
                    $('.event-description').text(e_desc);
                    $('.event-date').text(e_date);
                    $('.event-time').text(e_time);
                    $('.event-location').text(e_location);
                    $('.event-type').text(e_type);
                }
            },
            error: function (xhr, status, error) {//error handling
                error_handler(xhr, status, error);
            }
        });
    }
    //error handler
    const error_handler = (xhr, status, error) => {
        $("#error").show();
        $("#error").append(error_template_blank("An unexpected error occured. Please try again later."));
    }
    /**
     * 
     * FUNCTIONS FOR LISTS
     * 
     */
    //add the event to a list
    const add_event_to_list = () => {
        //get the list id
        let list_id = $("#l_id").val();
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
                "add": "event_to_list",
                "e_id": event_id,
                "l_id": list_id,
            }),
            success: function (resp, status) {//succesful query
                //submit form
                $("#add_to_list_form").submit();
            },
            error: function (xhr, status, error) {//error handling
                error_handler(xhr, status, error);
            }
        });
    }
    //populate the add_event_to_list modal with the user's lists
    const populate_add_event_to_list = () => {
        const u_id = get_cookie("user_id", document.cookie.split(";")) === "-1" ? null : get_cookie("user_id", document.cookie.split(";"))
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
                "type": "info",
                "user_id": u_id,
                "username": get_cookie("user_name", document.cookie.split(";")) === "-1" ? null : get_cookie("user_name", document.cookie.split(";")),
                "return": "lists",
                "id": u_id,
            }),
            success: function (resp, status) {//succesful query
                if (resp.status === "success" && resp.data.return.length > 0) {
                    //add the lists to the modal
                    resp.data.return.forEach(list => {
                        $("#l_id").append(`<option value="${list.l_id}">${list.l_name}</option>`);
                    });
                    $("#add_to_list_btn").prop("disabled", false);
                }
                else {
                    $("#l_id").html(`<option value="-1">No galleries found</option>`);
                    $("#add_to_list").prop("disabled", true);
                    $("#add_to_list").prop("title", "You must create a gallery first");
                    $("#add_to_list").tooltip();
                    if($("#add_to_list_form").find("p").length === 0){
                        $("#l_id").after(`<p class="text-muted">You must create a gallery first, greate a gallery <a href="profile.php?id=${u_id}">here</a></p>`);
                    }
                }
            },
            error: function (xhr, status, error) {//error handling
                error_handler(xhr, status, error);
            }
        });
    }

    /**
     * 
     * RATING
     * 
     */
    //load the review details from the information we have on the page
    const populate_edit_review = () => {
        //get the user id
        let u_rid = get_cookie("user_id", document.cookie.split(";")) === "-1" ? null : get_cookie("user_id", document.cookie.split(";"));
        if(u_rid !== "-1"){
            //get the review details
            $('#r_name').val($(`#r-${u_rid} .review-name`).text());
            $('#r_rating').val($(`#r-${u_rid} .review-rating`).text());
            $('#r_comment').val($(`#r-${u_rid} .review-comment`).text());
            $('#r_hidden_id').val(event_id);
            $('#r_img').text($(`#ri-${u_rid}`).attr("src").split("/").pop());
            $('#r_img').css("background-image", `url(${$(`#ri-${u_rid}`).attr("src")})`);
        }
    }
    //rate the event
    const rate_event = (max) => {
        for (var i = 0; i <= max; i++) {
            $('#rate .fa-star:eq(' + i + ')').css('color', 'var(--accB)');
        }
        $('#r_rating').val(max + 1);
    }
    //clear the stars
    const clear_stars = () => {
        $('#rate .fa-star').css('color', 'var(--main)');
        $('#r_rating').val(0);
    }
    //rate the event
    const review_event = () => {
        //get the values from the form
        let r_rating = $('#r_rating').val();
        let r_name = $('#r_name').val();
        let r_comment = $('#r_comment').val();
        let r_img = $("#r_img_input").val().split("\\").pop() !== "" ? $("#r_img_input").val().split("\\").pop() : $("#r_img").text();
        const review = {
            "r_rating": r_rating,
            "r_name": r_name,
            "r_comment": r_comment,
            "r_img": r_img,
            "u_rid": get_cookie("user_id", document.cookie.split(";")) === "-1" ? null : get_cookie("user_id", document.cookie.split(";")),
            "u_rname": get_cookie("user_name", document.cookie.split(";")) === "-1" ? null : get_cookie("user_name", document.cookie.split(";")),
        }
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
                "type": "rate",
                "user_id": get_cookie("user_id", document.cookie.split(";")) === "-1" ? null : get_cookie("user_id", document.cookie.split(";")),
                "username": get_cookie("user_name", document.cookie.split(";")) === "-1" ? null : get_cookie("user_name", document.cookie.split(";")),
                "event_id": event_id,
                "r_rating": r_rating,
                "r_name": r_name,
                "r_comment": r_comment,
                "r_img": r_img,
            }),
            success: function (resp, status) {//succesful query
                if (resp.status === "success") {
                    //submit the form to upload the review picture
                    $("#review_form").submit();
                    //update the page with the new info
                    $('.reviews').append(review_template(review));
                }
            },
            error: function (xhr, status, error) {//error handling
                error_handler(xhr, status, error);
            }
        });
    }
    //populate the view reviews modal with all of the reviews for the event
    const populate_view_reviews = () => {
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
                "type": "info",
                "user_id": get_cookie("user_id", document.cookie.split(";")) === "-1" ? null : get_cookie("user_id", document.cookie.split(";")),
                "username": get_cookie("user_name", document.cookie.split(";")) === "-1" ? null : get_cookie("user_name", document.cookie.split(";")),
                "return": "reviews",
                "id": event_id,
            }),
            success: function (resp, status) {//succesful query
                if (resp.status === "success" && resp.data.return.length > 0) {
                    //add the reviews to the modal
                    resp.data.return.forEach(review => {
                        $('#view_reviews_modal #reviews').append(review_template(review));
                    });
                }
                else {
                    $('#view_reviews_modal #reviews').append(`<p class="text-muted text-center">No reviews found</p>`);
                }
            },
            error: function (xhr, status, error) {//error handling
                error_handler(xhr, status, error);
            }
        });
    }
    /**
     * 
     * EVENT HANDLERS
     * 
     */
    //global
    let rating = -1;
    populate_edit_event();
    clear_stars();
    //when the submit button is clicked, edit and submit the event
    $("#submit_event").on("click", (e) => {
        if (validate_event()) {
            //hide the modal
            $("#event_modal").modal("hide");
            edit_event();
        }
        e.preventDefault();
    });
    //when a star is clicked on, rate the event
    $('#rate').on('click', '.fa-star', function (e) {
        rating = parseInt($(this).data('index'));
        rate_event(rating);
    });
    //when the mouse leaves the stars, clear the stars
    $('#rate').on('mouseleave', '.fa-star', () => {
        clear_stars();
        if (rating != -1) {
            rate_event(rating);
        }
    });
    //when a star is hovered over, change the color
    $('#rate').on('mouseover', '.fa-star', function (e) {
        clear_stars();
        rating = parseInt($(this).data('index'));
        rate_event(rating);
    });
    //when the submit review button is clicked, submit the review
    $('#submit_review').on('click', (e) => {
        if (validate_review()) {
            review_event();
        }
        e.preventDefault();
    });
    //when the edit review button is clicked, populate the form
    $('#edit_review').on('click', () => {
        populate_edit_review();
    });
    //when the add to list button is clicked, populate the modal
    $('#add_event_to_list').on('click', () => {
        populate_add_event_to_list();
    });
    //when the add-to-list button is clicked, add the event to the list
    $('#add_to_list').on('click', (e) => {
        if ($('l_id').val() != " " || $('l_id').val() != null) {
            add_event_to_list();
        }
        e.preventDefault();
    });
    //when the view_reviews button is clicked, populate the modal
    $('#view_reviews').on('click', () => {
        populate_view_reviews();
    });
});