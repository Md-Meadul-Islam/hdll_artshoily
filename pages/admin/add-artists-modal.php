<div>
    <div class="loader-wrapper d-none">
        <div class="bar-loader"></div>
    </div>
    <div class="w-100 g-0 d-flex justify-content-between align-items-center p-3">
        <div class="">
            <h5 class="modal-title">Add new Artists</h5>
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
                            placeholder="Leonardo" required>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <label for="last_name" class="form-label mb-0">
                        <strong>Last Name </strong><span class="limit text-success fs-8px"></span></label>
                    <div class="input-group">
                        <input type="text" name="last_name" class="form-control rounded-0" id="last_name"
                            placeholder="da Vinci">
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
                            placeholder="23-5-2098">
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <label for="origin" class="form-label mb-0">
                        <strong>Origin </strong><span class="limit text-success fs-8px"></span></label>
                    <div class="input-group">
                        <input type="text" name="origin" class="form-control rounded-0" id="origin"
                            placeholder="paris, france">
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
                    <div></div>
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
                    <div></div>
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
                    <div></div>
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
                    <input type="file" name="images[]" id="choosepostimage" accept="image/*" multiple>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer px-0 pb-0">
        <div class="col-12 d-flex justify-content-end align-items-center gap-2">
            <?php
            if (user()->email) { ?>
                <button type="submit" class="btn btn-primary" id="artistssavebtn" name="artistssavebtn">Save</button>
            <?php } ?>
        </div>
    </div>
</div>