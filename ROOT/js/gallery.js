//Tayla Orsmond u21467456
//Path: js\gallery.js
//Language: javascript, jquery
//Description: This file contains the javascript code for the gallery page
//e.g., editing and deleting a gallery, deleting an event from a gallery, etc.

import { validate_list } from "./validate.js";
import { get_cookie } from "./cookie.js";

$(() => {
    //GLOBALS
    //get the gallery id from the url
    const urlParams = new URLSearchParams(window.location.search);
    const list_id = urlParams.get('id');
    /**
     * 
     * FUNCTIONS FOR EDITING AND DELETING A GALLERY
     * 
     */
    //populate the edit gallery modal with the gallery's details that are on the page
    const populate_edit_list_modal = () => {
        $('#l_name').val($('.list-name').text());
        $('#l_desc').val($('.list-description').text());
    };
    //update list details
    const edit_list = () => {
        populate_edit_list_modal();
        //get the new list details
        const list_name = $('#l_name').val();
        const list_desc = $('#l_desc').val();
        //make an array of all the event card id's on the page (all the events in the gallery)
        const event_ids = [];
        $('.event-card').each(function(){
            event_ids.push($(this).attr('id'));
        });
        const l_events = event_ids.join(',');
        //make the ajax call 
        $.ajax({
            url: api_url,
            type: 'POST',
            accept: "application/json",
            contentType: "application/json",
            username: user_name,
            password: api_key,
            dataType: "json",
            data: JSON.stringify({
                "type": "update",
                "user_id": get_cookie("user_id", document.cookie.split(";")) === "-1" ? null : get_cookie("user_id", document.cookie.split(";")),
                "username": get_cookie("user_name", document.cookie.split(";")) === "-1" ? null : get_cookie("user_name", document.cookie.split(";")),
                "update": "list",
                "l_id": list_id,
                "l_name": list_name,
                "l_desc": list_desc,
                "l_events": l_events
            }),
            success: (resp, status) => {
                //if the response is successful, update the page with the new details
                if(resp.status === "success" && resp.data.return.length > 0){
                    $('.list-name').text(list_name);
                    $('.list-description').text(list_desc);
                    //close the modal
                    $('#edit-list-modal').modal('hide');
                } else{
                    console.log(resp.status);
                    console.log(resp.data.message);
                }
            },
            error: function(xhr,status,error){//error handling
                error_handler(xhr,status,error);
            }
        });
    }
    //error handler
    const error_handler = (xhr,status,error) => {
        console.log(status);
        console.log(xhr['responseText']);
        console.log(error);
        $("#error").show();
        $("#error").append(error_template_blank(error));
    }
    /**
     * 
     * EVENT HANDLERS
     * 
     */
     populate_edit_list_modal();
    //when the edit_list button is clicked, populate the modal with the gallery's details
    $('#edit_list').on('click', () => {
        populate_edit_list_modal();
    });
    //when the submit_list button is clicked, update the gallery's details
    $('#submit_list').on('click', (e) => {
        if(validate_list()){
            edit_list();
        }
        e.preventDefault();
    });
    //when a remove_event button is clicked, remove the event with the corresponding id from the gallery
    $('.events-area-inner').on('click', '.remove_event', (e) => {
        //get the event id from the button
        const event_id = $(e.currentTarget).attr('id').split('_')[1];
        console.log("yuh > " + event_id);
        $(`#${event_id}`).remove();
        e.currentTarget.remove();
        edit_list();
    });
});