const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');
/* constantes to connect */
const formConnect = document.getElementById('formConnect');
const usernameConnect = document.getElementById('usernameConnect');
const passwordConnect = document.getElementById('passwordConnect');

function checkInputsConnect() {
    // trim to remove the whitespaces
    const usernameConnectValue = usernameConnect.value.trim();
    const passwordConnectValue = passwordConnect.value.trim();
    var i = 0,
        j = 0;


    if (usernameConnectValue === '') {
        setErrorFor(usernameConnect, 'Username cannot be blank');
        i = 0;
    } else {
        setSuccessFor(usernameConnect);
        i = 1;
    }

    if (passwordConnectValue === '') {
        setErrorFor(passwordConnect, 'Password cannot be blank');
        j = 0;
    } else {
        setSuccessFor(passwordConnect);
        j = 1;
    }

    if (i == 1 && j == 1) {
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
    formControl.className = 'form-control1 success1';
}


signUpButton.addEventListener('click', () => {
    container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
    container.classList.remove("right-panel-active");
});