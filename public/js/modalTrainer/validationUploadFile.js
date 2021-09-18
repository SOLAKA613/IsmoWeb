var i = 0;

function HideShow() {
    var parent = $('#idFile');
    console.log(i);
    if (i == 0) {
        $('#idTable').remove();
        i = 1;
    } else {
        $('<table id="idTable" class="table table-primary table-striped"><tr><td width="10%" align="right"></td><td width="60%" ><div class="mb-3"><input type="hidden" id="indexFile" value="@if(!empty($fileName)){{$fileName}}@endif" /><input class="form-control inputFile" type="file" name="file" id="FormControlFile" onchange="return ValidationFile()" lang="en"  required><div class="error_file" id="file_error"></div></div></td><td class="formFile" width="30%" align="left"></td></tr><tr><td width="40%" align="right">Allowed file extensions:</td><td width="30"><span class="text-muted">.pdf</span></td><td width="30%" align="left"></td></tr></table>').appendTo(parent);
        i = 0;
    }
}

window.onload = function() {
    var btnUpdate = $("#buttonUpdate");
    var index_file = $("#indexFile").val();

    console.log(index_file);
    if (index_file !== "") {
        btnUpdate.show();
        $('#idTable').remove();
        i = 1;
    } else {
        btnUpdate.hide();
    }
};

function myFunction() {
    var file = document.getElementById("FormControlFile");
    var file_error = document.getElementById("file_error");
    var file_value = file.value;
    if (file_value === "") {
        setErrorFor(file, "Select File for Upload !", file_error);
        return false;

    } else if (file_value !== "") {
        setSuccessFor(file);
        return true;
    }
}

function ValidationFile() {
    var file = document.getElementById("FormControlFile");
    var file_error = document.getElementById("file_error");
    var file_value = file.value;
    var extension = file_value.split('.').pop().toLowerCase();
    var allowedFormats = ["pdf"];

    if (!(allowedFormats.indexOf(extension) > -1)) {
        setErrorFor(file, "The file type is incorrect enter a file type pdf !", file_error);
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