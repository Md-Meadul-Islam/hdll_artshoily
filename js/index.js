$(document).ready(function () {
    function generateUUID() {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
            var r = Math.random() * 16 | 0,
                v = c === 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    }
    let deviceUUID = localStorage.getItem('deviceUUID');
    if (!deviceUUID) {
        deviceUUID = generateUUID();
        localStorage.setItem('deviceUUID', deviceUUID);
    }
    $('body').on('click', function (e) {
        if ($(e.target).closest('.drawer-menu a, .drawer').length) {
            if ($(e.target).closest('.drawer-menu a').length) {
                $('.drawer').toggleClass('active');
            }
        } else {
            $('.drawer').removeClass('active');
        }
    });


    // Handle the back/forward navigation
    window.addEventListener('popstate', function (e) {

    });
    // load post ovserver
    $(window).on('scroll', function () {
        let windowHeight = $(window).scrollTop() + $(window).height();
    });
    $(window).resize(function () {
    });
})