var url = window.location.pathname;
var type = url.slice(7);
var nameMenu = capitalizeFirstLetter(type);

$(document).ready(function () {
  document.getElementById(type).className += " active";
  document.getElementById('nameMenu').innerHTML = nameMenu;

  $("#alert-message").fadeTo(2000, 500).slideUp(500, function () {
    $("#alert-message").slideUp(500);
  });
});

function capitalizeFirstLetter(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
}