//Tayla Orsmond u21467456
// Language: javascript (JQuery)
// Path: js\load.js
// Description: This is the functionality for loading events from the server into the page.
//<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

$(()=> {
    //Event template
    const event_template = (event) => {
        return `
        <div class="card event-card">
            <img src="${event.data.e_img}" class="card-img-top img-fluid" alt="...">
            <div class="card-body">
                <h5 class="card-title text-truncate">${event.data.e_name}</h5>
                <p class="card-text text-truncate">${event.data.e_location}</p>
                <a href="event.php?id=${event.data.e_id}" class="stretched-link"></a>
            </div>
        </div>
        `
    }
    //Primary event template
    const primary_event_template = (event) => {
        return `
        <div class="card text-bg-dark" id="event-primary">
            <img src="${event.e_img}" class="card-img" alt="...">
            <div class="card-img-overlay d-flex flex-column justify-content-between">
                <div class="card-header">Featured</div>
                <div>
                    <h5 class="card-title text-truncate">${event.e_name}</h5>
                    <p class="card-text h6 text-truncate">${event.e_location} | ${event.e_date}</p>
                    <p class="card-text text-truncate ">${event.e_desc}</p>
                    <div class="d-flex justify-content-center">
                        <a href="." class="btn btn-dark">${event.e_tag1}</a>
                        <a href="." class="btn btn-dark">${event.e_tag2}</a>
                        <a href="." class="btn btn-dark">${event.e_tag3}</a>
                    </div>
                    <a href="event.php?id=${event.e_id}" class="stretched-link"></a>
                </div>
            </div>
        </div>
        `
    }
    const error_template = (error) => {
        return `
            <div class="d-flex flex-column bg-light p-3 text-center">
                <img src="https://images.unsplash.com/photo-1599729872017-05170c770642?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1331&q=80" class="img-fluid" alt="...">
                ${error}
            </div>
        `
    }
    // Load the events from the server
    const load_events = (scope) => {
        $.ajax({
            url: 'api.php',
            type: "POST",
            accept: "application/json",
            contentType: "application/json",
            username: "root",
            password: "",
            dataType: "json",
            data: JSON.stringify({
                "type": "info",
                "user_id": window.sessionStorage.getItem("user_id"),
                "return": "events",
                "scope": scope,
                "id": window.sessionStorage.getItem("user_id"),
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
    //search for events
    const search_events = (search) => {
        $.ajax({
            url: 'api.php',
            type: "POST",
            accept: "application/json",
            contentType: "application/json",
            username: "root",
            password: "",
            dataType: "json",
            data: JSON.stringify({
                "type": "info",
                "user_id": window.sessionStorage.getItem("user_id"),
                "return": "search",
                "search": search,
                "id": window.sessionStorage.getItem("user_id"),
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
    //clear the events
    const clear_events = () => {
        $("#event-primary").empty();
        $("#event-primary").hide();
        $("#ea-1").empty();
        $("#ea-2").empty();
        $("#error-area").empty();
        $("#error-area").hide();
    };
    //populate the events
    const populate_events = (resp) => {
        //clear events
        clear_events();
        $("#event-primary").show();        
        if(resp.status == "success"){
            //Load the events
            let events = resp.data.return;
            let primary_event = events.shift();
            $("#event-primary").replaceWith(primary_event_template(primary_event));
            const half = Math.floor(events.length / 2);
            let e1 = events.slice(0, half);
            let e2 = events.slice(half, events.length);
            e1.forEach(event => {
                $("#ea-1").append(event_template(event));
            });
            e2.forEach(event => {
                $("#ea-2").append(event_template(event));
            });
        }
        else if(resp.status == "error"){
            $("#error-area").show();
            $("#error-area").append(error_template(resp.data.message));
        }
    }
    //error handler
    const error_handler = (xhr,status,error) => {
        console.log(status);
        console.log(xhr['responseText']);
        console.log(error);
        //clear events
        clear_events();
        $("#error-area").show();
        $("#error-area").append(error_template("Error loading events"));
    }
    //on page load, load the events for the local feed
    load_events("local");
    //on search, search for events
    $("#search").on("submit", (e) => {
        if($("#search-input").val().length > 0){
            search_events($("#search-input").val());
        }
        e.preventDefault();
    });
    //on click of the local link, load the local feed
    $("#local").on("click", () => {
        //make local link active
        $("#local").addClass("active");
        $("#global").removeClass("active");
        load_events("local");
    });
    //on click of the global link, load the global feed
    $("#global").on("click", () => {
        //make global link active
        $("#global").addClass("active");
        $("#local").removeClass("active");
        load_events("global");
    });
});