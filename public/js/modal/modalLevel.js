var editModal = document.getElementById('editLevel')
var deleteModal = document.getElementById('deleteLevel');
var idLev;
var idDel;

editModal.addEventListener('show.bs.modal', function(event) {
    // Button that triggered the modal
    var button = event.relatedTarget
        // Extract info from data-bs-* attributes
    var recipient = button.getAttribute('data-bs-whatever')
    var myobj = JSON.parse(recipient);
    // If necessary, you could initiate an AJAX request here
    // and then do the updating in a callback.
    //
    // Update the modal's content.
    var modalTitle = editModal.querySelector('.modal-title')
    idLev = myobj["id"];
    $("#btnAction").html("Update");

    modalTitle.textContent = myobj.name + "\'s information"
    document.getElementById("recipient-id").value = myobj["id"];
    document.getElementById("recipient-name").value = myobj["name"];

})

deleteModal.addEventListener('show.bs.modal', function(event) {
    // Button that triggered the modal
    var button = event.relatedTarget
        // Extract info from data-bs-* attributes
    var recipient = button.getAttribute('data-bs-whatever');
    var myobj = JSON.parse(recipient);
    idDel = myobj["id"];

})

$('#master').on('click', function(e) {
    if ($(this).is(':checked', true)) {
        $(".sub_chk").prop('checked', true);
    } else {
        $(".sub_chk").prop('checked', false);
    }
});

$('.delete').on('click', function(e) {
    var allVals = [];
    $(".sub_chk:checked").each(function() {
        allVals.push($(this).attr('data-id'));
    });
    if (allVals.length <= 0) {
        warning_toast("Please select row.");
    } else {
        $('#deleteAllLevels').modal('show');
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
            $("#deleteAllLevels").modal('hide');
            if (data['success']) {
                $(".sub_chk:checked").each(function() {
                    $("#tr_" + value).remove();
                });
                success_toast("Levels information has been deleted successfully.");
                setInterval('location.reload()', 5000);
            } else if (data['error']) {
                error_toast("Error while deleting levels information.");
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

$('.deleteLev').on('click', function(e) {
    $.ajax({
        url: 'deleteLevel',
        type: 'GET',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: 'id=' + idDel,
        success: function(data) {
            $("#deleteLevel").modal('hide');
            if (data['success']) {
                $("#tr_" + idDel).remove();
                success_toast("Level information has been deleted successfully.");
                setInterval('location.reload()', 5000);
            } else if (data['error']) {
                error_toast("Error while deleting level information.");
            } else {
                error_toast('Whoops Something went wrong!!');
            }
        },
        error: function(data) {
            alert(data.responseText);
        }
    });
});


$('#updateLevel').submit(function(e) {
    e.preventDefault();
    var id = $("#recipient-id").val();
    var name = $("#recipient-name").val();
    let token = $('input[name="_token"]').val();

    if (id == "") {
        error_toast("Code Level is required");
    }
    if (name == "") {
        error_toast("Name is required");
    } else if (id != "" && name != "") {
        $.ajax({
            url: "updateLevel",
            type: 'GET',
            data: {
                code: id,
                idLev: idLev,
                name: name,
                _token: token
            },
            success: function(data) {
                $("#editLevel").modal('hide');
                if (data['success']) {
                    if ($.isNumeric(idLev)) {
                        $("#tr_" + idLev + " td:nth-child(3)").html(id);
                        $("#tr_" + idLev + " td:nth-child(4)").html(name);
                        success_toast("Level has been updated successfully.");
                        idLev = "";
                        setInterval('location.reload()', 5000);
                    } else {
                        success_toast("Level has been inserted successfully.");
                        location.reload();
                    }
                } else if (data['error']) {
                    if ($.isNumeric(idLev)) {
                        error_toast("Error while updating level.");
                        idLev = "";
                    } else {
                        error_toast("Error while inserting level.");
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

$('#addLevel').on('click', function(e) {
    e.preventDefault();
    $("#editLevelLabel").html("Add Level");
    document.getElementById("recipient-id").value = "";
    document.getElementById("recipient-name").value = "";
    $("#btnAction").html("Add");
    $("#editLevel").modal('show');
});

function success_toast(message) {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
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
        "progressBar": false,
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