//Tayla Orsmond u21467456
//Language: javascript, jquery
//Path: js\login.js
//Description: This is the javascript for the login page. It validates the email and password fields and checks if they are empty or not.
//It checks password and repeat password fields to make sure they match.
/*
    /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    https://emailregex.com/
    General Email Regex (RFC 5322 Official Standard)

    /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+=~`-])[A-Za-z\d!@#$%^&*()_+=~`-]{8,}$/g
    https://stackoverflow.com/questions/19605150/regex-for-password-must-contain-at-least-eight-characters-at-least-one-number-a
    Password Regex

*/
import { validate_email, validate_password, email_err, psw_err, submit_err } from './validate.js';

$(() => {
    //VARIABLES
    let email, psw;
    let valid_email = false;
    let valid_psw = false;
    const email_field = $('#email');
    email = email_field.val();
    const psw_field = $('#password');
    psw = psw_field.val();
    const btn = $('#login');
    //EVENT HANDLERS
    btn.on('click', (e) => {
        if (valid_email && valid_psw) {
            $('form').submit("login");
        } else {
            submit_err.insertAfter(btn);
        }
        e.preventDefault();
    });
    email_field.on('input', () => {
        email = email_field.val();
        if (validate_email(email)) {
            email_field.removeClass('invalid');
            email_field.addClass('valid');
            email_err.remove();
            valid_email = true;
        } else {
            email_field.removeClass('valid');
            email_field.addClass('invalid');
            email_err.insertAfter(email_field);
            valid_email = false;
        }
    });
    psw_field.on('input', () => {
        psw = psw_field.val();
        if (validate_password(psw)) {
            psw_field.removeClass('invalid');
            psw_field.addClass('valid');
            psw_err.remove();
            valid_psw = true;
        } else {
            psw_field.removeClass('valid');
            psw_field.addClass('invalid');
            psw_err.insertAfter(psw_field);
            valid_psw = false;
        }
    });
});