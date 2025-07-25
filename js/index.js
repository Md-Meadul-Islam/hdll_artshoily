function loadLimitedEditionPrints() {
  $.ajax({
    url: "api/load-limited-edition-prints",
    method: "GET",
    success: function (res) {
      if (res.success && res.data.length > 0) {
        const data = res.data;
        data.forEach((art) => {
          let elm = ` <div class="col-md-4 col-sm-6 col-12">
                                <div class="d-flex align-items-center justify-content-center w-100">
                                <a href="viewart?a=${
                                  art["art_id"]
                                }" class="w-100">
                                    <img src="../storage/arts/${
                                      art["image"]
                                    }" alt="editions"
                                        style="max-height:300px; width:100%;object-fit:cover">
                                        </a>
                                </div>
                                <div class="row g-0 d-flex justify-content-between align-items-end pt-2">
                                    <div class="col-6">
                                        <p class="mb-0 fs-10px"><a href="viewart?a=${
                                          art["art_id"]
                                        }">${art["name"]}</a></p>
                                        <p class="text-secondary fs-10px mb-0">${
                                          art["canvas_type"] +
                                          " on " +
                                          art["media"]
                                        }</p>
                                        <p class="text-secondary fs-10px">${
                                          art["size"]
                                        }</p>
                                    </div>
                                    <div class="col-6 d-flex flex-column align-items-end">
                                        <p class="text-secondary fs-10px mb-0"><a href="viewartists?a=${
                                          art["users"][0]["user_id"]
                                        }">${
            art["users"][0]["first_name"] + " " + art["users"][0]["last_name"]
          }</a></p>
                                        <p class="text-secondary fs-10px text-capitalize">${art[
                                          "price"
                                        ]
                                          .split("_")
                                          .join(" ")}</p>
                                    </div>
                                </div>
                            </div>`;
          $(".limited-edition").append(elm);
        });
      }
    },
  });
}
function focusArtists() {
  $.ajax({
    url: "api/focus-artists",
    method: "GET",
    success: function (res) {
      if (res.success && res.data.length > 0) {
        const data = res.data;
        data.forEach((artist) => {
          let elm = `<div
                            class="col-lg-3 col-md-4 col-sm-8 col-10 d-flex flex-column justify-content-center align-items-center">
                            <div class="position-relative">
                                <img src="../${artist["coverphoto"]}" alt="${
            artist["first_name"]
          }"
                                    style="width: 200px;height:200px">
                                <div class="focus-absolute overflow-hidden">
                                    <img src="../${artist["userphoto"]}" alt="${
            artist["first_name"]
          }">
                                </div>
                            </div>
                            <div class="pt-5 d-flex align-items-center justify-content-center flex-column">
                                <div class="py-2">
                                    <div class="goldenStroke"></div>
                                </div>
                                <div class="text-center">
                                    <p class="fs-10px fw-bold">${
                                      artist["first_name"] +
                                      " " +
                                      artist["last_name"]
                                    }</p>
                                    <a href="viewartists?a=${artist["user_id"]}"
                                        class="btn btn-sm btn-outline-secondary text-uppercase">Discover</a>
                                </div>
                            </div>
                        </div>`;
          $(".focus-artists").append(elm);
        });
      }
    },
  });
}
function homeSculpture() {
  $.ajax({
    url: "api/home-sculptures",
    method: "GET",
    success: function (res) {
      if (res.success && res.data.length > 0) {
        const data = res.data;
        data.forEach((sculp) => {
          let elm = `<div class="col-md-4 col-sm-6 col-12">
                            <div class="d-flex align-items-center justify-content-center">
                            <a href="/view-sculpture?a=${
                              sculp["sculpture_id"]
                            }"><img src="../${sculp["image"]}" alt="${
            sculp["imgalt"]
          }"
                                    style="height:300px; width:100%;object-fit:cover">
                                    </a>
                            </div>
                            <div class="row g-0 d-flex justify-content-between align-items-end pt-2">
                                <div class="col-6">
                                    <p class="mb-0 fs-10px fw-bold"><a href="/view-sculpture?a=${
                                      sculp["sculpture_id"]
                                    }" class="text-dark">${
            sculp["name"]
          }</a></p>
                                    <p class="text-secondary fs-10px mb-0">${
                                      sculp["media"]
                                    }</p>
                                    <p class="text-secondary fs-10px">${
                                      sculp["size"]
                                    }</p>
                                </div>
                                <div class="col-6 d-flex flex-column align-items-end">
                                    <p class="text-secondary fs-10px">${
                                      sculp["currency"] + " " + sculp["price"]
                                    }</p>
                                </div>
                            </div>
                        </div>`;
          $(".home-sculptures").append(elm);
        });
      }
    },
  });
}
$(document).ready(function () {
  const urlPath = window.location.pathname;
  if (urlPath === "/") {
    loadLimitedEditionPrints();
    focusArtists();
    homeSculpture();
  }
  function generateUUID() {
    return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(
      /[xy]/g,
      function (c) {
        var r = (Math.random() * 16) | 0,
          v = c === "x" ? r : (r & 0x3) | 0x8;
        return v.toString(16);
      }
    );
  }
  let deviceUUID = localStorage.getItem("deviceUUID");
  if (!deviceUUID) {
    deviceUUID = generateUUID();
    localStorage.setItem("deviceUUID", deviceUUID);
  }
  $("body").on("click", function (e) {
    if ($(e.target).closest(".drawer-menu a, .drawer").length) {
      if ($(e.target).closest(".drawer-menu a").length) {
        $(".drawer").toggleClass("active");
      }
    } else {
      $(".drawer").removeClass("active");
    }

    if ($(e.target).closest(".more-btn").length) {
      let moreBtn = $(e.target).closest(".more-btn");
      let moreText = moreBtn.nextAll(".more-text");
      let moreDot = moreBtn.next(".more-dot");

      moreBtn.css("color", "black");
      moreText.toggleClass("d-none");
      moreDot.toggleClass("d-none");
    }
  });

  // Handle the back/forward navigation
  window.addEventListener("popstate", function (e) {});
  // load post ovserver
  $(window).on("scroll", function () {
    let windowHeight = $(window).scrollTop() + $(window).height();
  });
  $(window).resize(function () {});
});
