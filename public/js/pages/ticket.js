$(document).ready(function () {
    $(function () {
        let localtion = window.location.href;
        let url = new URL(localtion);
        let timeGeted = url.searchParams.get("date");
        
        let dtToday = new Date(timeGeted);

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

        $("#alert-success").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert-success").slideUp(500);
            $("#alert-success").removeClass("d-block").addClass("d-none");
        });
    });
});

function bookTicketWelcome() {
    let from = document.getElementById("ticket-from-welcome");
    let textFrom = from.options[from.selectedIndex].text;
    let to = document.getElementById("ticket-to-welcome");
    let textTo = to.options[to.selectedIndex].text;
    let date = document.getElementById("txtDateWelcome");

    if (textFrom == textTo) {
        error = 'Điểm đến và điểm đi giống nhau!';
        document.getElementById("error-book-welcome").innerHTML = error;
        $("#book-ticket").click(function (e) {
            e.stopPropagation();
        })
        return;
    }

    let url = '/ticket?from=' + textFrom + '&to=' + textTo + '&date=' + date.value;

    window.location.replace(url);
}

function takeTrips(tripsId) {
    let tripsSelected = [];

    for (let i = 0; i < trips.length; i++) {
        if (trips[i].id == tripsId) {
            tripsSelected = trips[i];
        }
    }

    let date = new Date();
    let time = date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
    let time_plus = date.getHours() + 1;
    let time_exp = time_plus + ":" + date.getMinutes() + ":" + date.getSeconds();
    let buy_date = tripsSelected.date + ' ' + time;
    let exp_date = tripsSelected.date + ' ' + time_exp;

    document.getElementById('header-modal-trips').innerHTML = tripsSelected.name_garages;
    // document.getElementById('bus').innerHTML = tripsSelected.bus_name;
    document.getElementById('license_plate').innerHTML = tripsSelected.license_plate;
    document.getElementById('roads').innerHTML = tripsSelected.nameRoad;
    document.getElementById('start').innerHTML = tripsSelected.start;
    document.getElementById('end').innerHTML = tripsSelected.end;
    document.getElementById('cost').innerHTML = tripsSelected.cost + ' VNĐ';
    document.getElementById('name_type').innerHTML = tripsSelected.name_type;
    // document.getElementById('driver').innerHTML = tripsSelected.driver;
    // document.getElementById('driver_mate').innerHTML = tripsSelected.driver_mate;
    document.getElementById('stock').innerHTML = tripsSelected.stock;

    document.getElementById('trips_id').value = tripsSelected.id;
    document.getElementById('hidden_name').value = tripsSelected.name;
    document.getElementById('hidden_bus').value = tripsSelected.bus_name;
    document.getElementById('hidden_license_plate').value = tripsSelected.license_plate;
    document.getElementById('hidden_roads').value = tripsSelected.nameRoad;
    document.getElementById('hidden_start').value = tripsSelected.start;
    document.getElementById('hidden_end').value = tripsSelected.end;
    document.getElementById('hidden_cost').value = tripsSelected.cost;
    document.getElementById('hidden_driver').value = tripsSelected.driver;
    document.getElementById('hidden_driver_mate').value = tripsSelected.driver_mate;
    document.getElementById('hidden_date').value = tripsSelected.date;
    document.getElementById('hidden_exp_date').value = exp_date;
    document.getElementById('hidden_buy_date').value = buy_date;

    $('#list-station-of-roads').empty();
    for (let x = 0; x < tripsSelected.estimate.length; x++) {
        let content = "<li class='list-group-item'>" + tripsSelected.estimate[x].station + " - " + tripsSelected.estimate[x].estimate;
        $('#list-station-of-roads').append(content);
    }

    $('#bookModal').modal('show');
}

