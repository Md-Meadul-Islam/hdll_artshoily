let blogs = [];
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

function fetchBlogs(page = 1, limit = 50) {
  return $.ajax({
    url: "/blogger/load-blogs-paginate",
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
  //initial blogs load
  const mainTable = ` <table class="table table-bordered table-striped hover" id="main-table">
            <thead> </thead>
            <tbody> </tbody>
        </table>`;
  $(".middlemenu").html(" ");
  $(".middlemenu").append(addButton("new-blog", "Add Blog", "article"));
  $(".middlemenu").append(mainTable);
  loadBlogsPaginate(1);

  $("body").on("click", function (e) {
    if ($(e.target).closest(".userphotobtn").length) {
      $(".userdetails").toggleClass("d-block");
    }
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
        url: "/blogger/store-blog",
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
        body = $("#textbody").html();
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
        url: "/blogger/update-blog",
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
          url: "/blogger/delete-blog",
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
  });

  //static modal show, event handling
  $("#staticmodal").on("show.bs.modal", function (e) {
    let targetId = $(e.relatedTarget).attr("id");
    //#region blogs
    //new blog
    if (targetId === "new-blog") {
      $("#staticmodal .modal-content").html(" ");
      $.ajax({
        url: "/blogger/create-blog-modal",
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
        url: "/blogger/edit-blog-modal",
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
