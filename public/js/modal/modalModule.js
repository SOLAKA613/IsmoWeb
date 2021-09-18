var editModal = document.getElementById('editModule');
var deleteModal = document.getElementById('deleteModule');
var idMo;
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
    idMo = myobj["id"];

    modalTitle.textContent = "update Module";
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

    modalTitle.textContent = "delete Module";

})

$('#master').on('click', function(e) {
    if ($(this).is(':checked', true)) {
        $(".sub_chk").prop('checked', true);
    } else {
        $(".sub_chk").prop('checked', false);
    }
});

$('.deleteMo').on('click', function(e) {
    $.ajax({
        url: $(this).data('url'),
        type: 'DELETE',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: 'id=' + idDel,
        success: function(data) {
            $("#deleteModule").modal('hide');
            if (data['success']) {
                $("#tr_" + idDel).remove();
                success_toast("Module information has been deleted successfully.");
                setInterval('location.reload()', 5000);
            } else if (data['error']) {
                error_toast("Error while deleting Module information.");
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
        $('#deleteAllModules').modal('show');
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
            $("#deleteAllModule").modal('hide');
            if (data['success']) {
                $(".sub_chk:checked").each(function() {
                    $("#tr_" + value).remove();
                });
                success_toast("Modules information has been deleted successfully.");
                setInterval('location.reload()', 5000);
            } else if (data['error']) {
                error_toast("Error while deleting Modules information.");
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



$('#updateModule').submit(function(e) {
    e.preventDefault();
    var id = $("#recipient-id").val();
    var name = $("#recipient-name").val();
    let token = $('input[name="_token"]').val();

    if (id == "") {
        error_toast("Code Module is required");
    }
    if (name == "") {
        error_toast("Name is required");
    } else if (id != "" && name != "") {
        $.ajax({
            url: "updateModule",
            type: 'GET',
            data: {
                code: id,
                idMo: idMo,
                name: name,
                _token: token
            },
            success: function(data) {
                $("#editModule").modal('hide');
                if (data['success']) {
                    if ($.isNumeric(idMo)) {
                        $("#tr_" + idMo + " td:nth-child(3)").html(id);
                        $("#tr_" + idMo + " td:nth-child(4)").html(name);
                        success_toast("Module has been updated successfully.");
                        idMo = "";
                        setInterval('location.reload()', 5000);
                    } else {
                        success_toast("Module has been inserted successfully.");
                        location.reload();
                    }
                } else if (data['error']) {
                    if ($.isNumeric(idMo)) {
                        error_toast("Error while updating module.");
                        idMo = "";
                    } else {
                        error_toast("Error while inserting module.");
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

$('#addModule').on('click', function(e) {
    e.preventDefault();
    $("#editModuleLabel").html("Add Module");
    document.getElementById("recipient-id").value = "";
    document.getElementById("recipient-name").value = "";
    $("#btnAction").html("Add");
    $("#editModule").modal('show');
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