//Tayla Orsmond u21467456
//Path: js\profile.js
//Language: javascript, jquery
//Description: This file contains the javascript code for the profile page
//e.g., adding an event, adding a gallery (list), following, unfollowing, viewing your events and your reviewed events etc.

$(() => {
    /**
     * 
     * CONSTANTS AND GLOBAL VARIABLES ===========================================================
     */
    //get the cookie values 
    const getCookie = (cookieName, cookies) => {
        const name = cookieName + "=";//beginning of cookie string (name of name value pair)
        for(const cookie of cookies){
            let c = cookie;
            while(c.charAt(0) == ' '){//parse until you get to just before a cookie name
                c = c.substring(1);
            }
            if(c.indexOf(name) == 0){//cookie name match
                return c.substring(name.length, c.length);//parse the cookie string to get value
            }
        }
        return "-1";
    }
    //Get the user id from the url
    const urlParams = new URLSearchParams(window.location.search);
    const user_id = urlParams.get('id');
    //event template
    const event_template = ({e_img, e_name, e_location, e_id}) => {
        return `
        <div class="card event-card">
            <img src="${e_img}" class="card-img-top img-fluid" alt="...">
            <div class="card-body">
                <h5 class="card-title text-truncate">${e_name}</h5>
                <p class="card-text text-truncate">${e_location}</p>
                <a href="event.php?id=${e_id}" class="stretched-link"></a>
            </div>
        </div>
        `
    }
    //gallery template list item for a list group 
    const gallery_template = ({g_img, g_name, g_id}) => {
        return `
        <li class="list-group-item">
            <div class="row">
                <div class="col-4">
                    <img src="${g_img}" class="img-fluid" alt="...">
                </div>
                <div class="col-8">
                    <h5 class="card-title text-truncate">${g_name}</h5>
                    <a href="gallery.php?id=${g_id}" class="stretched-link"></a>
                </div>
            </div>
        </li>
        `
    }
    //follower / following template list item for a list group
    const follower_following_template = ({u_name, u_id}) => {
        return `
        <li class="list-group-item">
            <a href="profile.php?id=${u_id}">${u_name}</a>
        </li>
        `
    }
    //error template
    const error_template = (error) => {
        return `
            <div class="d-flex flex-column bg-light p-3 text-center">
                <img src="https://images.unsplash.com/photo-1575805082881-8828b300e0ca?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80" class="img-fluid" alt="...">
                ${error}
            </div>
        `
    }
    /**
     * 
     * FUNCTIONS FOR EVENTS ===========================================================
     */
    //load the user's events
    const load_events = () => {
        $.ajax({
            url: api_url,
            type: "POST",
            accept: "application/json",
            contentType: "application/json",
            username: user_name,
            password: user_key,
            dataType: "json",
            data: JSON.stringify({
                "type": "info",
                "user_id": getCookie("user_id", document.cookie.split(";")) === "-1" ? null : getCookie("user_id", document.cookie.split(";")),
                "return": "events",
                "scope": "self",
                "id": user_id,
            }),
            success: function(resp, status){//succesful query
                console.log(status);
                console.log(resp.data);
                populate_events(resp);
            },
            error: function(xhr,status,error){//error handling
                error_handler(xhr,status,error);
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
            password: user_key,
            dataType: "json",
            data: JSON.stringify({
                "type": "info",
                "user_id": getCookie("user_id", document.cookie.split(";")) === "-1" ? null : getCookie("user_id", document.cookie.split(";")),
                "return": "reviewed",
                "id": user_id,
            }),
            success: function(resp, status){//succesful query
                console.log(status);
                console.log(resp.data);
                populate_events(resp);
            },
            error: function(xhr,status,error){//error handling
                error_handler(xhr,status,error);
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
            password: user_key,
            dataType: "json",
            data: JSON.stringify({
                "type": "info",
                "user_id": getCookie("user_id", document.cookie.split(";")) === "-1" ? null : getCookie("user_id", document.cookie.split(";")),
                "return": "lists",
                "id": user_id,
            }),
            success: function(resp, status){//succesful query
                console.log(status);
                console.log(resp.data);
                populate_galleries(resp);
            },
            error: function(xhr,status,error){//error handling
                error_handler(xhr,status,error);
            }
        })
    }
    //populate the events
    const populate_events = (resp) => {
        //clear events
        clear_events();       
        if(resp.status == "success" && resp.data.return.length > 0){
            //Load the events
            let events = resp.data.return;
            events.forEach((event) => {
                $("#events-inner").append(event_template(event));
            });
        }
        else{
            console.log(resp.status);
            console.log(resp.data.message);
            $("#error-area").show();
            $("#error-area").append(error_template("It's a still life over here. " + resp.data.message));
        }
    }
    //populate galleries
    const populate_galleries = (resp) => {
        //clear galleries
        clear_galleries();
        if(resp.status == "success" && resp.data.return.length > 0){
            //Load the galleries
            let galleries = resp.data.return;
            galleries.forEach((gallery) => {
                $("#galleries-inner").append(gallery_template(gallery));
            });
        }
        else if(resp.status == "error"){
            console.log(resp.status);
            console.log(resp.data.message);
            $("#error-area-g").show();
            $("#error-area-g").append(error_template("It's a still life over here. " + resp.data.message));
        }
    }
    //clear the events
    const clear_events = () => {
        $("#error").empty();
        $("#error").hide();
        $("#events-inner").empty();
        $("#events-inner").empty();
        $("#error-area").empty();
        $("#error-area").hide();
    };
    //clear the galleries
    const clear_galleries = () => {
        $("#error").empty();
        $("#error").hide();
        $("#error-area-g").empty();
        $("#error-area-g").hide();
        $("#galleries-inner").empty();
    };
    //error handler
    const error_handler = (xhr,status,error) => {
        console.log(status);
        console.log(xhr['responseText']);
        console.log(error);
        //clear events
        clear_events();
        $("#error").show();
        $("#error").append(error_template(error));
    }
    //add an event via a modal
    const add_event = () => {
        $.ajax({
            url: api_url,
            type: "POST",
            accept: "application/json",
            contentType: "application/json",
            username: user_name,
            password: user_key,
            dataType: "json",
            data: JSON.stringify({
                "type": "add",
                "user_id": getCookie("user_id", document.cookie.split(";")) === "-1" ? null : getCookie("user_id", document.cookie.split(";")),
                "user_name": getCookie("user_name", document.cookie.split(";")) === "-1" ? null : getCookie("user_name", document.cookie.split(";")),
                "add": "event",
                "e_name": $("#e_name").val(),
                "e_desc": $("#e_desc").val(),
                "e_date": $("#e_date").val(),
                "e_time": $("#e_time").val(),
                "e_location": $("#e_location").val(),
                "e_tag1": $("#e_tag1").val(),
                "e_tag2": $("#e_tag2").val(),
                "e_tag3": $("#e_tag3").val(),
                "e_tag4": $("#e_tag4").val(),
                "e_tag5": $("#e_tag5").val(),
                "e_img": $("#e_img").val(),
                "e_rating": $("#e_rating").val()
            }),
            success: function(resp, status){//succesful query
                console.log(status);
                console.log(resp.data);
                if(resp.status == "success"){
                    $("#add_event").modal("hide");
                    load_events();
                }
            },
            error: function(xhr,status,error){//error handling
                error_handler(xhr,status,error);
            }
        })
    }
    //add a gallery via a modal
    const add_gallery = () => {
        $.ajax({
            url: api_url,
            type: "POST",
            accept: "application/json",
            contentType: "application/json",
            username: user_name,
            password: user_key,
            dataType: "json",
            data: JSON.stringify({
                "type": "add",
                "user_id": getCookie("user_id", document.cookie.split(";")) === "-1" ? null : getCookie("user_id", document.cookie.split(";")),
                "return": "galleries",
                "id": user_id,
                "title": $("#add_gallery_title").val(),
                "description": $("#add_gallery_description").val(),
                "url": $("#add_gallery_url").val(),
            }),
            success: function(resp, status){//succesful query
                console.log(status);
                console.log(resp.data);
                if(resp.status == "success"){
                    $("#add_gallery").modal("hide");
                    load_galleries();
                }
            },
            error: function(xhr,status,error){//error handling
                error_handler(xhr,status,error);
            }
        })
    }
    /**
     * 
     * FUNCTIONS FOR (UN)FOLLOWING ===========================================================
     */
    //follow / unfollow the user
    const follow_unfollow = (f) => {
        $.ajax({
            url: api_url,
            type: "POST",
            accept: "application/json",
            contentType: "application/json",
            username: user_name,
            password: user_key,
            dataType: "json",
            data: JSON.stringify({
                "type": "follow",
                "user_id": getCookie("user_id", document.cookie.split(";")) === "-1" ? null : getCookie("user_id", document.cookie.split(";")),
                "follow": f,
                "username": getCookie("user_name", document.cookie.split(";")) === "-1" ? null : getCookie("user_name", document.cookie.split(";")),
                "follow_id": user_id,
                "follow_name": $("#username").html(),
            }),
            success: function(resp, status){//succesful query
                console.log(status);
                console.log(resp.data);
                let count = $(".followers").html();
                if(f === "follow"){
                    $("#follow").addClass('d-none');
                    $("#unfollow").removeClass('d-none');
                    $("#DM").removeClass('d-none');
                    $(".followers").html(parseInt(count) + 1);
                } 
                else if(f === "unfollow"){
                    $("#follow").removeClass('d-none');
                    $("#unfollow").addClass('d-none');
                    $("#DM").addClass('d-none');
                    $(".followers").html(parseInt(count) - 1);
                }
            },
            error: function(xhr,status,error){//error handling
                error_handler(xhr,status,error);
            }
        })
    }
    //load the user's followers in a modal
    const load_followers = () => {
        $.ajax({
            url: api_url,
            type: "POST",
            accept: "application/json",
            contentType: "application/json",
            username: user_name,
            password: user_key,
            dataType: "json",
            data: JSON.stringify({
                "type": "info",
                "user_id": getCookie("user_id", document.cookie.split(";")) === "-1" ? null : getCookie("user_id", document.cookie.split(";")),
                "return": "followers",
                "id": user_id,
            }),
            success: function(resp, status){//succesful query
                console.log(status);
                console.log(resp.data);
                populate_followers(resp);
            },
            error: function(xhr,status,error){//error handling
                error_handler(xhr,status,error);
            }
        })
    }
    //load the user's following in a modal
    const load_following = () => {
        $.ajax({
            url: api_url,
            type: "POST",
            accept: "application/json",
            contentType: "application/json",
            username: user_name,
            password: user_key,
            dataType: "json",
            data: JSON.stringify({
                "type": "info",
                "user_id": getCookie("user_id", document.cookie.split(";")) === "-1" ? null : getCookie("user_id", document.cookie.split(";")),
                "return": "following",
                "id": user_id,
            }),
            success: function(resp, status){//succesful query
                console.log(status);
                console.log(resp.data);
                populate_following(resp);
            },
            error: function(xhr,status,error){//error handling
                error_handler(xhr,status,error);
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
    //if the folios tab is clicked, load the user's events
    $("#folios").on("click", () => {
        $("#folios").addClass("active");
        $("#reviewed").removeClass("active");
        load_events();
    });
    //if the reviewed tab is clicked, load the user's reviewed events
    $("#reviewed").on("click", () => {
        $("#reviewed").addClass("active");
        $("#folios").removeClass("active");
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
    $("#following").on("click", () => {
        load_following();
    });
    //if the followers tab is clicked, load the user's followers
    $("#followers").on("click", () => {
        load_followers();
    });
});