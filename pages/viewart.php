<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords"
            content="artshoily, <?php echo $art['name'] . ', ' . $art['users'][0]['first_name'] . ' ' . $art['users'][0]['last_name'] ?>">
        <meta name="description" content="<?php echo $art['description'] ?>">
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
        <title><?php echo $art['name'] ?> | Art Shoily</title>
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
                    <div class="row g-5 d-flex justify-content-center px-2 py-2">
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
                                <!-- add to cart -->
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
                                        <div class="quantity w-50">
                                            <input type="number" class="form-control" value="1" min="1">
                                        </div>

                                    </div>
                                    <div class="d-flex align-items-center justify-content-between pt-2 px-2">
                                        <div>
                                            <a class="btn btn-outline-success bg-gold text-white px-3">Buy Now</a>
                                        </div>
                                        <div>
                                            <a class="btn btn-outline-success btn-danger text-white px-3">Add to
                                                Cart</a>
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
                                        <i class="star-icon bg-warning" style="zoom:1.2"></i>
                                        <i class="star-icon bg-warning" style="zoom:1.2"></i>
                                        <i class="star-icon bg-warning" style="zoom:1.2"></i>
                                        <i class="star-icon bg-warning" style="zoom:1.2"></i>
                                        <i class="star-icon bg-warning" style="zoom:1.2"></i>
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
                        <!-- more from artists -->
                        <div class="col-12">
                            <?php $firstUser = $art['users'][0]; ?>
                            <div class="suggestions row g-3 d-flex" data-userid="<?php echo $firstUser['user_id']; ?>"
                                data-username="<?php echo $firstUser['first_name'] . " " . $firstUser['last_name'] ?>">
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-10 col-12 mt-2 p-2">
                            <h4 class="fw-bold">About the Artwork</h4>
                            <?php
                            $description = htmlspecialchars($art['description']);
                            $words = explode(' ', $description);
                            $first_100_words = implode(' ', array_slice($words, 0, 100));
                            $remain_words = implode(' ', array_slice($words, 100));
                            ?>
                            <p class="art-desc text-justify mb-0" data-remain="<?php echo $remain_words; ?>">
                                <?php echo $first_100_words; ?>
                            </p>
                            <a
                                class="more-description-btn cursor-pointer w-100 d-flex align-items-center justify-content-center"><i
                                    class="angle-down-icon icon-bg-grey" style="zoom:1.2"></i></a>
                        </div>
                        <hr class="mt-1">
                        <div class="col-md-10 col-12 mt-2 p-2">
                            <h4 class="fw-bold">Shipping and Returns</h4>
                            <table>
                                <tr>
                                    <td>
                                        <p class="fw-bold mb-0 pe-2">Delivery Time:</p>
                                    </td>
                                    <td>Typically 5-7 business days for domestic shipments, 10-14 business days for
                                        international shipments.</td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="fw-bold mb-0 pe-2">Returns:</p>
                                    </td>
                                    <td>14 day return policy. Visit our help section for more information.</td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="fw-bold mb-0 pe-2">Delivery Cost:</p>
                                    </td>
                                    <td>Shipping is included.</td>
                                </tr>
                            </table>
                            <a
                                class="more-shipping-btn cursor-pointer w-100 d-flex align-items-center justify-content-center"><i
                                    class="angle-down-icon icon-bg-grey" style="zoom:1.2"></i></a>
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