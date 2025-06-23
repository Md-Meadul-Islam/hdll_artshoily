<div class="leftmenu col-2">
    <div class="sidebar px-2">
        <?php if (user()->email) { ?>
            <div class="card mb-3 p-2 rounded-0">
                <div class="user-panel pb-2 text-center">
                    <div class="image">
                        <img data-src="../<?php echo user()->userphoto; ?>"
                            class="rounded-circle border border-2 border-secondary" alt="User"
                            style="width:50px;height:50px">
                    </div>
                    <div class="info ps-2">
                        <a class="text-secondary">
                            <h5 class="text-capitalize fw-bold mb-0">
                                <?php echo user()->firstname . ' ' . user()->lastname; ?>
                            </h5>
                        </a>
                    </div>
                    <hr>
                </div>
            </div>
        <?php } ?>
        <nav class="">
            <div class="card p-2 gap-2 rounded-0">
                <div>
                    <a class="all-arts-btn d-flex align-items-center text-secondary cursor-pointer border border-1 border-secondary p-2 bg-primary-subtle bg-grey-400-hover"
                        id="all-arts-btn">
                        <i class="art-icon icon-bg-grey" style="zoom:1.5"></i>
                        <span class="ps-2">Arts</span>
                    </a>
                </div>
                <div>
                    <a class="all-users-btn d-flex align-items-center text-secondary cursor-pointer border border-1 border-secondary p-2 bg-success-subtle bg-grey-400-hover"
                        id="all-users-btn">
                        <i class="user-icon icon-bg-grey" style="zoom:1.5"></i>
                        <span class="ps-2">Users</span>
                    </a>
                </div>
                <div>
                    <a class="all-sculptures-btn d-flex align-items-center text-secondary cursor-pointer border border-1 border-secondary p-2 bg-danger-subtle bg-grey-400-hover"
                        id="all-sculptures-btn">
                        <i class="sculpture-icon icon-bg-grey" style="zoom:1.5"></i>
                        <span class="ps-2">Sculptures</span>
                    </a>
                </div>
                <div>
                    <a class="all-blogs-btn d-flex align-items-center text-secondary cursor-pointer border border-1 border-secondary p-2 bg-danger-subtle bg-grey-400-hover"
                        id="all-blogs-btn">
                        <i class="article-icon icon-bg-grey" style="zoom:1.5"></i>
                        <span class="ps-2">Blogs</span>
                    </a>
                </div>
                <div>
                    <a class="d-flex align-items-center text-secondary cursor-pointer border border-1 border-secondary p-2 bg-danger-subtle bg-grey-400-hover"
                        id="inspired-collections">
                        <span class="ps-2 text-nowrap">Inspired Collections</span>
                    </a>
                </div>
                <div>
                    <a class="d-flex align-items-center text-secondary cursor-pointer border border-1 border-secondary p-2 bg-danger-subtle bg-grey-400-hover"
                        id="limited-edition">
                        <span class="ps-2 text-nowrap">Limited Edition</span>
                    </a>
                </div>
                <div>
                    <a class="artshoily-in-focus d-flex align-items-center text-secondary cursor-pointer border border-1 border-secondary p-2 bg-warning-subtle bg-grey-400-hover"
                        id="artshoily-in-focus">
                        <i class="user-icon icon-bg-grey" style="zoom:1.5"></i>
                        <span class="ps-2 text-nowrap">Artshoily In Focus</span>
                    </a>
                </div>
                <div>
                    <a class="d-flex align-items-center text-secondary cursor-pointer border border-1 border-secondary p-2 bg-danger-subtle bg-grey-400-hover"
                        id="client-stories">
                        <span class="ps-2 text-nowrap">Client Stories </span>
                    </a>
                </div>
                <div>
                    <a class="d-flex align-items-center text-secondary cursor-pointer border border-1 border-secondary p-2 bg-danger-subtle bg-grey-400-hover"
                        id="partners-and-clients">
                        <span class="ps-2 text-nowrap">Partners And Clients</span>
                    </a>
                </div>
                <div>
                    <a class="d-flex align-items-center text-secondary cursor-pointer border border-1 border-secondary p-2 bg-danger-subtle bg-grey-400-hover"
                        id="latest-from-our-blog">
                        <span class="ps-2 text-nowrap">Latest From Our Blog</span>
                    </a>
                </div>
                <div>
                    <a class="d-flex align-items-center text-secondary cursor-pointer border border-1 border-secondary p-2 bg-danger-subtle bg-grey-400-hover"
                        id="hero-banner">
                        <span class="ps-2 text-nowrap">Hero Banner</span>
                    </a>
                </div>
            </div>
        </nav>
    </div>
</div>