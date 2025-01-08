let arts = [];
let artists = [];
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
    // Decode HTML entities
    body = body.replace(/&lt;/g, '<').replace(/&gt;/g, '>');
    body = body.replace(/&nbsp;/g, ' ');

    // Remove styles but keep content
    body = body.replace(/<span[^>]*style="[^"]*"[^>]*>(.*?)<\/span>/gi, '$1');
    body = body.replace(/ style="[^"]*"/gi, '');

    // Remove all class properties
    body = body.replace(/ class="[^"]*"/gi, '');

    // Remove extra <o:p> tags
    body = body.replace(/<o:p[^>]*>.*?<\/o:p>/gi, '');

    // Replace <div> with spaces and remove script and PHP tags
    body = body.replace(/<div>/g, ' ').replace(/<\/div>/g, ' ');
    body = body.replace(/<script[^>]*>/gi, '<div class="code">');
    body = body.replace(/<\/script>/gi, '</div>');
    body = body.replace(/<\?php/gi, '<div class="code">');
    body = body.replace(/\?>/gi, '</div>');

    // Trim extra spaces
    body = body.trim();

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
                        tr += `<a class="bg-dark text-white mx-1 fs-8px"> ${user.first_name + ' ' + user.last_name}</a>`;
                    })
                    tr += `</td>
                                        <td>${d.price + ' ' + d.currency} </td>
                                        <td>
                                            <div class="d-flex gap-1 align-items-center justify-content-center">
                                             <a class="copy-art btn btn-sm bg-success text-white"
                                                    data-bs-toggle="modal" data-bs-target="#staticmodal" id="copy-art">Copy</a>
                                                <a class="edit-arts btn btn-sm bg-primary text-white text-nowrap" id="edit-art"
                                                    data-bs-toggle="modal" data-bs-target="#staticmodal">Full Edit</a>
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

function fetchArtists(page = 1, limit = 50) {
    return $.ajax({
        url: 'admin/load-artists-paginate',
        method: 'GET',
        data: { page, limit },
    });
}
function renderTable(data) {
    $('#main-table thead').html('');
    $('#main-table tbody').html('');

    const tableHead = `<tr>
        <th>#</th>
        <th>Name</th>
        <th>Image</th>
        <th>Action</th>
        <th>Create at</th>
    </tr>`;
    $('#main-table thead').html(tableHead);

    data.forEach((d, k) => {
        renderArtistRow(d, k + 1);
    });
}
function addNewArtist(artist) {
    artists.unshift(artist);
    $('#main-table tbody').html('');
    artists.forEach((artist, index) => {
        renderArtistRow(artist, index + 1);
    });
}
function updateArtist(artist) {
    artists.unshift(artist);
    $('#main-table tbody').html('');
    artists.forEach((artist, index) => {
        renderArtistRow(artist, index + 1);
    });
}
function renderArtistRow(artist, index) {
    const tr = `<tr data-id="${artist.user_id}" key="${artist.id}">
        <td>${index}</td>
        <td>${artist.first_name + ' ' + artist.last_name}</td>
        <td>
            <div>
                <img src="../${artist.userphoto}" alt="" width="80px" height="60px">
            </div>
        </td>
        <td>
            <div class="d-flex gap-1 align-items-center justify-content-center">
                <a class="edit-artist btn btn-sm bg-primary text-white text-nowrap" id="edit-artist"
                    data-bs-toggle="modal" data-bs-target="#staticmodal">Full Edit</a>
                <a class="delete-artists btn btn-sm bg-danger">Delete</a>
            </div>
        </td>
        <td>${artist.cr_at}</td>
    </tr>`;
    $('#main-table tbody').append(tr);
}
function loadArtistsPaginate(page = 1) {
    fetchArtists(page).then(res => {
        if (res.success && res.data.length) {
            artists = res.data; // Update the global artists array
            renderTable(artists);
        }
    }).catch(err => {
        console.error('Failed to fetch artists', err);
    });
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
        const canvasWidth = index == 0 ? 400 : 800;
        const canvasHeight = 400;
        promises.push(new Promise((resolve, reject) => {
            const img = new Image();
            img.onload = function () {
                const canvas = document.createElement('canvas');
                canvas.width = canvasWidth
                canvas.height = canvasHeight
                const ctx = canvas.getContext('2d');
                ctx.fillStyle = 'white';
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
function imageProcess2(images, formData) {
    const promises = [];
    Array.from(images).forEach(function (imgElement, index) {
        promises.push(new Promise((resolve, reject) => {
            const img = new Image();
            img.onload = function () {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');

                // Set canvas dimensions to the image's original dimensions
                canvas.width = img.width;
                canvas.height = img.height;

                // Fill the canvas with white background
                ctx.fillStyle = 'white';
                ctx.fillRect(0, 0, canvas.width, canvas.height);

                // Draw the image on the canvas
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

                // Convert the canvas content to a Blob with reduced quality
                canvas.toBlob((blob) => {
                    if (blob) {
                        const fileName = `image${index + 1}.jpg`;
                        formData.append('images[]', blob, fileName);
                        resolve();
                    } else {
                        reject(new Error('Blob conversion failed'));
                    }
                }, 'image/jpeg', 0.7); // Adjust quality here (0.7 means 70% quality)
            };
            img.onerror = function () {
                reject(new Error('Image loading failed'));
            };
            img.src = $(imgElement).attr('src');
        }));
    });
    return Promise.all(promises);
}

function saveFormData(formData, url) {
    $.ajax({
        url: url,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
            if (res.success) {
                $('#staticmodal').modal('hide');
                $('.toaster').html(anySuccess(res.message));
                const d = res.data;
                addNewArtist(d);
                let tr = `<tr data-id="${d.art_id}" key="0">
                <td>0</td>
                <td>${d.name}</td>
                <td>
                    <div>
                        <img src="../storage/arts/${d.image}" alt="" width="80px" height="60px">
                    </div>
                </td>
                  <td class="">`
                if (Array.isArray(d.users)) {
                    d.users.forEach(user => {
                        tr += `<a class="class="bg-dark text-white mx-1 fs-8px"">${user.first_name} ${user.last_name}</a>`;
                    });
                }
                tr += `</td>
                <td>${d.price + ' ' + d.currency} </td>
                <td>
                    <div class="d-flex gap-1 align-items-center justify-content-center">
                     <a class="copy-arts btn btn-sm bg-success text-white"
                            data-bs-toggle="modal" data-bs-target="#staticmodal">Copy</a>
                        <a class="edit-arts btn btn-sm bg-primary text-white text-nowrap"
                            data-bs-toggle="modal" data-bs-target="#staticmodal">Full Edit</a>
                        <a class="delete-arts btn btn-sm bg-danger">Delete</a>
                    </div>
                </td>
                <td>${d.cr_at}</td>
            </tr>`;
                // $('#main-table tbody').prepend(tr);
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
        //arts
        if ($(e.target).closest('.all-arts-btn').length && !all_arts_btn_clicked) {
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
        if (e.target.id === 'artsavebtn') {
            const barLoader = $(e.target).closest('.modal-content').find('.loader-wrapper');
            barLoader.removeClass('d-none');
            let formData = new FormData();
            let artName = $('#name').val(), place = $('#place').val()
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
            if (image.hasClass('previousImg')) {
                $('.toaster').html(anyError('Image already Uploaded ! Please select another one.'));
                return 0;
            } else {
                const base64String = image[0].src.split(',')[1];
                const byteCharacters = atob(base64String);
                const byteNumbers = new Array(byteCharacters.length).fill().map((_, i) => byteCharacters.charCodeAt(i));
                const byteArray = new Uint8Array(byteNumbers);
                const blob = new Blob([byteArray], { type: 'image/jpeg' });
                formData.append('image', blob, 'image.jpg');
            }
            saveFormData(formData, 'store-art');
        }
        if (e.target.id === 'artupdatebtn') {
            const barLoader = $(e.target).closest('.modal-content').find('.loader-wrapper');
            barLoader.removeClass('d-none');
            let formData = new FormData();
            let artId = $('#artupdatebtn').data('id'), artName = $('#name').val(), place = $('#place').val()
                , creationDate = $('#creation-date').val(), media = $('#media').val(), canvasType = $('#canvas-type').val(), size = $('#size').val(), frame = $('#frame').val(), price = $('#price').val(), currency = $('#currency').val(), availability = $('#availability').val(), description = $('#description').html();
            if (artName) {
                formData.append('artId', artId);
                formData.append('name', artName);
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
            if (image.hasClass('previousImg')) {
                formData.append('previousImage', image[0].src);
            } else {
                const base64String = image[0].src.split(',')[1];
                const byteCharacters = atob(base64String);
                const byteNumbers = new Array(byteCharacters.length).fill().map((_, i) => byteCharacters.charCodeAt(i));
                const byteArray = new Uint8Array(byteNumbers);
                const blob = new Blob([byteArray], { type: 'image/jpeg' });
                formData.append('image', blob, 'image.jpg');
            }
            saveFormData(formData, 'update-art');
        }

        if ($(e.target).closest('.delete-arts').length) {
            const tr = $(e.target).closest('tr');
            const dataId = tr.data('id');
            if (confirm('Are you sure to Delete this?')) {
                $.ajax({
                    url: '/delete-art',
                    type: 'POST',
                    data: { id: dataId },
                    success: function (response) {
                        if (response.success) {
                            tr.remove();

                            $('.toaster').html(anySuccess(response.message));
                        } else {
                            $('.toaster').html(anyError(response.message));
                        }
                    },
                    error: function () {
                        $('.toaster').html(anyError(response.message));
                    }
                });
            }
        }


        //artists
        if ($(e.target).closest('.all-artists-btn').length && !all_artists_btn_clicked) {
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
        if (e.target.id === 'artistssavebtn') {
            const barLoader = $(e.target).closest('.modal-content').find('.loader-wrapper');
            barLoader.removeClass('d-none');
            let formData = new FormData();
            let firstName = $('#first_name').val(), lastName = $('#last_name').val(), lifespan = $('#lifespan').val(), origin = $('#origin').val(), bio1 = $('#bio1').html(), bio2 = $('#bio2').html(), bio3 = $('#bio3').html();
            if (firstName) {
                formData.append('fname', firstName);
            } else {
                $('.toaster').html(anyError('First Name is required !'));
                return 0;
            }
            if (lastName) {
                formData.append('lname', lastName);
            }
            if (bio1) {
                formData.append('lifespan', lifespan);
                formData.append('origin', origin);
                formData.append('bio1', sanitizeTextTag(bio1));
            }
            if (bio2) {
                formData.append('bio2', sanitizeTextTag(bio2));
            }
            if (bio3) {
                formData.append('bio3', sanitizeTextTag(bio3));
            }
            const images = $('#previewBox img');
            if (images.length === 0) {
                $('.toaster').html(anyError('Profile and Cover Image required !'));
                return 0;
            }
            imageProcess(images, formData).then(() => {
                $.ajax({
                    url: "store-artist",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (res) {
                        if (res.success) {
                            $('#staticmodal').modal('hide');
                            $('.toaster').html(anySuccess(res.message));
                            const d = res.data;
                            addNewArtist(d);
                        }
                    }
                });
            }).catch((error) => {
                console.error('Error processing images:', error);
            });
        }
        if (e.target.id === 'artistupdatebtn') {
            const barLoader = $(e.target).closest('.modal-content').find('.loader-wrapper');
            barLoader.removeClass('d-none');
            let formData = new FormData();
            let artId = $('#artupdatebtn').data('id'), firstName = $('#first_name').val(), lastName = $('#last_name').val(), lifespan = $('#lifespan').val(), origin = $('#origin').val(), bio1 = $('#bio1').html(), bio2 = $('#bio2').html(), bio3 = $('#bio3').html();
            if (firstName) {
                formData.append('art_id', artId);
                formData.append('fname', firstName);
            } else {
                $('.toaster').html(anyError('First Name is required !'));
                return 0;
            }
            if (lastName) {
                formData.append('lname', lastName);
            }
            if (bio1) {
                formData.append('lifespan', lifespan);
                formData.append('origin', origin);
                formData.append('bio1', sanitizeTextTag(bio1));
            }
            if (bio2) {
                formData.append('bio2', sanitizeTextTag(bio2));
            }
            if (bio3) {
                formData.append('bio3', sanitizeTextTag(bio3));
            }
            const images = $('#previewBox img');
            if (images.length === 0) {
                $('.toaster').html(anyError('Image required !'));
                return 0;
            }
            images.each(function (index, img) {
                if ($(img).hasClass('previousImg')) {
                    // Append previous images to formData
                    if (index === 0) {
                        formData.append('previousUserImage', img.src);
                    } else if (index === 1) {
                        formData.append('previousCoverImage', img.src);
                    }
                } else {
                    const fileInput = document.getElementById('choosepostimage');
                    const files = fileInput.files;
                    Array.from(files).forEach((file, i) => {
                        formData.append(`images[]`, file, file.name);
                    });
                }
            })
            $.ajax({
                url: 'update-artists',
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    if (res.success) {
                        $('#staticmodal').modal('hide');
                        $('.toaster').html(anySuccess(res.message));
                        updateArtist(res.data);
                    }
                }
            })
        }
        if ($(e.target).closest('.delete-artists').length) {
            const tr = $(e.target).closest('tr');
            const dataId = tr.data('id');
            if (confirm('Are you sure to Delete this?')) {
                $.ajax({
                    url: '/delete-artists',
                    type: 'POST',
                    data: { id: dataId },
                    success: function (response) {
                        if (response.success) {
                            tr.remove();
                            $('.toaster').html(anySuccess(response.message));
                        } else {
                            $('.toaster').html(anyError(response.message));
                        }
                    },
                    error: function () {
                        $('.toaster').html(anyError(response.message));
                    }
                });
            }
        }
    });

    //static modal show, event handling
    $('#staticmodal').on('show.bs.modal', function (e) {
        var targetId = $(e.relatedTarget).attr('id');
        //arts
        //new arts
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
        //copy arts
        if (targetId === 'copy-art') {
            const tr = $(e.relatedTarget).closest('tr');
            const dataId = tr.data('id');
            $('#staticmodal .modal-content').html(' ');
            $.ajax({
                url: 'admin/copy-art-modal',
                method: 'GET',
                data: { dataId, mode: 'copy' },
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
        if (targetId === 'edit-art') {
            const tr = $(e.relatedTarget).closest('tr');
            const dataId = tr.data('id');
            $('#staticmodal .modal-content').html(' ');
            $.ajax({
                url: 'admin/copy-art-modal',
                method: 'GET',
                data: { dataId, mode: 'edit' },
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
        //artists
        //add artist
        if (targetId === 'new-artists') {
            $('#staticmodal .modal-content').html(' ');
            $.ajax({
                url: 'admin/add-artitsts-modal',
                method: 'GET',
                success: function (res) {
                    $('#staticmodal .modal-content').html(res);
                    let fields = [
                        { input: '#first_name', limit: 50 },
                        { input: '#last_name', limit: 50 },
                        { input: '#lifespan', limit: 50 },
                        { input: '#origin', limit: 100 }
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
                    });
                    let textareas = [
                        { input: '#bio1', limit: 10000 },
                        { input: '#bio2', limit: 10000 },
                        { input: '#bio3', limit: 10000 }
                    ];

                    textareas.forEach((field) => {
                        $(field.input).on('input', function () {
                            let textLength = $(this).text().length;
                            let remaining = field.limit - textLength;
                            let spanElement = $(this).closest('.form-control').prev('label').find('.limit');

                            if (remaining >= 0) {
                                spanElement.text(`(Max ${field.limit} characters // ${remaining} remaining)`).removeClass('text-danger').addClass('text-success');
                            } else {
                                spanElement.text(`(Exceeded by ${Math.abs(remaining)} characters)`).removeClass('text-success').addClass('text-danger');
                            }
                        });
                    });
                }
            })
        }
        if (targetId === 'edit-artist') {
            const tr = $(e.relatedTarget).closest('tr');
            const dataId = tr.data('id');
            console.log(dataId)
            $('#staticmodal .modal-content').html(' ');
            $.ajax({
                url: 'admin/edit-artists-modal',
                method: 'GET',
                data: { dataId, mode: 'edit' },
                success: function (res) {
                    $('#staticmodal .modal-content').html(res);
                    let fields = [
                        { input: '#first_name', limit: 50 },
                        { input: '#last_name', limit: 50 },
                        { input: '#lifespan', limit: 50 },
                        { input: '#origin', limit: 100 }
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
                    });
                    let textareas = [
                        { input: '#bio1', limit: 500 },
                        { input: '#bio2', limit: 500 },
                        { input: '#bio3', limit: 500 }
                    ];

                    textareas.forEach((field) => {
                        $(field.input).on('input', function () {
                            let textLength = $(this).text().length;
                            let remaining = field.limit - textLength;
                            let spanElement = $(this).closest('.form-control').prev('label').find('.limit');

                            if (remaining >= 0) {
                                spanElement.text(`(Max ${field.limit} characters // ${remaining} remaining)`).removeClass('text-danger').addClass('text-success');
                            } else {
                                spanElement.text(`(Exceeded by ${Math.abs(remaining)} characters)`).removeClass('text-success').addClass('text-danger');
                            }
                        });
                    });
                }
            })
        }
        //add focus artists
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