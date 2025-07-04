function getQueryParam(param) {
  const urlParams = new URLSearchParams(window.location.search);
  return urlParams.get(param);
}
function loadArtsPagainated(payload) {
  $.ajax({
    url: "/load-art-paginate",
    method: "GET",
    data: { ...payload },
    success: function (res) {
      if (res.success && res.data.arts.length > 0) {
        const arts = res.data.arts;
        const artsDiv = $("#arts");
        artsDiv.empty();
        arts.forEach((art) => {
          const userLinks = art.users
            .map((user) => {
              return `<a href="viewartists/?a=${user.user_id}">${user.first_name} ${user.last_name}</a>`;
            })
            .join(", ");

          const readablePrice = art.price
            .replace(/_/g, " ")
            .replace(/\b\w/g, (char) => char.toUpperCase());

          const artsData = `
            <div class="col-md-4 col-sm-6 col-12 p-3">
              <div class="d-flex align-items-center justify-content-center border border-1">
                <a href="viewart?a=${art.art_id}">
                  <img src="../storage/arts/${art.image}"
                       alt="${art.imgalt}"
                       style="max-height:300px; max-width:300px; width:100%;">
                </a>
              </div>
              <div class="row g-0 d-flex justify-content-between align-items-end pt-2">
                <div class="col-6">
                  <p class="mb-0 fs-10px">
                    <a href="viewart?a=${art.art_id}" class="text-dark fw-bold">${art.name}</a>
                  </p>
                  <p class="text-secondary fs-10px mb-0">${art.canvas_type} on ${art.media}</p>
                  <p class="art-dimension text-secondary fs-10px" title="">${art.size}</p>
                </div>
                <div class="col-6 d-flex flex-column align-items-end">
                  <p class="mb-0 fs-10px">
                    <a class="cursor-pointer text-white text-uppercase rounded-0">
                      <i class="cart-icon icon-bg-gold icon-bg-grey-hover"></i>
                    </a>
                  </p>
                  <p class="text-secondary fs-10px mb-0">${userLinks}</p>
                  <p class="text-secondary fs-10px text-capitalize">${readablePrice}</p>
                </div>
              </div>
            </div>
          `;

          artsDiv.append(artsData);
        });
      }
    },
  });
}

function moreFromArtist() {
  const suggestions = $(".suggestions");
  const user_id = suggestions.data("userid");
  const user_name = suggestions.data("username");
  const art_id = getQueryParam("a");

  $.ajax({
    url: "api/more-from-artists",
    method: "GET",
    data: { user_id, art_id },
    success: function (res) {
      if (res.success && res.data.length > 0) {
        const data = res.data;
        let heading = `<h4>More From <a href="viewartists/?a=${user_id}" class="text-danger">${user_name}</a></h4>`;
        suggestions.prepend(heading);
        data.forEach((art) => {
          let suggestionData = `<div class="col-lg-2 col-md-3 col-6">
                    <a href="viewart/?a=${art["art_id"]}">
                        <img src="../storage/arts/${art["image"]}"
                            alt="${art["imgalt"]}"
                            style="max-height:300px; max-width:300px;width:100%;">
                    </a>
                    <p class="mb-0 fs-10px"><a href="viewart/?a=${
                      art["art_id"]
                    }" class="text-dark fw-bold">${art["name"]}</a></p>
                    <p class="text-secondary fs-10px mb-0">
                    ${art["canvas_type"] + " on " + art["media"]}
                    </p>
                    <p class="art-dimension text-secondary fs-10px mb-0" title="">
                        ${art["size"]}
                    </p>
                    <p class="text-secondary fs-10px">
                            ${art["currency"] + " " + art["price"]}
                    </p>
                </div>`;
          suggestions.append(suggestionData);
        });
      }
    },
  });
}
$(document).ready(function () {
  const urlPath = window.location.pathname;
  if (urlPath === "/art-gallery") {
    loadArtsPagainated({ page: 1, limit: 20 });
  }
  if (urlPath === "/viewart") {
    moreFromArtist();
  }

  let moreDescBtnClicked = false;
  $("body").on("click", function (e) {
    if ($(e.target).closest(".drawer-menu a, .drawer").length) {
      if ($(e.target).closest(".drawer-menu a").length) {
        $(".drawer").toggleClass("active");
      }
    } else {
      $(".drawer").removeClass("active");
    }

    if ($(e.target).closest(".more-description-btn").length) {
      const $this = $(".more-description-btn");
      const artDescDiv = $(".art-desc");
      const originalText = artDescDiv.html().trim(); // Store the original text
      const remainWords = artDescDiv.data("remain");

      if (!moreDescBtnClicked) {
        moreDescBtnClicked = true;
        artDescDiv.html(originalText + " " + remainWords); // Append text
        $this
          .find("i")
          .addClass("angle-up-icon")
          .removeClass("angle-down-icon");
      } else {
        moreDescBtnClicked = false;
        const first100Words = originalText.split(" ").slice(0, 100).join(" ");
        artDescDiv.html(first100Words); // Reset text
        $this
          .find("i")
          .addClass("angle-down-icon")
          .removeClass("angle-up-icon");
      }
    }
    if (e.target.id === "filter-apply") {
      const artName = $("#filter-art").val();
      const artistName = $("#filter-artist").val();
      const price = $("#filter-price").val();
      const payload = { page: 1, limit: 20 };
      if (artName) {
        payload.art_name = artName;
      }
      if (artistName) {
        payload.artist_name = artistName;
      }
      if (price) {
        payload.price = price;
      }
      loadArtsPagainated(payload);
    }
    if (e.target.id === "filter-reset") {
      $("#filter-art").val("");
      $("#filter-artist").val("");
      $("#filter-price").val("");

      // Optionally clear art container
      $("#arts").empty();

      const payload = { page: 1, limit: 20 };
      loadArtsPagainated(payload);
    }
  });

  // load post ovserver
  $(window).on("scroll", function () {
    let windowHeight = $(window).scrollTop() + $(window).height();
  });
  $(window).resize(function () {});
});
