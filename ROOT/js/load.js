//Tayla Orsmond u21467456
// Language: javascript, jquery
// Path: js\load.js
// Description: This is the functionality for loading events from the server into the page.
//<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
import { get_cookie } from "./cookie.js";
import { event_template, primary_event_template, user_template, error_template } from "./template.js";

$(() => {
    // Load the events from the server
    const load_events = (scope) => {
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
                "scope": scope,
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
    //search for events
    const search_events = (search) => {
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
                "return": "search",
                "search": search,
                "id": get_cookie("user_id", document.cookie.split(";")) == "-1" ? null : get_cookie("user_id", document.cookie.split(";"))
            }),
            success: function (resp, status) {//succesful query
                $("#search-input").val(search);
                populate_events(resp);
            },
            error: function (xhr, status, error) {//error handling
                error_handler(xhr, status, error);
            }
        })
    }
    //clear the events
    const clear_events = () => {
        $(".primary-event-outer").hide();
        $("#event_primary").empty();
        $("#event_primary").hide();
        $("#ea_1").empty();
        $("#ea_2").empty();
        $("#error_area").empty();
        $("#error_area").hide();
        $(".user-area-inner").empty();
        $(".user-area-inner").hide();
    };
    //populate the events
    const populate_events = (resp) => {
        //clear events
        clear_events();
        if (resp.status == "success" && resp.data.return.length > 0) {
            //Load the events
            $(".primary-event-outer").show();
            $("#event_primary").show();
            let events = resp.data.return;
            let primary_event = events.shift();
            $("#event_primary").replaceWith(primary_event_template(primary_event));
            const half = Math.ceil(events.length / 2.0);
            let e1 = events.slice(0, half);
            let e2 = events.slice(half, events.length);
            e1.forEach((event, index) => {
                $("#ea_1").append(event_template(event, index));
            });
            e2.forEach((event, index) => {
                $("#ea_2").append(event_template(event, index));
            });
        }
        else if (resp.status == "error") {
            $("#error_area").show();
            $("#error_area").append(error_template(resp.data.message));
        }
        else {
            $("#error_area").show();
            $("#error_area").append(error_template("It's a still life over here..."));
        }
    }

    //load users
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
                "return": "profiles"
            }),
            success: function (resp, status) {//succesful query
                populate_users(resp);
            },
            error: function (xhr, status, error) {//error handling
                error_handler(xhr, status, error);
            }
        })
    }
    //populate the users
    const populate_users = (resp) => {
        clear_events();
        if (resp.status == "success" && resp.data.return.length > 0) {
            $(".user-area-inner").show();
            //Load the users
            let users = resp.data.return;
            users.forEach((user) => {
                $(".user-area-inner").append(user_template(user));
            });
        }
        else if (resp.status == "error") {
            $("#error_area").show();
            $("#error_area").append(error_template(resp.data.message));
        }
        else {
            $("#error_area").show();
            $("#error_area").append(error_template("It's a still life over here..."));
        }
    }
    //error handler
    const error_handler = (xhr, status, error) => {
        //clear events
        clear_events();
        $("#error_area").show();
        $("#error_area").append(error_template("An unexpected error occured. Please try again later."));
    }
    //on page load, load the events for the local feed
    //if there is a get parameter, load the events for the search
    //get the search parameters from the url
    const url_params = new URLSearchParams(window.location.search);
    const search = url_params.get('search');
    if (search != null) {
        $("#global").addClass("active");
        $("#local").removeClass("active");
        $("#users").removeClass("active");

        search_events(search);
    }
    else {
        load_events("local");
    }

    //on search, search for events
    $("#search").on("click", (e) => {
        if ($("#search-input").val().length > 0) {
            search_events($("#search-input").val());
            $("#global").addClass("active");
            $("#local").removeClass("active");
            $("#users").removeClass("active");
        }
        e.preventDefault();
    });
    //on click of the local link, load the local feed
    $("#local").on("click", () => {
        //make local link active
        $("#local").addClass("active");
        $("#global").removeClass("active");
        $("#users").removeClass("active");
        $("#search-input").val("");
        load_events("local");
    });
    //on click of the global link, load the global feed
    $("#global").on("click", () => {
        //make global link active
        $("#global").addClass("active");
        $("#local").removeClass("active");
        $("#users").removeClass("active");
        $("#search-input").val("");
        load_events("global");
    });
    //on click of the users link, load the users
    $("#users").on("click", () => {
        //make users link active
        $("#users").addClass("active");
        $("#local").removeClass("active");
        $("#global").removeClass("active");
        $("#search-input").val("");
        load_users();
    });
});