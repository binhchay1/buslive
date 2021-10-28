$(document).ready(function () {

    $('#editModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget)
        let id = button.data('id');
        let role = button.data('role');
        let name = button.data('name');
        let phone = button.data('phone');
        let modal = $(this);

        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #role').val(role);
        modal.find('.modal-body #name').val(name);
        modal.find('.modal-body #phone').val(phone);
    });

    $('#deleteModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget)
        let id = button.data('id');
        let name = button.data('name');
        let modal = $(this);

        modal.find('.modal-body #id_delete').val(id);
        modal.find('.modal-body #name_delete').text(name);
    });
});

