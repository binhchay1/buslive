$(document).ready(function () {

    $('#editModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget)
        let id = button.data('id');
        let name = button.data('name');
        let address = button.data('address');
        let city = button.data('city');
        let modal = $(this);

        modal.find('.modal-body #id_edit').val(id);
        modal.find('.modal-body #name_edit').val(name);
        modal.find('.modal-body #address_edit').val(address);
        modal.find('.modal-body #list-city').val(city);
    });

    $('#deleteModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget)
        let id = button.data('id');
        let modal = $(this);

        $.ajax({
            url: '/admin/checkdeletestation',
            data: {
                id: id
            },
            type: 'GET'
        }).done(function (response) {
            if (response == true) {
                document.getElementById('text_delete_station').innerHTML = '';
                document.getElementById('text_delete_station').innerHTML = 'Bạn chắc chắn muốn xóa ?';
                document.getElementById('delete_station').disabled = false;
                modal.find('.modal-body #id_delete').val(id);
            } else {
                document.getElementById('text_delete_station').innerHTML = '';
                document.getElementById('text_delete_station').innerHTML = 'Điểm bến này bạn không thể xóa vì đang thuộc 1 tuyến đường đang chạy';
                document.getElementById('delete_station').disabled = true;
            }
        });
        
    });

});

function search() {
    var input, filter, table, tr, td, i;
    input = document.getElementById("station_search");
    filter = input.value.toUpperCase();
    table = document.getElementById("station_table");
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

