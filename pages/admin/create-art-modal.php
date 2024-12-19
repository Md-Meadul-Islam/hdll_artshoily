<div>
    <div class="loader-wrapper d-none">
        <div class="bar-loader"></div>
    </div>
    <div class="w-100 g-0 d-flex justify-content-between align-items-center p-3">
        <div class="">
            <h5 class="modal-title">Create Art</h5>
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
                        <strong>Name </strong>(<span class="limit text-success fs-8px">Max 200
                            characters</span>)</label>
                    <div class="input-group">
                        <input type="text" name="name" class="form-control rounded-0" id="name"
                            placeholder="art name..." required>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <label for="artists" class="form-label mb-0">
                        <strong>Select Artists </strong>
                    </label>
                    <div class="input-group">
                        <select name="artists[]" id="artists" class="form-select rounded-0">
                            <?php foreach ($artists as $user): ?>
                                <option value="<?php echo $user['user_id'] ?>"><?php echo $user['first_name'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="row g-1 d-flex align-items-center justify-content-between">
                <div class="col-md-6 col-12">
                    <label for="place" class="form-label mb-0">
                        <strong>Place Created </strong>(<span class="limit text-success fs-8px">Max 50
                            characters</span>)</label>
                    <div class="input-group">
                        <input type="text" name="place" class="form-control bg-warning-subtle rounded-0" id="place"
                            placeholder="give creation place...">
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <label for="creation-date" class="form-label mb-0">
                        <strong>Date Created </strong>(<span class="limit text-success fs-8px">Max 20
                            characters</span>)</label>
                    <div class="input-group">
                        <input type="text" name="creation-date" class="form-control bg-warning-subtle rounded-0"
                            id="creation-date" placeholder="give creation date...">
                    </div>
                </div>
            </div>

        </div>
        <div class="col-12">
            <div class="row g-1 d-flex align-items-center justify-content-between">
                <div class="col-md-6 col-12">
                    <label for="place" class="form-label mb-0">
                        <strong>Place Created </strong>(<span class="limit text-success fs-8px">Max 50
                            characters</span>)</label>
                    <div class="input-group">
                        <input type="text" name="place" class="form-control bg-warning-subtle rounded-0" id="place"
                            placeholder="give creation place...">
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <label for="creation-date" class="form-label mb-0">
                        <strong>Date Created </strong>(<span class="limit text-success fs-8px">Max 20
                            characters</span>)</label>
                    <div class="input-group">
                        <input type="text" name="creation-date" class="form-control bg-warning-subtle rounded-0"
                            id="creation-date" placeholder="give creation date...">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mt-1">
            <label for="textbody" class="form-label mb-0 mt-1"><strong>Text Body</strong></label>
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
                        <!-- <div class="imageDiv d-flex position-relative">
                            <span title="Choose Images"
                                class="text-center border border-2 border-secondary-subtle rounded-2 btn-bg-hover p-1"
                                id="imageInputBtn"><i class="image-icon icon-bg-grey"></i></span>
                            <div id="imageInputDiv" class="gap-1">
                                <div class="col-12">
                                    <label for="imagewidth">Width</label>
                                    <div class="input-group">
                                        <input type="number" id="imagewidth" value="100" class="form-control">
                                        <select name="imagewidthparam" id="imagewidthparam">
                                            <option value="px">px</option>
                                            <option value="%" selected>%</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="imageheight">Height</label>
                                    <div class="input-group">
                                        <input type="number" id="imageheight" value="100" class="form-control">
                                        <select name="imageheightparam" id="imageheightparam">
                                            <option value="px">px</option>
                                            <option value="%" selected>%</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="imagealign">Height</label>
                                    <select name="align" id="imagealign" class="form-control">
                                        <option value="left">Left</option>
                                        <option value="right">Right</option>
                                    </select>
                                </div>

                                <label for="choosearticleimage"
                                    class="text-center border border-2 border-secondary-subtle rounded-2 p-1 mt-2 bg-primary-subtle">Choose
                                    Image</label>
                                <input type="file" name="images" id="choosearticleimage" accept="image/*">
                            </div>
                        </div> -->
                    </div>
                </div>
                <div class="textbody mb-1 m-2" id="textbody" contenteditable="true" spellcheck="true" role="textbox"
                    aria-multiline="true" style="min-height:100px; max-height:400px; overflow-y:auto">
                    <div>Share your Creativity ...</div>
                </div>
            </div>
        </div>
        <div class="col-12 py-2">
            <div class="previewBox py-2" id="previewBox">
            </div>
            <div class="d-flex" style="width:80px">
                <div class="input-group">
                    <label for="choosepostimage" id="customImgInput" title="Choose Heading Image"><i
                            class="image-icon icon-bg-grey"></i></label>
                    <input type="file" name="images[]" id="choosepostimage" accept="image/*">
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer px-0 pb-0">
        <div class="row g-0 d-flex align-items-center justify-content-between w-100">
            <div class="col-6">
                <div class="input-group d-flex">
                    <span class="input-group-text" id="inputGroupPrepend"><i
                            class="history-icon icon-bg-grey"></i></span>
                    <input type="datetime-local" min="today" name="publishtime" id="publishtime" class="form-control">
                </div>
            </div>
            <div class="col-6 d-flex justify-content-end align-items-center gap-2">
                <?php
                if (user()->email) { ?>
                    <button type="submit" class="btn btn-primary" id="articlesavebtn" name="articlesave">Save</button>
                    <button type="submit" class="btn bg-success-subtle" id="postdraftbtn" name="postdraft">Save as
                        Draft</button>
                <?php } ?>
            </div>
        </div>
    </div>
</div>