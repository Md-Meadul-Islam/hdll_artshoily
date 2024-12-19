function loadArtsPaginate(p = 1) {
    let page = p;
    let limit = 50;
    $.ajax({
        url: 'admin/load-arts-paginate',
        method: 'GET',
        data: { page, limit },
        success: function (res) {
            if (res.success && res.data.length) {
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
                    $('#arts-table').append(tr);
                });
            }
        }
    })
}
$(document).ready(function () {
    loadArtsPaginate(1);
    $('body').on('click', function (e) {
        //user setting and more btn
        if (e.target.closest('.userphotobtn')) {
            $('.userdetails').toggleClass('d-block');
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
                        { input: '#title', limit: 100 },
                        { input: '#heading', limit: 200 },
                        { input: '#keywords', limit: 200 },
                        { input: '#metadesc', limit: 200 }
                    ];
                    fields.forEach((field) => {
                        $(field.input).on('keyup', function (e) {
                            let remaining = field.limit - $(this).val().length;
                            let spanElement = $(this).closest('div').prev('label').find('.limit');
                            if (remaining >= 0) {
                                spanElement.text(`Max ${field.limit} characters(${remaining} remaining)`).removeClass('text-danger').addClass('text-success');
                            } else {
                                spanElement.text(`Exceeded by ${Math.abs(remaining)} characters`).removeClass('text-success').addClass('text-danger');
                            }
                        })
                    })
                }
            })
        }
    })
})