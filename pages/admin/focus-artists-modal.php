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
                    <ul id="selectedArtistsList" class="d-flex flex-wrap p-0 my-1 gap-1"></ul>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer px-0 pb-0">
        <div class="col-12 d-flex justify-content-end align-items-center gap-2">
            <?php
            if (user()->email) { ?>
                <button type="submit" class="btn btn-primary" id="focusartistsavebtn" name="focusartistsavebtn">Save</button>
            <?php } ?>
        </div>
    </div>
</div>

<script>
    $('#artists').on('change', function () {
        const selectedId = $(this).val();
        const selectedText = $('#artists option:selected').text();
        if (!selectedFocusArtists.hasOwnProperty(selectedId)) {
            selectedFocusArtists[selectedId] = selectedText.trim();
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
        delete selectedFocusArtists[artistId];
        $(`#selectedArtistsList li[data-id="${artistId}"]`).remove();
    });
</script>