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

