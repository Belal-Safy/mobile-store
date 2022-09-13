$(document).ready(function() {
    initializeAosAnimation();
    bigNavbar();
    spinnerHide();
    $(window).scroll(bigNavbar);

    $("body").tooltip({
        selector: '[data-bs-toggle=tooltip]'
    });
});

function bigNavbar() {
    let scrollTop = (window.pageYOffset || document.documentElement.scrollTop);
    if (scrollTop < 150) {
        $(".fixed-top").css('box-shadow', 'none')
        $("#logo-img").css('width', "80px");
        $(".logo-p").css('margin-top', "17px");
    } else {
        $(".fixed-top").css('box-shadow', "0 0 8px rgba(0, 0, 0, .6)")
        $("#logo-img").css('width', "50px");
        $(".logo-p").css('margin-top', "0");
    }
}

function spinnerShow() {
    $('#spinner').css("display", "flex")
}

function spinnerHide() {
    $('#spinner').css("display", "none")
}

function initializeAosAnimation() {

    AOS.init();

    // You can also pass an optional settings object
    // below listed default settings
    AOS.init({ once: true });
}