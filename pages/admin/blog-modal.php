<?php
$data = ["blog_id" => "", "title" => "", "body" => "", "image" => ""];
if ($mode === 'edit') {
    $data = $blog;
}
?>
<div>
    <div class="loader-wrapper d-none">
        <div class="bar-loader"></div>
    </div>
    <div class="w-100 g-0 d-flex justify-content-between align-items-center p-3">
        <div class="">
            <h5 class="modal-title"><?php echo $mode === 'edit' ? 'Edit Blog' : 'Add New Blog' ?></h5>
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
                    <label for="title" class="form-label mb-0">
                        <strong>Title </strong><span class="limit text-success fs-8px"></span></label>
                    <div class="input-group">
                        <input type="text" name="title" class="form-control rounded-0" id="title"
                            placeholder="Urban Stories 07" value="<?php echo $data['title']; ?>" required>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <label for="user" class="form-label mb-0">
                        <strong>Select User </strong>
                    </label>
                    <div class="input-group">
                        <select name="user" id="user" class="form-select rounded-0">
                            <option value="" disabled selected>Choose a blogger</option>
                            <?php foreach ($bloggers as $user): ?>
                                <option value="<?php echo $user['user_id'] ?>">
                                    <?php echo $user['first_name'] . ' ' . $user['last_name'] ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mt-1">
            <label for="textbody" class="form-label mb-0 mt-1"><strong>Body</strong><span
                    class="limit text-success fs-8px"></span></label>
            <div class="form-control p-0 m-0">
                <div
                    class="viewOptions col-12 bg-secondary-subtle p-1 d-flex align-items-center justify-content-between">
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
                    <div class="toolbar d-flex gap-1 align-items-center">
                        <div>
                            <label for="chooseinnerimage" title="Choose Inner Image"
                                class="imageDiv text-center border border-2 border-secondary-subtle rounded-2 btn-bg-hover p-1"
                                id="imageInputBtn"><i class="image-icon icon-bg-grey"></i></label>
                            <input type="file" name="image" id="chooseinnerimage" accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="textbody mb-1 m-2" id="textbody" contenteditable="true" spellcheck="true" role="textbox"
                    aria-multiline="true" style="min-height:100px; max-height:400px; overflow-y:auto;outline:none;">
                    <div><?php echo html_entity_decode($data['body']); ?></div>
                </div>
            </div>
        </div>
        <div class="col-12 py-2">
            <strong>Cover/Header Image</strong>
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
                <button type="submit" class="btn btn-primary"
                    id="<?php echo $mode == 'edit' ? 'blogupdatebtn' : 'blogsavebtn' ?>"
                    name="<?php echo $mode == 'edit' ? 'blogupdatebtn' : 'blogsavebtn' ?>"
                    data-id="<?php echo $data['blog_id'] ?>"><?php echo $mode == 'edit' ? 'Update' : 'Save' ?></button>
            <?php } ?>
        </div>
    </div>
</div>
<script>
    $('body').on('change', '#chooseinnerimage', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (event) {
                const img = $('<img>').attr('src', event.target.result);
                $('#textbody').append(img);
            };
            reader.readAsDataURL(file);
        }
    });

    $('body').on('click', '#textbody img', function (e) {
        e.stopPropagation()
        const img = $(this);
        const options = `<div class="img-options">
        <a class="resize-btn border border-2 d-flex"><i
                                class="resize-icon icon-bg-grey"></i></a>
        <a class="align-left-btn border border-2 d-flex"><i
                                class="text-left-icon icon-bg-grey"></i></a>
        <a class="center-btn border border-2 d-flex"><i
                                class="text-center-icon icon-bg-grey"></i></a>
        <a class="align-right-btn border border-2 d-flex"><i
                                class="text-right-icon icon-bg-grey"></i></a>
        <a class="delete-btn border border-2 d-flex"><i
                                class="delete-icon icon-bg-grey"></i></a>
    </div>`;
        img.next('.img-options').remove();
        img.after(options);
    });

    $(document).on('click', function () {
        $('.img-options').remove();
    });

    // Prevent the click inside img-options from triggering the document click handler
    $('body').on('click', '.img-options', function (e) {
        e.stopPropagation();
    });


    $('body').on('click', '.resize-btn', function () {
        const img = $(this).closest('.img-options').prev('img');
        const newWidth = prompt('Enter new width in pixels:', img.width());
        if (newWidth) {
            img.css('width', newWidth + 'px');
        }
        $(this).closest('.img-options').remove();
    });

    $('body').on('click', '.delete-btn', function () {
        $(this).closest('.img-options').prev('img').remove();
        $(this).closest('.img-options').remove();
    });

    $('body').on('click', '.align-left-btn', function () {
        const img = $(this).closest('.img-options').prev('img');
        img.css({
            display: 'block',
            margin: '0 auto 0 0',
        });
        $(this).closest('.img-options').remove();
    });

    $('body').on('click', '.align-right-btn', function () {
        const img = $(this).closest('.img-options').prev('img');
        img.css({
            display: 'block',
            margin: '0 0 0 auto',
        });
        $(this).closest('.img-options').remove();
    });

    $('body').on('click', '.center-btn', function () {
        const img = $(this).closest('.img-options').prev('img');
        img.css({
            display: 'block',
            margin: '0 auto',
        });
        $(this).closest('.img-options').remove();
    });
</script>