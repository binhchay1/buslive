var selectedWeek = [];
var lastIndex = 0;
var currentMonth = 0;
var currentYear = 0;
var dataResponse = [];
var currentDate = '';
var currentStart = '';
var currentRepickBus = '';
var currentRepickStart = '';
var currentRepickDriver = '';
var currentRepickDriverMate = '';
var currentStock = 0;

$(document).ready(function () {
    setDefaultDate();

    if (roads.length > 0) {
        getDataStation(roads[0].id);
    }

    $('#add_customer_to_trips').click(function () {
        let tableBody = $("#buyers-table tbody");
        let getButtonGroup = $("#group-button-trips button");
        let buttonGroup = $("#group-button-trips");
        getButtonGroup.remove();

        let contentButton = '';
        let content = '';
        if (role == 2 || sub_role == 3) {
            contentButton = "<button type='button' class='btn btn-secondary mt-4' onclick='saveNewCustomer(3)' id='add_new_customer_to_table'>Lưu khách hàng</button><button type='button' class='btn btn-secondary mt-4 ml-4' data-dismiss='modal'>Đóng</button>";
            content = "<tr><td><input type='text' placeholder='Nhập tên khách hàng' id='name-new-customer' required><td><input type='text' placeholder='Nhập số điện thoại' id='phone-new-customer' required></td><td><input type='number' placeholder='Nhập số vé mua' id='ticket-new-customer' required></td><td>Chuyển khoản</td><td><input type='text' class='form-control' id='note-new-customer' required></td></tr>";
        } else {
            contentButton = "<button type='button' class='btn btn-secondary mt-4' onclick='saveNewCustomer(2)' id='add_new_customer_to_table'>Lưu khách hàng</button><button type='button' class='btn btn-secondary mt-4 ml-4' data-dismiss='modal'>Đóng</button>";
            content = "<tr><td><input type='text' placeholder='Nhập tên khách hàng' id='name-new-customer' required><td><input type='text' placeholder='Nhập số điện thoại' id='phone-new-customer' required></td><td><input type='number' placeholder='Nhập số vé mua' id='ticket-new-customer' required></td><td>Thanh toán trực tiếp</td><td><input type='text' class='form-control' id='note-new-customer' required></td></tr>";
        }

        tableBody.append(content);
        buttonGroup.append(contentButton);
        $('#text_new_customer').html('');
        $('#add_customer_to_trips').prop('disabled', true);
    });
});

function setDefaultDate() {
    if (lastChoiceMonth === null || lastChoiceYear === null) {
        let d = new Date();
        let year = d.getFullYear();
        let month = d.getMonth() + 1;
        currentYear = year;
        currentMonth = month;

        setTitleForDateTime(month, year, 'default');
    } else {
        currentYear = lastChoiceYear;
        currentMonth = lastChoiceMonth;
        setTitleForDateTime(lastChoiceMonth, lastChoiceYear, 'default');
    }
}

function getDaysInMonth(month, year) {

    let date = new Date(year, month, 1);
    let days = [];
    while (date.getMonth() === month) {
        days.push(moment(date).format('DD/MM'));
        date.setDate(date.getDate() + 1);
    }

    return days;
}

function setTextDateTime(week) {
    selectedWeek = week;
    let getTH = document.getElementsByTagName("th");
    let days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

    for (let i = 0; i < getTH.length; i++) {
        getTH[i].removeAttribute("data-target");
    }

    for (let i = 0; i < week.length; i++) {
        let cal = i + 1;
        let id = 'cal-th-' + cal;
        let getCurrentYear = week[i] + '/' + currentYear;

        let getDaySplice = getCurrentYear.slice(0, 2);
        let getMonthSplice = getCurrentYear.slice(3, 5);
        let getYearSplice = getCurrentYear.slice(6, 10);

        let d = new Date(getYearSplice, getMonthSplice - 1, getDaySplice);
        let dayName = days[d.getDay()];

        if (dayName == 'Sunday') {
            dayName = 'CN';
        }

        if (dayName == 'Monday') {
            dayName = 'T2';
        }

        if (dayName == 'Tuesday') {
            dayName = 'T3';
        }

        if (dayName == 'Wednesday') {
            dayName = 'T4';
        }

        if (dayName == 'Thursday') {
            dayName = 'T5';
        }

        if (dayName == 'Friday') {
            dayName = 'T6';
        }

        if (dayName == 'Saturday') {
            dayName = 'T7';
        }

        getTH[i].setAttribute("data-target", "#addModal");
        document.getElementById(id).innerHTML = '';
        document.getElementById(id).innerHTML = dayName + '<br>' + week[i];
    }

    if (week.length < 7) {
        for (let i = 1; i <= 7; i++) {
            if (i <= week.length) {
                continue;
            }
            let id = 'cal-th-' + i;
            document.getElementById(id).innerHTML = '';
        }
    }

    let roadsId = document.getElementById('selection-roads').value;

    getDataForTrips(selectedWeek, roadsId);
}

function changeCurrentWeek(type) {
    if (type == 'previous') {
        let cloneIndex = lastIndex - 1;
        if (cloneIndex == -1) {
            let currentM = currentMonth - 1;
            let currentY = 0;
            if (currentM == 0) {
                currentM = 12;
                currentY = currentYear - 1;
                currentYear = currentY;
                currentMonth = currentM;
            } else {
                currentY = currentYear;
                currentMonth = currentM;
            }
            lastIndex = 4;

            setTitleForDateTime(currentM, currentY, 'change');
        } else {
            let currentM = currentMonth;
            let currentY = currentYear;
            lastIndex = cloneIndex;

            setTitleForDateTime(currentM, currentY, 'change');
        }
    } else {
        let cloneIndex = lastIndex + 1;
        if (cloneIndex == 5) {
            let currentM = parseInt(currentMonth) + 1;
            let currentY = 0;
            if (currentM == 13) {
                currentM = 1;
                currentY = parseInt(currentYear) + 1;
                currentYear = currentY;
                currentMonth = currentM;
            } else {
                currentY = currentYear;
                currentMonth = currentM;
            }
            lastIndex = 0;

            setTitleForDateTime(currentM, currentY, 'change');
        } else {
            let currentM = currentMonth;
            let currentY = currentYear;
            lastIndex = cloneIndex;

            setTitleForDateTime(currentM, currentY, 'change');
        }
    }
}

function changeArrayWeek(getAllDay) {
    let arrayFixWeek = [
        [], [], [], [], []
    ];
    for (let i = 0; i < getAllDay.length; i++) {
        let result = getAllDay[i].substring(0, 2);
        if (result / 7 <= 1) {
            arrayFixWeek[0].push(getAllDay[i]);
        }

        if (result / 7 >= 1 && result / 7 < 2) {
            arrayFixWeek[1].push(getAllDay[i]);
        }

        if (result / 7 >= 2 && result / 7 < 3) {
            arrayFixWeek[2].push(getAllDay[i]);
        }

        if (result / 7 >= 3 && result / 7 < 4) {
            arrayFixWeek[3].push(getAllDay[i]);
        }

        if (result / 7 >= 4 && result / 7 < 5) {
            arrayFixWeek[4].push(getAllDay[i]);
        }
    }
    return arrayFixWeek;
}

function setTitleForDateTime(currentM, currentY, status) {
    document.getElementById('cal-header').innerHTML = '';
    document.getElementById('cal-header').innerHTML = 'Tháng ' + currentM + ' - ' + currentY;
    let getAllDay = getDaysInMonth(currentM - 1, currentY);

    let arrayFixWeek = changeArrayWeek(getAllDay);
    if (status == 'default') {
        for (let i = 0; i < arrayFixWeek.length; i++) {
            for (let j = 0; j < arrayFixWeek[i].length; j++) {
                let result = arrayFixWeek[i][j].substring(0, 2);
                if (lastChoiceMonth === null || lastChoiceYear === null || lastChoiceDay === null) {
                    if (result == new Date().getDate()) {
                        setTextDateTime(arrayFixWeek[i]);
                        lastIndex = i;
                    }
                } else {
                    if (result == lastChoiceDay) {
                        setTextDateTime(arrayFixWeek[i]);
                        lastIndex = i;
                    }
                }
            }
        }
    } else {
        setTextDateTime(arrayFixWeek[lastIndex]);
    }
}

function getDataStation(roadsId) {
    $.ajax({
        url: '/admin/getdatastation',
        data: {
            roadsId: roadsId
        },
        type: 'GET'
    }).done(function (response) {
        $('#list-station-of-roads').empty();
        for (let i = 0; i < response.length; i++) {
            let content = "<li class='list-group-item'><span>" + response[i].name + "</span><input type='time' name='estimate[" + i + "][" + response[i].id + "]' style='height: 30px;margin-left: 10px;' id='estimate' required></li>";
            $('#list-station-of-roads').append(content);
        }
    });
}

function getDataForTrips(week, roadsId) {
    $.ajax({
        url: '/admin/getdatatrips',
        data: {
            week: week,
            year: currentYear,
            roadsId: roadsId
        },
        type: 'GET'
    }).done(function (response) {
        dataResponse = response;
        let arrayColor = {
            1: '#b3afaf',
            2: '#3ede89',
            3: '#d96666'
        }
        let tableBody = $("#trips_table tbody");
        let allRow = $("#table-data-trips tr");
        allRow.remove();
        for (let i = 0; i < response.total; i++) {
            let textColumn0 = '';
            let textColumn1 = '';
            let textColumn2 = '';
            let textColumn3 = '';
            let textColumn4 = '';
            let textColumn5 = '';
            let textColumn6 = '';

            if (!jQuery.isEmptyObject(response.column[0])) {
                if (!jQuery.isEmptyObject(response.column[0][i])) {
                    textColumn0 = arrayColor[response.column[0][i].status];
                }
            }
            if (!jQuery.isEmptyObject(response.column[1])) {
                if (!jQuery.isEmptyObject(response.column[1][i])) {
                    textColumn1 = arrayColor[response.column[1][i].status];
                }
            }
            if (!jQuery.isEmptyObject(response.column[2])) {
                if (!jQuery.isEmptyObject(response.column[2][i])) {
                    textColumn2 = arrayColor[response.column[2][i].status];
                }
            }
            if (!jQuery.isEmptyObject(response.column[3])) {
                if (!jQuery.isEmptyObject(response.column[3][i])) {
                    textColumn3 = arrayColor[response.column[3][i].status];
                }
            }
            if (!jQuery.isEmptyObject(response.column[4])) {
                if (!jQuery.isEmptyObject(response.column[4][i])) {
                    textColumn4 = arrayColor[response.column[4][i].status];
                }
            }
            if (!jQuery.isEmptyObject(response.column[5])) {
                if (!jQuery.isEmptyObject(response.column[5][i])) {
                    textColumn5 = arrayColor[response.column[5][i].status];
                }
            }
            if (!jQuery.isEmptyObject(response.column[6])) {
                if (!jQuery.isEmptyObject(response.column[6][i])) {
                    textColumn6 = arrayColor[response.column[6][i].status];
                }
            }

            let content =
                "<tr id='row-trips-" + i + "'><td id='td-trips-" + i + "'>" + (jQuery.isEmptyObject(response.column[0]) ? '' : ((jQuery.isEmptyObject(response.column[0][i]) ? '' : "<div class='card' style='background-color: " + textColumn0 + "; height: 189px;' id='0-" + i + "' onclick='getInformationTrips(this.id)'><div class='card-body' style='font-size: 14px;'><div class='d-flex flex-column'><div><p>" + response.column[0][i].name + "</p><p>" + response.column[0][i].start + "-" + response.column[0][i].end + "</p></div><div></div><div><p>Lái xe : " + response.column[0][i].driver + "</p><p>Phụ xe : " + response.column[0][i].driver_mate + "</p><p>Xe chạy : " + response.column[0][i].bus_name + "</p></div></div></div></div>")))
                + "</td><td id='td-trips-" + (i + 1) + "'>" + (jQuery.isEmptyObject(response.column[1]) ? '' : ((jQuery.isEmptyObject(response.column[1][i]) ? '' : "<div class='card' style='background-color: " + textColumn1 + "; height: 189px;' id='1-" + i + "' onclick='getInformationTrips(this.id)'><div class='card-body' style='font-size: 14px;'><div class='d-flex flex-column'><div><p>" + response.column[1][i].name + "</p><p>" + response.column[1][i].start + "-" + response.column[1][i].end + "</p></div><div></div><div><p>Lái xe : " + response.column[1][i].driver + "</p><p>Phụ xe : " + response.column[1][i].driver_mate + "</p><p>Xe chạy : " + response.column[1][i].bus_name + "</p></div></div></div></div>")))
                + "</td><td id='td-trips-" + (i + 2) + "'>" + (jQuery.isEmptyObject(response.column[2]) ? '' : ((jQuery.isEmptyObject(response.column[2][i]) ? '' : "<div class='card' style='background-color: " + textColumn2 + "; height: 189px;' id='2-" + i + "' onclick='getInformationTrips(this.id)'><div class='card-body' style='font-size: 14px;'><div class='d-flex flex-column'><div><p>" + response.column[2][i].name + "</p><p>" + response.column[2][i].start + "-" + response.column[2][i].end + "</p></div><div></div><div><p>Lái xe : " + response.column[2][i].driver + "</p><p>Phụ xe : " + response.column[2][i].driver_mate + "</p><p>Xe chạy : " + response.column[2][i].bus_name + "</p></div></div></div></div>")))
                + "</td><td id='td-trips-" + (i + 3) + "'>" + (jQuery.isEmptyObject(response.column[3]) ? '' : ((jQuery.isEmptyObject(response.column[3][i]) ? '' : "<div class='card' style='background-color: " + textColumn3 + "; height: 189px;' id='3-" + i + "' onclick='getInformationTrips(this.id)'><div class='card-body' style='font-size: 14px;'><div class='d-flex flex-column'><div><p>" + response.column[3][i].name + "</p><p>" + response.column[3][i].start + "-" + response.column[3][i].end + "</p></div><div></div><div><p>Lái xe : " + response.column[3][i].driver + "</p><p>Phụ xe : " + response.column[3][i].driver_mate + "</p><p>Xe chạy : " + response.column[3][i].bus_name + "</p></div></div></div></div>")))
                + "</td><td id='td-trips-" + (i + 4) + "'>" + (jQuery.isEmptyObject(response.column[4]) ? '' : ((jQuery.isEmptyObject(response.column[4][i]) ? '' : "<div class='card' style='background-color: " + textColumn4 + "; height: 189px;' id='4-" + i + "' onclick='getInformationTrips(this.id)'><div class='card-body' style='font-size: 14px;'><div class='d-flex flex-column'><div><p>" + response.column[4][i].name + "</p><p>" + response.column[4][i].start + "-" + response.column[4][i].end + "</p></div><div></div><div><p>Lái xe : " + response.column[4][i].driver + "</p><p>Phụ xe : " + response.column[4][i].driver_mate + "</p><p>Xe chạy : " + response.column[4][i].bus_name + "</p></div></div></div></div>")))
                + "</td><td id='td-trips-" + (i + 5) + "'>" + (jQuery.isEmptyObject(response.column[5]) ? '' : ((jQuery.isEmptyObject(response.column[5][i]) ? '' : "<div class='card' style='background-color: " + textColumn5 + "; height: 189px;' id='5-" + i + "' onclick='getInformationTrips(this.id)'><div class='card-body' style='font-size: 14px;'><div class='d-flex flex-column'><div><p>" + response.column[5][i].name + "</p><p>" + response.column[5][i].start + "-" + response.column[5][i].end + "</p></div><div></div><div><p>Lái xe : " + response.column[5][i].driver + "</p><p>Phụ xe : " + response.column[5][i].driver_mate + "</p><p>Xe chạy : " + response.column[5][i].bus_name + "</p></div></div></div></div>")))
                + "</td><td id='td-trips-" + (i + 6) + "'>" + (jQuery.isEmptyObject(response.column[6]) ? '' : ((jQuery.isEmptyObject(response.column[6][i]) ? '' : "<div class='card' style='background-color: " + textColumn6 + "; height: 189px;' id='6-" + i + "' onclick='getInformationTrips(this.id)'><div class='card-body' style='font-size: 14px;'><div class='d-flex flex-column'><div><p>" + response.column[6][i].name + "</p><p>" + response.column[6][i].start + "-" + response.column[6][i].end + "</p></div><div></div><div><p>Lái xe : " + response.column[6][i].driver + "</p><p>Phụ xe : " + response.column[6][i].driver_mate + "</p><p>Xe chạy : " + response.column[6][i].bus_name + "</p></div></div></div></div>")))
                + "</td></tr>";
            tableBody.append(content);
        }
    });
}

function setTextForModal(textHeader) {

    let slice = textHeader.slice(10);
    let idHeader = 'cal-th-' + slice;
    let getTextHeader = document.getElementById(idHeader).innerHTML;
    let sliceDate = getTextHeader.slice(6, 11);
    let sliceDateForDay = sliceDate.slice(0, 2);
    let sliceDateForMonth = sliceDate.slice(3);

    let date = new Date();
    let dateCurrent = date.getDate();
    let monthCurrent = date.getMonth() + 1;
    let yearCurrent = date.getFullYear();
    let fullCurrent = yearCurrent + '-' + monthCurrent + '-' + dateCurrent;

    let textHeader1 = document.getElementById('cal-header').innerHTML;
    let sliceYear = textHeader1.slice(11);
    let currentPick = sliceYear + '-' + sliceDateForMonth + '-' + sliceDateForDay;

    let unixTimeCurrent = Date.parse(fullCurrent);
    let unixTimePick = Date.parse(currentPick);

    if (unixTimePick < unixTimeCurrent) {
        return;
    }

    document.getElementById('header-modal-trips').innerHTML = getTextHeader;
    document.getElementById('date-trips').value = sliceDate + '/' + currentYear;

    $('#addModal').modal('show');
}

function changeRoads() {
    let roadsId = $('#selection-roads option').filter(':selected').val();
    getDataForTrips(selectedWeek, roadsId)
}

function getInformationTrips(id) {
    let column = id.slice(0, 1);
    let td = id.slice(2);

    let dataRecord = dataResponse.column[column][td];
    let tripsId = dataRecord.id
    $.ajax({
        url: '/admin/getinformationtrips',
        data: {
            tripsId: tripsId
        },
        type: 'GET'
    }).done(function (response) {

        let textName = dataRecord.name;
        let textTime = 'Thời gian : ' + dataRecord.start + ' - ' + dataRecord.end + ' ngày ' + dataRecord.date;
        let textRoads = 'Tuyến đường : ' + response.roads_name;
        let textTotalSeat = 'Tổng ghế : ' + response.totalSeat;
        let textSell = 'Vé đã đặt : ' + response.sale;
        let textBus = 'Xe chạy : ' + response.bus_name;
        let textCost = 'Gía vé : ' + response.cost;
        let textStock = 'Số ghế trống : ' + response.stock;
        let textStatus = 'Trạng thái : ' + response.status;
        let textDriver = 'Lái xe : ' + response.driver.name;
        let textDriverMate = 'Phụ xe : ' + response.driver_mate.name;
        let valueDriverMate = response.driver_mate.id;
        let valueDriver = response.driver.id;
        let valueBus = response.bus_id;
        let valueCost = response.cost;
        let tripsId_hidden = response.tripsId;
        currentDate = dataRecord.date;
        currentStart = dataRecord.start;

        currentRepickBus = response.bus_id;
        currentRepickStart = dataRecord.start;
        currentRepickDriver = response.driver.id;
        currentRepickDriverMate = response.driver_mate.id;
        currentStock = response.stock;

        document.getElementById('name-modal-trips-show').innerHTML = '';
        document.getElementById('name-modal-trips-show').innerHTML = textName;

        document.getElementById('time-modal-trips-show').innerHTML = '';
        document.getElementById('time-modal-trips-show').innerHTML = textTime;

        document.getElementById('roads-modal-trips-show').innerHTML = '';
        document.getElementById('roads-modal-trips-show').innerHTML = textRoads;

        document.getElementById('totalSeat-modal-trips-show').innerHTML = '';
        document.getElementById('totalSeat-modal-trips-show').innerHTML = textTotalSeat;

        document.getElementById('sale-modal-trips-show').innerHTML = '';
        document.getElementById('sale-modal-trips-show').innerHTML = textSell;

        document.getElementById('stock-modal-trips-show').innerHTML = '';
        document.getElementById('stock-modal-trips-show').innerHTML = textStock;

        document.getElementById('status-modal-trips-show').innerHTML = '';
        document.getElementById('status-modal-trips-show').innerHTML = textStatus;

        document.getElementById('tripsId-hidden').value = tripsId_hidden;
        document.getElementById('date-trips-hidden').value = dataRecord.date;
        document.getElementById('start-hidden').value = dataRecord.start;

        if (response.statusIndex == 2) {
            for (let i = 0; i < bus.length; i++) {
                if (bus[i].status == false) {
                    $("#bus-modal-trips-show-select option[value=" + bus[i].id + "]").hide();
                }
            }

            for (let i = 0; i < driver.length; i++) {
                if (driver[i].status_delete == false) {
                    $("#driver-modal-trips-show-select option[value=" + driver[i].id + "]").hide();
                }
            }

            for (let i = 0; i < driver_mate.length; i++) {
                if (driver_mate[i].status_delete == false) {
                    $("#driver-mate-modal-trips-show-select option[value=" + driver_mate[i].id + "]").hide();
                }
            }
        }

        if (role == 3) {
            document.getElementById('bus-modal-trips-show').innerHTML = '';
            document.getElementById('bus-modal-trips-show').innerHTML = textBus;

            document.getElementById('driver-modal-trips-show').innerHTML = '';
            document.getElementById('driver-modal-trips-show').innerHTML = textDriver;

            document.getElementById('driver-mate-modal-trips-show').innerHTML = '';
            document.getElementById('driver-mate-modal-trips-show').innerHTML = textDriverMate;

            document.getElementById('cost-modal-trips-show').innerHTML = '';
            document.getElementById('cost-modal-trips-show').innerHTML = textCost;

        } else {
            if (response.statusIndex == 1 || response.statusIndex == 3) {
                $("#bus-modal-trips-show-select").attr("disabled", true);
                $("#driver-modal-trips-show-select").attr("disabled", true);
                $("#driver-mate-modal-trips-show-select").attr("disabled", true);
                $("#cost-modal-trips-show-input").attr("disabled", true);
                document.getElementById('bus-modal-trips-show-select').value = valueBus;
                document.getElementById('driver-modal-trips-show-select').value = valueDriver;
                document.getElementById('driver-mate-modal-trips-show-select').value = valueDriverMate;
                document.getElementById('cost-modal-trips-show-input').value = valueCost;
            } else {
                $("#bus-modal-trips-show-select").attr("disabled", false);
                $("#driver-modal-trips-show-select").attr("disabled", false);
                $("#driver-mate-modal-trips-show-select").attr("disabled", false);
                $("#cost-modal-trips-show-input").attr("disabled", false);
                document.getElementById('bus-modal-trips-show-select').value = valueBus;
                document.getElementById('driver-modal-trips-show-select').value = valueDriver;
                document.getElementById('driver-mate-modal-trips-show-select').value = valueDriverMate;
                document.getElementById('cost-modal-trips-show-input').value = valueCost;
            }
        }


        let estimateList = $("#estimate-data-modal-trips-show");
        let estimateRow = $("#estimate-data-modal-trips-show li");
        let tableBody = $("#buyers-table tbody");
        let allRow = $("#table-buyers-data tr");
        let buttonGroup = $("#group-button-trips");
        let getButtonGroup = $("#group-button-trips button");
        estimateRow.remove();
        getButtonGroup.remove();
        allRow.remove();

        if (role == 2) {
            for (let x = 0; x < response.estimate.length; x++) {
                let content = "<li class='mt-3'><span>" + response.estimate[x].station_name + " : <input type='time' style='height: 30px;margin-left: 10px;' id='estimate_show_" + response.estimate[x].id + "' value='" + response.estimate[x].estimate + "' onchange='saveEstimate(this.id)' required></span></li>";
                estimateList.append(content);
            }
        } else {
            for (let x = 0; x < response.estimate.length; x++) {
                let content = "<li class='mt-3'><span> - " + response.estimate[x].station_name + " : " + response.estimate[x].estimate + "</span></li>";
                estimateList.append(content);
            }
        }

        for (let i = 0; i < response.buyers.length; i++) {
            let text_pay_status = '';
            if (response.buyers[i].pay_status == 2) {
                text_pay_status = 'Thanh toán trực tiếp'; 'Thanh toán online'
            }

            if (response.buyers[i].pay_status == 1) {
                text_pay_status = 'Thanh toán online';
            }

            if (response.buyers[i].pay_status == 3) {
                text_pay_status = 'Chuyển khoản';
            }

            let content = "<tr><td>" + response.buyers[i].name_customer + "</td><td>" + response.buyers[i].phone_customer + "</td><td>" + response.buyers[i].totalBuy + "</td><td>" + text_pay_status + "</td><td><input type='text' class='form-control' value='" + response.buyers[i].note + "' id='" + response.tripsId + "-" + response.buyers[i].name_customer + "-" + response.buyers[i].phone_customer + "' onfocusout='saveNote(this.id)'></td></tr>";
            tableBody.append(content);
        }

        let contentButton = '';
        if (role == 2) {
            if (response.statusIndex == 1 || response.statusIndex == 3) {
                contentButton = "<button type='button' class='btn btn-secondary mt-4' data-dismiss='modal'>Đóng</button>";

            } else {
                contentButton = "<button type='button' class='btn btn-primary mt-4 mr-4' onclick='submitFormRepick()'>Lưu thay đổi</button>"
                    + "<button type='button' class='btn btn-secondary mr-4 mt-4' onclick='cancelTrips(" + response.tripsId + ")'>Hủy chuyến</button>"
                    + "<button type='button' class='btn btn-secondary mt-4' data-dismiss='modal'>Đóng</button>";
            }

            buttonGroup.append(contentButton);
        } else {
            let contentButton = "<button type='button' class='btn btn-secondary mt-4' data-dismiss='modal'>Đóng</button>";
            buttonGroup.append(contentButton);
        }

        if ( response.status == 'Đã hủy') {
            $('#add_customer_to_trips').prop('disabled', true);
        } else {
            $('#add_customer_to_trips').prop('disabled', false);
        }

        $('#showModal').modal('show');
    });
}

function saveNote(id) {
    let note = document.getElementById(id).value;
    id = id + '-' + note;
    $.ajax({
        url: '/admin/savenote',
        data: {
            id: id
        },
        type: 'GET'
    }).done(function (response) {
    });
}

function cancelTrips(tripsId) {
    if (confirm('Xác nhận xoá xe này!')) {
        alert('Bạn đã xác nhận xoá xe!');
        let busId = document.getElementById('bus-modal-trips-show-select').value;
        let driverId = document.getElementById('driver-modal-trips-show-select').value;
        let driverMateId = document.getElementById('driver-mate-modal-trips-show-select').value;
        let cost = document.getElementById('cost-modal-trips-show-input').value;
        let url = '';
        if ($("#acceptAll").prop('checked') == true) {
            url = "/admin/canceltrips?tripsId=" + tripsId + "&busId=" + busId + "&bus=" + busId
                + "&driver=" + driverId + "&driver_mate=" + driverMateId + "&cost=" + cost + "&date=" + currentDate + "&start=" + currentStart + "&acceptAll=on";
        } else {
            url = "/admin/canceltrips?tripsId=" + tripsId + "&busId=" + busId + "&bus=" + busId
                + "&driver=" + driverId + "&driver_mate=" + driverMateId + "&cost=" + cost + "&date=" + currentDate + "&start=" + currentStart;
        }
    
        window.location.replace(url);   
    } else {
        return;
    }
   
}

function saveEstimate(id) {
    let estimate = document.getElementById(id).value;
    $.ajax({
        url: '/admin/saveestimate',
        data: {
            id: id,
            estimate: estimate
        },
        type: 'GET'
    }).done(function (response) {
    });
}

function saveNewCustomer(pay_status) {
    let textError = document.getElementById('text_new_customer');
    textError.innerHTML = '';

    let name = document.getElementById('name-new-customer').value;
    if (name === null || name == '') {
        textError.innerHTML = 'Tên khách hàng không được để trống';
        textError.style.color = 'red';
        return;
    }
    let regexName = /^([a-zA-Z\sÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂẾưăạảấầẩẫậắằẳẵặẹẻẽềềểếỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ])+$/;
    if (regexName.test(name) === false) {
        textError.innerHTML = 'Tên khách hàng không đúng định dạng';
        textError.style.color = 'red';
        return;
    }

    let phone = document.getElementById('phone-new-customer').value;
    if (phone === null || phone == '') {
        textError.innerHTML = 'Số điện thoại khách hàng không được để trống';
        textError.style.color = 'red';
        return;
    }
    let regexPhone = /(03|05|07|08|09|01)+([0-9])/;
    if (regexPhone.test(phone) === false) {
        textError.innerHTML = 'Số điện thoại khách hàng không đúng định dạng';
        textError.style.color = 'red';
        return;
    }

    let total_buy = document.getElementById('ticket-new-customer').value;
    if (total_buy === null || total_buy == '') {
        textError.innerHTML = 'Số vé khách hàng không được để trống';
        textError.style.color = 'red';
        return;
    }

    if (total_buy <= 0) {
        textError.innerHTML = 'Số vé khách hàng không được nhỏ hơn hoặc bằng 0';
        textError.style.color = 'red';
        return;
    }

    if (total_buy > currentStock) {
        textError.innerHTML = 'Số vé khách hàng mua vượt quá số ghế còn trống';
        textError.style.color = 'red';
        return;
    }

    let note = document.getElementById('note-new-customer').value;
    let tripsId = document.getElementById('tripsId-hidden').value;
    $.ajax({
        url: '/admin/savenewcustomer',
        data: {
            name: name,
            phone: phone,
            note: note,
            total_buy: total_buy,
            tripsId: tripsId,
            pay_status: pay_status
        },
        type: 'GET'
    }).done(function (response) {
        $('#text_new_customer').html('');
        $('#text_new_customer').attr('style', '');
        if (response.status_add == 0) {
            $('#text_new_customer').html(response.text);
            $('#text_new_customer').attr('style', 'color: red');
        } else {
            let stockText = 'Số ghế trống : ' + response.stock;
            let sellText = 'Vé đã đặt : ' + response.sell;
            $('#name-new-customer').replaceWith(response.name);
            $('#phone-new-customer').replaceWith(response.phone);
            $('#ticket-new-customer').replaceWith(response.total_buy);
            $('#note-new-customer').replaceWith("<input type='text' class='form-control' value='" + response.note + "' id='" + response.tripsId + "-" + response.name + "-" + response.phone + "' onfocusout='saveNote(this.id)'>");
            $('#add_new_customer_to_table').remove();
            $('#add_customer_to_trips').prop('disabled', false);

            $('#sale-modal-trips-show').html('');
            $('#stock-modal-trips-show').html('');
            $('#text_new_customer').html(response.text);
            $('#text_new_customer').attr('style', 'color: #41e86e');
            $('#sale-modal-trips-show').html(sellText);
            $('#stock-modal-trips-show').html(stockText);
        }
    });
}

function submitFormRepick() {
    $('#bus-current-hidden').val(currentRepickBus);
    $('#start-current-hidden').val(currentRepickStart);
    $('#driver-current-hidden').val(currentRepickDriver);
    $('#driver-mate-current-hidden').val(currentRepickDriverMate);

    $('#form-repick-trips').submit();
}