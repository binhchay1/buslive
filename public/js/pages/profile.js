var Days = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
$(document).ready(function () {
    let option = '<option value="day" disabled>ngày</option>';
    let selectedDay = "day";
    for (let i = 1; i <= Days[0]; i++) {
        option += '<option value="' + i + '">' + i + '</option>';
    }
    $('#day').append(option);
    $('#day').val(selectedDay);

    let optionMonth = '<option value="month" disabled>tháng</option>';
    let selectedMon = "month";
    for (let i = 1; i <= 12; i++) {
        optionMonth = optionMonth + '<option value="' + i + '">' + i + '</option>';
    }
    $('#month').append(optionMonth);
    $('#month').val(selectedMon);

    let d = new Date();
    let optionDay = '<option value="year" disabled>năm</option>';
    selectedYear = "year";
    for (let i = 1930; i <= d.getFullYear(); i++) {
        optionDay = optionDay + '<option value="' + i + '">' + i + '</option>';
    }
    $('#year').append(optionDay);
    $('#year').val(selectedYear);


    setInputFilter(document.getElementById("phone"), function (value) {
        return /^-?\d*$/.test(value);
    });

    setDateMonthEdit();
});
function isLeapYear(year) {
    year = parseInt(year);
    if (year % 4 != 0) {
        return false;
    } else if (year % 400 == 0) {
        return true;
    } else if (year % 100 == 0) {
        return false;
    } else {
        return true;
    }
}

function change_year(select) {
    if (isLeapYear($(select).val())) {
        Days[1] = 29;

    }
    else {
        Days[1] = 28;
    }
    if ($("#month").val() == 2) {
        let day = $('#day');
        let val = $(day).val();
        let getTime = new Date();
        let current_year = getTime.getFullYear();
        let current_day = getTime.getDate();
        let e = document.getElementById("year");
        let year_get = e.value;
        $(day).empty();
        let option = '<option value="day" disabled>ngày</option>';
        for (let i = 1; i <= Days[1]; i++) {
            if (year_get == current_year) {
                changeCurrentMonth();
                if (i <= current_day) {
                    option += '<option value="' + i + '">' + i + '</option>';
                }
            } else {
                option += '<option value="' + i + '">' + i + '</option>';
            }
        }
        $(day).append(option);
        if (val > Days[month]) {
            val = 1;
        }
        $(day).val(val);
    } else {
        let day = $('#day');
        let val = $(day).val();
        let getTime = new Date();
        let current_year = getTime.getFullYear();
        let current_day = getTime.getDate();
        let e = document.getElementById("year");
        let year_get = e.value;
        $(day).empty();
        let option = '<option value="day" disabled>ngày</option>';
        for (let i = 1; i <= 31; i++) {
            if (year_get == current_year) {
                changeCurrentMonth();
                if (i <= current_day) {
                    option += '<option value="' + i + '">' + i + '</option>';
                }
            } else {
                option += '<option value="' + i + '">' + i + '</option>';
            }
        }
        $(day).append(option);
        if (val > Days[month]) {
            val = 1;
        }
        $(day).val(val);
    }
}

function change_month(select) {
    let day = $('#day');
    let val = $(day).val();
    $(day).empty();
    let option = '<option value="day">ngày</option>';
    let month = parseInt($(select).val()) - 1;
    for (let i = 1; i <= Days[month]; i++) {
        option += '<option value="' + i + '">' + i + '</option>';
    }
    $(day).append(option);
    if (val > Days[month]) {
        val = 1;
    }
    $(day).val(val);
}

function changeCurrentMonth() {
    let month = $('#month');
    let getTime = new Date();
    let current_month = getTime.getMonth() + 1;
    $(month).empty();
    let optionMonth = '<option value="month" disabled>tháng</option>';
    for (let i = 1; i <= 12; i++) {
        if (i <= current_month) {
            optionMonth = optionMonth + '<option value="' + i + '" >' + i + '</option>';
        }
    };
    $(month).append(optionMonth);
}

function setInputFilter(textbox, inputFilter) {
    ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function (event) {
        textbox.addEventListener(event, function () {
            if (inputFilter(this.value)) {
                this.oldValue = this.value;
                this.oldSelectionStart = this.selectionStart;
                this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {
                this.value = this.oldValue;
                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            } else {
                this.value = "";
            }
        });
    });
}

function setDateMonthEdit() {
    document.getElementById("year").value = yearEdit;
    document.getElementById("month").value = monthEdit;
    document.getElementById("day").value = dateEdit;
}