<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="artshoily">
        <meta name="description" content="">
        <meta property="og:locale" content="en_US">
        <meta property="og:type" content="website" />
        <meta property="og:site_name" content="Art Shoily" />
        <meta property="og:title" content="Art Shoily" />
        <meta property="og:description" content="" />
        <meta property="og:image" content="https://www.artshoily.com/images/og.jpg" />
        <meta property="og:url" content="https://www.artshoily.com" />
        <meta property="og:image:width" content="1280">
        <meta property="og:image:height" content="720">
        <meta name="twitter:card" content="summary_large_image">
        <meta itemprop="name" content="Art Shoily" />
        <meta itemprop="description" content="" />
        <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
        <meta name="rating" content="adult">
        <meta name="author" content="Art Shoily">
        <link rel="canonical" href="https://artishoily.com" />
        <link rel="apple-touch-icon" href="https://www.artishoily.com/images/favicon.ico">
        <link rel="icon" type="image/gif" href="../images/favicon.ico">
        <title>Art Shoily | Signup</title>
        <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="../css/bootstrap.css" />
        <link rel="stylesheet" href="../css/style.css" />
        <link rel="stylesheet" href="../css/loader.css" />
        <link rel="stylesheet" href="../css/auth-icons.css" />
        <script src="../js/utilities.js"></script>
    </head>

    <body>
        <div class="signup w-80 mx-auto" id="signup">
            <div class="row g-0 vh-100 d-flex align-items-center justify-content-center">
                <div class="col-lg-6 col-md-12">
                    <div class="d-flex justify-content-center py-4">
                        <a href="/" class="d-flex align-items-center w-auto" style="text-decoration: none">
                            <img data-src="../images/logo.jpg" width="150px" height="50px"></a>
                    </div><!-- End Logo -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="pt-4 pb-2">
                                <h5 class="card-title text-center pb-0 fs-4">Create New Account!</h5>
                            </div>
                            <form action="signup" method="POST" class="row g-0">
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
                                    <label for="email" class="form-label mb-0"><strong>E-mail</strong></label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend"><span
                                                class="envelope-icon icon-bg-grey"></span></span>
                                        <input type="email" name="email" class="form-control" id="email"
                                            autocomplete="email" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="phone" class="form-label mb-0"><strong>Phone</strong></label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend"><span
                                                class="phone-icon icon-bg-grey"></span></span>
                                        <input type="phone" name="phone" class="form-control" id="phone"
                                            autocomplete="phone" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="password" class="form-label mb-0"><strong>Password</strong></label>
                                    <div class="input-group position-relative z-1">
                                        <span class="input-group-text" id="inputGroupPrepend"><i
                                                class="key-icon icon-bg-grey"></i></span>
                                        <input type="password" name="password" class="form-control" id="password"
                                            required autocomplete="new-password">
                                        <div class="position-absolute right-2 top-0 bottom-0 d-flex align-items-center border-rounded"
                                            style="z-index:9">
                                            <a class="showpass bg-grey-400-hover rounded-circle d-flex p-1"
                                                data-target="#password"><i
                                                    class="views-icon icon-bg-grey icon-bg-white-hover"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="confirm-password" class="form-label mb-0"><strong>Confirm
                                            Password</strong></label>
                                    <div class="input-group position-relative z-1">
                                        <span class="input-group-text" id="inputGroupPrepend"><i
                                                class="key-icon icon-bg-grey"></i></span>
                                        <input type="password" name="confirm-password" class="form-control"
                                            id="confirm-password" required autocomplete="new-password">
                                        <div class="position-absolute right-2 top-0 bottom-0 d-flex align-items-center border-rounded"
                                            style="z-index:9">
                                            <a class="showpass bg-grey-400-hover rounded-circle d-flex p-1"
                                                data-target="#confirm-password"><i
                                                    class="views-icon icon-bg-grey icon-bg-white-hover"></i></a>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-12 py-2">
                                    <button class="btn btn-primary w-100" type="submit">Sign Up</button>
                                </div>
                                <div class="col-12">
                                    <p class="small mb-0 float-start">Aleady Have an Account? Please <a href="login"
                                            class="text-decoration-underline text-success fw-bold">Log
                                            In</a>
                                    </p>
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
        <script src="../js/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/animations.js"></script>
        <script>
            $(document).ready(function () {
                $('.showpass').on('mousedown', function () {
                    const targetInput = $($(this).data('target'));
                    const type = targetInput.attr('type') === 'password' ? 'text' : 'password';
                    targetInput.attr('type', type);
                });
                $('.showpass').on('mouseup', function () {
                    const targetInput = $($(this).data('target'));
                    targetInput.attr('type', 'password');
                });
            })
        </script>
        <?php pageAdd('components/toaster'); ?>
    </body>

</html>