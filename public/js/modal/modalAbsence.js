var editModal = document.getElementById('editAbsence')
var deleteModal = document.getElementById('deleteAbsence');
var viewModal = document.getElementById('viewAbsence');
var idAbs;
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
    idAbs = myobj["id"];
    $("#btnAction").html("Update");

    modalTitle.textContent = myobj.name + "\'s information"
    document.getElementById("recipient-id").value = myobj["id"];
    document.getElementById("recipient-type").value = myobj["type"];
    document.getElementById("recipient-remark").value = myobj["remark"];
    document.getElementById("recipient-firstTimeAbsence").value = moment(myobj["first_date_time"]).format('YYYY-MM-DDTHH:mm');
    document.getElementById("recipient-lastTimeAbsence").value = moment(myobj["last_date_time"]).format('YYYY-MM-DDTHH:mm');

})

deleteModal.addEventListener('show.bs.modal', function(event) {
    // Button that triggered the modal
    var button = event.relatedTarget
        // Extract info from data-bs-* attributes
    var recipient = button.getAttribute('data-bs-whatever');
    var myobj = JSON.parse(recipient);
    idDel = myobj["id"];

})

viewModal.addEventListener('show.bs.modal', function(event) {
    // Button that triggered the modal
    var button = event.relatedTarget
        // Extract info from data-bs-* attributes
    var recipient = button.getAttribute('data-bs-whatever');
    var myobj = JSON.parse(recipient);

    var id = $("#idAbsence");
    var type = $("#type");
    var remark = $("#remark");
    var firstTime = $("#first_time");
    var lastTime = $("#last_time");

    id.text(myobj["id"]);
    type.text(myobj["type"]);
    remark.text(myobj["remark"]);
    firstTime.text(myobj["first_date_time"]);
    lastTime.text(myobj["last_date_time"]);
});

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
        $('#deleteAllAbsences').modal('show');
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
            $("#deleteAllAbsences").modal('hide');
            if (data['success']) {
                $(".sub_chk:checked").each(function() {
                    $("#tr_" + value).remove();
                });
                success_toast("Absences information has been deleted successfully.");
                setInterval('location.reload()', 5000);
            } else if (data['error']) {
                error_toast("Error while deleting absences information.");
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

$('.deleteAbs').on('click', function(e) {
    $.ajax({
        url: 'deleteAbsence',
        type: 'GET',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: 'id=' + idDel,
        success: function(data) {
            console.log(idDel);
            $("#deleteAbsence").modal('hide');
            if (data['success']) {
                $("#tr_" + idDel).remove();
                success_toast("Absence information has been deleted successfully.");
                setInterval('location.reload()', 5000);
            } else if (data['error']) {
                error_toast("Error while deleting absence information.");
            } else {
                error_toast('Whoops Something went wrong!!');
            }
        },
        error: function(data) {
            alert(data.responseText);
        }
    });
});


$('#updateAbsence').submit(function(e) {
    e.preventDefault();
    var id = $("#recipient-id").val();
    var type = $("#recipient-type").val();
    var remark = $("#recipient-remark").val();
    var first_date = $("#recipient-firstTimeAbsence").val();
    var last_date = $("#recipient-lastTimeAbsence").val();
    let token = $('input[name="_token"]').val();

    if (id == "") {
        error_toast("Code Absence is required");
    }
    if (type == "") {
        error_toast("Type is required");
    }
    if (remark == "") {
        error_toast("Remark is required");
    }
    if (first_date == "") {
        error_toast("First date is required");
    }
    if (last_date == "") {
        error_toast("Last date is required");
    }
    if (id != "" && type != "" && remark != "" && first_date != "" && last_date != "") {
        console.log(id + " " + type);
        $.ajax({
            url: "updateAbsence",
            type: 'GET',
            data: {
                code: id,
                idAbs: idAbs,
                type: type,
                remark: remark,
                first_date_time: first_date,
                last_date_time: last_date,
                _token: token
            },
            success: function(data) {
                idAbs = "";
                $("#editAbsence").modal('hide');
                if (data['success']) {
                    if ($.isNumeric(idAbs)) {
                        $("#tr_" + idAbs + " td:nth-child(3)").html(id);
                        $("#tr_" + idAbs + " td:nth-child(4)").html(type);
                        $("#tr_" + idAbs + " td:nth-child(5)").html(first_date);
                        $("#tr_" + idAbs + " td:nth-child(6)").html(last_date);
                        success_toast("Absence has been updated successfully.");

                        setInterval('location.reload()', 5000);
                    } else {
                        success_toast("Absence has been inserted successfully.");
                        location.reload();
                    }
                } else if (data['error']) {
                    if ($.isNumeric(idAbs)) {
                        error_toast("Error while updating absence." + data['error']);
                    } else {
                        error_toast("Error while inserting absence. " + data['error']);
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

$('#addAbsence').on('click', function(e) {
    e.preventDefault();
    $("#editAbsenceLabel").html("Add Absence");
    var recepient_firstTime = $("#recipient-firstTimeAbsence");
    var recepient_lastTime = $("#recipient-lastTimeAbsence");
    var recepient_id = $("#recipient-id");
    var recepient_type = $("#recipient-type");
    var recepient_remark = $("#recipient-remark");

    document.getElementById("recipient-id").value = "";
    document.getElementById("recipient-type").value = "";
    document.getElementById("recipient-remark").value = "";
    document.getElementById("recipient-firstTimeAbsence").value = "";
    document.getElementById("recipient-lastTimeAbsence").value = "";

    $("#btnAction").html("Add");
    $("#editAbsence").modal('show');
    $("#btn").show();
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