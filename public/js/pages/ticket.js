var idGarageTo = 0;
var roadId = 0;

$(document).ready(function () {
    setRoad();
    setStation();
    getTimeOfBus();

    $('#from').on('change', function () {
        setRoad();
        getTimeOfBus('nonStation');
    });

    $('#station_from').on('change', function () {
        getTimeOfBus('station');
    });

    $('#station_to').on('change', function () {
        getTimeOfBus('station');
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

function getTimeOfBus(type) {
    $.ajax({
        url: '/gettime?roads_id=' + roadId,
        type: 'GET',
        success: function (res) {
            for (i of res) {
                if (i.roads_id == roadId) {
                    if (type == 'nonStation') {
                        $("#time_go").append("<option value='" + i.time_go + "'>" + i.time_go + "</option>");
                    } else {
                        i.time_go = 
                        $("#time_go").append("<option value='" + i.time_go + "'>" + i.time_go + "</option>");
                    }
                }
            }
        }
    });
}

function setSet() {
    for (i = 1; i <= 45; i++) {
        if (i == 20) {
            $("#bus-seat").append("<button id='seat-in-bus-" + i + "' type='button' class='seat m-3' data-toggle='tooltip' data-placement='top' title=''>" + i + "</button><br>");
        }
    }
}