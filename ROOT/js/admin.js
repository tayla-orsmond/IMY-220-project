//Tayla Orsmond u21467456
//Path: js\admin.js
//Language: javascript, jquery
//Description: This file contains the code for the admin page, allowing the admin to view all users and their information as well as delete users
//Also allows the admin to view all events and delete events

import { get_cookie } from "./cookie.js";
import { event_template_admin, user_template_admin, gallery_template_admin, error_template_blank } from "./template.js";

$(() => {
    //get all events
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
                "user_id": get_cookie("user_id", document.cookie.split(";")) == "-1" ? null : get_cookie("user_id", document.cookie.split(";")),
                "return": "events",
                "scope": "global",
                "id": get_cookie("user_id", document.cookie.split(";")) == "-1" ? null : get_cookie("user_id", document.cookie.split(";"))
            }),
            success: function (resp, status) {//succesful query
                populate_events(resp);
            },
            error: function (xhr, status, error) {//error handling
                error_handler(xhr, status, error);
            }
        })
    }
    //populate events
    const populate_events = (resp) => {
        $("#events").empty();
        if (resp.status === "success" && resp.data.return.length > 0) {
            resp.data.return.forEach((event) => {
                $("#events").append(event_template_admin(event));
            });
        }
        else {
            $("#events").append("<p class='text-center'>No events to display</p>");
        }
    }

    //load all users
    const load_users = () => {
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
                "user_id": get_cookie("user_id", document.cookie.split(";")) == "-1" ? null : get_cookie("user_id", document.cookie.split(";")),
                "return": "profiles",
                "scope": "global",
                "id": get_cookie("user_id", document.cookie.split(";")) == "-1" ? null : get_cookie("user_id", document.cookie.split(";"))
            }),
            success: function (resp, status) {//succesful query
                populate_users(resp);
            },
            error: function (xhr, status, error) {//error handling
                error_handler(xhr, status, error);
            }
        })
    }

    //populate users
    const populate_users = (resp) => {
        $("#users").empty();
        if (resp.status === "success" && resp.data.return.length > 0) {
            resp.data.return.forEach((user) => {
                $("#users").append(user_template_admin(user));
            });
        }
        else {
            $("#users").append("<p class='text-center'>No users to display</p>");
        }
    }

    //load galleries
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
                "user_id": get_cookie("user_id", document.cookie.split(";")) == "-1" ? null : get_cookie("user_id", document.cookie.split(";")),
                "return": "lists",
                "scope": "global",
                "id": get_cookie("user_id", document.cookie.split(";")) == "-1" ? null : get_cookie("user_id", document.cookie.split(";"))
            }),
            success: function (resp, status) {//succesful query
                populate_galleries(resp);
            },
            error: function (xhr, status, error) {//error handling
                error_handler(xhr, status, error);
            }
        })
    }

    //populate galleries
    const populate_galleries = (resp) => {
        $("#galleries").empty();
        if (resp.status === "success" && resp.data.return.length > 0) {
            resp.data.return.forEach((gallery) => {
                $("#galleries").append(gallery_template_admin(gallery));
            });
        }
        else {
            $("#galleries").append("<p class='text-center'>No galleries to display</p>");
        }
    }

    //error handler
    const error_handler = (xhr, status, error) => {
        //clear events
        $("#error_area").show();
        $("#error_area").append(error_template_blank("An unexpected error occured. Please try again later."));
    }

    //delete profile
    const delete_user = (user_id) => {
        $.ajax({
            url: api_url,
            type: "POST",
            accept: "application/json",
            contentType: "application/json",
            username: user_name,
            password: api_key,
            dataType: "json",
            data: JSON.stringify({
                "type": "delete",
                "user_id": get_cookie("user_id", document.cookie.split(";")) == "-1" ? null : get_cookie("user_id", document.cookie.split(";")),
                "delete": "user",
                "profile_id": user_id
            }),
            success: function (resp, status) {//succesful query
                load_users();
            },
            error: function (xhr, status, error) {//error handling
                error_handler(xhr, status, error);
            }
        })
    }

    //delete event
    const delete_event = (event_id) => {
        $.ajax({
            url: api_url,
            type: "POST",
            accept: "application/json",
            contentType: "application/json",
            username: user_name,
            password: api_key,
            dataType: "json",
            data: JSON.stringify({
                "type": "delete",
                "user_id": get_cookie("user_id", document.cookie.split(";")) == "-1" ? null : get_cookie("user_id", document.cookie.split(";")),
                "delete": "event",
                "event_id": event_id
            }),
            success: function (resp, status) {//succesful query
                load_events();
            },
            error: function (xhr, status, error) {//error handling
                error_handler(xhr, status, error);
            }
        })
    }

    //delete gallery
    const delete_gallery = (gallery_id) => {
        $.ajax({
            url: api_url,
            type: "POST",
            accept: "application/json",
            contentType: "application/json",
            username: user_name,
            password: api_key,
            dataType: "json",
            data: JSON.stringify({
                "type": "delete",
                "user_id": get_cookie("user_id", document.cookie.split(";")) == "-1" ? null : get_cookie("user_id", document.cookie.split(";")),
                "delete": "list",
                "list_id": gallery_id
            }),
            success: function (resp, status) {//succesful query
                load_galleries();
            },
            error: function (xhr, status, error) {//error handling
                error_handler(xhr, status, error);
            }
        })
    }

    load_events();
    load_users();
    load_galleries();

    setInterval(() => {
        load_events();
        load_users();
        load_galleries();
    }, 5000);

    //delete event handler
    $(document).on("click", ".delete_event", function () {
        delete_event($(this).attr("data-id"));
    });
    //delete user handler
    $(document).on("click", ".delete_user", function () {
        delete_user($(this).attr("data-id"));
    });
    //delete gallery handler
    $(document).on("click", ".delete_gallery", function () {
        delete_gallery($(this).attr("data-id"));
    });
});