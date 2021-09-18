const form = document.getElementById('form');
const username = document.getElementById('username');
const email = document.getElementById('email');
const password = document.getElementById('password');
const confirm_password = document.getElementById('confirm_password');

function checkInputs() {
    // trim to remove the whitespaces
    const usernameValue = username.value.trim();
    const emailValue = email.value.trim();
    const passwordValue = password.value.trim();
    const confirm_passwordValue = confirm_password.value.trim();
    var i = 0;
    var j = 0,
        k = 0,
        l = 0;

    if (usernameValue === '') {
        setErrorFor(username, 'Username cannot be blank');
        i = 0;
    } else {
        setSuccessFor(username);
        i = 1;
    }

    if (emailValue === '') {
        setErrorFor(email, 'Email cannot be blank');
        j = 0;
    } else if (!isEmail(emailValue)) {
        setErrorFor(email, 'Not a valid email');
        j = 0;
    } else {
        setSuccessFor(email);
        j = 1;
    }

    if (passwordValue === '') {
        setErrorFor(password, 'Password cannot be blank');
        k = 0;
    } else {
        setSuccessFor(password);
        k = 1;
    }

    if (confirm_passwordValue === '') {
        setErrorFor(confirm_password, 'Confirm password cannot be blank');
        l = 0;
    } else if (passwordValue !== confirm_passwordValue) {
        setErrorFor(confirm_password, 'Passwords does not match');
        l = 0;
    } else {
        setSuccessFor(confirm_password);
        l = 1;
    }

    if (i == 1 && j == 1 && k == 1 && l == 1) {
        return true;
    } else {
        return false;
    }
}

function setErrorFor(input, message) {
    const formControl = input.parentElement;
    const small = formControl.querySelector('small');
    formControl.className = 'form-control1 error';
    small.innerText = message;
}

function setSuccessFor(input) {
    const formControl = input.parentElement;
    formControl.className = 'form-control1 success';
}

function isEmail(email) {
    return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email);
}