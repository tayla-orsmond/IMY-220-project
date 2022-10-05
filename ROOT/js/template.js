//Tayla Orsmond u21467456
// Language: javascript, jquery
// Path: js\template.js
//Description: This file contains js templates.

//Event template
export const event_template = ({e_img, e_name, e_location, e_id}) => {
    return `
    <div class="card event-card" id="${e_id}">
        <img src="media/uploads/events/${e_img}" class="card-img-top img-fluid" alt="...">
        <div class="card-body">
            <h5 class="card-title text-truncate">${e_name}</h5>
            <p class="card-text text-truncate">${e_location}</p>
            <a href="event.php?id=${e_id}" class="stretched-link"></a>
        </div>
    </div>
    `
}
//Primary event template
export const primary_event_template = ({e_img, e_name, e_location, e_date, e_desc, e_id}) => {
    return `
    <div class="card text-bg-dark" id="event_primary">
        <img src="${e_img}" class="card-img" alt="...">
        <div class="card-img-overlay d-flex flex-column justify-content-between">
            <div class="card-header">Featured</div>
            <div>
                <h5 class="card-title text-truncate">${e_name}</h5>
                <p class="card-text h6 text-truncate">${e_location} | ${e_date}</p>
                <p class="card-text text-truncate ">
                    ${e_desc.replace(/#(\w+)/g, '<a href="home.php?search=$1">#$1</a>')}
                </p>
                <small class="card-text text-muted">'. $event['e_date'] .'</small>
                <a href="event.php?id=${e_id}" class="stretched-link"></a>
            </div>
        </div>
    </div>
    `
}
//gallery template list item for a list group 
export const gallery_template = ({l_name, l_id}) => {
    return `
    <li class="list-group-item my-2">
        <a href="gallery.php?id=${l_id}">${l_name}</a>
    </li>
    `
}
//follower template list item for a list group
export const follower_template = ({u_fname, u_fid}) => {
    return `
    <li class="list-group-item">
        <a href="profile.php?id=${u_fid}">@${u_fname}</a>
    </li>
    `
}
//following template list item for a list group
export const following_template = ({u_rname, u_rid}) => {
    return `
    <li class="list-group-item">
        <a href="profile.php?id=${u_rid}">@${u_rname}</a>
    </li>
    `
}
//review template
export const review_template = ({u_rid, u_rname, r_name, r_comment, r_rating}) => {
    let stars = "";
    for(var i = 0; i < r_rating; i++){
        stars += `<i class="fa fa-star fa-xl"></i>`;
    }
    for(var i = 0; i < 5 - r_rating; i++){
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
    </div>`;
}

//error template
export const error_template = (error) => {
    return `
        <div class="d-flex flex-column bg-light p-3 text-center">
            <img src="https://images.unsplash.com/photo-1599729872017-05170c770642?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1331&q=80" class="img-fluid" alt="...">
            ${error}
        </div>
    `
}
//error template
export const error_template_blank = (error) => {
    return `
        <div class="d-flex flex-column bg-light p-3 text-center">
            ${error}
        </div>
    `
}