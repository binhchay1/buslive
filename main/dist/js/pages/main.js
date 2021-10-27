var app = angular.module('adminApp', []);

app.controller('switchCtrl', function ($scope) {

  $scope.templates = [{
    name: 'Dashboard',
    url: 'dashboard.html',
    type: 'dashboard',
    active: 1,
  }, {
    name: 'Employee',
    url: 'employee.html',
    type: 'employee',
    active: 0,
  }, {
    name: 'Garages',
    url: 'garages.html',
    type: 'garages',
    active: 0,
  }];

  $scope.template = $scope.templates[0];
  $scope.type = 'dashboard';

  $scope.switchMenu = function (type) {
    let tem = $scope.templates.find(x => x.active == 1);
    tem.active = 0;
    document.getElementById(tem.type).className = document.getElementById(tem.type).className.replace(" active", "");
    let activeTem = $scope.templates.find(x => x.type == type);
    $scope.type == type;
    activeTem.active = 1;
    $scope.template = activeTem;
    document.getElementById(activeTem.type).className += " active";
  }


  $scope.backHome = function () {
    $scope.switchMenu('dashboard');
  }

});


app.controller('dashboardController', function ($scope) {
  $(function () {
    'use strict'

    let ticksStyle = {
      fontColor: '#495057',
      fontStyle: 'bold'
    }

    let mode = 'index';
    let intersect = true

    let $salesChart = $('#sales-chart')
    let salesChart = new Chart($salesChart, {
      type: 'bar',
      data: {
        labels: ['JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
        datasets: [
          {
            backgroundColor: '#007bff',
            borderColor: '#007bff',
            data: [1000, 2000, 3000, 2500, 2700, 2500, 3000]
          },
          {
            backgroundColor: '#ced4da',
            borderColor: '#ced4da',
            data: [700, 1700, 2700, 2000, 1800, 1500, 2000]
          }
        ]
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          mode: mode,
          intersect: intersect
        },
        hover: {
          mode: mode,
          intersect: intersect
        },
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            gridLines: {
              display: true,
              lineWidth: '4px',
              color: 'rgba(0, 0, 0, .2)',
              zeroLineColor: 'transparent'
            },
            ticks: $.extend({
              beginAtZero: true,
              callback: function (value) {
                if (value >= 1000) {
                  value /= 1000
                  value += 'k'
                }

                return '$' + value
              }
            }, ticksStyle)
          }],
          xAxes: [{
            display: true,
            gridLines: {
              display: false
            },
            ticks: ticksStyle
          }]
        }
      }
    })

    let $visitorsChart = $('#visitors-chart')
    let visitorsChart = new Chart($visitorsChart, {
      data: {
        labels: ['18th', '20th', '22nd', '24th', '26th', '28th', '30th'],
        datasets: [{
          type: 'line',
          data: [100, 120, 170, 167, 180, 177, 160],
          backgroundColor: 'transparent',
          borderColor: '#007bff',
          pointBorderColor: '#007bff',
          pointBackgroundColor: '#007bff',
          fill: false,
          pointHoverBackgroundColor: '#007bff',
          pointHoverBorderColor: '#007bff'
        },
        {
          type: 'line',
          data: [60, 80, 70, 67, 80, 77, 100],
          backgroundColor: 'tansparent',
          borderColor: '#ced4da',
          pointBorderColor: '#ced4da',
          pointBackgroundColor: '#ced4da',
          fill: false,
          pointHoverBackgroundColor: '#ced4da',
          pointHoverBorderColor: '#ced4da'
        }]
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          mode: mode,
          intersect: intersect
        },
        hover: {
          mode: mode,
          intersect: intersect
        },
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            gridLines: {
              display: true,
              lineWidth: '4px',
              color: 'rgba(0, 0, 0, .2)',
              zeroLineColor: 'transparent'
            },
            ticks: $.extend({
              beginAtZero: true,
              suggestedMax: 200
            }, ticksStyle)
          }],
          xAxes: [{
            display: true,
            gridLines: {
              display: false
            },
            ticks: ticksStyle
          }]
        }
      }
    })
  });
});

app.controller('employeeCtrl', function ($scope) {

  $('#editModal').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget)
    let id = button.data('id');
    let role = button.data('role');
    let name = button.data('name');
    let phone = button.data('phone');
    let modal = $(this);

    modal.find('.modal-body #id').val(id);
    modal.find('.modal-body #role').val(role);
    modal.find('.modal-body #name').val(name);
    modal.find('.modal-body #phone').val(phone);
  });

  $('#deleteModal').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget)
    let id = button.data('id');
    let name = button.data('name');
    let modal = $(this);

    modal.find('.modal-body #id_delete').val(id);
    modal.find('.modal-body #name_delete').text(name);
  });
});

app.controller('garagesCtrl', function ($scope) {
  $('#deleteModal').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget)
    let id = button.data('id');
    let name = button.data('name');
    let modal = $(this);

    modal.find('.modal-body #id_delete').val(id);
    modal.find('.modal-body #name_delete').text(name);
  });
});