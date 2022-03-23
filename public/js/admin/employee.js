var Days = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
$(document).ready(function () {

    $('#editModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget)
        let id = button.data('id');
        let name = button.data('name');
        let address = button.data('address');
        let phone = button.data('phone');
        let gender = button.data('gender');
        let dob = button.data('dob');
        let sub_role = button.data('sub_role');

        let dobarr = dob.split(/\-/g);
        let year = dobarr[0]
        let month = dobarr[1];
        let day = dobarr[2];

        let modal = $(this);
        modal.find('.modal-body #id_edit').val(id);
        modal.find('.modal-body #name_edit').val(name);
        modal.find('.modal-body #address_edit').val(address);
        modal.find('.modal-body #phone_edit').val(phone);
        modal.find('.modal-body #gender_edit').val(gender);
        modal.find('.modal-body #year_edit').val(year);
        modal.find('.modal-body #month_edit').val(month);
        modal.find('.modal-body #day_edit').val(day);
        modal.find('.modal-body #sub_role_edit').val(sub_role);
    });

    $('#deleteModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget)
        let id = button.data('id');
        let sub_role = button.data('sub_role');
        let modal = $(this);

        $.ajax({
            url: '/admin/checkdeleteemployee',
            data: {
                id: id,
                sub_role: sub_role,
            },
            type: 'GET'
        }).done(function (response) {
            if (response == 0) {
                document.getElementById('text_delete_employee').innerHTML = '';
                document.getElementById('text_delete_employee').innerHTML = 'Bạn chắc chắn muốn xóa ?';
                document.getElementById('delete_employee').disabled = false;
                modal.find('.modal-body #id_delete').val(id);
            } else {
                document.getElementById('text_delete_employee').innerHTML = '';
                document.getElementById('text_delete_employee').innerHTML = 'Nhân viên này bạn không thể xóa vì đang thuộc 1 tuyến đường đang chạy';
                document.getElementById('delete_employee').disabled = true;
            }
        });
    });

    let option = '<option value="day" disabled>ngày</option>';
    let selectedDay = "day";
    for (let i = 1; i <= Days[0]; i++) {
        option += '<option value="' + i + '">' + i + '</option>';
    }
    $('#day').append(option);
    $('#day').val(selectedDay);
    $('#day_edit').append(option);
    $('#day_edit').val(selectedDay);

    let optionMonth = '<option value="month" disabled>tháng</option>';
    let selectedMon = "month";
    for (let i = 1; i <= 12; i++) {
        optionMonth = optionMonth + '<option value="' + i + '">' + i + '</option>';
    }
    $('#month').append(optionMonth);
    $('#month_edit').append(optionMonth);
    $('#month').val(selectedMon);
    $('#month_edit').val(selectedMon);

    let d = new Date();
    let optionDay = '<option value="year" disabled>năm</option>';
    selectedYear = "year";
    for (let i = 1930; i <= d.getFullYear(); i++) {
        optionDay = optionDay + '<option value="' + i + '">' + i + '</option>';
    }
    $('#year').append(optionDay);
    $('#year_edit').append(optionDay);
    $('#year').val(selectedYear);
    $('#year_edit').val(selectedYear);


    setInputFilter(document.getElementById("phone"), function (value) {
        return /^-?\d*$/.test(value);
    });

});

function search() {
    var input, filter, table, tr, td, i;
    input = document.getElementById("employee_search");
    filter = input.value.toUpperCase();
    table = document.getElementById("employee_table");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        if (i == 0) {
            continue;
        }
        row = tr[i].getElementsByTagName("td");
        for (y = 0; y < row.length; y++) {
            td = row[y];
            text = td.innerHTML;
            if (text.indexOf('type="button"') == -1) {
                if (text.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                    break;
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
}

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

function change_year_edit(select) {
    if (isLeapYear($(select).val())) {
        Days[1] = 29;
    }
    else {
        Days[1] = 28;
    }
    if ($("#month_edit").val() == 2) {
        let day = $('#day_edit');
        let val = $(day).val();
        let getTime = new Date();
        let current_year = getTime.getFullYear();
        let current_day = getTime.getDate();
        let e = document.getElementById("year_edit");
        let year_get = e.value;
        $(day).empty();
        let option = '<option value="day" disabled>ngày</option>';
        for (let i = 1; i <= Days[1]; i++) {
            if (year_get == current_year) {
                changeCurrentMonthEdit();
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
        let day = $('#day_edit');
        let val = $(day).val();
        let getTime = new Date();
        let current_year = getTime.getFullYear();
        let current_day = getTime.getDate();
        let e = document.getElementById("year_edit");
        let year_get = e.value;
        $(day).empty();
        let option = '<option value="day" disabled>ngày</option>';
        for (let i = 1; i <= 31; i++) {
            if (year_get == current_year) {
                changeCurrentMonthEdit();
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

function change_month_edit(select) {
    let day = $('#day_edit');
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

function changeCurrentMonthEdit() {
    let month = $('#month_edit');
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