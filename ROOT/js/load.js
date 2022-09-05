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
    // Load the events from the server
    const load_events = () => {
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
                "scope": "global",
                "id": window.sessionStorage.getItem("user_id"),
            }),
            success: function(resp, status){//succesful query
                console.log(status);
                console.log(resp.data);
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
            },
            error: function(xhr,status,error){//error handling
                console.log(status);
                console.log(xhr['responseText']);
            }
        })
    }
    load_events();
});