<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            <?php echo user()->firstname; ?> | Dashboard
        </title>
        <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="../css/bootstrap.css" />
        <link rel="stylesheet" href="../css/style.css" />
        <link rel="stylesheet" href="../css/loader.css" />
        <link rel="stylesheet" href="../css/icons.css" />
        <script src="../js/utilities.js"></script>
    </head>

    <body>
        <?php pageAdd('admin/header') ?>
        <section class="mt-5 px-2 pt-3 d-block">
            <div class="row admincontainer d-flex position-relative g-0">
                <?php pageAdd('admin/leftbar'); ?>
                <div class="middlemenu col-10">
                    <div class="row py-1 g-0">
                        <div class="col-12 pb-2">
                            <table class="table table-bordered table-striped hover">
                                <thead>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Artists</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                    <th>Create at</th>
                                </thead>
                                <tbody id="arts-table">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="modal modal-lg fade" id="mainmodal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content overflow-hidden">
                    <div class="modal-header d-flex justify-content-between">
                        <div class="placeholder-wave bg-secondary w-100 rounded-3" style="min-height:30px"></div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-0">
                            <div class="col-12">
                                <div class="placeholder-wave bg-secondary w-100 rounded-3" style="min-height:40px">
                                </div>
                            </div>
                            <div class="col-12 mt-1">
                                <div class="placeholder-wave bg-secondary w-100 rounded-3" style="min-height:180px">
                                </div>
                            </div>
                            <div class="col-12 py-2">
                                <div class="placeholder-wave bg-secondary w-100 rounded-3" style="min-height:60px">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal modal-lg fade" id="staticmodal" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content overflow-hidden rounded-0">
                    <div class="modal-header d-flex justify-content-between">
                        <div class="placeholder-wave bg-secondary w-100" style="min-height:30px"></div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-0">
                            <div class="col-12">
                                <div class="placeholder-wave bg-secondary w-100" style="min-height:40px">
                                </div>
                            </div>
                            <div class="col-12 mt-1">
                                <div class="placeholder-wave bg-secondary w-100" style="min-height:180px">
                                </div>
                            </div>
                            <div class="col-12 py-2">
                                <div class="placeholder-wave bg-secondary w-100" style="min-height:60px">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="../js/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/admin.js"></script>
        <?php pageAdd('components/toaster'); ?>
    </body>

</html>