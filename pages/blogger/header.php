<nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top flex-column py-0">
    <div class="row g-0 w-100 d-flex align-items-center justify-content-between py-1">
        <div class="col-4 me-auto ">
            <div class="row g-0 d-flex align-items-center justify-content-start">
                <div class="col-3 d-flex align-items-center pe-2">
                    <div class="">
                        <a class="cursor-pointer bg-grey-400-hover rounded-5 p-2 d-flex" id="leftmenubtn"><i
                                class="menu-bar-icon icon-bg-grey icon-bg-white-hover"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4 px-2 d-flex align-items-center justify-content-center">
            <a href="/" class="navbar-brand m-0 p-0"><img data-src="../images/logo.jpg" src="./images/logo.jpg"
                    alt="Artshoily" height="40px"></a>
        </div>
        <div class="col-4 ms-auto d-flex align-items-center justify-content-end">
            <div class="px-3 d-flex align-items-center position-relative">
                <?php if (user()->email) { ?>
                    <a class="userphotobtn position-relative mx-1 cursor-pointer">
                        <img data-src="../<?php echo user()->userphoto ?>" alt="Profile"
                            class="rounded-circle border border-2 border-secondary-subtle" width="32px" height="32px">
                    </a>
                    <div class="userdetails bg-body-tertiary">
                        <div class="py-1 text-nowrap">
                            <a
                                class="cursor-pointer p-2 text-underline-hover text-nowrap"><?php echo user()->firstname . ' ' . user()->lastname ?></a>
                        </div>
                        <div class="py-1 d-flex justify-content-center">
                            <a class="btn btn-sm btn-secondary cursor-pointer text-nowrap"
                                onclick="event.preventDefault(); document.getElementById('logout_form').submit();">Log
                                Out</a>
                            <form id="logout_form" action="/logout" method="POST"></form>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</nav>