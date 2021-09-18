function myFunction() {
    var file = document.getElementById("FormControlFile");
    var file_error = document.getElementById("file_error");
    var file_value = file.value;

    if (file_value === "") {
        setErrorFor(file, "Select File for Upload !", file_error);
        document.getElementById("submit").disabled = true;
        return false;

    } else if (file_value !== "") {
        setSuccessFor(file);
        document.getElementById("submit").disabled = false;
        return true;
    }
}

function ValidationFile() {
    var file = document.getElementById("FormControlFile");
    var file_error = document.getElementById("file_error");
    var file_value = file.value;
    var extension = file_value.split('.').pop().toLowerCase();
    var size = file.files[0].size;
    var allowedFormats = ["xls", "xlsx"];

    if (!(allowedFormats.indexOf(extension) > -1)) {
        setErrorFor(file, "The file type is incorrect enter a file type xls/xlsx !", file_error);
        document.getElementById("submit").disabled = true;
        return false;

    } else {
        setSuccessFor(file);
        document.getElementById("submit").disabled = false;
        return true;
    }


}

function setErrorFor(input, message, file_error) {
    input.className = 'form-control inputFile is-invalid';
    file_error.textContent = message;
    file_error.className = 'invalid-feedback error_file';
}

function setSuccessFor(input) {
    input.className = 'form-control inputFile is-valid';
}