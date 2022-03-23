var url = window.location.pathname;
var type = url.slice(7);
var nameMenu = capitalizeFirstLetter(type);

$(document).ready(function () {
  if (type == 'employee' || type == 'garages' || type == 'dashboard' || type == 'bus'
    || type == 'roads' || type == 'station' || type == 'customers'
    || type == 'trips' || type == 'contact' || type == 'partner') {
    document.getElementById(type).className += " active";
  }

  translateText();

  document.getElementById('nameHeader').innerHTML = nameMenu;
  document.getElementById('nameMenu').innerHTML = nameMenu;

  $("#alert-message").fadeTo(2000, 500).slideUp(500, function () {
    $("#alert-message").slideUp(500);
  });

  $("send-mail-only-footer").submit(function (e) {

    e.preventDefault();

    let form = $(this);
    let url = '/sendmailonly'

    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: "POST",
      url: url,
      data: form.serialize(),
      success: function (data) {
        if (data == 'success') {
          $("#alert-thank").removeClass("d-none").addClass("d-block");
          $("#alert-thank").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert-thank").slideUp(500);
            $("#alert-thank").removeClass("d-block").addClass("d-none");
          });
        }
      }
    });
  });
});

function capitalizeFirstLetter(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
}

function translateText() {
  if (type == 'employee') {
    nameMenu = 'Quản lý nhân viên';
  }

  if (type == 'garages') {
    nameMenu = 'Quản lý nhà xe';
  }

  if (type == 'dashboard') {
    nameMenu = 'Dashboard ';
  }

  if (type == 'bus') {
    nameMenu = 'Quản lý xe';
  }

  if (type == 'roads') {
    nameMenu = 'Quản lý tuyến đường';
  }

  if (type == 'station') {
    nameMenu = 'Quản lý điểm bến';
  }

  if (type == 'customers') {
    nameMenu = 'Quản lý khách hàng';
  }

  if (type == 'trips') {
    nameMenu = 'Quản lý chuyến đi';
  }

  if (type == 'contact') {
    nameMenu = 'Quản lý liên hệ';
  }

  if (type == 'partner') {
    nameMenu = 'Yêu cầu đối tác';
  }
}
