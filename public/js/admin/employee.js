$(document).ready(function () {

    $('#editModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget)
        let id = button.data('id');
        let name = button.data('name');
        let email = button.data('email');
        let role = button.data('role');
        let garages = button.data('garages');
        let modal = $(this);

        modal.find('.modal-body #id_edit').val(id);
        modal.find('.modal-body #name_edit').val(name);
        modal.find('.modal-body #email_edit').val(email);

        $("#role_edit").val(role);
        $("#garages_edit").val(garages);
    });

    $('#deleteModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget)
        let id = button.data('id');
        let modal = $(this);

        modal.find('.modal-body #id_delete').val(id);
        modal.find('.modal-body #name_delete').text(name);
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

