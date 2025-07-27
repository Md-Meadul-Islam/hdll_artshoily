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
        <?php pageAdd('blogger/header') ?>
        <section class="mt-5 pt-3 d-block">
            <div class="row admincontainer d-flex position-relative g-0">
                <?php pageAdd('blogger/leftbar'); ?>
                <div class="middlemenu col-10" style="height:90vh;overflow-y:auto; scrollbar-width:none;">
                    <div class="row g-3 d-flex px-2 align-items-center justify-content-center vh-100">
                        <h3 class="text-center">Please select your action from left pan</h3>
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
        <script src="../js/animations.js"></script>
        <script src="../js/blogger.js"></script>
        <?php pageAdd('components/toaster'); ?>
    </body>

</html>