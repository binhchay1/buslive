var idGarageTo = 0;
var roadId = 0;
var from = document.getElementById("from");
var to = document.getElementById("to");
var station_from = document.getElementById("station_from");
var station_to = document.getElementById("station_to");
var cost_from = 0;
var cost_to = 0;
var seat_number = 0;
var dataTime = [];
var ticket_code = '';
var ticket_cost = 0;

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
        setTicket();
        getCost();
    });

    $('#station_from').on('change', function () {
        let station_from_id = station_from.options[station_from.selectedIndex].value;
        let station_to_id = station_to.options[station_to.selectedIndex].value;
        getTimeOfBus('station', station_from_id, station_to_id);
        setTicket();
        getCost();
    });

    $('#station_to').on('change', function () {
        let station_from_id = station_from.options[station_from.selectedIndex].value;
        let station_to_id = station_to.options[station_to.selectedIndex].value;
        getTimeOfBus('station', station_from_id, station_to_id);
        setTicket();
        getCost();
    });

    $('#time_go').on('change', function () {
        setTicket();
        disableSeat();
        getCost();
    });

    ticket_code = makeCode(30);
    getCost()
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
            document.getElementById('to_number').value = i.id;
        }
    }
}

function setStation() {
    let obj1 = road.find(o => o.id == roadId);
    for (i of station) {
        if (roadId == i.roads_id) {
            if (obj1.garages_id_first == from.value) {
                if (i.cost_first > (obj1.cost) / 2) {
                    $("#station_to").append("<option value='" + i.id + "'>" + i.name + "</option>");
                }

                if (i.cost_first < (obj1.cost) / 2) {
                    $("#station_from").append("<option value='" + i.id + "'>" + i.name + "</option>");
                }
                continue;
            }

            if (obj1.garages_id_second == from.value) {
                if (i.cost_second > (obj1.cost) / 2) {
                    $("#station_from").append("<option value='" + i.id + "'>" + i.name + "</option>");
                }

                if (i.cost_second < (obj1.cost) / 2) {
                    $("#station_to").append("<option value='" + i.id + "'>" + i.name + "</option>");
                }
            }
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
            $("#alert-ticket").text("2 Điểm dừng không thể giống nhau!");
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
            dataTime = [];
            $("#time_go option").remove();
            let count = 1;
            for (i of res['bus']) {
                dataTime.push(i)
                if (i.roads_id == roadId) {
                    if (type == 'nonStation') {
                        cost_from = 0;;
                        cost_to = 0;
                        $("#time_go").append("<option value='" + i.time_go + "' id='time_selection_" + count + "'>" + i.time_go + "</option>");
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
                            $("#time_go").append("<option value='" + timeStart + "' id='time_selection_" + count + "'>" + timeStart + "</option>");
                        }

                        if (typeof cost_from === 'undefined' && typeof cost_to !== 'undefined') {
                            let totalTime = convertH2M(i.time_arrival) - convertH2M(i.time_go);
                            let timePerCost = totalTime / i.cost;
                            let timeStartFloat = convertM2H(convertH2M(i.time_go) + timePerCost * cost_to);
                            let timeStart = timeStartFloat.split(".")[0];
                            $("#time_go").append("<option value='" + timeStart + "' id='time_selection_" + count + "'>" + timeStart + "</option>");
                        }

                        if (typeof cost_from !== 'undefined' && typeof cost_to !== 'undefined') {
                            let totalTime = convertH2M(i.time_arrival) - convertH2M(i.time_go);
                            let timePerCost = totalTime / i.cost;
                            let timeStartFloat = convertM2H(convertH2M(i.time_go) + timePerCost * cost_from);
                            let timeStart = timeStartFloat.split(".")[0];
                            $("#time_go").append("<option value='" + timeStart + "' id='time_selection_" + count + "'>" + timeStart + "</option>");
                        }
                    }
                }
                count++;
            }

            setTicket();
            disableSeat();
        }
    });
}

function setSet() {
    for (i = 1; i <= 40; i++) {
        if (i == 10 || i == 20 || i == 30) {
            $("#bus-seat").append("<button id='seat-in-bus-"
                + i + "' type='button' class='seat' data-toggle='tooltip' data-placement='top' onClick='setNumberSeat(this.id)'>"
                + i + "</button><span id='seat-back-"
                + i + "'></span><br>");
        } else {
            $("#bus-seat").append("<button id='seat-in-bus-"
                + i + "' type='button' class='seat' data-toggle='tooltip' data-placement='top' onClick='setNumberSeat(this.id)'>"
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

function setTicket() {

    let station_from_text = station_from.options[station_from.selectedIndex].text;
    let station_to_text = station_to.options[station_to.selectedIndex].text;
    let garage_from = from.options[from.selectedIndex].text;
    let garage_to = to.value;

    if (station_from_text == 'trống') {
        document.getElementById('location-ticket-from').innerHTML = garage_from;
        document.getElementById('place-from-ticket').value = garage_from;
    } else {
        document.getElementById('location-ticket-from').innerHTML = station_from_text;
        document.getElementById('place-from-ticket').value = station_from_text;
    }

    if (station_to_text == 'trống') {
        document.getElementById('location-ticket-to').innerHTML = garage_to;
        document.getElementById('place-to-ticket').value = garage_to;
    } else {
        document.getElementById('location-ticket-to').innerHTML = station_to_text;
        document.getElementById('place-to-ticket').value = station_to_text;
    }

    let time_ticket = document.getElementById('time_go').options[document.getElementById('time_go').selectedIndex].text;
    document.getElementById('time-ticket').innerHTML = time_ticket;
    document.getElementById('date-ticket').innerHTML = document.getElementById('date_create_ticket').innerHTML;

    let selected_option_time = $('#time_go option:selected').attr("id");
    let slice_option_time = selected_option_time.slice(15);
    let dataForBusTicket = dataTime[slice_option_time - 1];

    document.getElementById('bus-ticket').innerHTML = dataForBusTicket.name;
    document.getElementById('name-of-bus-ticket').value = dataForBusTicket.name;
    document.getElementById('license-plate-ticket').innerHTML = dataForBusTicket.license_plate;
    document.getElementById('license-plate-of-bus-ticket').value = dataForBusTicket.license_plate;
    document.getElementById('code-ticket').innerHTML = ticket_code;
    document.getElementById('hidden-code-ticket').value = ticket_code;
    document.getElementById('hidden-bus-id-ticket').value = dataForBusTicket.id;
}

function setNumberSeat(id) {
    let number = document.getElementById(id).textContent;
    document.getElementById('seat-ticket').innerHTML = number;
    document.getElementById('hidden-seat-ticket').value = number;
}

function makeCode(length) {
    var result = '';
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() *
            charactersLength));
    }

    if (ticket.length == 0) {
        return result;
    } else {
        for (z of ticket) {
            if (result === z.code) {
                makeCode(30);
            } else {
                return result;
            }
        }

    }
}

function disableSeat() {
    let time_ticket = document.getElementById('time_go').options[document.getElementById('time_go').selectedIndex].text;
    let from_disable = document.getElementById("from").value;
    let to_disable = document.getElementById("to_number").value;

    for (c = 1; c <= 45; c++) {
        let id_enable = 'seat-in-bus-' + c;
        document.getElementById(id_enable).disabled = false;
        document.getElementById(id_enable).style.backgroundColor = "white";
        document.getElementById(id_enable).removeAttribute("title");
    }

    for (x of disable_seat) {
        if (time_ticket === x.time_go && from_disable == x.from && to_disable == x.to) {
            let id_disable = 'seat-in-bus-' + x.seat;
            document.getElementById(id_disable).disabled = true;
            document.getElementById(id_disable).style.backgroundColor = "#E7E9EB";
            document.getElementById(id_disable).setAttribute("title", "Chỗ đã được đặt!");
        }
    }
    autoTakeSeat();
}

function autoTakeSeat() {
    for (b = 1; b <= 45; b++) {
        let id_disable_button = 'seat-in-bus-' + b;
        if (document.getElementById(id_disable_button).disabled) {
            continue;
        }

        document.getElementById('seat-ticket').innerHTML = b;
        document.getElementById('hidden-seat-ticket').value = b;
        break;
    }
}

function getCost() {
    let from = document.getElementById("from").value;
    let to = document.getElementById("to_number").value;
    let station_from = document.getElementById("station_from").value;
    let station_to = document.getElementById("station_to").value;

    for (m of road) {
        if (station_from == 0 && station_to == 0) {
            if ((m.garages_id_first == from && m.garages_id_second == to) || (m.garages_id_first == to && m.garages_id_second == from)) {
                ticket_cost = m.cost;
                break;
            }
        }

        if (station_from > 0 && station_to == 0) {
            if ((m.garages_id_first == from && m.garages_id_second == to) || (m.garages_id_first == to && m.garages_id_second == from)) {
                let obj1 = station.find(k => k.id == station_from);
                ticket_cost = obj1.cost_second;
                break;
            }
        }

        if (station_from == 0 && station_to > 0) {
            if ((m.garages_id_first == from && m.garages_id_second == to) || (m.garages_id_first == to && m.garages_id_second == from)) {
                let obj1 = station.find(p => p.id == to);
                ticket_cost = obj1.cost_second;
                break;
            }
        }

        if (station_from > 0 && station_to > 0) {
            if ((m.garages_id_first == from && m.garages_id_second == to) || (m.garages_id_first == to && m.garages_id_second == from)) {
                let obj1 = station.find(l => l.id == station_from);
                let obj2 = station.find(l => l.id == station_to);
                ticket_cost = obj1.cost_second - obj2.cost_second;
                break;
            }
        }
    }

    document.getElementById("hidden-cost-ticket").value = ticket_cost;
    document.getElementById("cost-ticket").innerHTML = ticket_cost + ' đ';
}