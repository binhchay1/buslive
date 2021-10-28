$(document).ready(function () {

    $('#editModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget)
        let id = button.data('id');
        let name = button.data('name');
        let phone = button.data('phone');
        let address = button.data('address');
        let modal = $(this);

        modal.find('.modal-body #id_edit').val(id);
        modal.find('.modal-body #name_edit').val(name);
        modal.find('.modal-body #phone_edit').val(phone);
        modal.find('.modal-body #address_edit').val(address);

    });

    $('#deleteModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget)
        let id = button.data('id');
        let modal = $(this);

        modal.find('.modal-body #id_delete').val(id);
    });
});