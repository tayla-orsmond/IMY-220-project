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
    //follower template list item for a list group
    const follower_template = ({u_fname, u_fid}) => {
        return `
        <li class="list-group-item">
            <a href="profile.php?id=${u_fid}">@${u_fname}</a>
        </li>
        `
    }
    //following template list item for a list group
    const following_template = ({u_rname, u_rid}) => {
        return `
        <li class="list-group-item">
            <a href="profile.php?id=${u_rid}">@${u_rname}</a>
        </li>
        `
    }
    //error template
    const error_template = (error) => {
        return `
            <div class="d-flex flex-column bg-light p-3 text-center">
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
        else{
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
                "e_img": $("#e_img").val(),
                "e_rating": $("#e_rating").val()
            }),
            success: function(resp, status){//succesful query
                if(resp.status == "success"){
                    load_events();
                }
                else{
                    console.log(resp.status + " | " + status);
                    console.log(resp.data.message);
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
                "add": "list",
                "id": user_id,
                "l_name": $("#g_name").val(),
                "l_desc": $("#g_desc").val(),
            }),
            success: function(resp, status){//succesful query
                if(resp.status == "success"){
                    load_galleries();
                }
                else{
                    console.log(resp.status + " | " + status);
                    console.log(resp.data.message);
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
    //load the user's followers / following in a modal
    const load_followers_following = (f) => {
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
                "return": f,
                "id": user_id,
            }),
            success: function(resp, status){//succesful query     
                populate_followers_following(resp, f);
            },
            error: function(xhr,status,error){//error handling
                error_handler(xhr,status,error);
            }
        })
    }
    //populate the modal with the user's followers / following
    const populate_followers_following = (resp, f) => {
        $("#follow_list").empty();
        $("#follow_modal_label").empty();
        $("#follow_modal_label").text("F" + f.slice(1));
        console.log(resp.data.return);
        if(resp.status === "success" && resp.data.return.length > 0){
            let follow = resp.data.return;
            if(f === "followers"){
                follow.forEach(user => {
                    $("#follow_list").append(follower_template(user));
                });
            }
            else{
                follow.forEach(user => {
                    $("#follow_list").append(following_template(user));
                });
            }
        }
        else{
            console.log(resp.status);
            console.log(resp.data.message);
            $("#follow_list").append(error_template(resp.data.message));
        }
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
    $("#show_following").on("click", () => {
        load_followers_following("following");
    });
    //if the followers tab is clicked, load the user's followers
    $("#show_followers").on("click", () => {
        load_followers_following("followers");
    });
});