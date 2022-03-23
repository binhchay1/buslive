$(document).ready(function () {

    $('#editModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget)
        let id = button.data('id');
        let name = button.data('name');
        let license = button.data('license');
        let name_type = button.data('name_type');
        let seat = button.data('seat');
        let path_of_img = button.data('path_of_img');
        let textSrc = path_of_img.split('/');
        let modal = $(this); 
        $('#area-img-edit-bus').attr('class', '');
        $('#area-img-edit-bus').attr('class', 'd-flex');
        $('#img-for-edit-bus').attr('src', path_of_img);
        let attr = $('#img_edit').attr('required');
        if(typeof attr !== 'undefined' && attr !== false) {
            $('#img_edit').removeAttr('required');
        }
    
        modal.find('.modal-body #id_edit').val(id);
        modal.find('.modal-body #name_edit').val(name);
        modal.find('.modal-body #license_plate_edit').val(license);
        modal.find('.modal-body #name_type_edit').val(name_type);
        modal.find('.modal-body #seat_edit').val(seat);
        modal.find('.modal-body #text-img-bus-edit').text(textSrc[3]);
        
    });

    $('#deleteModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget)
        let id = button.data('id');
        let modal = $(this);

        $.ajax({
            url: '/admin/checkdeletebus',
            data: {
                id: id,
            },
            type: 'GET'
        }).done(function (response) {
            if (response == 0) {
                document.getElementById('text_delete_bus').innerHTML = '';
                document.getElementById('text_delete_bus').innerHTML = 'Bạn chắc chắn muốn xóa ?';
                document.getElementById('delete_bus').disabled = false;
                modal.find('.modal-body #id_delete').val(id);
            } else {
                document.getElementById('text_delete_bus').innerHTML = '';
                document.getElementById('text_delete_bus').innerHTML = 'Xe này bạn không thể xóa vì đang thuộc 1 tuyến đường đang chạy';
                document.getElementById('delete_bus').disabled = true;
            }
        });
    });


});

function search() {
    var input, filter, table, tr, td, i;
    input = document.getElementById("bus_search");
    filter = input.value.toUpperCase();
    table = document.getElementById("bus_table");
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

function editImageBus() {
    $('#area-img-edit-bus').attr('class', '');
    $('#area-img-edit-bus').attr('class', 'd-none');
    $('#img_edit').attr('class', '');
    $('#img_edit').attr('class', 'form-control');
    $('#img_edit').attr('required');
}
