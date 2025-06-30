let arts = [];
let users = [];
let sculptures = [];
let blogs = [];
window.focusArtists = [];
function formatDoc(cmd, value = null) {
  if (value) {
    document.execCommand(cmd, false, value);
  } else {
    document.execCommand(cmd);
  }
}
function addLink() {
  var url = prompt("Insert url");
  if (url) {
    $("#textbody").focus();
    formatDoc("createLink", url);
  }
}
function sanitizeTextTag(body) {
  // Decode HTML entities
  body = body.replace(/&lt;/g, "<").replace(/&gt;/g, ">");
  body = body.replace(/&nbsp;/g, " ");

  // Remove styles but keep content
  body = body.replace(/<span[^>]*style="[^"]*"[^>]*>(.*?)<\/span>/gi, "$1");
  // Remove <style> tags and their content
  body = body.replace(/<style[^>]*>[\s\S]*?<\/style>/gi, "");

  // Remove all class properties
  body = body.replace(/ class="[^"]*"/gi, "");

  // Remove extra <o:p> tags
  body = body.replace(/<o:p[^>]*>.*?<\/o:p>/gi, "");

  // Replace <div> with spaces and remove script and PHP tags
  body = body.replace(/<div>/g, " ").replace(/<\/div>/g, " ");
  body = body.replace(/<script[^>]*>/gi, '<div class="code">');
  body = body.replace(/<\/script>/gi, "</div>");
  body = body.replace(/<\?php/gi, '<div class="code">');
  body = body.replace(/\?>/gi, "</div>");

  // Trim extra spaces
  body = body.trim();

  return body;
}
function fetchArts(page = 1, limit = 50) {
  return $.ajax({
    url: "/admin/load-arts-paginate",
    method: "GET",
    data: { page, limit },
  });
}
function renderArtsTable(data) {
  $("#main-table thead").html("");
  $("#main-table tbody").html("");

  const tableHead = `<tr><th>#</th>
    <th>Name</th>
    <th>Image</th>
    <th>Artists</th>
    <th>Price</th>
    <th>Action</th>
    <th>Create at</th></tr>`;
  $("#main-table thead").html(tableHead);

  data.forEach((d, k) => {
    renderArtsRow(d, k + 1);
  });
}
function renderArtsRow(art, index) {
  const comma = art.users.length > 1 ? ", " : "";
  let tr = `<tr data-id="${art.art_id}" key="${art.id}">
    <td>${index}</td>
    <td>${art.name}</td>
    <td>
        <div>
            <img src="../storage/arts/${art.image}" alt="" width="80px" height="60px">
        </div>
    </td>
    <td class="">`;
  art.users.forEach((user, i) => {
    tr += `<a class="bg-dark text-white ms-1 fs-8px"> ${
      user.first_name + " " + user.last_name
    }</a> ${i == 0 ? comma : ""}`;
  });
  tr += `</td>
    <td>${art.price + " " + art.currency} </td>
    <td>
        <div class="d-flex gap-1 align-items-center justify-content-center">
         <a class="copy-art btn btn-sm bg-success text-white"
                data-bs-toggle="modal" data-bs-target="#staticmodal" id="copy-art">Copy</a>
            <a class="edit-arts btn btn-sm bg-primary text-white text-nowrap" id="edit-art"
                data-bs-toggle="modal" data-bs-target="#staticmodal">Full Edit</a>
            <a class="delete-arts btn btn-sm bg-danger">Delete</a>
        </div>
    </td>
    <td>${art.cr_at}</td>
</tr>`;
  $("#main-table tbody").append(tr);
}
function addedOrUpdatedArt(art) {
  art.users = JSON.parse(art.users);
  // Find the index of the artist with the same user_id
  const index = arts.findIndex((a) => a.art_id === art.art_id);

  if (index !== -1) {
    // Update the existing artist data
    arts[index] = art;
  } else {
    // If the artist is not found, add it to the beginning of the array
    arts.unshift(art);
  }

  // Clear the current table body
  $("#main-table tbody").html("");

  // Re-render the table with the updated artists array
  arts.forEach((art, index) => {
    renderArtsRow(art, index + 1);
  });
}
function loadArtsPaginate(page = 1) {
  fetchArts(page)
    .then((res) => {
      if (res.success && res.data.length) {
        arts = res.data; // Update the global artists array
        renderArtsTable(arts);
      }
    })
    .catch((err) => {
      console.error("Failed to fetch artists", err);
    });
}

function fetchUsers(page = 1, limit = 50) {
  return $.ajax({
    url: "/admin/load-users-paginate",
    method: "GET",
    data: { page, limit },
  });
}
function renderUsersTable(data) {
  $("#main-table thead").html("");
  $("#main-table tbody").html("");

  const tableHead = `<tr>
        <th>#</th>
        <th>Name</th>
        <th>Image</th>
        <th>Role</th>
        <th>Action</th>
        <th>Create at</th>
    </tr>`;
  $("#main-table thead").html(tableHead);

  data.forEach((d, k) => {
    renderUsersRow(d, k + 1);
  });
}
function renderUsersRow(user, index) {
  const tr = `<tr data-id="${user.user_id}" key="${user.id}">
        <td>${index}</td>
        <td>${user.first_name + " " + user.last_name}</td>
        <td>
            <div>
                <img src="../${
                  user.userphoto
                }" alt="" width="80px" height="60px">
            </div>
        </td>
       <td>${user.userrole}</td>
        <td>
            <div class="d-flex gap-1 align-items-center justify-content-center">
                <a class="edit-user btn btn-sm bg-primary text-white text-nowrap" id="edit-user"
                    data-bs-toggle="modal" data-bs-target="#staticmodal">Full Edit</a>
                <a class="delete-user btn btn-sm bg-danger">Delete</a>
            </div>
        </td>
        <td>${user.cr_at}</td>
    </tr>`;
  $("#main-table tbody").append(tr);
}
function addedOrUpdatedUser(user) {
  // Find the index of the user with the same user_id
  const index = users.findIndex((a) => a.user_id === user.user_id);

  if (index !== -1) {
    // Update the existing user data
    users[index] = user;
  } else {
    // If the user is not found, add it to the beginning of the array
    users.unshift(user);
  }

  // Clear the current table body
  $("#main-table tbody").html("");

  // Re-render the table with the updated users array
  users.forEach((user, index) => {
    renderUsersRow(user, index + 1);
  });
}
function loadUsersPaginate(page = 1) {
  fetchUsers(page)
    .then((res) => {
      if (res.success && res.data.length) {
        users = res.data; // Update the global users array
        renderUsersTable(users);
      }
    })
    .catch((err) => {
      console.error("Failed to fetch artists", err);
    });
}

function fetchSculptures(page = 1, limit = 50) {
  return $.ajax({
    url: "/admin/load-sculptures-paginate",
    method: "GET",
    data: { page, limit },
  });
}
function renderSculpturesTable(data) {
  $("#main-table thead").html("");
  $("#main-table tbody").html("");

  const tableHead = `<tr><th>#</th>
    <th>Name</th>
    <th>Image</th>
    <th>Artists</th>
    <th>Price</th>
    <th>Action</th>
    <th>Create at</th></tr>`;
  $("#main-table thead").html(tableHead);

  data.forEach((d, k) => {
    renderSculpturesRow(d, k + 1);
  });
}
function renderSculpturesRow(sculpture, index) {
  const comma = sculpture.users.length > 1 ? ", " : "";
  let tr = `<tr data-id="${sculpture.sculpture_id}" key="${sculpture.id}">
    <td>${index}</td>
    <td>${sculpture.name}</td>
    <td>
        <div>
            <img src="../${sculpture.image}" alt="" width="80px" height="60px">
        </div>
    </td>
    <td class="">`;
  sculpture.users.forEach((user, i) => {
    tr += `<a class="bg-dark text-white ms-1 fs-8px"> ${
      user.first_name + " " + user.last_name
    }</a> ${i == 0 ? comma : ""}`;
  });
  tr += `</td>
    <td>${sculpture.price + " " + sculpture.currency} </td>
    <td>
        <div class="d-flex gap-1 align-items-center justify-content-center">
         <a class="copy-sculpture btn btn-sm bg-success text-white"
                data-bs-toggle="modal" data-bs-target="#staticmodal" id="copy-sculpture">Copy</a>
            <a class="edit-sculpture btn btn-sm bg-primary text-white text-nowrap" id="edit-sculpture"
                data-bs-toggle="modal" data-bs-target="#staticmodal">Full Edit</a>
            <a class="delete-sculpture btn btn-sm bg-danger">Delete</a>
        </div>
    </td>
    <td>${sculpture.cr_at}</td>
</tr>`;
  $("#main-table tbody").append(tr);
}
function addedOrUpdatedSculpture(sculp) {
  sculp.users = JSON.parse(sculp.users);
  // Find the index of the sculpist with the same user_id
  const index = sculptures.findIndex(
    (a) => a.sculpture_id === sculp.sculpture_id
  );

  if (index !== -1) {
    // Update the existing sculpist data
    sculptures[index] = sculp;
  } else {
    // If the sculpist is not found, add it to the beginning of the array
    sculptures.unshift(sculp);
  }

  // Clear the current table body
  $("#main-table tbody").html("");

  // Re-render the table with the updated sculpists array
  sculptures.forEach((sculp, index) => {
    renderSculpturesRow(sculp, index + 1);
  });
}
function loadSculpturePaginate(page = 1) {
  fetchSculptures(page)
    .then((res) => {
      if (res.success && res.data.length) {
        sculptures = res.data; // Update the global artists array
        renderSculpturesTable(sculptures);
      }
    })
    .catch((err) => {
      console.error("Failed to fetch artists", err);
    });
}

function fetchBlogs(page = 1, limit = 50) {
  return $.ajax({
    url: "/load-blogs-paginate",
    method: "GET",
    data: { page, limit },
  });
}
function renderBlogTable(data) {
  $("#main-table thead").html("");
  $("#main-table tbody").html("");
  const tableHead = `<tr>
    <th>#</th>
    <th>Title</th>
    <th>Image</th>
    <th>User</th>
    <th>Action</th>
    <th>Create at</th>
</tr>`;
  $("#main-table thead").html(tableHead);
  data.forEach((d, k) => {
    renderBlogRow(d, k + 1);
  });
}
function renderBlogRow(blog, index) {
  const tr = `<tr data-id="${blog.blog_id}" key="${blog.id}">
        <td>${index}</td>
        <td>${blog.title}</td>
        <td>
            <div>
                <img src="../${blog.image}" alt="" width="80px" height="60px">
            </div>
        </td>
         <td>${blog.user.first_name}</td>
        <td>        
            <div class="d-flex gap-1 align-items-center justify-content-center">
                <a class="edit-blog btn btn-sm bg-primary text-white text-nowrap" id="edit-blog"
                    data-bs-toggle="modal" data-bs-target="#staticmodal">Full Edit</a>
                <a class="delete-blog btn btn-sm bg-danger">Delete</a>
            </div>
        </td>
        <td>${blog.cr_at}</td>
    </tr>`;
  $("#main-table tbody").append(tr);
}
function addedOrUpdatedBlog(blog) {
  blog.user = JSON.parse(blog.user);
  // Find the index of the blogist with the same user_id
  const index = blogs.findIndex((a) => a.blog_id === blog.blog_id);

  if (index !== -1) {
    // Update the existing blogist data
    blogs[index] = blog;
  } else {
    // If the blogist is not found, add it to the beginning of the array
    blogs.unshift(blog);
  }

  // Clear the current table body
  $("#main-table tbody").html("");

  // Re-render the table with the updated blogists array
  blogs.forEach((blog, index) => {
    renderBlogRow(blog, index + 1);
  });
}
function loadBlogsPaginate(page = 1) {
  fetchBlogs(page)
    .then((res) => {
      if (res.success && res.data.length) {
        blogs = res.data; //update global blogs array
        renderBlogTable(blogs);
      }
    })
    .catch((err) => {
      console.error("Failed to fetch Blogs", err);
    });
}

function fetchFocusArtists(page = 1, limit = 50) {
  return $.ajax({
    url: "/admin/load-focus-artists-paginate",
    method: "GET",
    data: { page, limit },
  });
}
function renderFocusArtistsTable(data) {
  $("#main-table thead").html("");
  $("#main-table tbody").html("");
  const tableHead = `<tr>
    <th>#</th>
    <th>Name</th>
    <th>Image</th>
    <th>Action</th>
    <th>Create at</th>
</tr>`;
  $("#main-table thead").html(tableHead);
  data.forEach((d, k) => {
    renderFocusArtistsRow(d, k + 1);
  });
}
function renderFocusArtistsRow(artists, index) {
  const tr = `<tr data-id="${artists.id}" key="${artists.id}" data-sl="${
    artists.sl
  }" draggable="true" ondragstart="onDragStart(event)" ondragover="onDragOver(event)" ondrop="onDrop(event)">
        <td>${artists.sl}</td>
        <td>${artists.first_name + " " + artists.last_name}</td>
        <td>
            <div>
                <img src="../${
                  artists.userphoto
                }" alt="" width="80px" height="60px">
            </div>
        </td>
        <td>        
            <div class="d-flex gap-1 align-items-center justify-content-center">
                <a class="delete-focus-artists-btn btn btn-sm bg-danger">Delete</a>
            </div>
        </td>
        <td>${artists.cr_at}</td>
    </tr>`;
  $("#main-table tbody").append(tr);
}
function addedOrUpdatedFocusArtists(focus) {
  // Find the index of the blogist with the same user_id
  const index = focusArtists.findIndex((a) => a.user_id === focus.user_id);

  if (index !== -1) {
    // Update the existing blogist data
    focusArtists[index] = focus;
  } else {
    // If the blogist is not found, add it to the beginning of the array
    focusArtists.unshift(focus);
  }

  // Clear the current table body
  $("#main-table tbody").html("");

  // Re-render the table with the updated blogists array
  focusArtists.forEach((a, index) => {
    renderFocusArtistsRow(a, index + 1);
  });
}
function loadFocusArtistsPaginate(page = 1) {
  fetchFocusArtists(page)
    .then((res) => {
      if (res.success && res.data.length) {
        focusArtists = res.data; //update global blogs array
        renderFocusArtistsTable(focusArtists);
      }
    })
    .catch((err) => {
      console.error("Failed to fetch Blogs", err);
    });
}

function addButton(id, title, icon) {
  return `<div class="d-flex pb-3 px-3 justify-content-end"> <a class="d-flex align-items-center text-secondary cursor-pointer border border-1 border-secondary p-2 bg-primary bg-grey-400-hover" id="${id}" data-bs-toggle="modal" data-bs-target="#staticmodal"> <i class="${icon}-icon icon-bg-grey" style="zoom:1.5"></i> <span class="ps-2">${title}</span> </a> </div>`;
}
function updateInputField() {
  const input = $("#choosepostimage")[0];
  const dataTransfer = new DataTransfer();
  selectedFiles.forEach((file) => {
    dataTransfer.items.add(file);
  });
  input.files = dataTransfer.files;
}
function imageProcess(images, formData) {
  const promises = [];
  Array.from(images).forEach(function (imgElement, index) {
    const canvasWidth = index == 0 ? 400 : 800;
    const canvasHeight = 400;
    promises.push(
      new Promise((resolve, reject) => {
        const img = new Image();
        img.onload = function () {
          const canvas = document.createElement("canvas");
          canvas.width = canvasWidth;
          canvas.height = canvasHeight;
          const ctx = canvas.getContext("2d");
          ctx.fillStyle = "white";
          ctx.drawImage(img, 0, 0);
          ctx.fillRect(0, 0, canvasWidth, canvasHeight);
          let width = img.width;
          let height = img.height;
          let scaleFactor;
          if (width / height > canvasWidth / canvasHeight) {
            scaleFactor = canvasWidth / width;
          } else {
            scaleFactor = canvasHeight / height;
          }
          width *= scaleFactor;
          height *= scaleFactor;
          const x = (canvasWidth - width) / 2;
          const y = (canvasHeight - height) / 2;

          ctx.drawImage(img, x, y, width, height);

          canvas.toBlob(
            (blob) => {
              if (blob) {
                console.log(blob);
                const fileName = `image${index + 1}.jpg`;
                formData.append("images[]", blob, fileName);
                resolve();
              } else {
                reject(new Error("Blob conversion failed"));
              }
            },
            "image/jpeg",
            0.7
          );
        };
        img.onerror = function () {
          reject(new Error("Image loading failed"));
        };
        img.src = $(imgElement).attr("src");
      })
    );
  });
  return Promise.all(promises);
}

let selectedFiles = [];
let selectedArtists = {};
let selectedFocusArtists = {};
let current_clicked = "";
$(document).ready(function () {
  $("body").on("click", function (e) {
    if ($(e.target).closest(".userphotobtn").length) {
      $(".userdetails").toggleClass("d-block");
    }
    //arts
    if (
      $(e.target).closest(".all-arts-btn").length &&
      current_clicked !== "all-arts-btn"
    ) {
      current_clicked = "all-arts-btn";
      const mainTable = ` <table class="table table-bordered table-striped hover" id="main-table">
                        <thead> </thead>
                        <tbody> </tbody>
                    </table>`;
      $(".middlemenu").html(" ");
      $(".middlemenu").append(addButton("new-art", "Add Art", "art"));
      $(".middlemenu").append(mainTable);
      loadArtsPaginate(1);
    }
    if (e.target.id === "artsavebtn") {
      const barLoader = $(e.target)
        .closest(".modal-content")
        .find(".loader-wrapper");
      barLoader.removeClass("d-none");
      let formData = new FormData();
      let artName = $("#name").val(),
        place = $("#place").val(),
        creationDate = $("#creation-date").val(),
        media = $("#media").val(),
        canvasType = $("#canvas-type").val(),
        size = $("#size").val(),
        frame = $("#frame").val(),
        price = $("#price").val() || "favorite",
        currency = $("#currency").val(),
        availability = $("#availability").val(),
        description = $("#description").html();
      if (artName) {
        formData.append("name", artName);
      } else {
        $(".toaster").html(anyError("Art Name is required !"));
        return 0;
      }
      if (Object.keys(selectedArtists).length > 0) {
        let artistIds = Object.keys(selectedArtists);
        formData.append("artists", JSON.stringify(artistIds));
      } else {
        $(".toaster").html(anyError("Please Select Artists!"));
        return 0;
      }
      if (price) {
        formData.append("price", price);
      } else {
        $(".toaster").html(anyError("Please give Price !"));
        return 0;
      }

      place ? formData.append("place", place) : "";
      creationDate ? formData.append("creationDate", creationDate) : "";
      media ? formData.append("media", media) : "";
      canvasType ? formData.append("canvasType", canvasType) : "";
      size ? formData.append("size", size) : "";
      frame ? formData.append("frame", frame) : "";
      currency ? formData.append("currency", currency) : "";
      availability ? formData.append("availability", availability) : "";
      description
        ? formData.append("description", sanitizeTextTag(description))
        : "";

      const image = $("#previewBox img");
      if (image.length === 0) {
        $(".toaster").html(anyError("Image required !"));
        return 0;
      }
      if (image.hasClass("previousImg")) {
        $(".toaster").html(
          anyError("Image already Uploaded ! Please select another one.")
        );
        return 0;
      } else {
        const base64String = image[0].src.split(",")[1];
        const byteCharacters = atob(base64String);
        const byteNumbers = new Array(byteCharacters.length)
          .fill()
          .map((_, i) => byteCharacters.charCodeAt(i));
        const byteArray = new Uint8Array(byteNumbers);
        const blob = new Blob([byteArray], { type: "image/jpeg" });
        formData.append("image", blob, "image.jpg");
      }
      $.ajax({
        url: "/store-art",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
          if (res.success) {
            $("#staticmodal").modal("hide");
            $(".toaster").html(anySuccess(res.message));
            addedOrUpdatedArt(res.data);
          }
        },
      });
    }
    if (e.target.id === "artupdatebtn") {
      const barLoader = $(e.target)
        .closest(".modal-content")
        .find(".loader-wrapper");
      barLoader.removeClass("d-none");
      let formData = new FormData();
      let artId = $("#artupdatebtn").data("id"),
        artName = $("#name").val(),
        place = $("#place").val(),
        creationDate = $("#creation-date").val(),
        media = $("#media").val(),
        canvasType = $("#canvas-type").val(),
        size = $("#size").val(),
        frame = $("#frame").val(),
        price = $("#price").val(),
        currency = $("#currency").val(),
        availability = $("#availability").val(),
        description = $("#description").html();
      if (artName) {
        formData.append("artId", artId);
        formData.append("name", artName);
      } else {
        $(".toaster").html(anyError("Art Name is required !"));
        return 0;
      }
      if (Object.keys(selectedArtists).length > 0) {
        let artistIds = Object.keys(selectedArtists);
        formData.append("artists", JSON.stringify(artistIds));
      } else {
        $(".toaster").html(anyError("Please Select Artists!"));
        return 0;
      }
      if (price) {
        formData.append("price", price);
      } else {
        $(".toaster").html(anyError("Please give Price !"));
        return 0;
      }

      place ? formData.append("place", place) : "";
      creationDate ? formData.append("creationDate", creationDate) : "";
      media ? formData.append("media", media) : "";
      canvasType ? formData.append("canvasType", canvasType) : "";
      size ? formData.append("size", size) : "";
      frame ? formData.append("frame", frame) : "";
      currency ? formData.append("currency", currency) : "";
      availability ? formData.append("availability", availability) : "";
      description
        ? formData.append("description", sanitizeTextTag(description))
        : "";

      const image = $("#previewBox img");
      if (image.length === 0) {
        $(".toaster").html(anyError("Image required !"));
        return 0;
      }
      if (image.hasClass("previousImg")) {
        formData.append("previousImage", image[0].src);
      } else {
        const base64String = image[0].src.split(",")[1];
        const byteCharacters = atob(base64String);
        const byteNumbers = new Array(byteCharacters.length)
          .fill()
          .map((_, i) => byteCharacters.charCodeAt(i));
        const byteArray = new Uint8Array(byteNumbers);
        const blob = new Blob([byteArray], { type: "image/jpeg" });
        formData.append("image", blob, "image.jpg");
      }
      $.ajax({
        url: "/update-art",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
          if (res.success) {
            $("#staticmodal").modal("hide");
            $(".toaster").html(anySuccess(res.message));
            addedOrUpdatedArt(res.data);
          }
        },
      });
    }
    if ($(e.target).closest(".delete-arts").length) {
      const tr = $(e.target).closest("tr");
      const dataId = tr.data("id");
      if (confirm("Are you sure to Delete this?")) {
        $.ajax({
          url: "/delete-art",
          type: "POST",
          data: { id: dataId },
          success: function (response) {
            if (response.success) {
              tr.remove();
              arts = arts.filter((art) => art.art_id !== dataId);
              $(".toaster").html(anySuccess(response.message));
            } else {
              $(".toaster").html(anyError(response.message));
            }
          },
          error: function () {
            $(".toaster").html(anyError(response.message));
          },
        });
      }
    }

    //#region Artists
    if (
      $(e.target).closest(".all-users-btn").length &&
      current_clicked !== "all-users-btn"
    ) {
      current_clicked = "all-users-btn";
      const mainTable = ` <table class="table table-bordered table-striped hover" id="main-table">
                        <thead> </thead>
                        <tbody> </tbody>
                    </table>`;
      $(".middlemenu").html(" ");
      $(".middlemenu").append(addButton("new-user", "Add User", "user"));
      $(".middlemenu").append(mainTable);
      loadUsersPaginate(1);
    }
    if (e.target.id === "usersavebtn") {
      const barLoader = $(e.target)
        .closest(".modal-content")
        .find(".loader-wrapper");
      barLoader.removeClass("d-none");
      let formData = new FormData();
      let firstName = $("#first_name").val(),
        lastName = $("#last_name").val(),
        lifespan = $("#lifespan").val(),
        origin = $("#origin").val(),
        bio1 = $("#bio1").html(),
        bio2 = $("#bio2").html(),
        bio3 = $("#bio3").html(),
        userrole = $("#userrole").val();
      if (firstName) {
        formData.append("fname", firstName);
      } else {
        $(".toaster").html(anyError("First Name is required !"));
        return 0;
      }
      if (lastName) {
        formData.append("lname", lastName);
      }
      if (bio1) {
        formData.append("lifespan", lifespan);
        formData.append("origin", origin);
        formData.append("bio1", sanitizeTextTag(bio1));
      }
      if (bio2) {
        formData.append("bio2", sanitizeTextTag(bio2));
      }
      if (bio3) {
        formData.append("bio3", sanitizeTextTag(bio3));
      }
      if (userrole) {
        formData.append("userrole", userrole);
      } else {
        formData.append("userrole", "artists");
      }
      const images = $("#previewBox img");
      if (images.length === 0) {
        $(".toaster").html(anyError("Profile and Cover Image required !"));
        return 0;
      }
      imageProcess(images, formData)
        .then(() => {
          $.ajax({
            url: "/admin/store-user",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
              if (res.success) {
                $("#staticmodal").modal("hide");
                $(".toaster").html(anySuccess(res.message));
                addedOrUpdatedUser(res.data);
              }
            },
          });
        })
        .catch((error) => {
          console.error("Error processing images:", error);
        });
    }
    if (e.target.id === "userupdatebtn") {
      const barLoader = $(e.target)
        .closest(".modal-content")
        .find(".loader-wrapper");
      barLoader.removeClass("d-none");
      let formData = new FormData();
      let userId = $("#userupdatebtn").data("id"),
        firstName = $("#first_name").val(),
        lastName = $("#last_name").val(),
        lifespan = $("#lifespan").val(),
        origin = $("#origin").val(),
        bio1 = $("#bio1").html(),
        bio2 = $("#bio2").html(),
        bio3 = $("#bio3").html(),
        userrole = $("#userrole").val();
      if (firstName) {
        formData.append("user_id", userId);
        formData.append("fname", firstName);
      } else {
        $(".toaster").html(anyError("First Name is required !"));
        return 0;
      }
      if (lastName) {
        formData.append("lname", lastName);
      }
      if (bio1) {
        formData.append("lifespan", lifespan);
        formData.append("origin", origin);
        formData.append("bio1", sanitizeTextTag(bio1));
      }
      if (bio2) {
        formData.append("bio2", sanitizeTextTag(bio2));
      }
      if (bio3) {
        formData.append("bio3", sanitizeTextTag(bio3));
      }
      if (userrole) {
        formData.append("userrole", userrole);
      } else {
        formData.append("userrole", "artists");
      }
      const images = $("#previewBox img");
      if (images.length === 0) {
        $(".toaster").html(anyError("Image required !"));
        return 0;
      }
      images.each(function (index, img) {
        const previewImg = $(img).closest(".previewImg");
        const file = previewImg.data("file");

        if ($(img).hasClass("previousImg")) {
          // Append previous images to formData
          if ($(img).hasClass("user")) {
            formData.append("previousUserImage", img.src);
          } else if ($(img).hasClass("cover")) {
            formData.append("previousCoverImage", img.src);
          }
        } else if (file) {
          formData.append(`images[]`, file, file.name);
        }
      });
      $.ajax({
        url: "/admin/update-user",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
          if (res.success) {
            $("#staticmodal").modal("hide");
            $(".toaster").html(anySuccess(res.message));
            addedOrUpdatedUser(res.data);
          }
        },
      });
    }
    if ($(e.target).closest(".delete-user").length) {
      const tr = $(e.target).closest("tr");
      const dataId = tr.data("id");
      if (confirm("Are you sure to Delete this?")) {
        $.ajax({
          url: "/admin/delete-user",
          type: "POST",
          data: { id: dataId },
          success: function (response) {
            if (response.success) {
              tr.remove();
              artists = artists.filter((artist) => artist.user_id !== dataId);
              $(".toaster").html(anySuccess(response.message));
            } else {
              $(".toaster").html(anyError(response.message));
            }
          },
          error: function () {
            $(".toaster").html(anyError(response.message));
          },
        });
      }
    }
    //#endregion
    //#region Sculptures
    if (
      $(e.target).closest(".all-sculptures-btn").length &&
      current_clicked !== "all-sculptures-btn"
    ) {
      current_clicked = "all-sculptures-btn";
      const mainTable = ` <table class="table table-bordered table-striped hover" id="main-table">
                        <thead> </thead>
                        <tbody> </tbody>
                    </table>`;
      $(".middlemenu").html(" ");
      $(".middlemenu").append(
        addButton("new-sculpture", "Add Sculpture", "sculpture")
      );
      $(".middlemenu").append(mainTable);
      loadSculpturePaginate(1);
    }
    if (e.target.id === "sculpsavebtn") {
      const barLoader = $(e.target)
        .closest(".modal-content")
        .find(".loader-wrapper");
      barLoader.removeClass("d-none");
      let formData = new FormData();
      let sculpName = $("#name").val(),
        place = $("#place").val(),
        creationDate = $("#creation-date").val(),
        media = $("#media").val(),
        canvasType = $("#canvas-type").val(),
        size = $("#size").val(),
        frame = $("#frame").val(),
        price = $("#price").val(),
        currency = $("#currency").val(),
        availability = $("#availability").val(),
        description = $("#description").html();
      if (sculpName) {
        formData.append("name", sculpName);
      } else {
        $(".toaster").html(anyError("Sculpture Name is required !"));
        return 0;
      }
      if (Object.keys(selectedArtists).length > 0) {
        let artistIds = Object.keys(selectedArtists);
        formData.append("artists", JSON.stringify(artistIds));
      } else {
        $(".toaster").html(anyError("Please Select Artists!"));
        return 0;
      }
      if (price) {
        formData.append("price", price);
      } else {
        $(".toaster").html(anyError("Please give Price !"));
        return 0;
      }

      place ? formData.append("place", place) : "";
      creationDate ? formData.append("creationDate", creationDate) : "";
      media ? formData.append("media", media) : "";
      canvasType ? formData.append("canvasType", canvasType) : "";
      size ? formData.append("size", size) : "";
      frame ? formData.append("frame", frame) : "";
      currency ? formData.append("currency", currency) : "";
      availability ? formData.append("availability", availability) : "";
      description
        ? formData.append("description", sanitizeTextTag(description))
        : "";

      const image = $("#previewBox img");
      if (image.length === 0) {
        $(".toaster").html(anyError("Image required !"));
        return 0;
      }
      if (image.hasClass("previousImg")) {
        $(".toaster").html(
          anyError("Image already Uploaded ! Please select another one.")
        );
        return 0;
      } else {
        const base64String = image[0].src.split(",")[1];
        const byteCharacters = atob(base64String);
        const byteNumbers = new Array(byteCharacters.length)
          .fill()
          .map((_, i) => byteCharacters.charCodeAt(i));
        const byteArray = new Uint8Array(byteNumbers);
        const blob = new Blob([byteArray], { type: "image/jpeg" });
        formData.append("image", blob, "image.jpg");
      }
      $.ajax({
        url: "/store-sculpture",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
          if (res.success) {
            $("#staticmodal").modal("hide");
            $(".toaster").html(anySuccess(res.message));
            addedOrUpdatedSculpture(res.data);
          }
        },
      });
    }
    if (e.target.id === "sculpupdatebtn") {
      const barLoader = $(e.target)
        .closest(".modal-content")
        .find(".loader-wrapper");
      barLoader.removeClass("d-none");
      let formData = new FormData();
      let sculpId = $("#sculpupdatebtn").data("id"),
        sculpName = $("#name").val(),
        place = $("#place").val(),
        creationDate = $("#creation-date").val(),
        media = $("#media").val(),
        canvasType = $("#canvas-type").val(),
        size = $("#size").val(),
        frame = $("#frame").val(),
        price = $("#price").val(),
        currency = $("#currency").val(),
        availability = $("#availability").val(),
        description = $("#description").html();
      if (sculpName) {
        formData.append("sculpId", sculpId);
        formData.append("name", sculpName);
      } else {
        $(".toaster").html(anyError("Art Name is required !"));
        return 0;
      }
      if (Object.keys(selectedArtists).length > 0) {
        let artistIds = Object.keys(selectedArtists);
        formData.append("artists", JSON.stringify(artistIds));
      } else {
        $(".toaster").html(anyError("Please Select Artists!"));
        return 0;
      }
      if (price) {
        formData.append("price", price);
      } else {
        $(".toaster").html(anyError("Please give Price !"));
        return 0;
      }

      place ? formData.append("place", place) : "";
      creationDate ? formData.append("creationDate", creationDate) : "";
      media ? formData.append("media", media) : "";
      canvasType ? formData.append("canvasType", canvasType) : "";
      size ? formData.append("size", size) : "";
      frame ? formData.append("frame", frame) : "";
      currency ? formData.append("currency", currency) : "";
      availability ? formData.append("availability", availability) : "";
      description
        ? formData.append("description", sanitizeTextTag(description))
        : "";

      const image = $("#previewBox img");
      if (image.length === 0) {
        $(".toaster").html(anyError("Image required !"));
        return 0;
      }
      if (image.hasClass("previousImg")) {
        formData.append("previousImage", image[0].src);
      } else {
        const base64String = image[0].src.split(",")[1];
        const byteCharacters = atob(base64String);
        const byteNumbers = new Array(byteCharacters.length)
          .fill()
          .map((_, i) => byteCharacters.charCodeAt(i));
        const byteArray = new Uint8Array(byteNumbers);
        const blob = new Blob([byteArray], { type: "image/jpeg" });
        formData.append("image", blob, "image.jpg");
      }
      $.ajax({
        url: "/update-sculpture",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
          if (res.success) {
            $("#staticmodal").modal("hide");
            $(".toaster").html(anySuccess(res.message));
            addedOrUpdatedSculpture(res.data);
          }
        },
      });
    }
    if ($(e.target).closest(".delete-sculpture").length) {
      const tr = $(e.target).closest("tr");
      const dataId = tr.data("id");
      if (confirm("Are you sure to Delete this?")) {
        $.ajax({
          url: "/delete-sculpture",
          type: "POST",
          data: { id: dataId },
          success: function (response) {
            if (response.success) {
              tr.remove();
              sculptures = sculptures.filter(
                (sculp) => sculp.sculpture_id !== dataId
              );
              $(".toaster").html(anySuccess(response.message));
            } else {
              $(".toaster").html(anyError(response.message));
            }
          },
          error: function () {
            $(".toaster").html(anyError(response.message));
          },
        });
      }
    }
    //#endregion
    //#region Blogs
    if (
      $(e.target).closest(".all-blogs-btn").length &&
      current_clicked !== "all-blogs-btn"
    ) {
      current_clicked = "all-blogs-btn";
      const mainTable = ` <table class="table table-bordered table-striped hover" id="main-table">
            <thead> </thead>
            <tbody> </tbody>
        </table>`;
      $(".middlemenu").html(" ");
      $(".middlemenu").append(addButton("new-blog", "Add Blog", "article"));
      $(".middlemenu").append(mainTable);
      loadBlogsPaginate(1);
    }
    if (e.target.id === "blogsavebtn") {
      const barLoader = $(e.target)
        .closest(".modal-content")
        .find(".loader-wrapper");
      barLoader.removeClass("d-none");
      let formData = new FormData();
      let title = $("#title").val(),
        user = $("#user").val(),
        body = $("#textbody").html();
      if (title) {
        formData.append("title", title);
      } else {
        $(".toaster").html(anyError("Title is required !"));
        return 0;
      }
      if (body) {
        formData.append("body", sanitizeTextTag(body));
      } else {
        $(".toaster").html(anyError("Body is required !"));
        return 0;
      }
      if (user) {
        formData.append("user_id", user);
      } else {
        $(".toaster").html(anyError("Please select a Blogger !"));
        return 0;
      }

      const image = $("#previewBox img");
      if (image.length === 0) {
        $(".toaster").html(anyError("Blog Cover Image required !"));
        return 0;
      }
      const base64String = image[0].src.split(",")[1];
      const byteCharacters = atob(base64String);
      const byteNumbers = new Array(byteCharacters.length)
        .fill()
        .map((_, i) => byteCharacters.charCodeAt(i));
      const byteArray = new Uint8Array(byteNumbers);
      const blob = new Blob([byteArray], { type: "image/jpeg" });
      formData.append("image", blob, "image.jpg");
      $.ajax({
        url: "/store-blog",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
          if (res.success) {
            $("#staticmodal").modal("hide");
            $(".toaster").html(anySuccess(res.message));
            addedOrUpdatedBlog(res.data);
          }
        },
      });
    }
    if (e.target.id === "blogupdatebtn") {
      const barLoader = $(e.target)
        .closest(".modal-content")
        .find(".loader-wrapper");
      barLoader.removeClass("d-none");
      let formData = new FormData();
      let blogId = $("#blogupdatebtn").data("id"),
        title = $("#title").val(),
        user = $("#user").val(),
        body = $("#body").html();
      if (title) {
        formData.append("blog_id", blogId);
        formData.append("title", title);
      } else {
        $(".toaster").html(anyError("Title is required !"));
        return 0;
      }
      if (body) {
        formData.append("body", sanitizeTextTag(body));
      } else {
        $(".toaster").html(anyError("Body is required !"));
        return 0;
      }
      if (user) {
        formData.append("user_id", user);
      } else {
        $(".toaster").html(anyError("Please select a Blogger !"));
        return 0;
      }
      const image = $("#previewBox img");
      if (image.length === 0) {
        $(".toaster").html(anyError("Image required !"));
        return 0;
      }
      if (image.hasClass("previousImg")) {
        formData.append("previousImage", image[0].src);
      } else {
        const base64String = image[0].src.split(",")[1];
        const byteCharacters = atob(base64String);
        const byteNumbers = new Array(byteCharacters.length)
          .fill()
          .map((_, i) => byteCharacters.charCodeAt(i));
        const byteArray = new Uint8Array(byteNumbers);
        const blob = new Blob([byteArray], { type: "image/jpeg" });
        formData.append("image", blob, "image.jpg");
      }
      $.ajax({
        url: "/update-blog",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
          if (res.success) {
            $("#staticmodal").modal("hide");
            $(".toaster").html(anySuccess(res.message));
            addedOrUpdatedBlog(res.data);
          }
        },
      });
    }
    if ($(e.target).closest(".delete-blog").length) {
      const tr = $(e.target).closest("tr");
      const dataId = tr.data("id");
      if (confirm("Are you sure to Delete this?")) {
        $.ajax({
          url: "/delete-blog",
          type: "POST",
          data: { id: dataId },
          success: function (response) {
            if (response.success) {
              tr.remove();
              blogs = blogs.filter((blog) => blog.blog_id !== dataId);
              $(".toaster").html(anySuccess(response.message));
            } else {
              $(".toaster").html(anyError(response.message));
            }
          },
          error: function () {
            $(".toaster").html(anyError(response.message));
          },
        });
      }
    }
    //#endregion
    //#region focus artists
    if (
      $(e.target).closest(".artshoily-in-focus").length &&
      current_clicked !== "artshoily-in-focus"
    ) {
      current_clicked = "artshoily-in-focus";
      const mainTable = ` <table class="table table-bordered table-striped hover" data-array="focusArtists" id="main-table">
            <thead> </thead>
            <tbody> </tbody>
        </table>`;
      $(".middlemenu").html(" ");
      $(".middlemenu").append(
        addButton("new-focus-artists", "Add Focus Artists", "user")
      );
      $(".middlemenu").append(mainTable);
      loadFocusArtistsPaginate(1);
    }
    if (e.target.id === "focusartistsavebtn") {
      const barLoader = $(e.target)
        .closest(".modal-content")
        .find(".loader-wrapper");
      barLoader.removeClass("d-none");
      let formData = new FormData();

      if (Object.keys(selectedFocusArtists).length > 0) {
        let artistIds = Object.keys(selectedFocusArtists);
        formData.append("artists", JSON.stringify(artistIds));
      } else {
        $(".toaster").html(anyError("Please Select Artists!"));
        return 0;
      }
      $.ajax({
        url: "/store-focus-artists",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
          if (res.success) {
            $("#staticmodal").modal("hide");
            $(".toaster").html(anySuccess(res.message));
            const artists = res.data;
            artists.forEach((data) => {
              addedOrUpdatedFocusArtists(data);
            });
          }
        },
      });
    }
    if ($(e.target).closest(".delete-focus-artists-btn").length) {
      const tr = $(e.target).closest("tr");
      const dataId = tr.data("id");
      if (confirm("Are you sure to Delete this?")) {
        $.ajax({
          url: "/delete-focus-artists",
          type: "POST",
          data: { id: dataId },
          success: function (response) {
            if (response.success) {
              tr.remove();
              focusArtists = focusArtists.filter(
                (artist) => artist.user_id !== dataId
              );
              $(".toaster").html(anySuccess(response.message));
            } else {
              $(".toaster").html(anyError(response.message));
            }
          },
          error: function () {
            $(".toaster").html(anyError(response.message));
          },
        });
      }
    }
    //#endregion
  });

  //static modal show, event handling
  $("#staticmodal").on("show.bs.modal", function (e) {
    let targetId = $(e.relatedTarget).attr("id");
    //sculptures
    //new arts
    if (targetId === "new-art") {
      $("#staticmodal .modal-content").html(" ");
      $.ajax({
        url: "/admin/create-art-modal",
        method: "GET",
        success: function (res) {
          $("#staticmodal .modal-content").html(res);
          let fields = [
            { input: "#name", limit: 200 },
            { input: "#place", limit: 50 },
            { input: "#creation-date", limit: 20 },
            { input: "#media", limit: 50 },
            { input: "#canvas-type", limit: 50 },
            { input: "#frame", limit: 50 },
            { input: "#size", limit: 50 },
          ];
          fields.forEach((field) => {
            $(field.input).on("keyup", function (e) {
              let remaining = field.limit - $(this).val().length;
              let spanElement = $(this)
                .closest("div")
                .prev("label")
                .find(".limit");
              if (remaining >= 0) {
                spanElement
                  .text(
                    `(Max ${field.limit} characters // ${remaining} remaining)`
                  )
                  .removeClass("text-danger")
                  .addClass("text-success");
              } else {
                spanElement
                  .text(`(Exceeded by ${Math.abs(remaining)} characters)`)
                  .removeClass("text-success")
                  .addClass("text-danger");
              }
            });
          });
        },
      });
    }
    //copy arts
    if (targetId === "copy-art") {
      const tr = $(e.relatedTarget).closest("tr");
      const dataId = tr.data("id");
      $("#staticmodal .modal-content").html(" ");
      $.ajax({
        url: "/admin/copy-art-modal",
        method: "GET",
        data: { dataId, mode: "copy" },
        success: function (res) {
          $("#staticmodal .modal-content").html(res);
          let fields = [
            { input: "#name", limit: 200 },
            { input: "#place", limit: 50 },
            { input: "#creation-date", limit: 20 },
            { input: "#media", limit: 50 },
            { input: "#canvas-type", limit: 50 },
            { input: "#frame", limit: 50 },
            { input: "#size", limit: 50 },
          ];
          fields.forEach((field) => {
            $(field.input).on("keyup", function (e) {
              let remaining = field.limit - $(this).val().length;
              let spanElement = $(this)
                .closest("div")
                .prev("label")
                .find(".limit");
              if (remaining >= 0) {
                spanElement
                  .text(
                    `(Max ${field.limit} characters // ${remaining} remaining)`
                  )
                  .removeClass("text-danger")
                  .addClass("text-success");
              } else {
                spanElement
                  .text(`(Exceeded by ${Math.abs(remaining)} characters)`)
                  .removeClass("text-success")
                  .addClass("text-danger");
              }
            });
          });
          $("#selectedArtistsList")
            .children("li")
            .each(function () {
              let artistId = $(this).data("id").toString().trim();
              let artistName = $(this).text().replace("✖", "").trim();
              selectedArtists[artistId] = artistName;
            });
        },
      });
    }
    if (targetId === "edit-art") {
      const tr = $(e.relatedTarget).closest("tr");
      const dataId = tr.data("id");
      $("#staticmodal .modal-content").html(" ");
      $.ajax({
        url: "/copy-art-modal",
        method: "GET",
        data: { dataId, mode: "edit" },
        success: function (res) {
          $("#staticmodal .modal-content").html(res);
          let fields = [
            { input: "#name", limit: 200 },
            { input: "#place", limit: 50 },
            { input: "#creation-date", limit: 20 },
            { input: "#media", limit: 50 },
            { input: "#canvas-type", limit: 50 },
            { input: "#frame", limit: 50 },
            { input: "#size", limit: 50 },
          ];
          fields.forEach((field) => {
            $(field.input).on("keyup", function (e) {
              let remaining = field.limit - $(this).val().length;
              let spanElement = $(this)
                .closest("div")
                .prev("label")
                .find(".limit");
              if (remaining >= 0) {
                spanElement
                  .text(
                    `(Max ${field.limit} characters // ${remaining} remaining)`
                  )
                  .removeClass("text-danger")
                  .addClass("text-success");
              } else {
                spanElement
                  .text(`(Exceeded by ${Math.abs(remaining)} characters)`)
                  .removeClass("text-success")
                  .addClass("text-danger");
              }
            });
          });
          $("#selectedArtistsList")
            .children("li")
            .each(function () {
              let artistId = $(this).data("id").toString().trim();
              let artistName = $(this).text().replace("✖", "").trim();
              selectedArtists[artistId] = artistName;
            });
        },
      });
    }
    //#region artists
    //add artist
    if (targetId === "new-user") {
      $("#staticmodal .modal-content").html(" ");
      $.ajax({
        url: "/admin/add-user-modal",
        method: "GET",
        success: function (res) {
          $("#staticmodal .modal-content").html(res);
          let fields = [
            { input: "#first_name", limit: 50 },
            { input: "#last_name", limit: 50 },
            { input: "#lifespan", limit: 50 },
            { input: "#origin", limit: 100 },
          ];
          fields.forEach((field) => {
            $(field.input).on("keyup", function (e) {
              let remaining = field.limit - $(this).val().length;
              let spanElement = $(this)
                .closest("div")
                .prev("label")
                .find(".limit");
              if (remaining >= 0) {
                spanElement
                  .text(
                    `(Max ${field.limit} characters // ${remaining} remaining)`
                  )
                  .removeClass("text-danger")
                  .addClass("text-success");
              } else {
                spanElement
                  .text(`(Exceeded by ${Math.abs(remaining)} characters)`)
                  .removeClass("text-success")
                  .addClass("text-danger");
              }
            });
          });
          let textareas = [
            { input: "#bio1", limit: 10000 },
            { input: "#bio2", limit: 10000 },
            { input: "#bio3", limit: 10000 },
          ];

          textareas.forEach((field) => {
            $(field.input).on("input", function () {
              let textLength = $(this).text().length;
              let remaining = field.limit - textLength;
              let spanElement = $(this)
                .closest(".form-control")
                .prev("label")
                .find(".limit");

              if (remaining >= 0) {
                spanElement
                  .text(
                    `(Max ${field.limit} characters // ${remaining} remaining)`
                  )
                  .removeClass("text-danger")
                  .addClass("text-success");
              } else {
                spanElement
                  .text(`(Exceeded by ${Math.abs(remaining)} characters)`)
                  .removeClass("text-success")
                  .addClass("text-danger");
              }
            });
          });
        },
      });
    }
    if (targetId === "edit-user") {
      const tr = $(e.relatedTarget).closest("tr");
      const dataId = tr.data("id");
      $("#staticmodal .modal-content").html(" ");
      $.ajax({
        url: "/admin/edit-user-modal",
        method: "GET",
        data: { dataId, mode: "edit" },
        success: function (res) {
          $("#staticmodal .modal-content").html(res);
          let fields = [
            { input: "#first_name", limit: 50 },
            { input: "#last_name", limit: 50 },
            { input: "#lifespan", limit: 50 },
            { input: "#origin", limit: 100 },
          ];
          fields.forEach((field) => {
            $(field.input).on("keyup", function (e) {
              let remaining = field.limit - $(this).val().length;
              let spanElement = $(this)
                .closest("div")
                .prev("label")
                .find(".limit");
              if (remaining >= 0) {
                spanElement
                  .text(
                    `(Max ${field.limit} characters // ${remaining} remaining)`
                  )
                  .removeClass("text-danger")
                  .addClass("text-success");
              } else {
                spanElement
                  .text(`(Exceeded by ${Math.abs(remaining)} characters)`)
                  .removeClass("text-success")
                  .addClass("text-danger");
              }
            });
          });
          let textareas = [
            { input: "#bio1", limit: 500 },
            { input: "#bio2", limit: 500 },
            { input: "#bio3", limit: 500 },
          ];

          textareas.forEach((field) => {
            $(field.input).on("input", function () {
              let textLength = $(this).text().length;
              let remaining = field.limit - textLength;
              let spanElement = $(this)
                .closest(".form-control")
                .prev("label")
                .find(".limit");

              if (remaining >= 0) {
                spanElement
                  .text(
                    `(Max ${field.limit} characters // ${remaining} remaining)`
                  )
                  .removeClass("text-danger")
                  .addClass("text-success");
              } else {
                spanElement
                  .text(`(Exceeded by ${Math.abs(remaining)} characters)`)
                  .removeClass("text-success")
                  .addClass("text-danger");
              }
            });
          });
        },
      });
    }
    //add focus artists
    if (targetId === "new-focus-artists") {
      $("#staticmodal .modal-content").html(" ");
      $.ajax({
        url: "/admin/add-focus-artists-modal",
        method: "GET",
        success: function (res) {
          $("#staticmodal .modal-content").html(res);
        },
      });
    }
    //#endregion
    //#region sculptures
    //new sculpture
    if (targetId === "new-sculpture") {
      $("#staticmodal .modal-content").html(" ");
      $.ajax({
        url: "/admin/create-sculpture-modal",
        method: "GET",
        success: function (res) {
          $("#staticmodal .modal-content").html(res);
          let fields = [
            { input: "#name", limit: 200 },
            { input: "#place", limit: 50 },
            { input: "#creation-date", limit: 20 },
            { input: "#media", limit: 50 },
            { input: "#canvas-type", limit: 50 },
            { input: "#frame", limit: 50 },
            { input: "#size", limit: 50 },
          ];
          fields.forEach((field) => {
            $(field.input).on("keyup", function (e) {
              let remaining = field.limit - $(this).val().length;
              let spanElement = $(this)
                .closest("div")
                .prev("label")
                .find(".limit");
              if (remaining >= 0) {
                spanElement
                  .text(
                    `(Max ${field.limit} characters // ${remaining} remaining)`
                  )
                  .removeClass("text-danger")
                  .addClass("text-success");
              } else {
                spanElement
                  .text(`(Exceeded by ${Math.abs(remaining)} characters)`)
                  .removeClass("text-success")
                  .addClass("text-danger");
              }
            });
          });
        },
      });
    }
    //copy arts
    if (targetId === "copy-sculpture") {
      const tr = $(e.relatedTarget).closest("tr");
      const dataId = tr.data("id");
      $("#staticmodal .modal-content").html(" ");
      $.ajax({
        url: "/admin/copy-sculp-modal",
        method: "GET",
        data: { dataId, mode: "copy" },
        success: function (res) {
          $("#staticmodal .modal-content").html(res);
          let fields = [
            { input: "#name", limit: 200 },
            { input: "#place", limit: 50 },
            { input: "#creation-date", limit: 20 },
            { input: "#media", limit: 50 },
            { input: "#canvas-type", limit: 50 },
            { input: "#frame", limit: 50 },
            { input: "#size", limit: 50 },
          ];
          fields.forEach((field) => {
            $(field.input).on("keyup", function (e) {
              let remaining = field.limit - $(this).val().length;
              let spanElement = $(this)
                .closest("div")
                .prev("label")
                .find(".limit");
              if (remaining >= 0) {
                spanElement
                  .text(
                    `(Max ${field.limit} characters // ${remaining} remaining)`
                  )
                  .removeClass("text-danger")
                  .addClass("text-success");
              } else {
                spanElement
                  .text(`(Exceeded by ${Math.abs(remaining)} characters)`)
                  .removeClass("text-success")
                  .addClass("text-danger");
              }
            });
          });
          $("#selectedArtistsList")
            .children("li")
            .each(function () {
              let artistId = $(this).data("id").toString().trim();
              let artistName = $(this).text().replace("✖", "").trim();
              selectedArtists[artistId] = artistName;
            });
        },
      });
    }
    if (targetId === "edit-sculpture") {
      const tr = $(e.relatedTarget).closest("tr");
      const dataId = tr.data("id");
      $("#staticmodal .modal-content").html(" ");
      $.ajax({
        url: "/copy-sculp-modal",
        method: "GET",
        data: { dataId, mode: "edit" },
        success: function (res) {
          $("#staticmodal .modal-content").html(res);
          let fields = [
            { input: "#name", limit: 200 },
            { input: "#place", limit: 50 },
            { input: "#creation-date", limit: 20 },
            { input: "#media", limit: 50 },
            { input: "#canvas-type", limit: 50 },
            { input: "#frame", limit: 50 },
            { input: "#size", limit: 50 },
          ];
          fields.forEach((field) => {
            $(field.input).on("keyup", function (e) {
              let remaining = field.limit - $(this).val().length;
              let spanElement = $(this)
                .closest("div")
                .prev("label")
                .find(".limit");
              if (remaining >= 0) {
                spanElement
                  .text(
                    `(Max ${field.limit} characters // ${remaining} remaining)`
                  )
                  .removeClass("text-danger")
                  .addClass("text-success");
              } else {
                spanElement
                  .text(`(Exceeded by ${Math.abs(remaining)} characters)`)
                  .removeClass("text-success")
                  .addClass("text-danger");
              }
            });
          });
          $("#selectedArtistsList")
            .children("li")
            .each(function () {
              let artistId = $(this).data("id").toString().trim();
              let artistName = $(this).text().replace("✖", "").trim();
              selectedArtists[artistId] = artistName;
            });
        },
      });
    }
    //#endregion
    //#region blogs
    //new blog
    if (targetId === "new-blog") {
      $("#staticmodal .modal-content").html(" ");
      $.ajax({
        url: "/create-blog-modal",
        method: "GET",
        success: function (res) {
          $("#staticmodal .modal-content").html(res);
          let fields = [{ input: "#title", limit: 200 }];
          fields.forEach((field) => {
            $(field.input).on("keyup", function (e) {
              let remaining = field.limit - $(this).val().length;
              let spanElement = $(this)
                .closest("div")
                .prev("label")
                .find(".limit");
              if (remaining >= 0) {
                spanElement
                  .text(
                    `(Max ${field.limit} characters // ${remaining} remaining)`
                  )
                  .removeClass("text-danger")
                  .addClass("text-success");
              } else {
                spanElement
                  .text(`(Exceeded by ${Math.abs(remaining)} characters)`)
                  .removeClass("text-success")
                  .addClass("text-danger");
              }
            });
          });
          let textareas = [{ input: "#textbody", limit: 10000 }];

          textareas.forEach((field) => {
            $(field.input).on("input", function () {
              let textLength = $(this).text().length;
              let remaining = field.limit - textLength;
              let spanElement = $(this)
                .closest(".form-control")
                .prev("label")
                .find(".limit");

              if (remaining >= 0) {
                spanElement
                  .text(
                    `(Max ${field.limit} characters // ${remaining} remaining)`
                  )
                  .removeClass("text-danger")
                  .addClass("text-success");
              } else {
                spanElement
                  .text(`(Exceeded by ${Math.abs(remaining)} characters)`)
                  .removeClass("text-success")
                  .addClass("text-danger");
              }
            });
          });
        },
      });
    }
    if (targetId === "edit-blog") {
      const tr = $(e.relatedTarget).closest("tr");
      const dataId = tr.data("id");
      $("#staticmodal .modal-content").html(" ");
      $.ajax({
        url: "/edit-blog-modal",
        method: "GET",
        data: { blog_id: dataId },
        success: function (res) {
          $("#staticmodal .modal-content").html(res);
          let fields = [{ input: "#title", limit: 200 }];
          fields.forEach((field) => {
            $(field.input).on("keyup", function (e) {
              let remaining = field.limit - $(this).val().length;
              let spanElement = $(this)
                .closest("div")
                .prev("label")
                .find(".limit");
              if (remaining >= 0) {
                spanElement
                  .text(
                    `(Max ${field.limit} characters // ${remaining} remaining)`
                  )
                  .removeClass("text-danger")
                  .addClass("text-success");
              } else {
                spanElement
                  .text(`(Exceeded by ${Math.abs(remaining)} characters)`)
                  .removeClass("text-success")
                  .addClass("text-danger");
              }
            });
          });
          let textareas = [{ input: "#textbody", limit: 10000 }];

          textareas.forEach((field) => {
            $(field.input).on("input", function () {
              let textLength = $(this).text().length;
              let remaining = field.limit - textLength;
              let spanElement = $(this)
                .closest(".form-control")
                .prev("label")
                .find(".limit");

              if (remaining >= 0) {
                spanElement
                  .text(
                    `(Max ${field.limit} characters // ${remaining} remaining)`
                  )
                  .removeClass("text-danger")
                  .addClass("text-success");
              } else {
                spanElement
                  .text(`(Exceeded by ${Math.abs(remaining)} characters)`)
                  .removeClass("text-success")
                  .addClass("text-danger");
              }
            });
          });
        },
      });
    }
    //#endregion
  });

  //file preview
  $("body").on("change", "#choosepostimage", function (e) {
    const previewBox = $("#previewBox");
    const files = e.target.files;
    Array.from(files)
      .slice(0, 2)
      .forEach((file) => {
        selectedFiles.push(file);
        const reader = new FileReader();
        reader.onload = function (event) {
          const img = $("<img>").attr("src", event.target.result);
          const crossBtn = $("<span>").addClass("previewcrossbtn").text("✖");
          const previewImg = $("<div>")
            .addClass("previewImg position-relative")
            .append(img)
            .append(crossBtn);
          previewImg.data("file", file);
          previewBox.append(previewImg);
        };
        reader.readAsDataURL(file);
      });
  });

  //crossBtn for preview files
  $("body").on("click", ".previewcrossbtn", function () {
    const previewImg = $(this).closest(".previewImg");
    const file = previewImg.data("file");
    selectedFiles = selectedFiles.filter((f) => f !== file);
    previewImg.remove();
    updateInputField();
  });
});

let draggedId = null;
function onDragStart(e) {
  dragSrcEl = e.currentTarget;
  dragSrcEl.classList.add("dragging");
  e.dataTransfer.effectAllowed = "move";
  e.dataTransfer.setData("text/html", dragSrcEl.outerHTML);
  draggedId = dragSrcEl.getAttribute("data-id");
}
function onDragOver(e) {
  e.preventDefault();
  e.dataTransfer.dropEffect = "move";
  const target = e.currentTarget;
  const tbody = target.parentNode;
  const draggingRow = document.querySelector(".dragging");

  if (target !== draggingRow) {
    const bounding = target.getBoundingClientRect();
    const offset = bounding.y + bounding.height / 2;
    if (e.clientY - offset > 0) {
      target.after(draggingRow);
    } else {
      target.before(draggingRow);
    }
  }
}
function onDrop(e) {
  const draggingRow = document.querySelector(".dragging");
  if (draggingRow) draggingRow.classList.remove("dragging");
  updateOrderAfterDrag();
}
function updateOrderAfterDrag() {
  const rows = Array.from(document.querySelectorAll("#main-table tbody tr"));
  const arrayName = document.querySelector("#main-table").dataset.array;
  let dataArray = window[arrayName];

  const oldIndex = dataArray.findIndex((p) => p.id == draggedId);
  const newIndex = rows.findIndex(
    (row) => row.getAttribute("data-id") == draggedId
  );
  if (newIndex === oldIndex) return;
  const minIndex = Math.min(oldIndex, newIndex);
  const maxIndex = Math.max(oldIndex, newIndex);
  const affectedRows = rows.slice(minIndex, maxIndex + 1);
  const slList = affectedRows.map((row) =>
    parseInt(row.getAttribute("data-sl"))
  );
  const minSl = Math.min(...slList);
  let updatedArraySlice = [];
  affectedRows.forEach((row, i) => {
    const id = row.getAttribute("data-id");
    const sl = row.getAttribute("data-sl");
    const data = dataArray.find((p) => p.id == id);
    if (data) {
      const newSl = minSl + i;
      if (data && data.sl !== newSl) {
        data.sl = newSl;
        row.setAttribute("data-sl", newSl); // update attribute if needed
        row.children[0].textContent = newSl; // update visual sl
        updatedArraySlice.push({ id: data.id, sl: newSl });
      }
    }
  });
  updatedArraySlice.forEach((u) => {
    const index = window[arrayName].findIndex((item) => item.id == u.id);
    if (index !== -1) {
      window[arrayName][index].sl = u.sl;
    }
  });
  saveRowOrder(updatedArraySlice, arrayName); // Optional: send to server
}

function saveRowOrder(updatedArraySlice, arrayName) {
  const payload = {
    arrayName: arrayName,
    order: updatedArraySlice.map((p) => ({ id: p.id, sl: p.sl })),
  };
  $.ajax({
    url: "/admin/update-row-order",
    method: "POST",
    contentType: "application/json",
    data: JSON.stringify(payload),
    success: (res) => {
      if (res.success) {
        let body = `<div class="toast-message">
                    <div class="d-flex align-items-center px-2">
                        <a class="px-2">
                            <i class="okey-icon icon-bg-green" style="zoom:1.3"></i>
                        </a>
                        <p class="text-secondary p-1 mb-0">
                        ${res.message}</p><a class="toasterHideBtn cursor-pointer d-flex text-warning px-1 bg-grey-400-hover rounded-circle">✖</a>
                    </div>
                </div>`;
        $(".toaster").html(body);
      } else {
        anyError(res.message);
      }
    },
    error: (err) => {},
  });
}
