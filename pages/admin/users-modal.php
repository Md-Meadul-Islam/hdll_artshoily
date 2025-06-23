<?php
$data = [
    "user_id" => "",
    "first_name" => "",
    "last_name" => "",
    "lifespan" => "",
    "origin" => "",
    "bio1" => "",
    "bio2" => "",
    "bio3" => "",
    "userphoto" => "",
    "coverphoto" => "",
    "userrole" => ""
];
if ($mode === 'edit') {
    $data = $user;
}
?>
<div>
    <div class="loader-wrapper d-none">
        <div class="bar-loader"></div>
    </div>
    <div class="w-100 g-0 d-flex justify-content-between align-items-center p-3">
        <div class="">
            <h5 class="modal-title"><?php echo $mode === 'edit' ? 'Edit & Update User' : 'Add New User' ?></h5>
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
                    <label for="first_name" class="form-label mb-0">
                        <strong>First Name </strong><span class="limit text-success fs-8px"></span></label>
                    <div class="input-group">
                        <input type="text" name="first_name" class="form-control rounded-0" id="first_name"
                            value="<?php echo $data['first_name'] ?>" placeholder="Leonardo" required>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <label for="last_name" class="form-label mb-0">
                        <strong>Last Name </strong><span class="limit text-success fs-8px"></span></label>
                    <div class="input-group">
                        <input type="text" name="last_name" class="form-control rounded-0" id="last_name"
                            value="<?php echo $data['last_name'] ?>" placeholder="da Vinci">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mt-1">
            <div class="row g-1 d-flex align-items-center justify-content-between">
                <div class="col-md-6 col-12">
                    <label for="lifespan" class="form-label mb-0">
                        <strong>Life Span </strong><span class="limit text-success fs-8px"></span></label>
                    <div class="input-group">
                        <input type="text" name="lifespan" class="form-control rounded-0" id="lifespan"
                            value="<?php echo $data['lifespan'] ?>" placeholder="1998-2018">
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <label for="origin" class="form-label mb-0">
                        <strong>Origin </strong><span class="limit text-success fs-8px"></span></label>
                    <div class="input-group">
                        <input type="text" name="origin" class="form-control rounded-0" id="origin"
                            value="<?php echo $data['origin'] ?>" placeholder="paris, france">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mt-1">
            <label for="bio1" class="form-label mb-0 mt-1"><strong>bio1</strong><span
                    class="limit text-success fs-8px"></span></label>
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
                <div class="bio1 mb-1 m-2" id="bio1" contenteditable="true" spellcheck="true" role="textbox"
                    aria-multiline="true" style="min-height:50px; max-height:400px; overflow-y:auto;outline:none">
                    <?php echo html_entity_decode($data['bio1']) ?>
                </div>
            </div>
        </div>
        <div class="col-12 mt-1">
            <label for="bio2" class="form-label mb-0 mt-1"><strong>bio2</strong><span
                    class="limit text-success fs-8px"></span></label>
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
                <div class="bio2 mb-1 m-2" id="bio2" contenteditable="true" spellcheck="true" role="textbox"
                    aria-multiline="true" style="min-height:50px; max-height:400px; overflow-y:auto;outline:none;">
                    <?php if ($data['bio2']) {
                        echo html_entity_decode($data['bio2']);
                    } ?>
                </div>
            </div>
        </div>
        <div class="col-12 mt-1">
            <label for="bio3" class="form-label mb-0 mt-1"><strong>bio3</strong><span
                    class="limit text-success fs-8px"></span></label>
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
                <div class="bio3 mb-1 m-2" id="bio3" contenteditable="true" spellcheck="true" role="textbox"
                    aria-multiline="true" style="min-height:50px; max-height:400px; overflow-y:auto;outline:none;">
                    <?php if ($data['bio3']) {
                        echo html_entity_decode($data['bio3']);
                    } ?>
                </div>
            </div>
        </div>
        <div class="col-12 py-2">
            <p style="color:blue; font-size:10px; margin-bottom:0;">Please upload "Profile Photo" and "Cover Picture" in
                sequence</p>
            <div class="previewBox py-2" id="previewBox">
                <?php if ($data['userphoto']) { ?>
                    <div class="previewImg position-relative">
                        <img src="../<?php echo $data['userphoto'] ?>" class="previousImg user"><span
                            class="previewcrossbtn">✖</span>
                    </div>
                <?php }
                if ($data['coverphoto']) { ?>
                    <div class="previewImg position-relative">
                        <img src="../<?php echo $data['coverphoto'] ?>" class="previousImg cover"><span
                            class="previewcrossbtn">✖</span>
                    </div>

                <?php } ?>
            </div>
            <div class="d-flex" style="width:80px">
                <div class="input-group">
                    <label for="choosepostimage" id="customImgInput" title="Choose Heading Image"><i
                            class="image-icon icon-bg-grey"></i></label>
                    <input type="file" name="images[]" id="choosepostimage" accept="image/*" multiple>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer px-0 pb-0">
        <div class="col-12 d-flex justify-content-end align-items-center gap-2">
            <div>
                <select name="userrole" id="userrole" class="form-select">
                    <option value="" disabled>Please select user Role</option>
                    <option value="artists" <?php echo $data['userrole'] == 'artists' ? "selected" : "" ?>>Artists
                    </option>
                    <option value="blogger" <?php echo $data['userrole'] == 'blogger' ? "selected" : "" ?>>Blogger
                    </option>
                </select>
            </div>
            <?php
            if (user()->email) { ?>
                <button type="submit" class="btn btn-primary"
                    id="<?php echo $mode == 'edit' ? 'userupdatebtn' : 'usersavebtn' ?>"
                    name="<?php echo $mode == 'edit' ? 'userupdatebtn' : 'usersavebtn' ?>"
                    data-id="<?php echo $data['user_id'] ?>"><?php echo $mode == 'edit' ? 'Update' : 'Save' ?></button>
            <?php } ?>
        </div>
    </div>
</div>