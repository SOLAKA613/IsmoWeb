const trainee_code = document.getElementById('id');
const first_name = document.getElementById('first_name');
const last_name = document.getElementById('last_name');
const division = document.getElementById('division');
const age = document.getElementById('age');
const email = document.getElementById('email');
const login = document.getElementById('login');
const password = document.getElementById('password');
var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;


function checkInputs() {
    // trim to remove the whitespaces
    const trainee_codeValue = trainee_code.value.trim();
    const first_nameValue = first_name.value.trim();
    const last_nameValue = last_name.value.trim();
    const ageValue = age.value.trim();
    const emailValue = email.value.trim();
    const loginValue = login.value.trim();
    const passwordValue = password.value.trim();
    var i = 0,
        j = 0,
        k = 0,
        l = 0,
        m = 0,
        a = 0,
        b = 0;

    if (trainee_codeValue === '') {
        setErrorFor(trainee_code, 'Code trainee cannot be blank');
        i = 0;
    } else if (trainee_codeValue.length < 6 || trainee_codeValue.length > 13) {
        setErrorFor(trainee_code, 'Code trainee must contain a minimum of 6 characters and a maximum of 13 characters');
        i = 0
    } else {
        setSuccessFor(trainee_code);
        i = 1
    }

    if (first_nameValue === '') {
        setErrorFor(first_name, 'First name cannot be blank');
        j = 0;
    } else if (first_nameValue.length < 3 || first_nameValue.length > 25) {
        setErrorFor(first_name, 'First name must contain a minimum of 3 characters and a maximum of 25 characters');
        j = 0;
    } else {
        setSuccessFor(first_name);
        j = 1;
    }

    if (last_nameValue === '') {
        console.log("lestname: " + last_nameValue.value);
        setErrorFor(last_name, 'Last name cannot be blank');
        k = 0;
    } else if (last_nameValue.length < 2 || last_nameValue.length > 25) {
        setErrorFor(last_name, 'Last name must contain a minimum of 3 characters and a maximum of 25 characters');
        k = 0;
    } else {
        setSuccessFor(last_name);
        k = 1;
    }


    if (ageValue === '') {
        setErrorFor(age, 'Age cannot be blank');
        l = 0;
    } else if (ageValue < 16 || ageValue > 40) {
        setErrorFor(age, 'Age must equal a minimum of 16 and a maximum of 40');
        l = 0;
    } else {
        setSuccessFor(age);
        l = 1;
    }

    if (emailValue === '') {
        setErrorFor(email, 'Email cannot be blank');
        m = 0;
    } else if (!filter.test(emailValue)) {
        setErrorFor(email, 'Please provide a valid email address');
        m = 0;
    } else {
        setSuccessFor(email);
        m = 1;
    }

    if (loginValue === '') {
        setErrorFor(login, 'Login cannot be blank');
        a = 0;
    } else if (loginValue.length < 7 || loginValue.length > 25) {
        setErrorFor(login, 'Login must contain a minimum of 8 characters and a maximum of 25 characters');
        a = 0;
    } else {
        setSuccessFor(login);
        a = 1;
    }

    if (passwordValue === '') {
        setErrorFor(password, 'Password cannot be blank');
        b = 0;
    } else if (passwordValue.length < 7 || passwordValue.length > 25) {
        setErrorFor(password, 'Password must contain a minimum of 8 characters and a maximum of 25 characters');
        b = 0;
    } else {
        setSuccessFor(password);
        b = 1;
    }

    if (i == 1 && j == 1 && k == 1 && l == 1 && m == 1 && a == 1 && b == 1) {
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