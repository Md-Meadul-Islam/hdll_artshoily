function loadBlogs(page = 1, limit = 20) {
  $.ajax({
    url: "load-blogs-paginate",
    method: "GET",
    data: { page, limit },
    success: function (res) {
      if (res.success && res.data.length > 0) {
        const data = res.data;
        data.forEach((blog, i) => {
          let elm = `<div class="col-md-8 col-12 px-lg-5 px-md-3 px-2 py-2">
                    <div class="row d-flex align-items-center justify-content-center">
                        <div class="col-md-3 col-sm-6 col-12 d-flex p-2">
                            <a class="w-100" href="https://artshoily.com/blog?b=${blog.blog_id}">
                                <img src="../${blog.image}" style="max-height:200px; width:100%; object-fit:cover;" alt="${blog.title}"/></a>
                        </div>
                        <div class="col-md-9 col-12 p-2">
                            <a href="https://artshoily.com/blog?b=${blog.blog_id}">
                                <h3 class="fw-bold" style="color:rgb(0, 122, 192)">${blog.title}</h3>
                            </a>
                            <div class="pb-2">
                                <p class="mb-0">
                                ${blog.body} <a class="text-dark fw-bold" href="https://artshoily.com/blog?b=${blog.blog_id}">...</a>
                                </p>
                            </div>
                        </div>   
                    </div>               
                </div>`;
          $("#blogs").append(elm);
        });
      }
    },
  });
}
$(document).ready(function () {
  const urlPath = window.location.pathname;
  if (urlPath === "/blogs") {
    loadBlogs(1, 20);
  }
  $("body").on("click", function (e) {
    if ($(e.target).closest(".drawer-menu a, .drawer").length) {
      if ($(e.target).closest(".drawer-menu a").length) {
        $(".drawer").toggleClass("active");
      }
    } else {
      $(".drawer").removeClass("active");
    }
  });
});
