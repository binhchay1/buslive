$(document).ready(function () {

    $('#editModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget)
        let id = button.data('id');
        let garage1 = button.data('garages_id_first');
        let garage2 = button.data('garages_id_second');
        let cost = button.data('cost');
        let modal = $(this);

        modal.find('.modal-body #id_edit').val(id);
        modal.find('.modal-body #cost').val(cost);

        $("#garage1_edit").val(garage1);
        $("#garage2_edit").val(garage2);
    });

    $('#deleteModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget)
        let id = button.data('id');
        let modal = $(this);

        modal.find('.modal-body #id_delete').val(id);
    });

});

function search() {
    var input, filter, table, tr, td, i;
    input = document.getElementById("employee_search");
    filter = input.value.toUpperCase();
    table = document.getElementById("employee_table");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        if (i == 0) {
            continue;
        }
        row = tr[i].getElementsByTagName("td");
        for (y = 0; y < row.length; y++) {
            td = row[y];
            text = td.innerHTML;
            if (text.indexOf('type="button"') == -1) {
                if (text.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                    break;
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
}

function validate(evt) {
    var theEvent = evt || window.event;

    if (theEvent.type === 'paste') {
        key = evt.clipboardData.getData('text/plain');
    } else {
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
    }
    var regex = /[0-9]|\./;
    if (!regex.test(key)) {
        theEvent.returnValue = false;
        if (theEvent.preventDefault) theEvent.preventDefault();
    }
}

