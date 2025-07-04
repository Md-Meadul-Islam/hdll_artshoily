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
        <section class="mt-3">
            <div class="row g-0 d-flex justify-content-center align-items-center">
                <div class="col-lg-8 col-md-10 col-12">
                    <div class="row g-0 d-flex align-items-center justify-content-md-between  justify-content-center py-3 px-lg-5 px-md-3 px-2">
                        <div class="col-lg-9 col-12">
                            <h6 class="text-uppercase text-secondary">Filter by</h6>
                            <div class="w-100 d-flex gap-3 align-items-center justify-content-between">
                                <div>
                                    <input type="text" name="filter-art" id="filter-art" class="form-control rounded-0 bg-gold" placeholder="Art Name">
                                </div>
                                <div>
                                    <input type="text" name="filter-artist" id="filter-artist" class="form-control rounded-0 bg-gold" placeholder="Artist Name">
                                </div>
                                <div>
                                    <select name="filter-price" id="filter-price" class="form-control rounded-0 bg-gold">
                                        <option value="" selected disabled>Price</option>
                                        <option value="favorite">Favorite</option>
                                        <option value="premium">Premium</option>
                                        <option value="high_value">High Value</option>
                                        <option value="not_for_sale">Not For Sale</option>
                                    </select>
                                </div>
                                <div class="d-lg-block d-none">
                                    <span style="font-size:30px; color: rgb(168, 128, 65);">|</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-8 col-12 pt-4 d-flex gap-2 justify-content-md-end justify-content-center">
                            <span class="filter-apply btn bg-gold btn-outline-secondary text-white rounded-0 border border-2 px-3" id="filter-apply">Apply</span>
                            <span class="filter-reset btn bg-gold btn-outline-secondary text-white rounded-0 border border-2 px-3" id="filter-reset">Reset</span>
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
                    <div class="row g-0 d-flex justify-content-center" id="arts">
                    </div>
                    <div class="col-12 d-flex align-items-end justify-content-end">
                        <a href="art-gallery" class="btn btn-sm bg-secondary-subtle text-uppercase">View more</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- gallery section ends -->
        <?php pageAdd('components/footer'); ?>
        <script src="./js/jquery.min.js"></script>
        <script src="./js/bootstrap.min.js"></script>
        <script src="./js/animations.js"></script>
        <script src="./js/art.js"></script>
    </body>

</html>