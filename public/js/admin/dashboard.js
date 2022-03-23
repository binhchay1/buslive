var mode = 'index';
var intersect = true;
var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
}

var datasetsSaleCurrent = [];
var datasetsSaleLast = [];

var datasetsAccess = [];

$(document).ready(function () {
    let d = new Date();
    let currentYear = d.getFullYear();
    getDataOrder();
    getDataAnalysis('year', currentYear);

    $('#yearPicker').datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years"
    }).on('changeDate', function (ev) {
        getDataAnalysis('year', ev.format());
    });

    $('#monthPicker').datepicker({
        format: "mm-yyyy",
        startView: "months",
        minViewMode: "months"
    }).on('changeDate', function (ev) {
        getDataAnalysis('month', ev.format());
    });
});

function getDataOrder() {
    $.ajax({
        url: '/admin/getanalystorder',
        type: 'GET'
    }).done(function (response) {
        let dataAjax = response['each_month'];
        let datasetsOrderCurrent = [];

        for (let i = 0; i < dataAjax.length; i++) {
            datasetsOrderCurrent.push(dataAjax[i][0]);
        }

        document.getElementById('total-order').innerHTML = response.total;

        let salesChartCanvas = document.getElementById('revenue-chart-canvas').getContext('2d')

        let salesChartData = {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            datasets: [
                {
                    label: 'Digital Goods',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: datasetsOrderCurrent
                },
            ]
        }

        let salesChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        display: false
                    }
                }],
                yAxes: [{
                    gridLines: {
                        display: false
                    }
                }]
            }
        }

        let salesChart = new Chart(salesChartCanvas, {
            type: 'line',
            data: salesChartData,
            options: salesChartOptions
        })
    });
}

function getDataAnalysis(type, date) {
    $.ajax({
        url: '/admin/getdataanalysis',
        type: 'GET',
        data: {
            type: type,
            date: date
        },
    }).done(function (response) {
        let text = '';
        if (type == 'year') {
            text = 'năm ' + date;
        } else {
            let split = date.split('-');
            let month = split[0];
            let year = split[1];
            text = 'tháng ' + month + ' năm ' + year;
        }
        document.getElementById('date-card-text').innerHTML = text;

        let checkNull = 0;
        if (typeof response.datasets[0].data !== 'undefined' && response.datasets[0].data !== false) {
            for (let i = 0; i < response.datasets[0].data.length; i++) {
                if (response.datasets[0].data[i] > 0) {
                    checkNull = 1;
                }
            }
        }

        if (checkNull == 0) {
            $('#message-none').attr('class', '');
            $('#message-none').attr('class', 'd-flex justify-content-center');
        }

        let pieChartCanvas = $('#pieChart').get(0).getContext('2d')
        let pieData = response;
        let pieOptions = {
            maintainAspectRatio: false,
            responsive: true,
        }

        new Chart(pieChartCanvas, {
            type: 'pie',
            data: pieData,
            options: pieOptions
        })
    });
}

function formatDate(date) {
    let dd = date.getDate();
    let mm = date.getMonth() + 1;
    let yyyy = date.getFullYear();
    if (dd < 10) { dd = '0' + dd }
    if (mm < 10) { mm = '0' + mm }
    date = yyyy + '-' + mm + '-' + dd
    return date
}

function Last7Days() {
    let result = [];
    for (let i = 0; i < 7; i++) {
        let d = new Date();
        d.setDate(d.getDate() - i);
        result.push(formatDate(d))
    }

    return result;
}