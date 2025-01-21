<?php
$data = [
    "sculpture_id" => "",
    "user_ids" => "",
    "name" => "",
    "date_created" => "",
    "place_created" => "",
    "media" => "",
    "canvas_type" => "",
    "size" => "",
    "frame" => "",
    "description" => "",
    "price" => "",
    "currency" => "",
    "status" => "",
    "image" => "",
    "users" => []
];
if ($mode === 'edit' || $mode === 'copy') {
    $data = $sculpture;
}
?>
<div>
    <div class="loader-wrapper d-none">
        <div class="bar-loader"></div>
    </div>
    <div class="w-100 g-0 d-flex justify-content-between align-items-center p-3">
        <div class="">
            <h5 class="modal-title"><?php
            if ($mode === 'edit') {
                echo 'Edit Sculpture';
            } else if ($mode === 'copy') {
                echo "Copy Sculpture";
            } else {
                echo 'Add New Sculpture';
            } ?></h5>
        </div>
        <div class="position-relative">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
    </div>
</div>
<hr>
<div class="modal-body">
    <div class="row g-0 d-flex">
        <div class="col-12">
            <div class="row g-1 d-flex align-items-center justify-content-between">
                <div class="col-md-6 col-12">
                    <label for="name" class="form-label mb-0">
                        <strong>Name </strong><span class="limit text-success fs-8px"></span></label>
                    <div class="input-group">
                        <input type="text" name="name" class="form-control rounded-0" id="name"
                            placeholder="Urban Stories 07" value="<?php echo $data['name']; ?>" required>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <label for="artists" class="form-label mb-0">
                        <strong>Select Artists </strong>
                    </label>
                    <div class="input-group">
                        <select name="artists" id="artists" class="form-select rounded-0">
                            <option value="" disabled selected>Choose an artist</option>
                            <?php foreach ($artists as $user): ?>
                                <option value="<?php echo $user['user_id'] ?>">
                                    <?php echo $user['first_name'] . ' ' . $user['last_name'] ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <ul id="selectedArtistsList" class="d-flex flex-wrap p-0 my-1 gap-1">
                        <?php foreach ($data['users'] as $selctedUser) { ?>
                            <li class="d-flex align-items-center bg-primary fs-8px px-2"
                                data-id="<?php echo $selctedUser['user_id'] ?>">
                                <?php echo $selctedUser['first_name'] . ' ' . $selctedUser['last_name'] ?>
                                <a class="remove-artist text-danger ps-2 cursor-pointer"
                                    data-id="<?php echo $selctedUser['user_id'] ?>">✖</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="row g-1 d-flex align-items-center justify-content-between">
                <div class="col-md-6 col-12">
                    <label for="place" class="form-label mb-0">
                        <strong>Place Created </strong><span class="limit text-success fs-8px"></span></label>
                    <div class="input-group">
                        <input type="text" name="place" class="form-control bg-warning-subtle rounded-0" id="place"
                            placeholder="Uffizi Gallery, Florence" value="<?php echo $data['place_created']; ?>">
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <label for="creation-date" class="form-label mb-0">
                        <strong>Creation Date </strong><span class="limit text-success fs-8px"></span></label>
                    <div class="input-group">
                        <input type="text" name="creation-date" class="form-control bg-warning-subtle rounded-0"
                            id="creation-date" placeholder="1472-1475" value="<?php echo $data['date_created']; ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="row g-1 d-flex align-items-center justify-content-between">
                <div class="col-md-6 col-12">
                    <label for="media" class="form-label mb-0">
                        <strong>Media </strong><span class="limit text-success fs-8px"></span></label>
                    <div class="input-group">
                        <input type="text" name="media" class="form-control bg-warning-subtle rounded-0" id="media"
                            placeholder="oil, watercolor, acrylic..." value="<?php echo $data['media']; ?>">
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <label for="canvas-type" class="form-label mb-0">
                        <strong>Canvas Type </strong><span class="limit text-success fs-8px"></span></label>
                    <div class="input-group">
                        <input type="text" name="canvas-type" class="form-control bg-warning-subtle rounded-0"
                            id="canvas-type" placeholder="linen, cotton..." value="<?php echo $data['canvas_type']; ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="row g-1 d-flex align-items-center justify-content-between">
                <div class="col-md-6 col-12">
                    <label for="size" class="form-label mb-0">
                        <strong>Size </strong><span class="limit text-success fs-8px"></span></label>
                    <div class="input-group">
                        <input type="text" name="size" class="form-control bg-warning-subtle rounded-0" id="size"
                            placeholder="32 x 32.6 inches" value="<?php echo $data['size']; ?>">
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <label for="frame" class="form-label mb-0">
                        <strong>Frame </strong><span class="limit text-success fs-8px"></span></label>
                    <div class="input-group">
                        <input type="text" name="frame" class="form-control bg-warning-subtle rounded-0" id="frame"
                            placeholder="woden, metal, plastic..." value="<?php echo $data['frame']; ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="row g-1 d-flex align-items-center justify-content-between">
                <div class="col-md-4 col-12">
                    <label for="price" class="form-label mb-0">
                        <strong>Price </strong></label>
                    <div class="input-group">
                        <input type="number" name="price" class="form-control" id="price" min="10"
                            value="<?php echo $data['price']; ?>">
                    </div>
                </div>
                <div class="col-md-4 col-6">
                    <label for="currency" class="form-label mb-0">
                        <strong>Currency</strong></label>
                    <div class="input-group">
                        <select name="currency" id="currency" class="form-select rounded-0">
                            <option value="BDT">BDT</option>
                            <option value="USD">USD</option>
                            <option value="Range" selected>Range</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 col-6">
                    <label for="availability" class="form-label mb-0">
                        <strong>Availability</strong></label>
                    <div class="input-group">
                        <select name="availability" id="availability" class="form-select rounded-0">
                            <option value="available" selected>Available</option>
                            <option value="sold">Sold</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mt-1">
            <label for="description" class="form-label mb-0 mt-1"><strong>Description</strong></label>
            <div class="form-control p-0 m-0">
                <div class="viewOptions col-12 bg-secondary-subtle p-1">
                    <div class="toolbar d-flex gap-1 align-items-center">
                        <button type="button" onclick="formatDoc('undo')" title="Undo"
                            class="text-center border border-2 border-secondary-subtle rounded-2 btn-bg-hover p-1">
                            <span class="undo-icon icon-bg-grey icon-bg-white-hover"></span>
                        </button>
                        <button type="button" onclick="formatDoc('redo')" title="Redo"
                            class="text-center border border-2 border-secondary-subtle rounded-2 btn-bg-hover p-1">
                            <span class="redo-icon icon-bg-grey icon-bg-white-hover"></span>
                        </button>
                        <button type="button" onclick="formatDoc('bold')" title="Bold"
                            class="text-center border border-2 border-secondary-subtle rounded-2 btn-bg-hover p-1">
                            <span class="bold-icon icon-bg-grey icon-bg-white-hover"></span>
                        </button>
                        <button type="button" onclick="formatDoc('italic')" title="Italic"
                            class="text-center border border-2 border-secondary-subtle rounded-2 btn-bg-hover p-1">
                            <span class="italic-icon icon-bg-grey icon-bg-white-hover"></span>
                        </button>
                        <button type="button" onclick="formatDoc('underline')" title="Underline"
                            class="text-center border border-2 border-secondary-subtle rounded-2 btn-bg-hover p-1"> <i
                                class="underline-icon icon-bg-grey icon-bg-white-hover"></i></button>
                        <select onchange="formatDoc('fontSize', this.value); this.selectedIndex=0;"
                            class="text-center border border-2 border-secondary-subtle rounded-2 btn-bg-hover p-0"
                            style="width:100px;">
                            <option value="" selected="" hidden="" disabled="">Font Size</option>
                            <option value="1">12px</option>
                            <option value="2">13px</option>
                            <option value="3">16px</option>
                            <option value="4">18px</option>
                            <option value="5">24px</option>
                            <option value="6">32px</option>
                            <option value="7">48px</option>
                        </select>
                        <select onchange="formatDoc('formatBlock', this.value); this.selectedIndex=0;"
                            class="text-center border border-2 border-secondary-subtle rounded-2 btn-bg-hover p-0"
                            style="width:100px;">
                            <option value="" selected="" hidden="" disabled="">Heading</option>
                            <option value="h1">&lt;h1&gt;</option>
                            <option value="h2">&lt;h2&gt;</option>
                            <option value="h3">&lt;h3&gt;</option>
                            <option value="h4">&lt;h4&gt;</option>
                            <option value="h5">&lt;h5&gt;</option>
                            <option value="h6">&lt;h6&gt;</option>
                        </select>

                        <button onclick="formatDoc('strikeThrough')" title="Del"
                            class="text-center border border-2 border-secondary-subtle rounded-2 btn-bg-hover p-1"><i
                                class="strikethrugh-icon icon-bg-grey icon-bg-white-hover"></i></button>
                        <button onclick="formatDoc('justifyLeft')" title="Align Left"
                            class="text-center border border-2 border-secondary-subtle rounded-2 btn-bg-hover p-1"><i
                                class="text-left-icon icon-bg-grey icon-bg-white-hover"></i></button>
                        <button onclick="formatDoc('justifyCenter')" title="Align Center"
                            class="text-center border border-2 border-secondary-subtle rounded-2 btn-bg-hover p-1"><i
                                class="text-center-icon icon-bg-grey icon-bg-white-hover"></i></button>
                        <button onclick="formatDoc('justifyRight')" title="Align Right"
                            class="text-center border border-2 border-secondary-subtle rounded-2 btn-bg-hover p-1"><i
                                class="text-right-icon icon-bg-grey icon-bg-white-hover"></i></button>
                        <button onclick="formatDoc('justifyFull')" title="Align Justify"
                            class="text-center border border-2 border-secondary-subtle rounded-2 btn-bg-hover p-1"><i
                                class="text-justify-icon icon-bg-grey icon-bg-white-hover"></i></button>
                        <button onclick="formatDoc('insertOrderedList')" title="Ordered List"
                            class="text-center border border-2 border-secondary-subtle rounded-2 btn-bg-hover p-1"><i
                                class="olist-icon icon-bg-grey icon-bg-white-hover"></i></button>
                        <button onclick="formatDoc('insertUnorderedList')" title="Unodered List"
                            class="text-center border border-2 border-secondary-subtle rounded-2 btn-bg-hover p-1"><i
                                class="ulist-icon icon-bg-grey icon-bg-white-hover"></i></button>
                        <button type="button" onclick="formatDoc('insertHTML', '<br>')" title="Break"
                            class="text-center border border-2 border-secondary-subtle rounded-2 btn-bg-hover p-1">
                            <span class="break-icon icon-bg-grey icon-bg-white-hover"></span>
                        </button>
                    </div>
                </div>
                <div class="description mb-1 m-2" id="description" contenteditable="true" spellcheck="true"
                    role="textbox" aria-multiline="true" style="min-height:100px; max-height:400px; overflow-y:auto">
                    <?php echo $data['description']; ?>
                </div>
            </div>
        </div>
        <div class="col-12 py-2">
            <div class="previewBox py-2" id="previewBox">
                <?php if (!empty($data['image'])) { ?>
                    <div class="previewImg position-relative">
                        <img src="../<?php echo $data['image'] ?>" class="previousImg"><span
                            class="previewcrossbtn">✖</span>
                    </div>
                <?php } ?>
            </div>
            <div class="d-flex" style="width:80px">
                <div class="input-group">
                    <label for="choosepostimage" id="customImgInput" title="Choose Heading Image"><i
                            class="image-icon icon-bg-grey"></i></label>
                    <input type="file" name="image" id="choosepostimage" accept="image/*">
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer px-0 pb-0">
        <div class="col-12 d-flex justify-content-end align-items-center gap-2">
            <?php
            if (user()->email) { ?>
                <button type="submit" class="btn btn-primary" id="<?php echo $mode === 'edit' ? 'sculpupdatebtn' : 'sculpsavebtn';
                ?>" name="artsavebtn"
                    data-id="<?php echo $data['sculpture_id'] ?>"><?php echo $mode === 'edit' ? 'Update' : 'Save'; ?></button>
            <?php } ?>
        </div>
    </div>
</div>
<script>
    $('#artists').on('change', function () {
        console.log(selectedArtists)
        const selectedId = $(this).val();
        const selectedText = $('#artists option:selected').text();
        if (!selectedArtists.hasOwnProperty(selectedId)) {
            selectedArtists[selectedId] = selectedText.trim();
            $('#selectedArtistsList').append(`
                <li class="d-flex align-items-center bg-primary fs-8px px-2" data-id="${selectedId}">
                    ${selectedText}
                    <a class="remove-artist text-danger ps-2 cursor-pointer" data-id="${selectedId}">✖</a>
                </li>
            `);
        }
        $(this).val('');
    });
    $('#selectedArtistsList').on('click', '.remove-artist', function () {
        const artistId = $(this).data('id');
        delete selectedArtists[artistId];
        $(`#selectedArtistsList li[data-id="${artistId}"]`).remove();
    });
</script>