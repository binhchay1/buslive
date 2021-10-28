$(document).ready(function () {

    $('#editModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget)
        let id = button.data('id');
        let name = button.data('name');
        let phone = button.data('phone');
        let address = button.data('address');
        let city = button.data('city');
        let modal = $(this);

        modal.find('.modal-body #id_edit').val(id);
        modal.find('.modal-body #name_edit').val(name);
        modal.find('.modal-body #phone_edit').val(phone);
        modal.find('.modal-body #address_edit').val(address);
        modal.find('.modal-body #list-city').val(city);
    });

    $('#deleteModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget)
        let id = button.data('id');
        let modal = $(this);

        modal.find('.modal-body #id_delete').val(id);
    });
});