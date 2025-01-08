<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="artshoily, <?php echo $artist['first_name'] . ' ' . $artist['last_name'] ?>">
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
        <link rel="canonical" href="https://artishoily.com/viewartists" />
        <link rel="apple-touch-icon" href="https://www.artishoily.com/images/favicon.ico">
        <link rel="icon" type="image/gif" href="../images/favicon.ico">
        <title><?php echo $artist['first_name'] . ' ' . $artist['last_name'] ?> | Art Shoily</title>
        <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="./css/bootstrap.css" />
        <link rel="stylesheet" href="./css/style.css" />
        <link rel="stylesheet" href="./css/loader.css" />
        <link rel="stylesheet" href="./css/icons.css" />
        <script src="../js/utilities.js"></script>
    </head>

    <body>
        <style>
            p {
                margin-bottom: 0 !important;
            }
        </style>
        <?php pageAdd('components/header'); ?>
        <!-- artist section starts -->
        <section class="mt-5">
            <div class="row g-0 d-flex align-items-center justify-content-center pt-4">
                <div class="col-lg-10 col-12 p-2">
                    <div class="row g-0 d-flex justify-content-center px-2 py-2">
                        <div class="col-12">
                            <img data-src="<?php echo $artist['coverphoto'] ?>"
                                alt="<?php echo $artist['first_name'] ?>" class="w-100"
                                style="max-height:300px;object-fit:cover;">
                        </div>
                        <div class="col-12 pt-3">
                            <div class="row g-2">
                                <div class="col-md-6 col-12">
                                    <div class="row g-0">
                                        <div class="col-md-6 col-12 p-2">
                                            <img data-src="<?php echo $artist['userphoto'] ?>"
                                                alt="<?php echo $artist['first_name'] ?>" class="p-2 w-100">
                                        </div>
                                        <div class="col-md-6 col-12 p-2">
                                            <h3 class="fw-bold">
                                                <?php echo $artist['first_name'] . ' ' . $artist['last_name']; ?>
                                            </h3>
                                            <p class="mb-0"><?php echo $artist['lifespan'] ?></p>
                                            <p class="mb-0"><?php echo $artist['origin'] ?></p>
                                            <p class="mb-0"><?php echo $artist['email'] ?></p>
                                            <p class="mb-0"><?php echo $artist['phone'] ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 p-2">
                                    <p class="text-justify text-secondary">
                                        <?php echo html_entity_decode($artist['bio1']) ?>
                                    </p>
                                    <?php if ($artist['bio2']) { ?>
                                        <p class="text-justify text-secondary">
                                            <?php echo html_entity_decode($artist['bio2']); ?>
                                        </p>
                                    <?php } ?>
                                    <?php if ($artist['bio3']) { ?>
                                        <p class="text-justify text-secondary">
                                            <?php echo html_entity_decode($artist['bio3']); ?>
                                        </p><?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- artist section ends -->
        <section>
            <div class="row g-0 d-flex align-items-center justify-content-center pt-2">
                <div class="col-md-10 col-12">
                    <h5 class="text-uppercase fw-semibold px-2">More of his Design</h5>
                    <div class="goldenStroke"></div>
                    <div class="more-from-artist row g-2 d-flex justify-content-center">
                    </div>
                </div>
            </div>
        </section>
        <?php pageAdd('components/footer'); ?>
        <script src="./js/jquery.min.js"></script>
        <script src="./js/bootstrap.min.js"></script>
        <script src="./js/animations.js"></script>
        <script src="./js/artists.js"></script>
    </body>

</html>