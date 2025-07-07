<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="artshoily">
        <meta name="description" content="<?php echo $blog['title'] ?>">
        <meta property="og:locale" content="en_US">
        <meta property="og:type" content="website" />
        <meta property="og:site_name" content="Art Shoily" />
        <meta property="og:title" content="Art Shoily | <?php echo $blog['title'] ?>" />
        <meta property="og:description" content="" />
        <meta property="og:image" content="https://www.artshoily.com/<?php echo $blog['image'] ?>" />
        <meta property="og:url" content="https://www.artshoily.com/blog?b=<?php echo $blog['blog_id'] ?>" />
        <meta property="og:image:width" content="1280">
        <meta property="og:image:height" content="720">
        <meta name="twitter:card" content="summary_large_image">
        <meta itemprop="name" content="Art Shoily | <?php echo $blog['title'] ?>" />
        <meta itemprop="description" content="<?php echo $blog['title'] ?>" />
        <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
        <meta name="rating" content="adult">
        <meta name="author" content="Art Shoily">
        <link rel="canonical" href="https://artshoily.com/blog?b=<?php echo $blog['blog_id'] ?>" />
        <link rel="apple-touch-icon" href="https://www.artishoily.com/images/favicon.ico">
        <link rel="icon" type="image/gif" href="../images/favicon.ico">
        <title>Art Shoily | <?php echo $blog['title'] ?></title>
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
        <section class="pt-5">
            <div class="row g-0 d-flex justify-content-center">
                <div class="col-lg-8 col-md-10 col-12 pt-lg-4 pt-md-3 pt-2">
                    <div>
                        <img data-src="../<?php echo $blog['image'] ?>" alt="<?php echo $blog['imgalt'] ?>"
                            style="width:100%;max-height:300px; object-fit:cover;">
                    </div>
                    <h2 class="text-center fw-bold pt-2"><?php echo $blog['title'] ?></h2>
                    <div class="blog">
                        <?php echo html_entity_decode($blog['body']); ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- hero section ends -->
        <?php pageAdd('components/footer'); ?>
        <script src="./js/jquery.min.js"></script>
        <script src="./js/bootstrap.min.js"></script>
        <script src="./js/animations.js"></script>
        <script src="./js/blogs.js"></script>
    </body>

</html>