//Tayla Orsmond u21467456
//Path: js\validate.js
//Language: javascript, jquery
//Description: This file contains validation functions, error messages and variables for the signup, login, profile and event pages.
//It contains the validation for the forms in the event, gallery and review modal.
//It also contains the validation for the forms in the signup, login, profile and event pages.

/**
 * 
 * VALIDATE EVENT MODAL
 * 
 */
//globals
let valid_name = false;
let valid_date = false;
let valid_time = false;
let valid_location = false;
let valid_image = false;
//validate the event form
//validate the name
//the name must be between 3 and 50 characters
//the name must not contain any special characters besides !, ? and @
$("#e_name").on("input", () => {
    let name = $("#e_name").val();
    let name_regex = /^[a-zA-Z0-9!@? ]{3,50}$/;
    if (name_regex.test(name)) {
        $("#e_name").removeClass("invalid");
        $("#e_name").addClass("valid");
        $("#e_name_err").remove();
        valid_name = true;
    } else {
        $("#e_name").removeClass("valid");
        $("#e_name").addClass("invalid");
        if(!$("#e_name_err").html()) {
            $('<div class="error" id="e_name_err">The name must be between 3 and 50 characters and must not contain any special characters besides "!", "?" and "@"</div>').insertAfter("#e_name");
        }
        valid_name = false;
    }
});
//validate the date
//the date is required
$("#e_date").on("input", () => {
    let date = $("#e_date").val();
    if (date !== "") {
        $("#e_date").removeClass("invalid");
        $("#e_date").addClass("valid");
        $("#e_date_err").remove();
        valid_date = true;
    } else {
        $("#e_date").removeClass("valid");
        $("#e_date").addClass("invalid");
        if(!$("#e_date_err").html()) {
            $('<div class="error" id="e_date_err">The date is required</div>').insertAfter("#e_date");
        }
        valid_date = false;
    }
});
//validate the time
//the time is required
$("#e_time").on("input", () => {
    let time = $("#e_time").val();
    if (time !== "") {
        $("#e_time").removeClass("invalid");
        $("#e_time").addClass("valid");
        $("#e_time_err").remove();
        valid_time = true;
    } else {
        $("#e_time").removeClass("valid");
        $("#e_time").addClass("invalid");
        if(!$("#e_time_err").html()) {
            $('<div class="error" id="e_time_err">The time is required</div>').insertAfter("#e_time");
        }
        valid_time = false;
    }
});
//validate the location
//the location must be between 3 and 50 characters
//the location must not contain any special characters
$("#e_location").on("input", () => {
    let location = $("#e_location").val();
    let location_regex = /^[\w\s,]{3,50}$/;
    if (location_regex.test(location)) {
        $("#e_location").removeClass("invalid");
        $("#e_location").addClass("valid");
        $("#e_location_err").remove();
        valid_location = true;
    } else {
        $("#e_location").removeClass("valid");
        $("#e_location").addClass("invalid");
        if(!$("#e_location_err").html()) {
            $('<div class="error" id="e_location_err">The location must be between 3 and 50 characters and must not contain any special characters besides ","</div>').insertAfter("#e_location");
        }
        valid_location = false;
    }
});
//allow a user to upload an image by dragging and dropping it into the image input or clicking on the div
//the image must be a jpg, jpeg, png or gif
//the image must be less than 2MB
$("#e_img").on("dragover", function (e) {
    e.preventDefault();
    e.stopPropagation();
    $("#e_img").addClass("dragover");
});
$("#e_img").on("dragleave", function (e) {
    e.preventDefault();
    e.stopPropagation();
    $("#e_img").removeClass("dragover");
});
$("#e_img").on("drop", function (e) {
    e.preventDefault();
    e.stopPropagation();
    $("#e_img").removeClass("dragover");
    let file = e.originalEvent.dataTransfer.files[0];
    let file_regex = /\.(jpg|jpeg|png|gif)$/i;
    if(file.name === undefined){
        $("#e_img").removeClass("valid");
        $("#e_img").addClass("invalid");
        if(!$("#e_img_err").html()) {
            $('<div class="error" id="e_img_err">The image must be a jpg, jpeg, png or gif and must be less than 2MB</div>').insertAfter("#e_img");
        }
        valid_image = false;
        //remove the image input value
        $("#e_img").text("");
    }
    if (file_regex.test(file.name)) {
        if (file.size < 2000000) {
            $("#e_img").removeClass("invalid");
            $("#e_img").addClass("valid");
            $("#e_img_err").remove();
            //set the image input value to the file name
            $("#e_img").text(file.name);
            $("#e_img_input").val(file);
            valid_image = true;
        } else {
            $("#e_img").removeClass("valid");
            $("#e_img").addClass("invalid");
            //remove the image input value
            $("#e_img").text("");
            if(!$("#e_img_err").html()) {
                $('<div class="error" id="e_img_err">The image must be less than 2MB</div>').insertAfter("#e_img");
            }
            valid_image = false;
        }
    } else {
        $("#e_img").removeClass("valid");
        $("#e_img").addClass("invalid");
        if(!$("#e_img_err").html()) {
            $('<div class="error" id="e_img_err">The image must be a jpg, jpeg, png or gif</div>').insertAfter("#e_img");
        }
        valid_image = false;
    }
});
$("#e_img").on("click", () => {
    $("#e_img_input").click();
});
$("#e_img_input").on("change", () => {
    let file = $("#e_img_input").prop("files")[0];
    let file_regex = /\.(jpg|jpeg|png|gif)$/i;
    if(file.name === undefined){
        $("#e_img").removeClass("valid");
        $("#e_img").addClass("invalid");
        if(!$("#e_img_err").html()) {
            $('<div class="error" id="e_img_err">The image must be a jpg, jpeg, png or gif and must be less than 2MB</div>').insertAfter("#e_img");
        }
        valid_image = false;
        //remove the image input value
        $("#e_img").text("");
    }
    if (file_regex.test(file.name)) {
        if (file.size < 2000000) {
            $("#e_img").removeClass("invalid");
            $("#e_img").addClass("valid");
            $("#e_img_err").remove();
            //set the image input value to the file name
            $("#e_img").text(file.name);
            valid_image = true;
        } else {
            $("#e_img").removeClass("valid");
            $("#e_img").addClass("invalid");
            if(!$("#e_img_err").html()) {
                $('<div class="error" id="e_img_err">The image must be less than 2MB</div>').insertAfter("#e_img");
            }
            valid_image = false;
        }
    } else {
        $("#e_img").removeClass("valid");
        $("#e_img").addClass("invalid");
        if(!$("#e_img_err").html()) {
            $('<div class="error" id="e_img_err">The image must be a jpg, jpeg, png or gif</div>').insertAfter("#e_img");
        }
        valid_image = false;
    }
});

//highlight the hashtags in the description as the user types
$("#e_desc").on("input", () => {
    let description = $("#e_desc").val();
    let description_regex = /#(\w+)/g;
    let new_description = description.replace(description_regex, "<span class='text-primary'>#$1</span>");
    $("#e_desc_val").html(new_description);
});

/**
 * 
 * VALIDATE LIST (GALLERY) MODAL
 * 
 */
//globals
let valid_l_name = false;
//validate the list (gallery) form
$('#l_name').on('input', () => {
    let name = $('#l_name').val();
    let name_regex = /^[a-zA-Z0-9!@? ]{3,50}$/;
    if (name_regex.test(name)) {
        $('#l_name').removeClass('invalid');
        $('#l_name').addClass('valid');
        $('#l_name_err').remove();
        valid_l_name = true;
    } else {
        $('#l_name').removeClass('valid');
        $('#l_name').addClass('invalid');
        if (!$('#l_name_err').html()) {
            $('<div class="error" id="l_name_err">The name must be between 3 and 50 characters and must not contain any special characters besides !, ? and @</div>').insertAfter('#l_name');
        }
        valid_l_name = false;
    }
});

//FUNCTIONS
export const validate_event = () => {
    return valid_name && valid_date && valid_time && valid_location && valid_image;
}
export const validate_list = () => {
    return valid_l_name;
}
export const validate_username = (username) => {
    const rg = new RegExp(/^(?=[a-zA-Z0-9_.]{3,20}$)(?!.*[_.]{2}).*$/);
    return rg.test(username);
}
export const validate_email = (email) => {
    const rg = new RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
    return rg.test(email);
}
export const validate_password = (psw) => {
    const rg = new RegExp(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+=~`-])[A-Za-z\d!@#$%^&*()_+=~`-]{8,}$/);
    return rg.test(psw);
}

//ERROR MESSAGES
export const username_err = $('<div></div>', {
    html: 'Please enter a valid Username.',
    class: 'invalid bg-warning p-3',
    id: 'username_err'
});
export const email_err = $('<div></div>', {
    html: 'Please enter a valid Email Address.',
    class: 'invalid bg-warning p-3',
    id: 'email_err'
});
export const psw_err = $('<div></div>', {
    html: 'Please enter a valid password. Passwords must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, one special character and one number.',
    class: 'invalid bg-warning p-3',
    id: 'psw_err'
});
export const repeat_psw_err = $('<div></div>', {
    html: 'Passwords must match.',
    class: 'invalid bg-warning p-3',
    id: 'repeat_psw_err'
});
export const submit_err = $('<div></div>', {
    html: 'Please make sure all fields are filled in correctly before submitting.',
    class: 'invalid bg-warning p-3',
    id: 'submit_err'
});