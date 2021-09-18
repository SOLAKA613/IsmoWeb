$(document).ready(function() {

    $('#DataTrainer').submit(function(e) {
        e.preventDefault();
        console.log("division: " + division + " level: " + level + " module: " + module1);
        let token = $('input[name="_token"]').val();
        $.ajax({
            url: "moduleTrainerController/show",
            type: 'GET',
            data: {
                division: division,
                level: level,
                module: module1,
                _token: token
            },
            success: function(data) {
                if (data['success']) {
                    alert(data['success']);
                } else if (data['error']) {
                    error_toast("Error while send data.");
                } else {
                    error_toast('Whoops Something went wrong!!');
                }
            },
            error: function(data) {
                alert(data.responseText);
            }
        });
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



});