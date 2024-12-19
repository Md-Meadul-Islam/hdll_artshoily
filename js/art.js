function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
}
function moreFromArtist() {
    const suggestions = $('.suggestions');
    const user_id = suggestions.data('userid');
    const user_name = suggestions.data('username');
    const art_id = getQueryParam('a');

    $.ajax({
        url: 'api/more-from-artists',
        method: "GET",
        data: { user_id, art_id },
        success: function (res) {
            if (res.success && res.data.length > 0) {
                const data = res.data;
                let heading = `<h4>More From <a href="viewartists/?a=${user_id}" class="text-danger">${user_name}</a></h4>`;
                suggestions.prepend(heading);
                data.forEach(art => {
                    let suggestionData = `<div class="col-lg-2 col-md-3 col-6">
                    <a href="viewart/?a=${art['art_id']}">
                        <img src="../storage/arts/${art['image']}"
                            alt="${art['imgalt']}"
                            style="max-height:300px; max-width:300px;width:100%;">
                    </a>
                    <p class="mb-0 fs-10px">${art['name']}</p>
                    <p class="text-secondary fs-10px mb-0">
                    ${art['canvas_type'] + ' on ' + art['media']}
                    </p>
                    <p class="art-dimension text-secondary fs-10px mb-0" title="">
                        ${art['size']}
                    </p>
                    <p class="text-secondary fs-10px">
                            ${art['currency'] + ' ' + art['price']}
                    </p>
                </div>`;
                    suggestions.append(suggestionData);
                });
            }
        }
    })
}
$(document).ready(function () {
    moreFromArtist();
    let moreDescBtnClicked = false;
    $('body').on('click', function (e) {
        if ($(e.target).closest('.drawer-menu a, .drawer').length) {
            if ($(e.target).closest('.drawer-menu a').length) {
                $('.drawer').toggleClass('active');
            }
        } else {
            $('.drawer').removeClass('active');
        }

        if ($(e.target).closest('.more-description-btn').length) {
            const $this = $('.more-description-btn');
            const artDescDiv = $('.art-desc');
            const originalText = artDescDiv.html().trim(); // Store the original text
            const remainWords = artDescDiv.data('remain');

            if (!moreDescBtnClicked) {
                moreDescBtnClicked = true;
                artDescDiv.html(originalText + ' ' + remainWords);  // Append text
                $this.find('i').addClass('angle-up-icon').removeClass('angle-down-icon');
            } else {
                moreDescBtnClicked = false;
                const first100Words = originalText.split(' ').slice(0, 100).join(' ');
                artDescDiv.html(first100Words);  // Reset text
                $this.find('i').addClass('angle-down-icon').removeClass('angle-up-icon');
            }
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