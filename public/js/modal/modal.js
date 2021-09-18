var exampleModal = document.getElementById('exampleModal')
exampleModal.addEventListener('show.bs.modal', function(event) {
    // Button that triggered the modal
    var button = event.relatedTarget
        // Extract info from data-bs-* attributes
    var recipient = button.getAttribute('data-bs-whatever')
    var myobj = JSON.parse(recipient);
    // If necessary, you could initiate an AJAX request here
    // and then do the updating in a callback.
    //
    // Update the modal's content.
    var modalTitle = exampleModal.querySelector('.modal-title')

    console.log("modalTitle" + myobj["id"]);

    modalTitle.textContent = myobj.first_name + "\'s information"
    document.getElementById("recipient-id").innerHTML = myobj["id"];
    document.getElementById("recipient-firstname").innerHTML = myobj["first_name"];
    document.getElementById("recipient-lastname").innerHTML = myobj["last_name"];
    document.getElementById("recipient-age").innerHTML = myobj["age"];
    document.getElementById("recipient-gender").innerHTML = myobj["gender"];
    document.getElementById("recipient-email").innerHTML = myobj["email"];
    document.getElementById("recipient-login").innerHTML = myobj["login"];
    document.getElementById("recipient-password").innerHTML = myobj["password"];

})

$(document).ready(function() {

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
            $('#deleteAllTrainee').modal('show');
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
                $("#deleteAllTrainee").modal('hide');
                if (data['success']) {
                    $(".sub_chk:checked").each(function() {
                        $("#tr_" + value).remove();
                    });
                    success_toast("Trainees information has been deleted successfully.");
                    setInterval('location.reload()', 5000);
                } else if (data['error']) {
                    error_toast("Error while deleting trainees information.");
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