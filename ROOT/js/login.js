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
    //ERROR MESSAGES
    const email_err = $('<div></div>', {
        html: 'Please enter a valid Email Address.',
        class: 'bg-warning p-3',
        id: 'email_err'
    });
    const psw_err = $('<div></div>', {
        html: 'Please enter a valid password. Passwords must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, one special character and one number.',
        class: 'bg-warning p-3',
        id: 'psw_err'
    });
    const submit_err = $('<div></div>', {
        html: 'Please make sure all fields are filled in correctly before submitting.',
        class: 'bg-warning p-3',
        id: 'submit_err'
    });
    //EVENT HANDLERS
    btn.on('click', (e) => {
        if (valid_email && valid_psw) {
            $('form').submit("login");
        } else {
            submit_err.insertAfter(btn);
        }
        e.preventDefault();
    });
    email_field.on('blur', () => {
        email = email_field.val();
        if (validateEmail(email)) {
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
    psw_field.on('blur', () => {
        psw = psw_field.val();
        if (validatePsw(psw)) {
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
    //FUNCTIONS
    const validateEmail = (email) => {
        const rg = new RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
        return rg.test(email);
    }
    const validatePsw = (psw) => {
        const rg = new RegExp(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+=~`-])[A-Za-z\d!@#$%^&*()_+=~`-]{8,}$/);
        return rg.test(psw);
    }
});