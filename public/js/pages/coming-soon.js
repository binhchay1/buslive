$(document).ready(function () {

    $("#send-mail-only").submit(function (e) {

        e.preventDefault();

        let form = $(this);
        let url = '/sendmailonly'

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: url,
            data: form.serialize(),
            success: function (data) {
                if (data == 'success') {
                    $("#alert-thank").removeClass("d-none").addClass("d-block");
                    $("#alert-thank").fadeTo(2000, 500).slideUp(500, function () {
                        $("#alert-thank").slideUp(500);
                        $("#alert-thank").removeClass("d-block").addClass("d-none");
                    });
                }
            }
        });
    });
});