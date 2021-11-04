var idGarageTo = 0;
var roadId = 0;

$(document).ready(function () {
    setRoad();
    setStation();

    $('#from').on('change', function () {
        setRoad();
    });
});

function setRoad() {
    let from = document.getElementById("from");
    let garage_id = from.options[from.selectedIndex].value;
    let to = document.getElementById("to");

    for (i of road) {
        if (garage_id == i.garages_id_first) {
            idGarageTo = i.garages_id_second;
            roadId = i.id;
            break;
        }

        if (garage_id == i.garages_id_second) {
            idGarageTo = i.garages_id_first;
            roadId = i.id;
            break;
        }
    }

    for (i of garagesTo) {
        if (idGarageTo == i.id) {
            to.value = i.name_garage;
        }
    }
}

function setStation() {

    for (i of station) {
        if (roadId == i.roads_id) {
            $("#station_from").append("<option value='" + i.id + "'>" + i.name + "</option>");
            $("#station_to").append("<option value='" + i.id + "'>" + i.name + "</option>");
        }
    }
}

function setSet() {
    for (i = 1; i <= 45; i++) {
        if (i == 20) {
            $("#bus-seat").append("<button id='seat-in-bus-" + i + "' type='button' class='seat m-3' data-toggle='tooltip' data-placement='top' title=''>" + i + "</button><br>");        
        }
    }
}