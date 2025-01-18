function loadBlogs(page = 1, limit = 20) {
    $.ajax({
        url: 'load-blogs-paginate',
        method: 'GET',
        data: { page, limit },
        success: function (res) {
            if (res.success && res.data.length > 0) {
                const data = res.data;
                data.forEach((blog, i) => {

                    let elm = `<div class="col-md-10 col-12 pt-lg-4 pt-md-3 pt-2 p-2">
                    <div class="row g-3 d-flex justify-content-center">
                        <div class="col-md-4 col-sm-6 col-12 ${i % 2 == 0 ? '' : 'order-2'}">
                            <img src="../${blog.image}" class="w-100 border border-2 rounded-2" alt="${blog.imgalt}">
                        </div>
                        <div class="col-md-8 col-sm-6 col-12">
                            <a href="blog?b=${blog.blog_id}">
                                <h4 class="fw-bold text-underline-hover">${blog.title}</h4>
                            </a>
                            <p>${blog.body}</p>
                        </div>
                    </div>
                </div>`;
                    $('.blogs').append(elm);
                });
            }
        }
    })
}
$(document).ready(function () {
    const urlPath = window.location.pathname;
    // if (urlPath === '/blogs') {
    //     loadBlogs(1, 20);
    // }
    $('body').on('click', function (e) {
        if ($(e.target).closest('.drawer-menu a, .drawer').length) {
            if ($(e.target).closest('.drawer-menu a').length) {
                $('.drawer').toggleClass('active');
            }
        } else {
            $('.drawer').removeClass('active');
        }
    });
})