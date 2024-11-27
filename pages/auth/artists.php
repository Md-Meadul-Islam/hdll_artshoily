<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="artshoily">
        <meta name="description" content="">
        <link rel="icon" type="image/gif" href="../images/favicon.ico">
        <title>Art Shoily | Artists</title>
        <link rel="stylesheet" href="./css/bootstrap.css" />
        <link rel="stylesheet" href="./css/style.css" />
        <link rel="stylesheet" href="./css/auth-icons.css" />
        <script src="../js/utilities.js"></script>
    </head>

    <body>
        <div class="create w-80 mx-auto" id="create">
            <div class="row g-0 vh-100 d-flex align-items-center justify-content-center">
                <div class="col-lg-6 col-md-12">
                    <div class="d-flex justify-content-center py-4">
                        <a href="/" class="d-flex align-items-center w-auto" style="text-decoration: none">
                            <img src="../images/logo.jpg" width="150px" height="50px"></a>
                    </div><!-- End Logo -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="pt-4 pb-2">
                                <h5 class="card-title text-center pb-0 fs-4">Create New Account!</h5>
                            </div>
                            <form action="store-artists" method="POST" class="row g-0" enctype="multipart/form-data">
                                <div class="col-12">
                                    <div class="row g-0">
                                        <div class="col-md-6 col-sm-12 pe-2">
                                            <label for="firstname" class="form-label mb-0"><strong>First
                                                    Name</strong></label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="inputGroupPrepend"><span
                                                        class="user-icon icon-bg-grey"></span></span>
                                                <input type="text" name="firstname" class="form-control" id="firstname"
                                                    autocomplete="name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <label for="lastname" class="form-label mb-0"><strong>Last
                                                    Name</strong></label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="inputGroupPrepend"><span
                                                        class="user-icon icon-bg-grey"></span></span>
                                                <input type="text" name="lastname" class="form-control" id="lastname"
                                                    autocomplete="lastname">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="profile" class="form-label mb-0"><strong>Profile</strong></label>
                                    <div class="input-group">
                                        <input type="file" name="profiles[]" class="form-control" id="profiles"
                                            autocomplete="profile" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="cover" class="form-label mb-0"><strong>Cover</strong></label>
                                    <div class="input-group">
                                        <input type="file" name="profiles[]" class="form-control" id="cover"
                                            autocomplete="cover">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="bio" class="form-label mb-0"><strong>BIO</strong></label>
                                    <div class="input-group">
                                        <textarea name="bio" id="bio" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 py-2">
                                    <button class="btn btn-primary w-100" type="submit">Add Artists</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="credits text-center">
                    Developed and Maintain by <a href="https://www.hdllfreelance.com">HDLL Freelance</a>
                </div>
            </div>
        </div>
        <script src="./js/jquery.min.js"></script>
        <script src="./js/bootstrap.min.js"></script>
        <?php pageAdd('components/toaster'); ?>
    </body>

</html>