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
        <!-- hero section starts -->
        <section class="mt-5">
            <div class="row g-0 d-flex">
                <div class="col-12">
                    <div class="hero-img w-100">
                        <img data-src="./images/arts.png" src="./images/arts.png" alt="Artists Cover Image"
                            class="w-100 h-100">
                    </div>
                </div>
            </div>
        </section>
        <!-- hero section ends -->
        <!-- art section starts -->
        <section class="mt-5">
            <div class="row g-0 d-flex align-items-center justify-content-center">
                <div class="col-lg-10 col-12">
                    <div class="row g-0 d-flex px-2 py-2">
                        <div class="col-lg-4 col-sm-6 col-12 p-2">
                            <div
                                class="art-image border border-1 border-secondary rounded-2 shadow w-100 overflow-hidden">
                                <img class="w-100" data-src="../storage/arts/<?php echo $art['image']; ?>"
                                    alt="<?php echo $art['name'] ?>">
                            </div>
                        </div>
                        <div class="col-lg-8 col-sm-6 col-12 p-2">
                            <h4 class="text-secondary fw-bold"><?php echo $art['name']; ?></h4>
                            <table>
                                <tbody>
                                    <tr>
                                        <td>
                                            <span class="text-secondary fs-10px fw-bold">Artists</span>
                                        </td>
                                        <td>
                                            <p class="mb-0">
                                                <?php foreach ($art['users'] as $user): ?>
                                                    <a><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></a>
                                                <?php endforeach ?>
                                            </p>
                                        </td>
                                    </tr>
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
                                        <td> <span class="text-secondary fs-10px fw-bold pe-2">Dimensions</span> </td>
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
                                    <tr>
                                        <td> <span class="text-secondary fs-10px fw-bold">Price</span> </td>
                                        <td>
                                            <p class="mb-0 text-capitalize">
                                                <?php echo $art['currency'] . ' ' . $art['price'] ?>
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <p class="py-2"><?php echo $art['description'] ?></p>
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