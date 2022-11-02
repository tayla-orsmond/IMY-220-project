//Tayla Orsmond u21467456
// Language: javascript, jquery
// Path: js\template.js
//Description: This file contains js templates.

//Event template
export const event_template = ({ e_img, e_name, e_location, e_rating, e_id }, index) => {
    return `
    <div class="card event-card" id="${e_id}">
        <img src="media/uploads/events/${e_img}" class="card-img-top img-fluid" alt="...">
        <div class="card-body">
            <p>${index < 2 ? `<span class="badge badge-new">New</span>` : ``}</p>
            <h5 class="card-title text-truncate">${e_name}</h5>
            <div class="rating">
                <span class="fa fa-star ${e_rating >= 1 ? "checked" : ""}"></span>
                <span class="fa fa-star ${e_rating >= 2 ? "checked" : ""}"></span>
                <span class="fa fa-star ${e_rating >= 3 ? "checked" : ""}"></span>
                <span class="fa fa-star ${e_rating >= 4 ? "checked" : ""}"></span>
                <span class="fa fa-star ${e_rating >= 5 ? "checked" : ""}"></span>
            </div>
            <p class="card-text text-truncate">${e_location}</p>
            <a href="event.php?id=${e_id}" class="stretched-link"></a>
        </div>
    </div>
    `;
}
//Primary event template
export const primary_event_template = ({ e_img, e_name, e_location, e_date, e_desc, e_rating, e_id }) => {
    return `
    <div class="card text-bg-dark" id="event_primary">
        <img src="media/uploads/events/${e_img}" class="card-img" alt="...">
        <div class="card-img-overlay d-flex flex-column justify-content-between">
            <div class="card-header">Featured</div>
            <div>
                <div class="rating">
                    <span class="fa fa-star ${e_rating >= 1 ? "checked" : ""}"></span>
                    <span class="fa fa-star ${e_rating >= 2 ? "checked" : ""}"></span>
                    <span class="fa fa-star ${e_rating >= 3 ? "checked" : ""}"></span>
                    <span class="fa fa-star ${e_rating >= 4 ? "checked" : ""}"></span>
                    <span class="fa fa-star ${e_rating >= 5 ? "checked" : ""}"></span>
                </div>
                <h5 class="card-title text-truncate">${e_name}</h5>
                <p class="card-text h6 text-truncate">${e_location} | ${e_date}</p>
                <p class="card-text text-truncate ">
                    ${e_desc.replace(/#(\w+)/g, '<a href="home.php?search=$1">#$1</a>')}
                </p>
                <a href="event.php?id=${e_id}" class="stretched-link"></a>
            </div>
        </div>
    </div>
    `;
}
//User template
export const user_template = ({ u_id, u_name, u_profile, u_display_name, u_bio, u_admin }) => {
    return `
    <div class="card user-card" id="${u_id}">
        <div class="card-body">
            <div class="d-flex justify-content-start align-items-start flex-wrap p-1">
                <img src="media/uploads/profiles/${u_profile}" class="img-fluid rounded-circle m-2" alt="...">
                <div>
                    <h5 class="card-title text-truncate">${u_display_name}</h5>
                    <p class="card-text">${u_admin ? `<span class="badge badge-admin">Admin</span>` : ``}</p>
                </div>
            </div>
            <p class="card-text text-truncate">
                <a href="profile.php?id=${u_id}">@${u_name}</a>
                <p class="text-muted">${u_bio.trim() === "" ? "No Bio" : u_bio.trim()}</p>
            </p>
            <a href="profile.php?id=${u_id}" class="stretched-link"></a>
        </div>
    </div>
    `;
}

//gallery template list item for a list group 
export const gallery_template = ({ l_name, l_id }) => {
    return `
    <li class="list-group-item my-2">
        <a href="gallery.php?id=${l_id}">${l_name}</a>
    </li>
    `;
}
//follower template list item for a list group
export const follower_template = ({ u_fname, u_fid }) => {
    return `
    <li class="list-group-item">
        <a href="profile.php?id=${u_fid}">@${u_fname}</a>
    </li>
    `;
}
//following template list item for a list group
export const following_template = ({ u_rname, u_rid }) => {
    return `
    <li class="list-group-item">
        <a href="profile.php?id=${u_rid}">@${u_rname}</a>
    </li>
    `;
}
//review template
export const review_template = ({ u_rid, u_rname, r_name, r_comment, r_rating }) => {
    let stars = "";
    for (var i = 0; i < r_rating; i++) {
        stars += `<i class="fa fa-star fa-xl"></i>`;
    }
    for (var i = 0; i < 5 - r_rating; i++) {
        stars += `<i class="fa fa-star-o fa-xl"></i>`;
    }
    return `<div class="p-1 mt-2 review-box">
        <p class="h5 review-name">${r_name}</p>
        <div class="d-flex justify-content-between">
            <p><a href="profile.php?id=${u_rid}">@${u_rname}</a></p>
            <p>${stars}</p>
            <span class="d-none review-rating">${r_rating}</span></div>
        </div>
        <p class="review-comment">${r_comment}</p>
        <div class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#review_modal" id="edit_review">Edit Review</div>
    </div>
    `;
}
//chat template
export const chat_template = ({ u_rid, u_rname, u_profile, c_message, c_timestamp, c_unread}) => {
    return `
    <div class="chat" id="${u_rid}" data-name="${u_rname}">
        <div class="d-flex justify-content-between align-items-center p-2">
            <img src="media/uploads/profiles/${u_profile}" class="img-fluid rounded-circle" style="width:4rem; height:4rem; objectFit:cover;" alt="...">
            <div class="right">
                <div class="d-flex align-items-center justify-content-end">
                    <a href="profile.php?id=${u_rid}">@${u_rname}</a>
                    <span class="unread-dot mx-2 ${c_unread ? "" : "d-none"}"></span>
                </div>
                <span class="text-muted small">${c_message}</span>
                <span class="text-muted small"> ${c_timestamp ? "| " + new Date(c_timestamp).toLocaleTimeString() : ""}</span>
            </div>
        </div>
    </div>
    `;
}
//message template
export const message_template = ({ u_rid, u_rname, u_sid, u_sname, c_message, c_timestamp, c_unread }, reciever_id) => {
    //replace links with anchor tags
    //replace youtube links with embedded video
    c_message = c_message.replace(/(https?:\/\/www.youtube.com\/watch\?v=([^\s]+))/g, '<iframe width="100%" height="315" src="https://www.youtube.com/embed/$2" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
    c_message = c_message.replace(/(https?:\/\/[^\s]+)/g, '<a href="$1">$1</a>');

    //if the message is from the reciever
    let sent = u_rid == reciever_id;
    let align = u_rid == reciever_id ? "right offset-5" : "left";
    return `
    <div class="message-box col-6 ${u_sid} ${align}">
        <div class="bg-light p-3 rounded ${c_unread && sent ? "unread" : ""} ">
            <p>${c_message}</p>
        </div>
        <p class="text-muted ${align}">${new Date(c_timestamp).toLocaleTimeString()}</p>
    </div>
    `;
}
//error template
export const error_template = (error) => {
    return `
        <div class="d-flex flex-column bg-light p-3 text-center">
            <img src="https://images.unsplash.com/photo-1599729872017-05170c770642?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1331&q=80" class="img-fluid" alt="...">
            ${error}
        </div>
    `;
}
//error template
export const error_template_blank = (error) => {
    return `
        <div class="d-flex flex-column bg-light p-3 text-center">
            ${error}
        </div>
    `;
}

//event template for admin page
//table row
export const event_template_admin = ({ e_id, e_name, u_rid, u_rname, e_location, e_date, e_time, e_img }) => {
    return `
    <tr>
        <th scope="row">${e_id}</th>
        <td><img src="${e_img}" class="img-fluid rounded" alt="..."></td>
        <td class="text-truncate">
            <a href="event.php?id=${e_id}">${e_name}</a>
        </td>
        <td class="text-truncate">
            <a href="profile.php?id=${u_rid}">@${u_rname}</a>
        </td>
        <td class="text-truncate">${e_date}</td>
        <td class="text-truncate">${e_time}</td>
        <td class="text-truncate">${e_location}</td>
        <td>
            <div class="btn btn-primary delete_event" data-id="${e_id}">Delete</div>
        </td>
    </tr>
    `;
}

//user template for admin page
//table row
export const user_template_admin = ({ u_id, u_name, u_display_name, u_profile }) => {
    return `
    <tr>
        <th scope="row">${u_id}</th>
        <td><img src="${u_profile}" class="img-fluid rounded" alt="..."></td>
        <td class="text-truncate">
            <a href="profile.php?id=${u_id}">@${u_name}</a>
        </td>
        <td class="text-truncate">${u_display_name}</td>
        <td>
            <div class="btn btn-primary delete_user" data-id="${u_id}">Delete</div>
        </td>
    </tr>
    `;
}

//list template for admin page
//table row
export const gallery_template_admin = ({ l_id, u_rid, u_rname, l_name, l_desc }) => {
    return `
    <tr>
        <th scope="row">${l_id}</th>
        <td class="text-truncate">${l_name}</td>
        <td class="text-truncate">
            <a href="profile.php?id=${u_rid}">@${u_rname}</a>
        </td>
        <td class="text-truncate">${l_desc}</td>
        <td>
            <div class="btn btn-primary delete_gallery" data-id="${l_id}">Delete</div>
        </td>
    </tr>
    `;
}

//tag template
export const tag_template = tag => {
    return `
    <p>
        <span class="badge badge-pill bg-secondary p-2">
            <a href="home.php?search=${tag[0].substr(1, tag[0].length)}">${tag[0]}</a>
        </span> 
        <small>${tag[1]} posts</small>
    </p>`;
}

//category template
export const category_template = (category, number) => {
    return `
    <p>
        <span class="badge badge-pill bg-primary p-2">
            <a href="home.php?search=${category[0]}">${category[0]}</a>
        </span> - <small>${category[1]} / ${number} posts</small><br/>
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: ${category[1]/number * 100}%" aria-label="${category[0]}" aria-valuenow="${category[1]}" aria-valuemin="0" aria-valuemax="${number}"></div>
        </div>
    </p>`;
}