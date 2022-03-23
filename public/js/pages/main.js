$(document).ready(function () {
    function injectSvgSprite(path) {

        let ajax = new XMLHttpRequest();
        ajax.open("GET", path, true);
        ajax.send();
        ajax.onload = function (e) {
            let div = document.createElement("div");
            div.className = 'd-none';
            div.innerHTML = ajax.responseText;
            document.body.insertBefore(div, document.body.childNodes[0]);
        }
    }

    $("#alert-success").fadeTo(2000, 500).slideUp(500, function() {
        $("#alert-success").slideUp(500);
        $("#alert-success").removeClass("d-block").addClass("d-none");
    });

    injectSvgSprite('https://bootstraptemple.com/files/icons/orion-svg-sprite.svg');

    let countDownDate = new Date("Dec 28, 2021 12:00:00").getTime();
    let x = setInterval(function () {
        let now = new Date().getTime();
        let distance = countDownDate - now;
        let days = Math.floor(distance / (1000 * 60 * 60 * 24));
        let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById("button-countdown-days").textContent = days + ' ngày';
        document.getElementById("button-countdown-hours").textContent = hours + ' giờ';
        document.getElementById("button-countdown-mins").textContent = minutes + ' phút';
        document.getElementById("button-countdown-seconds").textContent = seconds + ' giây';

        if (distance < 0) {
            clearInterval(x);
            document.getElementById("button-countdown-days").textContent = 0 + 'ngày';
            document.getElementById("button-countdown-hours").textContent = 0 + 'giờ';
            document.getElementById("button-countdown-mins").textContent = 0 + 'phút';
        }
    }, 1000);
})