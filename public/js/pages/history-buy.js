var time = document.getElementById('time-picker-history').value;
var check = 0;
$(document).ready(function () {
    let dataSearch = Object.values(data);

    if (dataSearch.length == 0) {
        document.getElementById('empty-history').classList.remove('d-none');
        document.getElementById('empty-history').classList.remove('d-block');
        document.getElementById('empty-history').classList.add('d-block');
    } else {
        document.getElementById('empty-history').classList.remove('d-none');
        document.getElementById('empty-history').classList.remove('d-block');
        document.getElementById('empty-history').classList.add('d-none');
    }

});

function setDataTicket(search) {

    let dataSearch = Object.keys(data);
    check = 0;

    for (let i = 0; i < dataSearch.length; i++) {
        if (dataSearch[i] == search) {
            document.getElementById(search).classList.remove('d-block');
            document.getElementById(dataSearch[i]).classList.remove('d-none');
            document.getElementById(search).classList.add('d-block');
            check = 1;
        } else {
            document.getElementById(dataSearch[i]).classList.remove('d-none');
            document.getElementById(dataSearch[i]).classList.remove('d-block');
            document.getElementById(dataSearch[i]).classList.add('d-none');
        }
    }

    if (check == 0) {
        document.getElementById('empty-history').classList.remove('d-none');
        document.getElementById('empty-history').classList.remove('d-block');
        document.getElementById('empty-history').classList.add('d-block');
    } else {
        document.getElementById('empty-history').classList.remove('d-none');
        document.getElementById('empty-history').classList.remove('d-block');
        document.getElementById('empty-history').classList.add('d-none');
    }
}

