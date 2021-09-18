var exampleModal = document.getElementById('exampleModal');
var id = "";
var array;
exampleModal.addEventListener('show.bs.modal', function(event) {
    // Button that triggered the modal
    var button = event.relatedTarget
        // Extract info from data-bs-* attributes
    var recipient = button.getAttribute('data-bs-whatever')
    var myobj = JSON.parse(recipient);
    // If necessary, you could initiate an AJAX request here
    // and then do the updating in a callback.
    // Update the modal's content.
    var modalTitle = exampleModal.querySelector('.modal-title');
    id = myobj["id"];

    modalTitle.textContent = myobj.first_name + "\'s information"
    document.getElementById("recipient-id").innerHTML = myobj["id"];
    document.getElementById("recipient-firstname").innerHTML = myobj["first_name"];
    document.getElementById("recipient-lastname").innerHTML = myobj["last_name"];
    document.getElementById("recipient-age").innerHTML = myobj["age"];
    document.getElementById("recipient-gender").innerHTML = myobj["gender"];
    document.getElementById("recipient-email").innerHTML = myobj["email"];

    let mountains = ["Module", "Level", "Division"];

    sendData();
    for (let i = 0; i < array.length; i++) {
        console.log(array[i]);
    }

    let table = document.querySelector("#myTableJS");
    removeTable();
    generateTableHead(table, mountains);
    generateTable(table, array);

})

function generateTableHead(table, data) {
    let thead = table.createTHead();
    let row = thead.insertRow();
    row.classList.add("table-dark");
    for (let key of data) {
        let th = document.createElement("th");
        let text = document.createTextNode(key);
        th.appendChild(text);
        row.appendChild(th);
    }
}

function generateTable(table, data) {
    for (let element of data) {
        let row = table.insertRow();
        var tab = element.split(",");
        for (key in tab) {
            let cell = row.insertCell();
            let text = document.createTextNode(tab[key]);
            cell.appendChild(text);
        }
    }
}

function removeTable() {
    let table = document.querySelector("#myTableJS");
    table.deleteTHead();
}

function sendData() {
    $.ajax({
        url: "listData",
        async: false,
        type: 'GET',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: 'id=' + id,
        success: function(data) {
            if (data['success']) {
                array = data['success'];
            } else if (data['error']) {
                error_toast(data['error']);
            } else {
                error_toast('Whoops Something went wrong!!');
            }
        },
        error: function(data) {
            alert(data.responseText);
        }
    });
}


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
            $('#deleteAllTrainer').modal('show');
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
                $("#deleteAllTrainer").modal('hide');
                if (data['success']) {
                    $(".sub_chk:checked").each(function() {
                        $("#tr_" + value).remove();
                    });
                    success_toast("Trainers information has been deleted successfully.");
                    setInterval('location.reload()', 5000);
                } else if (data['error']) {
                    error_toast("Error while deleting trainers information.");
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