var idGarageTo = 0;
var roadId = 0;
var from = document.getElementById("from");
var to = document.getElementById("to");
var station_from = document.getElementById("station_from");
var station_to = document.getElementById("station_to");
var cost_from = 0;
var cost_to = 0;

$(document).ready(function () {
    setRoad();
    setStation();
    getTimeOfBus('nonStation', 0, 0);
    setSet();
    addStyle();

    $('#from').on('change', function () {
        setRoad();
        let station_from_id = station_from.options[from.selectedIndex].value;
        let station_to_id = station_to.options[from.selectedIndex].value;
        getTimeOfBus('nonStation', station_from_id, station_to_id);
    });

    $('#station_from').on('change', function () {

        let station_from_id = station_from.options[station_from.selectedIndex].value;
        let station_to_id = station_to.options[station_to.selectedIndex].value;

        getTimeOfBus('station', station_from_id, station_to_id);
    });

    $('#station_to').on('change', function () {

        let station_from_id = station_from.options[station_from.selectedIndex].value;
        let station_to_id = station_to.options[station_to.selectedIndex].value;

        getTimeOfBus('station', station_from_id, station_to_id);
    });
});

function setRoad() {
    let garage_id = from.options[from.selectedIndex].value;

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

function getTimeOfBus(type, stationIdFrom, stationIdTo) {
    if (stationIdFrom == 0 && stationIdTo == 0) {
        type = 'nonStation';
    }

    if (!(stationIdFrom.toString() == '0') && !stationIdTo.toString() == '0') {
        if (stationIdFrom == stationIdTo) {
            $("#alert-ticket").removeClass("d-none").addClass("d-block");
            $("#alert-ticket").text("Station From is same place with Station To!");
            $("#alert-ticket").fadeTo(2000, 500).slideUp(500, function () {
                $("#alert-ticket").slideUp(500);
                $("#alert-ticket").removeClass("d-block").addClass("d-none");
            });
            return;
        }
    }

    $.ajax({
        url: '/gettime?roads_id=' + roadId + '&station_id_from=' + stationIdFrom + '&station_id_to=' + stationIdTo,
        type: 'GET',
        success: function (res) {
            $("#time_go option").remove();
            for (i of res['bus']) {
                if (i.roads_id == roadId) {
                    if (type == 'nonStation') {
                        cost_from = 0;;
                        cost_to = 0;
                        $("#time_go").append("<option value='" + i.time_go + "'>" + i.time_go + "</option>");
                    } else {
                        let garage_id = from.options[from.selectedIndex].value;

                        if (res['station_from']) {
                            if (res['station_from'].garages_id_first == garage_id) {
                                cost_from = res['station_from'].cost_first;
                            }
                            if (res['station_from'].garages_id_second == garage_id) {
                                cost_from = res['station_from'].cost_second;
                            }
                        }

                        if (res['station_to']) {
                            if (res['station_to'].garages_id_first == garage_id) {
                                cost_to = res['station_to'].cost_first;
                            }
                            if (res['station_to'].garages_id_second == garage_id) {
                                cost_to = res['station_to'].cost_second;
                            }
                        }

                        if (typeof cost_from !== 'undefined' && typeof cost_to === 'undefined') {
                            let totalTime = convertH2M(i.time_arrival) - convertH2M(i.time_go);
                            let timePerCost = totalTime / i.cost;
                            let timeStartFloat = convertM2H(convertH2M(i.time_go) + timePerCost * cost_from);
                            let timeStart = timeStartFloat.split(".")[0];
                            $("#time_go").append("<option value='" + timeStart + "'>" + timeStart + "</option>");
                        }

                        if (typeof cost_from === 'undefined' && typeof cost_to !== 'undefined') {
                            let totalTime = convertH2M(i.time_arrival) - convertH2M(i.time_go);
                            let timePerCost = totalTime / i.cost;
                            let timeStartFloat = convertM2H(convertH2M(i.time_go) + timePerCost * cost_to);
                            let timeStart = timeStartFloat.split(".")[0];
                            $("#time_go").append("<option value='" + timeStart + "'>" + timeStart + "</option>");
                        }

                        if (typeof cost_from !== 'undefined' && typeof cost_to !== 'undefined') {
                            let totalTime = convertH2M(i.time_arrival) - convertH2M(i.time_go);
                            let timePerCost = totalTime / i.cost;
                            let timeStartFloat = convertM2H(convertH2M(i.time_go) + timePerCost * cost_from);
                            let timeStart = timeStartFloat.split(".")[0];
                            $("#time_go").append("<option value='" + timeStart + "'>" + timeStart + "</option>");
                        }
                    }
                }
            }
        }
    });
}

function setSet() {
    for (i = 1; i <= 40; i++) {
        if (i == 10 || i == 20 || i == 30) {
            $("#bus-seat").append("<button id='seat-in-bus-" 
            + i + "' type='button' class='seat' data-toggle='tooltip' data-placement='top' title=''>" 
            + i + "</button><span id='seat-back-" 
            + i + "'></span><br>");
        } else {
            $("#bus-seat").append("<button id='seat-in-bus-" 
            + i + "' type='button' class='seat' data-toggle='tooltip' data-placement='top' title=''>" 
            + i + "</button><span id='seat-back-" 
            + i + "'></span>");
        }
    }
}

function convertH2M(timeInHour) {
    let timeParts = timeInHour.split(":");
    return Number(timeParts[0]) * 60 + Number(timeParts[1]);
}

function convertM2H(timeInHour) {
    let hours = Math.floor(timeInHour / 60);
    let minutes = timeInHour % 60;
    if (hours < 10) {
        hours = '0' + hours;
    }
    if (minutes < 10) {
        minutes = '0' + minutes;
    }
    let string = hours + ':' + minutes;
    return string;
}

function float2int(value) {
    return value | 0;
}

function addStyle() {
    for (let i = 1; i <= 40; i++) {
        if (i <= 10) {
            let idSeat = 'seat-in-bus-' + i;
            let element = document.getElementById(idSeat);
            element.classList.add("mb-1");
            element.classList.add("mt-2");
            element.classList.add("ml-4");
            continue;
        }

        if (10 < i && i <= 20) {
            let idSeat = 'seat-in-bus-' + i;
            let element = document.getElementById(idSeat);
            element.classList.add("mb-4");
            element.classList.add("ml-4");
            continue;
        }

        if (20 < i && i <= 30) {
            let idSeat = 'seat-in-bus-' + i;
            let element = document.getElementById(idSeat);
            element.classList.add("mb-1");
            element.classList.add("ml-4");
            continue;
        }

        if (30 < i && i <= 40) {
            let idSeat = 'seat-in-bus-' + i;
            let element = document.getElementById(idSeat);
            element.classList.add("mb-2");
            element.classList.add("ml-4");
            continue;
        }
    }

}