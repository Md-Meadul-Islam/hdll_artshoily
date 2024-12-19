<div class="leftmenu col-2">
    <div class="sidebar px-2">
        <?php if (user()->email) { ?>
            <div class="card mb-3 p-2 rounded-0">
                <div class="user-panel pb-2 text-center">
                    <div class="image">
                        <img data-src="<?php echo user()->userphoto; ?>"
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
                    <a class="d-flex align-items-center text-secondary cursor-pointer border border-1 border-secondary p-2 bg-primary-subtle bg-grey-400-hover"
                        id="new-art" data-bs-toggle="modal" data-bs-target="#staticmodal">
                        <i class="article-icon icon-bg-grey" style="zoom:1.5"></i>
                        <span class="ps-2">Add Arts</span>
                    </a>
                </div>
                <div>
                    <a class="d-flex align-items-center text-secondary cursor-pointer border border-1 border-secondary p-2 bg-success-subtle bg-grey-400-hover"
                        id="allartists">
                        <i class="user-icon icon-bg-grey" style="zoom:1.5"></i>
                        <span class="ps-2">Artists</span>
                    </a>
                </div>
                <div>
                    <a class="d-flex align-items-center text-secondary cursor-pointer border border-1 border-secondary p-2 bg-danger-subtle bg-grey-400-hover"
                        id="inspired-collection">
                        <i class="search-icon icon-bg-grey" style="zoom:1.5"></i>
                        <span class="ps-2">Inspired Collection</span>
                    </a>
                </div>
                <div>
                    <a class="d-flex align-items-center text-secondary cursor-pointer border border-1 border-secondary p-2 bg-primary-subtle bg-grey-400-hover"
                        id="limited-edition">
                        <i class="article-icon icon-bg-grey" style="zoom:1.5"></i>
                        <span class="ps-2">Limited Edition</span>
                    </a>
                </div>
                <div>
                    <a class="d-flex align-items-center text-secondary cursor-pointer border border-1 border-secondary p-2 bg-warning-subtle bg-grey-400-hover"
                        id="client-stories">
                        <i class="polls-icon icon-bg-grey" style="zoom:1.5"></i>
                        <span class="ps-2">Client Stories</span>
                    </a>
                </div>
                <div>
                    <a class="d-flex align-items-center text-secondary cursor-pointer border border-1 border-secondary p-2 bg-danger-subtle bg-grey-400-hover"
                        id="editor-pics">
                        <i class="article-icon icon-bg-grey" style="zoom:1.5"></i>
                        <span class="ps-2">Editor's Pics</span>
                    </a>
                </div>
                <div>
                    <a class="d-flex align-items-center text-secondary cursor-pointer border border-1 border-secondary p-2 bg-danger-subtle bg-grey-400-hover"
                        id="blogs">
                        <i class="article-icon icon-bg-grey" style="zoom:1.5"></i>
                        <span class="ps-2">Blogs</span>
                    </a>
                </div>
            </div>
        </nav>
    </div>
</div>