<div>
    <div class="loader-wrapper d-none">
        <div class="bar-loader"></div>
    </div>
    <div class="w-100 g-0 d-flex justify-content-between align-items-center p-3">
        <div class="">
            <h5 class="modal-title">Add / Edit Focus Artists</h5>
        </div>
        <div class="position-relative">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
    </div>
</div>
<hr>
<div class="modal-body">
    <div class="row g-0 d-flex py-1">
        <div class="col-12">
            <div class="row g-1 d-flex align-items-center justify-content-between">
                <div class="col-12 p-0">
                    <label for="artists" class="form-label mb-0">
                        <strong>Select Artists (<span class="fs-8px text-danger">minmax 4</span>)</strong>
                    </label>
                    <div class="input-group">
                        <select name="artists[]" id="artists" class="form-select rounded-0">
                            <?php foreach ($artists as $user): ?>
                                <option value="<?php echo $user['user_id'] ?>">
                                    <?php echo $user['first_name'] . ' ' . $user['last_name'] ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <label for="selected-artists" class="form-label mb-0">
                    <strong>Selected Artists</strong>
                </label>
                <div class="col-12 border border-1 p-2" style="min-height: 100px;" id="selected-artists"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer px-0 pb-0">
        <div class="col-12 d-flex justify-content-end align-items-center gap-2">
            <?php
            if (user()->email) { ?>
                <button type="submit" class="btn btn-primary" id="articlesavebtn" name="articlesave">Save</button>
            <?php } ?>
        </div>
    </div>
</div>