$(document).ready(function() {
    $(function() {
        let dtToday = new Date();

        let month = dtToday.getMonth() + 1;
        let day = dtToday.getDate();
        let year = dtToday.getFullYear();
        if (month < 10)
            month = '0' + month.toString();
        if (day < 10)
            day = '0' + day.toString();

        let maxDate = year + '-' + month + '-' + day;;
        $('#txtDateWelcome').attr('min', maxDate);
        $('#txtDateWelcome').attr('value', maxDate);

        $('[data-toggle="tooltip"]').tooltip();

        $("#alert-success").fadeTo(2000, 500).slideUp(500, function() {
            $("#alert-success").slideUp(500);
            $("#alert-success").removeClass("d-block").addClass("d-none");
        });
    });
});

function bookTicketNow() {
    document.documentElement.scrollTop = 10;
}

function bookTicketWelcome() {
    let from = document.getElementById("ticket-from-welcome");
    let textFrom = from.options[from.selectedIndex].text;
    let to = document.getElementById("ticket-to-welcome");
    let textTo = to.options[to.selectedIndex].text;
    let date = document.getElementById("txtDateWelcome");

    if (textFrom == textTo) {
        error = 'Điểm đến và điểm đi giống nhau!';
        document.getElementById("error-book-welcome").innerHTML = error;
        $("#book-ticket").click(function(e) {
            e.stopPropagation();
        })
        return;
    }

    let url = '/ticket?from=' + textFrom + '&to=' + textTo + '&date=' + date.value;

    window.location.replace(url);
}