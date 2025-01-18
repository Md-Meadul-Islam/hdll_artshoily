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
        <title>Art Shoily | Art Gallery</title>
        <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="./css/bootstrap.css" />
        <link rel="stylesheet" href="./css/style.css" />
        <link rel="stylesheet" href="./css/loader.css" />
        <link rel="stylesheet" href="./css/icons.css" />
        <script src="../js/utilities.js"></script>
    </head>

    <body>
        <?php pageAdd('components/header'); ?>
        <!-- hero section starts -->
        <section class="mt-5">
            <div class="row g-0">
                <div class="col-12">
                    <div class="hero-img w-100">
                        <img data-src="./images/bg_art_gallery.jpg" src="./images/bg_art_gallery.jpg" alt="HomePage"
                            class="w-100 h-100">
                    </div>
                </div>
            </div>
        </section>
        <!-- hero section ends -->
        <section class="mt-5">
            <div class="row g-0 d-flex justify-content-center align-items-center">
                <div class="col-lg-8 col-md-10 col-12">
                    <div class="row g-0 d-flex align-items-center justify-content-between  py-3 px-lg-5 px-md-3 px-2">
                        <div class="col-lg-9 col-12">
                            <h6 class="text-uppercase text-secondary">Filter by</h6>
                            <ul class="nav w-100 d-flex align-items-center justify-content-between">
                                <li class="nav-item">
                                    <a href=""
                                        class="btn bg-gold btn-outline-secondary text-white rounded-0 border border-2 px-4">Name</a>
                                </li>
                                <li class="nav-item">
                                    <a href=""
                                        class="btn bg-gold btn-outline-secondary text-white rounded-0 border border-2 px-4">Price</a>
                                </li>
                                <li class="nav-item">
                                    <a href=""
                                        class="btn bg-gold btn-outline-secondary text-white rounded-0 border border-2 px-4">Size</a>
                                </li>
                                <li class="nav-item d-lg-block d-none">
                                    <span style="font-size:30px; color: rgb(168, 128, 65);">|</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-12 text-end">
                            <h6 class="text-uppercase text-secondary">Explore by</h6>
                            <ul class="nav w-100 d-flex align-items-center justify-content-end">
                                <li class="nav-item">
                                    <a href=""
                                        class="btn bg-gold btn-outline-secondary text-white rounded-0 border border-2 px-4">Artists</a>
                                </li>
                        </div>
                    </div>
                    <div class="goldenStroke w-100"></div>
                </div>
            </div>
        </section>
        <!-- gallery section starts -->
        <section class="mt-5">
            <div class="row g-0 d-flex align-items-center justify-content-center py-3">
                <div class="col-lg-8 col-12">
                    <h4 class="text-center text-uppercase text-secondary">- Gallery -</h4>
                    <div class="row g-0 d-flex justify-content-center">
                        <?php foreach ($arts as $i => $art): ?>
                            <div class="col-md-4 col-sm-6 col-12 p-3">
                                <div class="d-flex align-items-center justify-content-center border border-1">
                                    <a href="viewart?a=<?php echo $art['art_id'] ?>">
                                        <img data-src="../storage/arts/<?php echo $art['image']; ?>"
                                            alt="<?php $art['imgalt'] ?>"
                                            style="max-height:300px; max-width:300px;width:100%;">
                                    </a>
                                </div>
                                <div class="row g-0 d-flex justify-content-between align-items-end pt-2">
                                    <div class="col-6">
                                        <p class="mb-0 fs-10px"><a
                                                href="viewart?a=<?php echo $art['art_id'] ?>"  class="text-dark fw-bold"><?php echo $art['name']; ?></a>
                                        </p>
                                        <p class="text-secondary fs-10px mb-0">
                                            <?php echo $art['canvas_type'] . " on " . $art['media']; ?>
                                        </p>
                                        <p class="art-dimension text-secondary fs-10px" title=""><?php echo $art['size']; ?>
                                        </p>
                                    </div>
                                    <div class="col-6 d-flex flex-column align-items-end">
                                        <p class="mb-0 fs-10px"><a
                                                class="cursor-pointer text-white text-uppercase rounded-0"><i
                                                    class="cart-icon icon-bg-gold icon-bg-grey-hover"></i>
                                            </a>
                                        </p>
                                        <p class="text-secondary fs-10px mb-0">
                                            <?php foreach ($art['users'] as $user): ?>
                                                <a
                                                    href="viewartists/?a=<?php echo $user['user_id'] ?>"><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></a>
                                            <?php endforeach ?>
                                        </p>
                                        <p class="text-secondary fs-10px">
                                            <?php echo $art['currency'] . " " . $art['price']; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                        <div class="col-12 d-flex align-items-end justify-content-end">
                            <a href="art-gallery" class="btn btn-sm bg-secondary-subtle text-uppercase">View more</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- gallery section ends -->
        <?php pageAdd('components/footer'); ?>
        <script src="./js/jquery.min.js"></script>
        <script src="./js/bootstrap.min.js"></script>
        <script src="./js/animations.js"></script>
        <script src="./js/index.js"></script>
    </body>

</html>