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
        <title>Art Shoily | Art</title>
        <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="./css/bootstrap.css" />
        <link rel="stylesheet" href="./css/style.css" />
        <link rel="stylesheet" href="./css/loader.css" />
        <link rel="stylesheet" href="./css/icons.css" />
        <script src="../js/utilities.js"></script>
    </head>

    <body>
        <?php pageAdd('components/header'); ?>
        <!-- art section starts -->
        <section class="mt-5">
            <div class="row g-0 d-flex align-items-center justify-content-center pt-4">
                <div class="col-lg-10 col-12 p-2">
                    <div class="row g-5 d-flex px-2 py-2">
                        <div class="col-lg-8 col-sm-6 col-12">
                            <div class="art-image border border-1 border-secondary shadow w-100 overflow-hidden">
                                <img class="w-100" data-src="../storage/arts/<?php echo $art['image']; ?>"
                                    alt="<?php echo $art['name'] ?>">
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="p-2 bg-secondary-subtle">
                                <h4 class="fw-bold"><?php echo $art['name']; ?></h4>
                                <p class="mb-0">
                                    <?php foreach ($art['users'] as $user): ?>
                                        <a href="viewartists/?a=<?php echo $user['user_id'] ?>"
                                            class="text-danger"><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></a>
                                    <?php endforeach ?>
                                </p>
                                <p class="mb-0 fs-10px">
                                    <?php echo $art['place_created'] ?>
                                </p>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <span class="text-secondary fs-10px fw-bold">Year</span>
                                            </td>
                                            <td>
                                                <p class="mb-0">
                                                    <?php echo $art['date_created'] ?>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> <span class="text-secondary fs-10px fw-bold pe-2">Dimensions</span>
                                            </td>
                                            <td class="">
                                                <p class="mb-0"><?php echo $art['size'] ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> <span class="text-secondary fs-10px fw-bold">Media</span> </td>
                                            <td>
                                                <p class="mb-0 text-capitalize"><?php echo $art['media'] ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> <span class="text-secondary fs-10px fw-bold">Type</span> </td>
                                            <td>
                                                <p class="mb-0 text-capitalize"><?php echo $art['canvas_type'] ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> <span class="text-secondary fs-10px fw-bold">Frame</span> </td>
                                            <td>
                                                <p class="mb-0 text-capitalize"><?php echo $art['frame'] ?></p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="bg-dark text-white shadow-lg mt-3">
                                    <div class="w-100 d-flex align-items-center justify-content-between pt-2 px-2">
                                        <div>
                                            <p class="mb-0">
                                                <span class="text-capitalize fs-8px">
                                                    <?php echo $art['currency'] ?>
                                                </span>
                                                <span class="fw-bold">
                                                    <?php echo $art['price'] ?>
                                                </span>
                                            </p>
                                        </div>
                                        <div>
                                            <a class="btn btn-danger px-3">Add to Cart</a>
                                        </div>
                                    </div>
                                    <div class="px-2 pb-1">
                                        <p class="fs-8px">Buy Now, Pay Later</p>
                                    </div>
                                </div>
                                <div class="pt-lg-4 pt-2">
                                    <div class="d-flex align-items-center">
                                        <i class="okey-icon bg-success me-1" style="zoom:1.2"></i>
                                        Shipping included
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <i class="okey-icon bg-success me-1" style="zoom:1.2"></i>
                                        14 day satisfaction guarantee
                                    </div>

                                    <div class="d-flex align-items-center pt-2">
                                        <i class="star-icon bg-dark" style="zoom:1.2"></i>
                                        <i class="star-icon bg-dark" style="zoom:1.2"></i>
                                        <i class="star-icon bg-dark" style="zoom:1.2"></i>
                                        <i class="star-icon bg-dark" style="zoom:1.2"></i>
                                        <i class="star-icon bg-dark" style="zoom:1.2"></i>
                                        <span class="ps-1">Trustpilot Score</span>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between pt-3">
                                        <div class="d-flex align-items-center">
                                            <a class="bg-grey-400-hover d-flex rounded-circle p-1 cursor-pointer">
                                                <i class="love-icon icon-bg-dark icon-bg-white-hover"></i>
                                            </a>
                                            <span class="ps-1">0</span>
                                        </div>
                                        <div>
                                            <p class="mb-0">600 views</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <p class="text-justify"><?php echo $art['description'] ?></p>
                        </div>
                        <div class="col-12">
                            <div class="row g-3 d-flex">
                                <?php if (!empty($suggestions)): ?>
                                    <?php $firstUser = $art['users'][0]; ?>
                                    <h4>More From <a href="viewartists/?a=<?php echo $firstUser['user_id'] ?>"
                                            class="text-danger"><?php echo $firstUser['first_name'] . " " . $firstUser['last_name'] ?></a>
                                    </h4>
                                    <?php foreach ($suggestions as $suggest): ?>
                                        <div class="col-lg-2 col-md-3 col-6">
                                            <a href="viewart/?a=<?php echo $suggest['art_id'] ?>">
                                                <img data-src="../storage/arts/<?php echo $suggest['image']; ?>"
                                                    alt="<?php $suggest['imgalt'] ?>"
                                                    style="max-height:300px; max-width:300px;width:100%;">
                                            </a>
                                            <p class="mb-0 fs-10px"><?php echo $suggest['name']; ?></p>
                                            <p class="text-secondary fs-10px mb-0">
                                                <?php echo $suggest['canvas_type'] . " on " . $suggest['media']; ?>
                                            </p>
                                            <p class="art-dimension text-secondary fs-10px mb-0" title="">
                                                <?php echo $suggest['size']; ?>
                                            </p>
                                            <p class="text-secondary fs-10px">
                                                <?php echo $suggest['currency'] . " " . $suggest['price']; ?>
                                            </p>
                                        </div>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- art section ends -->
        <?php pageAdd('components/footer'); ?>
        <script src="./js/jquery.min.js"></script>
        <script src="./js/bootstrap.min.js"></script>
        <script src="./js/animations.js"></script>
        <script src="./js/art.js"></script>
    </body>

</html>