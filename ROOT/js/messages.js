//Tayla Orsmond u21467456
//Path: js\messages.js
//Language: javascript, jquery
//Description: This file contains the code for the messages page
// Allowing the user to send messages to other users that have a mutual following relationship
// Also allows the user to view their chats with other users and view the messages sent and received
import { error_template_blank, chat_template, message_template} from "./template.js";
import { get_cookie } from "./cookie.js";

$(() => {
    //Load the users chats
    const load_chats = () => {
        return new Promise((resolve, reject) => {
            //make the ajax call to get the users chats
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
                    "return": "chats"
                }),
                success: function(resp, status){//succesful query
                    resolve(resp);
                },
                error: function(error){//error handling
                    reject(error);
                }
            });
        });
    }
    //populate the chats div with the users chats
    const populate_chats = (resp) => {
        if(resp.status == "success" && resp.data.return.length > 0){
            resp.data.return.forEach(chat => {
                $("#chats").append(chat_template(chat));
            });
        }
        else{
            console.log(resp.status);
            console.log(resp.data.message);
            $("#chats").append(error_template_blank("It's a still life over here. " + resp.data.message));
        }
    }
    //Load the users messages for a specific chat
    const load_messages = (chat_id) => {
        return new Promise((resolve, reject) => {
            //make the ajax call to get the users messages
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
                    "return": "chat",
                    "receiver_id": chat_id
                }),
                success: function(resp, status){//succesful query
                    resolve(resp);
                },
                error: function(error){//error handling
                    reject(error);
                }
            });
        });
    }
    //populate the messages div with the users messages
    const populate_messages = (resp, chat_id, chat_name) => {
        //populate the chat header with the users name
        $("#chat_header").empty();
        $("#chat_header").append(`<h3 id="${chat_id}"><i class="fa-regular fa-comments"></i> <a href="profile.html?id=${chat_id}">@${chat_name}</a></h3>`);
        //clear the messages div
        $("#chat_messages").empty();
        if(resp.status === "success" && resp.data.return.length > 0){
            resp.data.return.forEach(message => {
                $("#chat_messages").prepend(message_template(message, chat_id));
            });
        }
        else{
            console.log(resp.status);
            console.log(resp.data.message);
            $("#chat_messages").append(error_template_blank("It's a still life over here. " + resp.data.message));
        }
    }
    //send a message to a user
    const send_message = (message, chat_id) => {
        return new Promise((resolve, reject) => {
            //make the ajax call to send the message
            $.ajax({
                url: api_url,
                type: "POST",
                accept: "application/json",
                contentType: "application/json",
                username: user_name,
                password: api_key,
                dataType: "json",
                data: JSON.stringify({
                    "type": "chat",
                    "user_id": get_cookie("user_id", document.cookie.split(";")) == "-1" ? null : get_cookie("user_id", document.cookie.split(";")),
                    "receiver_id": chat_id,
                    "message": message
                }),
                success: function(resp, status){//succesful query
                    console.log(resp.data.message);
                    resolve(resp);
                },
                error: function(error){//error handling
                    reject(error);
                }
            });
        });
    }
    //error handler
    const error_handler = (error) => {
        console.log(error);
        $("#error").empty();
        $("#error").show();
        $("#error").append(error_template_blank(error));
    }
    /**
     * 
     * EVENT HANDLERS
     * 
     */
    //get the chat ud from the url and load the messages for that chat if it is not equal to the current user id
    const urlParams = new URLSearchParams(window.location.search);
    const chat_ = urlParams.get('chat');
    const chat_n = urlParams.get('chatn');
    //load the users chats
    //disable the send button
    $("#chat_send").prop("disabled", true);
    load_chats().then((resp) => {
        $("#error").hide();
        //clear the chats div
        $("#chats").empty();
        populate_chats(resp);
        //if the chat id is not equal to the current user id
        if(chat_ != "-1" && chat_ != get_cookie("user_id", document.cookie.split(";"))){
            //load the messages for that chat
            load_messages(chat_).then((resp) => {
                populate_messages(resp, chat_, chat_n);
                //enable the send button
                $("#chat_send").prop("disabled", false);
            }).catch((error) => {
                error_handler(error);
            })
        }
    }).catch((error) => {
        error_handler(error);
    })

    //load the users messages for a specific chat when a chat is clicked
    $(document).on("click", ".chat", function(){
        $("#error").hide();
        //get the chat id
        const chat_id = $(this).attr("id");
        const chat_name = $(this).text().split("@")[1];
        //load the users messages for the chat
        load_messages(chat_id).then((resp) => {
            populate_messages(resp, chat_id, chat_name);
            //enable the send button
            $("#chat_send").prop("disabled", false);
        }).catch((error) => {
            error_handler(error);
        })
    });
    //send a message when the send button is clicked
    $(document).on("click", "#chat_send", (e) =>{
        e.preventDefault();
        $("#error").hide();
        //get the chat id
        const chat_id = $("#chat_header h3").attr("id");
        const chat_name = $("#chat_header h3").text().split("@")[1];
        let message = $("#chat_message").val();
        message = message.trim();
        console.log("yuh > " + chat_id + " " + chat_name + " " + message);
        //send the message if not empty
        if(message != ""){
            send_message(message, chat_id).then((resp) => {
                //load the users messages for the chat
                load_messages(chat_id).then((resp) => {
                    populate_messages(resp, chat_id, chat_name);
                }).catch((error) => {
                    error_handler(error);
                });
            }).catch((error) => {
                error_handler(error);
            })
        }
    });
});