var editModal = document.getElementById('editDivision');
var deleteModal = document.getElementById('deleteDivision');
var idDiv;
var idDel;

editModal.addEventListener('show.bs.modal', function(event) {
    // Button that triggered the modal
    var button = event.relatedTarget
        // Extract info from data-bs-* attributes
    var recipient = button.getAttribute('data-bs-whatever')
    var myobj = JSON.parse(recipient);
    $("#btnAction").html("Update");
    // If necessary, you could initiate an AJAX request here
    // and then do the updating in a callback.
    //
    // Update the modal's content.
    var modalTitle = editModal.querySelector('.modal-title')
    idDiv = myobj["id"];

    modalTitle.textContent = "update Division";
    document.getElementById("recipient-id").value = myobj["id"];
    document.getElementById("recipient-name").value = myobj["name"];

})

deleteModal.addEventListener('show.bs.modal', function(event) {
    // Button that triggered the modal
    var button = event.relatedTarget
        // Extract info from data-bs-* attributes
    var recipient = button.getAttribute('data-bs-whatever')
    var myobj = JSON.parse(recipient);
    var modalTitle = editModal.querySelector('.modal-title')
    idDel = myobj["id"];

    modalTitle.textContent = "delete Division";

})

$('#master').on('click', function(e) {
    if ($(this).is(':checked', true)) {
        $(".sub_chk").prop('checked', true);
    } else {
        $(".sub_chk").prop('checked', false);
    }
});

$('.deleteDev').on('click', function(e) {
    $.ajax({
        url: 'deleteDivision',
        type: 'DELETE',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: 'id=' + idDel,
        success: function(data) {
            $("#deleteDivision").modal('hide');
            if (data['success']) {
                $("#tr_" + idDel).remove();
                success_toast("Division information has been deleted successfully.");
                setInterval('location.reload()', 5000);
            } else if (data['error']) {
                error_toast("Error while deleting division information.");
            } else {
                error_toast('Whoops Something went wrong!!');
            }
        },
        error: function(data) {
            alert(data.responseText);
        }
    });
});

$('.delete').on('click', function(e) {
    var allVals = [];
    $(".sub_chk:checked").each(function() {
        allVals.push($(this).attr('data-id'));
    });
    if (allVals.length <= 0) {
        warning_toast("Please select row.");
    } else {
        $('#deleteAllDivisions').modal('show');
    }
});

$('.delete_all').on('click', function(e) {
    var allVals = [];
    $(".sub_chk:checked").each(function() {
        allVals.push($(this).attr('data-id'));
    });
    var join_selected_values = allVals.join(",");
    $.ajax({
        url: $(this).data('url'),
        type: 'DELETE',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: 'ids=' + join_selected_values,
        success: function(data) {
            $("#deleteAllDivision").modal('hide');
            if (data['success']) {
                $(".sub_chk:checked").each(function() {
                    $("#tr_" + value).remove();
                });
                success_toast("Divisions information has been deleted successfully.");
                setInterval('location.reload()', 5000);
            } else if (data['error']) {
                error_toast("Error while deleting divisions information.");
            } else {
                error_toast('Whoops Something went wrong!!');
            }
        },
        error: function(data) {
            alert(data.responseText);
        }
    });


    $.each(allVals, function(index, value) {
        $("#tr_" + value).remove();
    });

});


$('#updateDivision').submit(function(e) {
    e.preventDefault();
    var id = $("#recipient-id").val();
    var name = $("#recipient-name").val();
    let token = $('input[name="_token"]').val();

    if (id == "") {
        error_toast("Code Division is required");
    }
    if (name == "") {
        error_toast("Name is required");
    } else if (id != "" && name != "") {
        $.ajax({
            url: "updateDivision",
            type: 'PUT',
            data: {
                code: id,
                idDiv: idDiv,
                name: name,
                _token: token
            },
            success: function(data) {
                $("#editDivision").modal('hide');
                if (data['success']) {
                    if ($.isNumeric(idDiv)) {
                        $("#tr_" + idDiv + " td:nth-child(3)").html(id);
                        $("#tr_" + idDiv + " td:nth-child(4)").html(name);
                        success_toast("Division has been updated successfully.");
                        idDiv = "";
                        setInterval('location.reload()', 5000);
                    } else {
                        success_toast("Division has been inserted successfully.");
                        location.reload();
                    }
                } else if (data['error']) {
                    if ($.isNumeric(idDiv)) {
                        error_toast("Error while updating division.");
                        idDiv = "";
                    } else {
                        error_toast("Error while inserting division.");
                    }
                } else {
                    error_toast('Whoops Something went wrong!!');
                }
            },
            error: function(data) {
                alert(data.responseText);
            }
        });
    }
});

$('#addDivision').on('click', function(e) {
    e.preventDefault();
    $("#editDivisionLabel").html("Add Division");
    document.getElementById("recipient-id").value = "";
    document.getElementById("recipient-name").value = "";
    $("#btnAction").html("Add");
    $("#editDivision").modal('show');
});


function success_toast(message) {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "5000",
        "timeOut": "10000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    toastr.success(message);
}

function error_toast(message) {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "5000",
        "timeOut": "10000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    toastr.error(message);
}

function warning_toast(message) {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    toastr.warning(message);
}