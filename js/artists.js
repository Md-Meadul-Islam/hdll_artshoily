function loadAllArtists() {
    $.ajax({
        url: "/api/artists",
        method: 'GET',
        dataType: 'json',
        success: function (res) {
            console.log(res);
        },
        error: function (error) {
            console.error(error);
        }
    });
}
$(document).ready(function () {
    loadAllArtists();
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
        //
    });
    // load post ovserver
    $(window).on('scroll', function () {
        let windowHeight = $(window).scrollTop() + $(window).height();
    });
    $(window).resize(function () {
    });
})