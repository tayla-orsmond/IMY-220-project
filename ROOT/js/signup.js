//Tayla Orsmond u21467456
//Language: javascript, jquery
//Path: js\signup.js
//Description: This is the javascript for the signup page. It validates the username, email, password and repeat_password fields and checks if they are empty or not.
//It checks password and repeat password fields to make sure they match.
/*
    /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    https://emailregex.com/
    General Email Regex (RFC 5322 Official Standard)

    /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+=~`-])[A-Za-z\d!@#$%^&*()_+=~`-]{8,}$/g
    https://stackoverflow.com/questions/19605150/regex-for-password-must-contain-at-least-eight-characters-at-least-one-number-a
    Password Regex

    ^(?=[a-zA-Z0-9._]{3,20}$)(?!.*[_.]{2})[^_.].*[^_.]$
    https://stackoverflow.com/questions/12018245/regular-expression-to-validate-username
    Username Regex

*/

$(() => {
    //VARIABLES
    let username, email, psw, repeat_psw;
    let valid_username = false;
    let valid_email = false;
    let valid_psw = false;
    let valid_repeat_psw = false;
    const username_field = $('#username');
    username = username_field.val();
    const email_field = $('#email');
    email = email_field.val();
    const psw_field = $('#password');
    psw = psw_field.val();
    const repeat_psw_field = $('#confirm');
    repeat_psw = repeat_psw_field.val();
    const btn = $('#signup');
    //ERROR MESSAGES
    const username_err = $('<div></div>', {
        html: 'Please enter a valid Username.',
        class: 'invalid bg-warning p-3',
        id: 'username_err'
    });
    const email_err = $('<div></div>', {
        html: 'Please enter a valid Email Address.',
        class: 'invalid bg-warning p-3',
        id: 'email_err'
    });
    const psw_err = $('<div></div>', {
        html: 'Please enter a valid password. Passwords must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, one special character and one number.',
        class: 'invalid bg-warning p-3',
        id: 'psw_err'
    });
    const repeat_psw_err = $('<div></div>', {
        html: 'Passwords must match.',
        class: 'invalid bg-warning p-3',
        id: 'repeat_psw_err'
    });
    const submit_err = $('<div></div>', {
        html: 'Please make sure all fields are filled in correctly before submitting.',
        class: 'invalid bg-warning p-3',
        id: 'submit_err'
    });
    //EVENT HANDLERS
    btn.on('click', (e) => {
        if (valid_username && valid_email && valid_psw && valid_repeat_psw) {
            $('form').submit("signup");
        } else {
            submit_err.insertAfter(btn);
        }
        e.preventDefault();
    });
    username_field.on('blur', () => {
        username = username_field.val();
        if (validateUsername(username)) {
            username_field.removeClass('invalid');
            username_field.addClass('valid');
            username_err.remove();
            valid_username = true;
        } else {
            username_field.removeClass('valid');
            username_field.addClass('invalid');
            username_err.insertAfter(username_field);
            valid_username = false;
        }
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
        if (validatePassword(psw)) {
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
    repeat_psw_field.on('blur', () => {
        repeat_psw = repeat_psw_field.val();
        if (validatePassword(repeat_psw) && psw === repeat_psw) {
            repeat_psw_field.removeClass('invalid');
            repeat_psw_field.addClass('valid');
            repeat_psw_err.remove();
            valid_repeat_psw = true;
        } else {
            repeat_psw_field.removeClass('valid');
            repeat_psw_field.addClass('invalid');
            repeat_psw_err.insertAfter(repeat_psw_field);
            valid_repeat_psw = false;
        }
    });
    //FUNCTIONS
    const validateUsername = (username) => {
        const rg = new RegExp(/^(?=[a-zA-Z0-9_.]{3,20}$)(?!.*[_.]{2}).*$/);
        return rg.test(username);
    }
    const validateEmail = (email) => {
        const rg = new RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
        return rg.test(email);
    }
    const validatePassword = (psw) => {
        const rg = new RegExp(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+=~`-])[A-Za-z\d!@#$%^&*()_+=~`-]{8,}$/);
        return rg.test(psw);
    }
});