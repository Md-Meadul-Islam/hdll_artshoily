function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
}
function loadAllArtists(page, limit) {
    $.ajax({
        url: "api/artists",
        method: 'GET',
        data: { page, limit },
        dataType: 'json',
        success: function (res) {
            if (res.success && res.data.length > 0) {
                const data = res.data;
                data.forEach(artist => {
                    let elm = `<div
                            class="col-lg-3 col-md-4 col-sm-6 col-10 d-flex flex-column justify-content-center align-items-center">
                            <div class="position-relative border border-1 border-secondary">
                                <img src="../${artist['coverphoto']}" alt="${artist['first_name']}"
                                    style="width: 200px;height:200px">
                                <div class="focus-absolute overflow-hidden">
                                    <img src="../${artist['userphoto']}" alt="${artist['first_name']}">
                                </div>
                            </div>
                            <div class="pt-5 d-flex align-items-center justify-content-center flex-column">
                                <div class="py-2">
                                    <div class="goldenStroke"></div>
                                </div>
                                <div class="text-center">
                                    <p class="fs-10px fw-bold">${artist['first_name'] + ' ' + artist['last_name']}</p>
                                    <a href="viewartists?a=${artist['user_id']}"
                                        class="btn btn-sm btn-outline-secondary text-uppercase">Discover</a>
                                </div>
                            </div>
                        </div>`;
                    $('.all-artists').append(elm);
                })
            }
        },
        error: function (error) {
            console.error(error);
        }
    });
}
function loadArtsOfArtist() {
    const artistId = getQueryParam('a');
    $.ajax({
        url: "api/load-arts-of-artist",
        method: 'GET',
        data: { artistId },
        dataType: 'json',
        success: function (res) {
            if (res.success) {
                const data = res.data;
                data.forEach(art => {
                    let arts = `<div class="col-md-4 col-sm-6 col-12 p-3">
                            <div class="d-flex align-items-center justify-content-center border border-1">
                                <a href="viewart?a=${art['art_id']}">
                                    <img src="../storage/arts/${art['image']}"
                                        alt="${art['imgalt']}"
                                        style="max-height:300px; max-width:300px;width:100%;">
                                </a>
                            </div>
                            <div class="row g-0 d-flex justify-content-between align-items-start pt-2">
                                <div class="col-6">
                                    <p class="mb-0 fs-10px"><a
                                            href="viewart?a=${art['art_id']}">${art['name']}</a>
                                    </p>
                                    <p class="text-secondary fs-10px mb-0">${art['canvas_type'] + ' on ' + art['media']}
                                    </p>
                                    <p class="art-dimension text-secondary fs-10px"> ${art['size']}</p>
                                </div>
                                <div class="col-6 d-flex flex-column align-items-end">
                                    <p class="mb-0 fs-10px"><a
                                            class="cursor-pointer text-white text-uppercase rounded-0"><i
                                                class="cart-icon icon-bg-gold icon-bg-grey-hover"></i>
                                        </a>
                                    </p>
                                    <p class="text-secondary fs-10px">${art['currency'] + " " + art['price']
                        }</p >
                                </div>
                            </div>
                        </div>`;
                    $('.more-from-artist').append(arts);
                });
            }
        },
        error: function (error) {
            console.error(error);
        }
    });
}

$(document).ready(function () {
    // loadAllArtists();
    const urlPath = window.location.pathname;
    if (urlPath === '/artists') {
        loadAllArtists(1, 20);
    }
    console.log(urlPath);
    if (urlPath === '/viewartists') {
        loadArtsOfArtist();
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
        //
    });
    // load post ovserver
    $(window).on('scroll', function () {
        let windowHeight = $(window).scrollTop() + $(window).height();
    });
    $(window).resize(function () {
    });
})