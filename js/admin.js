function formatDoc(cmd, value = null) {
    if (value) {
        document.execCommand(cmd, false, value);
    } else {
        document.execCommand(cmd);
    }
}
function addLink() {
    var url = prompt('Insert url');
    if (url) {
        $('#textbody').focus();
        formatDoc('createLink', url);
    }
}
function sanitizeTextTag(body) {
    body = body.replace(/&lt;/g, '<').replace(/&gt;/g, '>');
    body = body.replace(/&nbsp;/g, '');
    body = body.replace(/<span[^>]*style="[^"]*"[^>]*>(.*?)<\/span>/gi, '');
    body = body.replace(/style="[^"]*"/gi, '');
    body = body.replace(/<div>/g, '').replace(/<\/div>/g, ' ');
    body = body.replace(/<script[^>]*>/gi, '<div class="code">');
    body = body.replace(/<\/script>/gi, '</div>');
    body = body.replace(/<\?php/gi, '<div class="code">');
    body = body.replace(/\?>/gi, '</div>');
    return body;
}
function loadArtsPaginate(page = 1) {
    let limit = 50;
    $.ajax({
        url: 'admin/load-arts-paginate',
        method: 'GET',
        data: { page, limit },
        success: function (res) {
            if (res.success && res.data.length) {
                $('#main-table thead').html('');
                $('#main-table tbody').html('');
                const tableHead = `<tr><th>#</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Artists</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                    <th>Create at</th></tr>`;
                $('#main-table thead').html(tableHead);

                const data = res.data;
                data.forEach((d, k) => {
                    let tr = `<tr data-id="${d.art_id}" key="${d.id}">
                                        <td>${k + 1}</td>
                                        <td>${d.name}</td>
                                        <td>
                                            <div>
                                                <img src="../storage/arts/${d.image}" alt="" width="80px" height="60px">
                                            </div>
                                        </td>
                                        <td class="">`
                    d.users.forEach(user => {
                        tr += `<a> ${user.first_name + ' ' + user.last_name}</a>`;
                    })
                    tr += `</td>
                                        <td>${d.price + ' ' + d.currency} </td>
                                        <td>
                                            <div class="d-flex gap-1 align-items-center justify-content-center">
                                             <a class="copy-art btn btn-sm bg-success text-white"
                                                    data-bs-toggle="modal" data-bs-target="#staticmodal" id="copy-art">Copy</a>
                                                <a class="edit-arts btn btn-sm bg-primary text-white text-nowrap"
                                                    data-bs-toggle="modal" data-bs-target="#staticmodal">Full Edit</a>
                                                <?php if ($article['is_deleted'] == '0') { ?>
                                                    <a class="soft-delete-arts btn btn-sm bg-warning text-nowrap">Soft Delete</a>
                                                <?php } ?>
                                                <a class="delete-arts btn btn-sm bg-danger">Delete</a>
                                            </div>
                                        </td>
                                        <td>${d.cr_at}</td>
                                    </tr>`;
                    $('#main-table tbody').append(tr);
                });
            }
        }
    })
}
function loadArtistsPaginate(page = 1) {
    let limit = 50;
    $.ajax({
        url: 'admin/load-artists-paginate',
        method: 'GET',
        data: { page, limit },
        success: function (res) {
            if (res.success && res.data.length) {
                $('#main-table thead').html('');
                $('#main-table tbody').html('');
                const tableHead = `<tr><th>#</th> <th>Name</th> <th>Image</th><th>Action</th> <th>Create at</th></tr>`;
                $('#main-table thead').html(tableHead);
                const data = res.data;
                data.forEach((d, k) => {
                    let tr = `<tr data-id="${d.user_id}" key="${d.id}">
                                        <td>${k + 1}</td>
                                        <td>${d.first_name + ' ' + d.last_name}</td>
                                        <td>
                                            <div>
                                                <img src="../${d.userphoto}" alt="" width="80px" height="60px">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1 align-items-center justify-content-center">
                                                <a class="edit-arts btn btn-sm bg-primary text-white text-nowrap"
                                                    data-bs-toggle="modal" data-bs-target="#staticmodal">Full Edit</a>
                                                <?php if ($article['is_deleted'] == '0') { ?>
                                                    <a class="soft-delete-arts btn btn-sm bg-warning text-nowrap">Soft Delete</a>
                                                <?php } ?>
                                                <a class="delete-arts btn btn-sm bg-danger">Delete</a>
                                            </div>
                                        </td>
                                        <td>${d.cr_at}</td>
                                    </tr>`;
                    $('#main-table tbody').append(tr);
                });
            }
        }
    })
}
function addButton(id, title, icon) {
    return `<div class="d-flex pb-3 px-3 justify-content-end"> <a class="d-flex align-items-center text-secondary cursor-pointer border border-1 border-secondary p-2 bg-primary bg-grey-400-hover" id="${id}" data-bs-toggle="modal" data-bs-target="#staticmodal"> <i class="${icon}-icon icon-bg-grey" style="zoom:1.5"></i> <span class="ps-2">${title}</span> </a> </div>`;
}
function updateInputField() {
    const input = $('#choosepostimage')[0];
    const dataTransfer = new DataTransfer();
    selectedFiles.forEach(file => {
        dataTransfer.items.add(file);
    });
    input.files = dataTransfer.files;
}
function imageProcess(images, formData) {
    const promises = [];
    Array.from(images).forEach(function (imgElement, index) {
        const canvasWidth = 400;
        const canvasHeight = 400;
        promises.push(new Promise((resolve, reject) => {
            const img = new Image();
            img.onload = function () {
                const canvas = document.createElement('canvas');
                canvas.width = canvasWidth
                canvas.height = canvasHeight
                const ctx = canvas.getContext('2d');
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

                canvas.toBlob((blob) => {
                    if (blob) {
                        console.log(blob);
                        const fileName = `image${index + 1}.jpg`;
                        formData.append('images[]', blob, fileName);
                        resolve();
                    } else {
                        reject(new Error('Blob conversion failed'));
                    }
                }, 'image/jpeg', 0.7);
            }
            img.onerror = function () {
                reject(new Error('Image loading failed'));
            };
            img.src = $(imgElement).attr('src');
        }));
    })
    return Promise.all(promises);
}
function saveFormData(formData, url) {
    $.ajax({
        url: url,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (resposne) {
            const res = JSON.parse(resposne);
            if (res.success) {
                $('#staticmodal').modal('hide');
                $('.toaster').html(anySuccess(res.message));

                const d = res.data;
                let tr = `<tr data-id="${d.art_id}" key="0">
                <td>0</td>
                <td>${d.name}</td>
                <td>
                    <div>
                        <img src="../storage/arts/${d.image}" alt="" width="80px" height="60px">
                    </div>
                </td>
                  <td class="">`
                d.users.forEach(user => {
                    tr += `<a> ${user.first_name + ' ' + user.last_name}</a>`;
                })
                tr += `</td>
                <td>${d.price + ' ' + d.currency} </td>
                <td>
                    <div class="d-flex gap-1 align-items-center justify-content-center">
                     <a class="copy-arts btn btn-sm bg-success text-white"
                            data-bs-toggle="modal" data-bs-target="#staticmodal">Copy</a>
                        <a class="edit-arts btn btn-sm bg-primary text-white text-nowrap"
                            data-bs-toggle="modal" data-bs-target="#staticmodal">Full Edit</a>
                        <?php if ($article['is_deleted'] == '0') { ?>
                            <a class="soft-delete-arts btn btn-sm bg-warning text-nowrap">Soft Delete</a>
                        <?php } ?>
                        <a class="delete-arts btn btn-sm bg-danger">Delete</a>
                    </div>
                </td>
                <td>${d.cr_at}</td>
            </tr>`;
                $('#main-table tbody').prepend(tr);
            }
        },
        error: function (xhr) {
            console.log(xhr);
        }
    })
}
let selectedFiles = [];
let selectedArtists = [];
let all_artists_btn_clicked, all_arts_btn_clicked = false;
$(document).ready(function () {
    $('body').on('click', function (e) {
        if ($(e.target).closest('.userphotobtn').length) {
            $('.userdetails').toggleClass('d-block');
        }
        if ($(e.target).closest('.allarts').length && !all_arts_btn_clicked) {
            all_arts_btn_clicked = true;
            all_artists_btn_clicked = false;
            const mainTable = ` <table class="table table-bordered table-striped hover" id="main-table">
                        <thead> </thead>
                        <tbody> </tbody>
                    </table>`;
            $('.middlemenu').html(' ');
            $('.middlemenu').append(addButton('new-art', 'Add Art', 'article'));
            $('.middlemenu').append(mainTable);
            loadArtsPaginate(1);
        }
        if ($(e.target).closest('.allartists').length && !all_artists_btn_clicked) {
            all_artists_btn_clicked = true;
            all_arts_btn_clicked = false;
            const mainTable = ` <table class="table table-bordered table-striped hover" id="main-table">
                        <thead> </thead>
                        <tbody> </tbody>
                    </table>`;
            $('.middlemenu').html(' ');
            $('.middlemenu').append(addButton('new-artists', 'Add Artist', 'user'));
            $('.middlemenu').append(mainTable);
            loadArtistsPaginate(1);
        }

        if (e.target.id === 'artsavebtn') {
            const barLoader = $(e.target).closest('.modal-content').find('.loader-wrapper');
            barLoader.removeClass('d-none');
            let formData = new FormData();
            let artName = $('#name').val(), artistsSelect = $('#artists'), place = $('#place').val()
                , creationDate = $('#creation-date').val(), media = $('#media').val(), canvasType = $('#canvas-type').val(), size = $('#size').val(), frame = $('#frame').val(), price = $('#price').val(), currency = $('#currency').val(), availability = $('#availability').val(), description = $('#description').html();
            if (artName) {
                formData.append('name', artName)
            } else {
                $('.toaster').html(anyError('Art Name is required !'));
                return 0;
            }
            if (selectedArtists.length > 0) {
                formData.append('artists', JSON.stringify(selectedArtists));
            } else {
                $('.toaster').html(anyError('Please Select Artists !'));
                return 0;
            }
            if (price) {
                formData.append('price', price)
            } else {
                $('.toaster').html(anyError('Please give Price !'));
                return 0;
            }

            place ? formData.append('place', place) : '';
            creationDate ? formData.append('creationDate', creationDate) : '';
            media ? formData.append('media', media) : '';
            canvasType ? formData.append('canvasType', canvasType) : '';
            size ? formData.append('size', size) : '';
            frame ? formData.append('frame', frame) : '';
            currency ? formData.append('currency', currency) : '';
            availability ? formData.append('availability', availability) : '';
            description ? formData.append('description', sanitizeTextTag(description)) : '';

            const image = $('#previewBox img');
            if (image.length === 0) {
                $('.toaster').html(anyError('Image required !'));
                return 0;
            }
            const base64String = image[0].src.split(',')[1];
            const byteCharacters = atob(base64String);
            const byteNumbers = new Array(byteCharacters.length).fill().map((_, i) => byteCharacters.charCodeAt(i));
            const byteArray = new Uint8Array(byteNumbers);
            const blob = new Blob([byteArray], { type: 'image/jpeg' });
            formData.append('image', blob, 'image.jpg');
            saveFormData(formData, 'store-art');
        }
        if (e.target.id === 'artistssavebtn') {
            const barLoader = $(e.target).closest('.modal-content').find('.loader-wrapper');
            barLoader.removeClass('d-none');
            let formData = new FormData();
            let firstName = $('#first_name').val(), lastName = $('#last_name').val(), bio = $('#bio').html();
            if (firstName) {
                formData.append('firstName', firstName);
            } else {
                $('.toaster').html(anyError('First Name is required !'));
                return 0;
            }
            if (lastName) {
                formData.append('lastName', lastName);
            }
            if (bio) {
                formData.append('bio', sanitizeTextTag(bio));
            }
            const images = $('#previewBox img');
            if (images.length === 0) {
                $('.toaster').html(anyError('Profile and Cover Image required !'));
                return 0;
            }
            imageProcess(images, formData).then(() => {
                saveFormData(formData, 'store-artist');
            }).catch((error) => {
                console.error('Error processing images:', error);
            });
        }
    });

    //static modal show, event handling
    $('#staticmodal').on('show.bs.modal', function (e) {
        var targetId = $(e.relatedTarget).attr('id');
        //add art
        if (targetId === 'new-art') {
            $('#staticmodal .modal-content').html(' ');
            $.ajax({
                url: 'admin/create-art-modal',
                method: 'GET',
                success: function (res) {
                    $('#staticmodal .modal-content').html(res);
                    let fields = [
                        { input: '#name', limit: 200 },
                        { input: '#place', limit: 50 },
                        { input: '#creation-date', limit: 20 },
                        { input: '#media', limit: 50 },
                        { input: '#canvas-type', limit: 50 },
                        { input: '#frame', limit: 50 },
                        { input: '#size', limit: 50 }
                    ];
                    fields.forEach((field) => {
                        $(field.input).on('keyup', function (e) {
                            let remaining = field.limit - $(this).val().length;
                            let spanElement = $(this).closest('div').prev('label').find('.limit');
                            if (remaining >= 0) {
                                spanElement.text(`(Max ${field.limit} characters // ${remaining} remaining)`).removeClass('text-danger').addClass('text-success');
                            } else {
                                spanElement.text(`(Exceeded by ${Math.abs(remaining)} characters)`).removeClass('text-success').addClass('text-danger');
                            }
                        })
                    })
                }
            })
        }
        if (targetId === 'copy-art') {
            const tr = $(e.relatedTarget).closest('tr');
            const dataId = tr.data('id');
            $('#staticmodal .modal-content').html(' ');
            $.ajax({
                url: 'admin/copy-art-modal',
                method: 'GET',
                data: { dataId },
                success: function (res) {
                    $('#staticmodal .modal-content').html(res);
                    let fields = [
                        { input: '#name', limit: 200 },
                        { input: '#place', limit: 50 },
                        { input: '#creation-date', limit: 20 },
                        { input: '#media', limit: 50 },
                        { input: '#canvas-type', limit: 50 },
                        { input: '#frame', limit: 50 },
                        { input: '#size', limit: 50 }
                    ];
                    fields.forEach((field) => {
                        $(field.input).on('keyup', function (e) {
                            let remaining = field.limit - $(this).val().length;
                            let spanElement = $(this).closest('div').prev('label').find('.limit');
                            if (remaining >= 0) {
                                spanElement.text(`(Max ${field.limit} characters // ${remaining} remaining)`).removeClass('text-danger').addClass('text-success');
                            } else {
                                spanElement.text(`(Exceeded by ${Math.abs(remaining)} characters)`).removeClass('text-success').addClass('text-danger');
                            }
                        })
                    })
                }
            })
        }
        if (targetId === 'new-artists') {
            $('#staticmodal .modal-content').html(' ');
            $.ajax({
                url: 'admin/add-artitsts-modal',
                method: 'GET',
                success: function (res) {
                    $('#staticmodal .modal-content').html(res);
                    let fields = [
                        { input: '#first_name', limit: 50 },
                        { input: '#last_name', limit: 50 }
                    ];
                    fields.forEach((field) => {
                        $(field.input).on('keyup', function (e) {
                            let remaining = field.limit - $(this).val().length;
                            let spanElement = $(this).closest('div').prev('label').find('.limit');
                            if (remaining >= 0) {
                                spanElement.text(`(Max ${field.limit} characters // ${remaining} remaining)`).removeClass('text-danger').addClass('text-success');
                            } else {
                                spanElement.text(`(Exceeded by ${Math.abs(remaining)} characters)`).removeClass('text-success').addClass('text-danger');
                            }
                        })
                    })
                }
            })
        }
        if (targetId === 'add-focus-artists') {
            $('#staticmodal .modal-content').html(' ');
            $.ajax({
                url: 'admin/add-focus-art-modal',
                method: 'GET',
                success: function (res) {
                    $('#staticmodal .modal-content').html(res);
                }
            })
        }
    })

    //file preview
    $('body').on('change', '#choosepostimage', function (e) {
        const previewBox = $('#previewBox');
        const files = e.target.files;
        Array.from(files).slice(0, 2).forEach(file => {
            selectedFiles.push(file);
            const reader = new FileReader();
            reader.onload = function (event) {
                const img = $('<img>').attr('src', event.target.result);
                const crossBtn = $('<span>').addClass('previewcrossbtn').text('✖');
                const previewImg = $('<div>').addClass('previewImg position-relative').append(img).append(crossBtn);
                previewImg.data('file', file);
                previewBox.append(previewImg);
            };
            reader.readAsDataURL(file);
        })

    });

    //crossBtn for preview files
    $('body').on('click', '.previewcrossbtn', function () {
        const previewImg = $(this).closest('.previewImg');
        const file = previewImg.data('file');
        selectedFiles = selectedFiles.filter(f => f !== file);
        previewImg.remove();
        updateInputField();
    });


})