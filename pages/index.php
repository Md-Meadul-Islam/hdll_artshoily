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
        <title>Art Shoily</title>
        <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="./css/bootstrap.css" />
        <link rel="stylesheet" href="./css/style.css" />
        <link rel="stylesheet" href="./css/loader.css" />
        <link rel="stylesheet" href="./css/icons.css" />
        <script src="../js/utilities.js"></script>
    </head>

    <body>
        <?php pageAdd('components/header'); ?>
        <script>
            let headtitle = document.querySelector('head title');
            let metakeys = document.querySelector('meta[name="keywords"]');
            let metadesc = document.querySelector('meta[name="description"]');
            let canonical = document.querySelector('link[rel="canonical"]');
            function meta(title, key, desc, can) {
                headtitle.innerHTML = title;
                metakeys.setAttribute('content', key);
                metadesc.setAttribute('content', desc);
                canonical.setAttribute('href', can);
            }
        </script>
        <!-- hero section starts -->
        <section class="mt-5">
            <div class="row g-0 d-flex">
                <div class="col-12">
                    <div class="hero-img w-100">
                        <img data-src="./images/hero.jpg" src="./images/hero.jpg" alt="HomePage" class="w-100 h-100">
                    </div>
                </div>
            </div>
        </section>
        <!-- hero section ends -->
        <!-- discover section starts -->
        <section class="py-5">
            <div class="row g-0 d-flex justify-content-center align-items-center">
                <div class="col-lg-8 col-md-10 col-12">
                    <div class="w-100 d-flex align-items-center justify-content-center">
                        <div class="goldenStroke position-relative"></div>
                    </div>
                    <div class="w-100 py-3">
                        <p class="text-center">
                            At Artshoily, we focus on quality and thoughtful curation, offering a carefully selected
                            collection of paintings, drawings, limited edition prints, sculptures, digital art,
                            traditional crafts, tribal art, rare collectibles, and unique artifacts. Each piece is
                            sourced from trusted artists, designers, and collectors, ensuring authenticity and cultural
                            depth. Whether you're discovering a statement piece or a hidden gem, Artshoily is your
                            gateway to celebrating the rich artistic heritage of Bangladesh and beyond.
                        </p>
                    </div>
                    <!-- <ul class="nav text-uppercase text-gold fs-10px d-flex align-items-center justify-content-around">
                        <li class="nav-item">
                            <a>Impeccable Curation</a>
                        </li>
                        <li class="nav-item">
                            <a>Guaranteed Authenticity</a>
                        </li>
                        <li class="nav-item">
                            <a>Personalized Service</a>
                        </li>
                        <li class="nav-item">
                            <a>Insured Worldwide Shipping</a>
                        </li>
                    </ul>
                    <div class="w-100 d-flex align-items-center justify-content-center py-3 fs-10px">
                        <a class="btn btn-sm btn-outline-secondary text-uppercase">Learn More</a>
                    </div> -->
                    <div class="w-100 bg-secondary-subtle mt-3 py-3">
                        <h4 class="text-center">
                            - DISCOVER OUR WORLD -
                        </h4>
                        <div class="row g-0 d-flex justify-content-around align-items-center pt-3">
                            <div class="col-md-4 col-8">
                                <div class="">
                                    <img data-src="./images/discover/02.png" alt="discover"
                                        class="w-100 h-100 rounded-circle">
                                </div>
                                <div class="goldenStroke py-2"></div>
                                <div class="d-flex align-items-center justify-content-center">
                                    <a href="art-gallery" class="text-uppercase">Art Gallery</a>
                                </div>
                            </div>
                            <div class="col-md-4 col-8">
                                <div class="">
                                    <img data-src="./images/discover/01.png" alt="discover"
                                        class="w-100 h-100 rounded-circle">
                                </div>
                                <div class="goldenStroke py-2"></div>
                                <div class="d-flex align-items-center justify-content-center">
                                    <a class="text-uppercase">Collectibles</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- discover section ends -->
        <!-- inspired collections section starts -->
        <section class="py-5">
            <div class="row g-0 d-flex align-items-center justify-content-center">
                <h4 class="text-center">
                    - INSPIRED COLLECTIONS -
                </h4>
                <div class="col-md-10 col-12">
                    <div class="row g-0 d-flex align-items-center justify-content-around">
                        <div class="col-md-4 col-sm-6 col-12 p-2">
                            <div>
                                <img data-src="./images/inspired_collections/Gond_Art_1_720x.png" alt="collections"
                                    class="w-100 h-100">
                            </div>
                            <div>
                                <p>Intricate Gond Paintings</p>
                                <div class="goldenStroke"></div>
                                <div class="py-2">
                                    <a href="art-gallery" class="btn btn-sm btn-outline-secondary">SHOP</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12 p-2">
                            <div>
                                <img data-src="./images/inspired_collections/Oleographs-03_720x.png" alt="collections"
                                    class="w-100 h-100">
                            </div>
                            <div>
                                <p>Intricate Gond Paintings</p>
                                <div class="goldenStroke"></div>
                                <div class="py-2">
                                    <a href="viewart/?a=dadfdd545dfd3424"
                                        class="btn btn-sm btn-outline-secondary">EXPLORE</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12 p-2">
                            <div>
                                <img data-src="./images/inspired_collections/Collectibles-01_5bbce089-5173-45e4-beda-c224bee3e335_720x.png"
                                    alt="collections" class="w-100 h-100">
                            </div>
                            <div>
                                <p>Intricate Gond Paintings</p>
                                <div class="goldenStroke"></div>
                                <div class="py-2">
                                    <a href="viewartists/?a=" class="btn btn-sm btn-outline-secondary">DISCOVER</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- inspired collections section ends -->
        <!-- limited editions prints section starts -->
        <section class="py-5">
            <div class="row g-0 d-flex align-items-center justify-content-center">
                <div class="col-md-10 col-12">
                    <div class="p-2 d-flex flex-column justify-content-center align-items-center">
                        <h4 class="text-center text-uppercase py-3">
                            - Limited Edition Prints -
                        </h4>
                        <p class="text-center">
                            A collection of limited edition masterpieces by World most acclaimed artists; serigraphs
                            offer a
                            fantastic way to own works by masters such as M.F. Husain, Thota Vaikuntam, S.H. Raza and
                            many
                            more,
                            at affordable prices.
                        </p>
                        <div class="goldenStroke w-50"></div>
                    </div>
                    <div class="row g-0 d-flex align-items-center justify-content-around">
                        <div class="col-12 py-3">
                            <div>
                                <img data-src="./images/Desktop-06_1800x.png" alt="Limited Editions"
                                    class="w-100 h-100">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="limited-edition row d-flex align-items-center justify-content-center">
                            </div>
                        </div>
                        <div class="col-12 d-flex align-items-end justify-content-end">
                            <a href="art-gallery" class="btn btn-sm bg-secondary-subtle text-uppercase">VIEW ENTIRE
                                COLLECTION </a>
                        </div>
                    </div>
                </div>
                <div class="col-12 py-3">
                    <div>
                        <img data-src="./images/Homepage_Small_Banner_Desktop_1800x.png" alt="Limited Editions"
                            class="w-100 h-100">
                    </div>
                </div>
            </div>
        </section>
        <!-- limited editions prints section ends -->
        <!--focus section starts -->
        <section class="py-5">
            <div class="row g-0 d-flex align-items-center justify-content-center">
                <h4 class="text-center text-uppercase pb-3">
                    - ARTSHOILY IN FOCUS -
                </h4>
                <div class="col-md-10 col-12">
                    <div class="focus-artists row g-0 d-flex align-items-center justify-content-around">
                    </div>
                </div>
            </div>
        </section>
        <!--focus section ends -->
        <!-- client stories section starts -->
        <section class="py-5">
            <div class="row g-0 d-flex align-items-center justify-content-center">
                <div class="col-md-10 col-12 bg-secondary-subtle">
                    <div class="p-2 d-flex flex-column justify-content-center align-items-center">
                        <h4 class="text-center text-uppercase py-3">
                            - CLIENT STORIES -
                        </h4>
                    </div>
                    <div class="row g-0 d-flex align-items-center justify-content-around p-2">
                        <div class="col-md-4 col-sm-6 col-12 p-3">
                            <div class="d-flex align-items-center justify-content-center">
                                <img data-src="./images/stories/Mohit-Chopra-Dinkar-Jadhav-Gurgaon_420x420.png"
                                    alt="editions" style="max-height:300px; max-width:300px">
                            </div>
                            <div>
                                <p class="fs-10px text-italic py-2">Painting by Rafael Mirkim</p>
                                <div class="goldenStroke"></div>
                                <p class="text-secondary fs-10px mb-0 pt-2">Client: M. Maikel</p>
                                <p class="text-secondary fs-10px">Toronto, Canada</p>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12 p-3">
                            <div class="d-flex align-items-center justify-content-center">
                                <img data-src="./images/stories/Amit-Banerji-Claire-Iono-02_420x420.png" alt="editions"
                                    style="max-height:300px; max-width:300px">
                            </div>
                            <div>
                                <p class="fs-10px text-italic py-2">Paintings by Claire Iono </p>
                                <div class="goldenStroke"></div>
                                <p class="text-secondary fs-10px mb-0 pt-2">Client: D'Anglo</p>
                                <p class="text-secondary fs-10px">New York, USA </p>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12 p-3">
                            <div class="d-flex align-items-center justify-content-center">
                                <img data-src="./images/stories/Mohit-Chopra-Dinkar-Jadhav-Gurgaon_420x420.png"
                                    alt="editions" style="max-height:300px; max-width:300px">
                            </div>
                            <div>
                                <p class="fs-10px text-italic py-2">Painting by Alex Bonan</p>
                                <div class="goldenStroke"></div>
                                <p class="text-secondary fs-10px mb-0 pt-2">Client: Sonal Gandhi</p>
                                <p class="text-secondary fs-10px">Chicago, USA </p>
                            </div>
                        </div>
                        <div class="col-12 d-flex align-items-end justify-content-end">
                            <a class="btn btn-sm bg-secondary-subtle text-uppercase shadow-lg">VIEW All STORIES
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- client stories section ends -->
        <!--  gift cards section starts -->
        <!-- <section class="py-5">
            <div class="row g-0 d-flex align-items-center justify-content-center">
                <h4 class="text-center text-uppercase">
                    - Gift cards - </h4>
                <div class="col-md-10 col-12">
                    <div>
                        <img data-src="./images/gifts/Gift-Card-Banner-Desktop-1_271a1c0a-d499-48d5-b0dc-689c6a0b2f45_1800x.png"
                            alt="gifts" class="w-100">
                    </div>
                </div>
            </div>
        </section> -->
        <!-- gift cards section ends -->
        <!-- collectibles section starts -->
        <section class="py-5">
            <div class="row g-0 d-flex align-items-center justify-content-center">
                <h4 class="text-center text-uppercase">
                    - COLLECTIBLES -
                </h4>
                <div class="col-md-10 col-12">
                    <div class="row g-0 d-flex justify-content-around">
                        <div class="col-md-4 col-sm-6 col-12 p-3">
                            <div class="d-flex align-items-center justify-content-center">
                                <img data-src="./images/collectibles/rug1.jpg" alt="editors"
                                    style="height:300px; max-width:300px">
                            </div>
                            <div class="row g-0 d-flex justify-content-between align-items-end pt-2">
                                <div class="col-6">
                                    <p class="mb-0 fs-10px fw-bold">Hanuman Plaque 01 </p>
                                    <p class="text-secondary fs-10px mb-0">Brass</p>
                                    <p class="text-secondary fs-10px">6 x 2 x 7.75 inches</p>
                                </div>
                                <div class="col-6 d-flex flex-column align-items-end">
                                    <p class="text-secondary fs-10px">BDT 50,400 </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12 p-3">
                            <div class="d-flex align-items-center justify-content-center">
                                <img data-src="./images/collectibles/rug2.jpg" alt="editors" style="height:300px;
                                    max-width:300px">
                            </div>
                            <div class="row g-0 d-flex justify-content-between align-items-end pt-2">
                                <div class="col-6">
                                    <p class="mb-0 fs-10px fw-bold">Sperry Remington Idool Red Typewriter </p>
                                    <p class="text-secondary fs-10px mb-0">Assorted Materials </p>
                                    <p class="text-secondary fs-10px">13.5 x 12 x 4.5 Inches</p>
                                </div>
                                <div class="col-6 d-flex flex-column align-items-end">
                                    <p class="text-secondary fs-10px">BDT 33,040</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12 p-3">
                            <div class="d-flex align-items-center justify-content-center">
                                <img data-src="./images/collectibles/rug3.jpg" alt="editors"
                                    style="height:300px; max-width:300px">
                            </div>
                            <div class="row g-0 d-flex justify-content-between align-items-end pt-2">
                                <div class="col-6">
                                    <p class="mb-0 fs-10px fw-bold">Bala Krishna </p>
                                    <p class="text-secondary fs-10px mb-0">Bronze</p>
                                    <p class="text-secondary fs-10px">3.5 x 3.5 x 4 inches</p>
                                </div>
                                <div class="col-6 d-flex flex-column align-items-end">
                                    <p class="text-secondary fs-10px">Price on Inquiry | <span
                                            class="text-uppercase text-gold">Sold</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- collectibles section ends -->
        <!-- news section starts -->
        <section class="py-5">
            <div class="row g-0 d-flex align-items-center justify-content-center">
                <div class="col-md-10 col-12">
                    <div class="row g-0 d-flex align-items-center justify-content-center">
                        <h4 class="text-center text-uppercase">- PARTNERS AND CLIENTS -
                        </h4>
                        <div class="col-2 p-2 h-100">
                            <div class="w-100 h-100">
                                <img data-src="./images/news/Verve-02_200x.png" alt="VERVE" class="w-100 h-100">
                            </div>
                        </div>
                        <div class="col-2 p-2 h-100">
                            <div class="w-100 h-100">
                                <img data-src="./images/news/India-Today_200x.png" alt="India" class="w-100 h-100">
                            </div>
                        </div>
                        <div class="col-2 p-2 h-100">
                            <div class="w-100 h-100">
                                <img data-src="./images/news/Casa-Vogue-02_200x.png" alt="Casa-Vogue"
                                    class="w-100 h-100">
                            </div>
                        </div>
                        <div class="col-2 p-2 h-100">
                            <div class="w-100 h-100">
                                <img data-src="./images/news/AD-02_200x.png" alt="AD-02" class="w-100 h-100">
                            </div>
                        </div>
                        <div class="col-2 p-2 h-100">
                            <div class="w-100 h-100">
                                <img data-src="./images/news/Deccan-Chronicle_200x.png" alt="Deccan-Chronicle"
                                    class="w-100 h-100">
                            </div>
                        </div>
                        <div class="col-2 p-2 h-100">
                            <div class="w-100 h-100">
                                <img data-src="./images/news/DNA-02_200x.png" alt="DNA" class="w-100 h-100">
                            </div>
                        </div>
                        <div class="col-12 d-flex align-items-center justify-content-end py-2">
                            <a href="" class="btn btn-sm bg-secondary-subtle shadow-lg text-uppercase">View all press
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- news section ends -->
        <!-- blogs section starts -->
        <section class="py-5">
            <div class="row g-0 d-flex align-items-center justify-content-center">
                <div class="col-md-10 col-12">
                    <div class="p-2 d-flex flex-column justify-content-center align-items-center">
                        <h4 class="text-center text-uppercase py-3">
                            - LATEST FROM OUR BLOG -
                        </h4>
                    </div>
                    <div class="row g-0 d-flex align-items-center justify-content-around p-2">
                        <div class="col-md-4 col-sm-6 col-12 p-3">
                            <div class="d-flex align-items-center justify-content-center">
                                <img data-src="./images/blog/718a48ac-3d9d-47b1-9dc6-c124fb10c66e_435x290.png"
                                    alt="editions" style="max-height:200px; width:100%">
                            </div>
                            <div class="py-3">
                                <p class="fs-10px pb-2">Trails in Colour - Tracking Anjolie Ela Menon's
                                    Maverick Journey Through Her Artworks</p>
                                <div class="goldenStroke w-80"></div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12 p-3">
                            <div class="d-flex align-items-center justify-content-center">
                                <img data-src="./images/blog/bb76d2b4-7349-4b02-a869-f3c938e376e4_435x290.png"
                                    alt="editions" style="max-height:200px; width:100%">
                            </div>
                            <div class="py-3">
                                <div class="goldenStroke w-80"></div>
                                <p class="fs-10px pt-2">Art of Consequence - A Photo Essay on the Legendary, Non
                                    Conforming Artist Jamini Roy</p>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12 p-3">
                            <div class="d-flex align-items-center justify-content-center">
                                <img data-src="./images/blog/c69ad448-6e9a-4cb3-9769-591de18a0ef9_435x290.png"
                                    alt="editions" style="max-height:200px; width:100%">
                            </div>
                            <div class="py-3">
                                <p class="fs-10px pb-2">V.S. Gaitonde The Record breaking Icon of Indian Modernism</p>
                                <div class="goldenStroke w-80"></div>
                            </div>
                        </div>
                        <div class="col-12 d-flex align-items-end justify-content-end">
                            <a class="btn btn-sm bg-secondary-subtle text-uppercase shadow-lg">VIEW All BLOGS
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- blogs section ends -->
        <div class="modal modal-lg fade" id="mainmodal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content overflow-hidden">
                </div>
            </div>
        </div>
        <?php pageAdd('components/footer'); ?>
        <script src="./js/jquery.min.js"></script>
        <script src="./js/bootstrap.min.js"></script>
        <script src="./js/animations.js"></script>
        <script src="./js/index.js"></script>
        <?php pageAdd('components/toaster'); ?>
    </body>

</html>