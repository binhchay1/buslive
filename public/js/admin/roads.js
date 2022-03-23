var currentArrayStationPush = [];

$(document).ready(function () {
    if (station.length > 0) {
        setStationInListAdd();
    }

    $('#editModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget)
        let id = button.data('id');
        let name = button.data('name');
        let garage1 = button.data('garages_id_first');
        let garage2 = button.data('garages_id_second');
        let arrayStation = button.data('array');
        let modal = $(this);

        currentArrayStationPush = [];
        if(String(arrayStation).indexOf(",") > -1) {
            let split = arrayStation.split(',');
            for(let i = 0; i < split.length; i++) {
                currentArrayStationPush.push(split[i]);
            }
        }

        modal.find('.modal-body #id_edit').val(id);
        modal.find('.modal-body #name_edit').val(name);

        $("#garage1_edit").val(garage1);
        $("#garage2_edit").val(garage2);

        setStationInListEdit(arrayStation);

        $('#garage1_edit').on('change', function () {
            let garagesFirst = document.getElementById('garage1_edit').options[document.getElementById('garage1_edit').selectedIndex].value;
            let garagesSecond = document.getElementById('garage2_edit').options[document.getElementById('garage2_edit').selectedIndex].value;
            let arrayStationForSet = '';
            for (let k = 0; k < roads.length; k++) {
                if (garagesFirst == roads[k].garages_id_first && garagesSecond == roads[k].garages_id_second) {
                    arrayStationForSet = roads[k].station;
                }
            }

            setStationInListEdit(arrayStationForSet);
        });

        $('#garage2_edit').on('change', function () {
            let garagesFirst = document.getElementById('garage1_edit').options[document.getElementById('garage1_edit').selectedIndex].value;
            let garagesSecond = document.getElementById('garage2_edit').options[document.getElementById('garage2_edit').selectedIndex].value;
            let arrayStationForSet = '';
            for (let k = 0; k < roads.length; k++) {
                if (garagesFirst == roads[k].garages_id_first && garagesSecond == roads[k].garages_id_second) {
                    arrayStationForSet = roads[k].station;
                }
            }
            setStationInListEdit(arrayStationForSet);
        });

    });

    $('#deleteModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget)
        let id = button.data('id');
        let modal = $(this);

        $.ajax({
            url: '/admin/checkdeleteroads',
            data: {
                id: id,
            },
            type: 'GET'
        }).done(function (response) {
            if (response == 0) {
                document.getElementById('text_delete_roads').innerHTML = '';
                document.getElementById('text_delete_roads').innerHTML = 'Bạn chắc chắn muốn xóa ?';
                document.getElementById('delete_roads').disabled = false;
                modal.find('.modal-body #id_delete').val(id);
            } else {
                document.getElementById('text_delete_roads').innerHTML = '';
                document.getElementById('text_delete_roads').innerHTML = 'Tuyến đường này bạn không thể xóa vì đang thuộc 1 tuyến đường đang chạy';
                document.getElementById('delete_roads').disabled = true;
            }
        });
    });

    $('#addModal').on('show.bs.modal', function () {
        currentArrayStationPush = [];
    });

});

function search() {
    var input, filter, table, tr, td, i;
    input = document.getElementById("roads_search");
    filter = input.value.toUpperCase();
    table = document.getElementById("roads_table");
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

function saveRoads(type) {
    if (type == 'add') {
        document.getElementById('arrayStation').value = currentArrayStationPush;
        document.getElementById("roads_add_form").submit();
    } else {
        document.getElementById('arrayStationEdit').value = currentArrayStationPush;
        document.getElementById("roads_edit_form").submit();
    }
}

function searchInModalAdd() {
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById("searchModalAdd");
    filter = input.value.toUpperCase();
    ul = document.getElementById("list-station");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("span")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}

function searchInModalEdit() {
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById("searchModalEdit");
    filter = input.value.toUpperCase();
    ul = document.getElementById("list-station-edit");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("span")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}

function setStationInListEdit(arrayStation) {
    let garagesFirst = document.getElementById('garage1_edit').options[document.getElementById('garage1_edit').selectedIndex].value;
    let garagesSecond = document.getElementById('garage2_edit').options[document.getElementById('garage2_edit').selectedIndex].value;
    let arrayListStation = [];
    let split = [];
    let arrayCheck = String(arrayStation);
    if (arrayCheck.indexOf(",") > -1) {
        split = arrayCheck.split(",");
    } else {
        split = Array(arrayCheck);
    }

    for (let i = 0; i < station.length; i++) {
        if (garagesFirst == station[i].id || garagesSecond == station[i].id) {
            continue;
        } else {
            arrayListStation.push(station[i]);
        }
    }

    $('#list-station-edit').empty();
    for (let x = 0; x < arrayListStation.length; x++) {
        let status = 0;
        let content = "<li class='list-group-item'><input class='form-check-input ml-1' type='checkbox' value='" + arrayListStation[x].id + "' id='list-edit-station-" + x + "' onclick='pushArray(this.id)'>"
            + "<span style='margin-left: 30px; min-width: 160px;'>" + arrayListStation[x].name + "</span>"
            + "<span style='margin-left: 30px;'>Địa chỉ : " + arrayListStation[x].address + "</span></li>";

        for (let y = 0; y < split.length; y++) {
            if (split[y] == arrayListStation[x].id) {
                status = 1;
                break;
            }
        }

        if (status == 1) {
            $('#list-station-edit').prepend(content);
        } else {
            $('#list-station-edit').append(content);
        }
    }

    let countLi = document.getElementById('list-station-edit').getElementsByTagName("li").length;
    for (let i = 0; i < countLi; i++) {
        let name = 'list-edit-station-' + i;
        let element = document.getElementById(name);
        let result = arrayCheck.indexOf(element.value);

        if (result > -1) {
            element.checked = true;
        }
    }
}

function setStationInListAdd() {
    let garagesFirst = document.getElementById('garage1').options[document.getElementById('garage1').selectedIndex].value;
    let garagesSecond = document.getElementById('garage2').options[document.getElementById('garage2').selectedIndex].value;

    let arrayListStation = [];

    for (let i = 0; i < station.length; i++) {
        if (garagesFirst == station[i].id || garagesSecond == station[i].id) {
            continue;
        } else {
            arrayListStation.push(station[i]);
        }
    }

    arrayListStationCurrent = arrayListStation;

    $('#list-station').empty();
    for (let x = 0; x < arrayListStation.length; x++) {
        let content = "<li class='list-group-item'><input class='form-check-input ml-1' type='checkbox' value='" + arrayListStation[x].id + "' id='list-station-" + x + "' onclick='pushArray(this.id)'>"
            + "<span style='margin-left: 30px; min-width: 160px;'>" + arrayListStation[x].name + "</span>"
            + "<span style='margin-left: 30px;'>Địa chỉ : " + arrayListStation[x].address + "</span></li>";
        $('#list-station').append(content);
    }
}

function pushArray(id) {
    let element = document.getElementById(id);
    if (element.checked) {
        currentArrayStationPush.push(element.value);
    } else {
        let index = currentArrayStationPush.indexOf(element.value);
        if (index !== -1) {
            currentArrayStationPush.splice(index, 1);
        }
    }
}