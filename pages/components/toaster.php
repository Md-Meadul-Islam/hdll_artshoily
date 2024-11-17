<div class="toaster anim">
</div>
<?php
if (isset($_SESSION['success']) || isset($_SESSION['error'])) { ?>
    <div class="toaster" id="toaster">
        <?php if (isset($_SESSION['success'])) {
            foreach ($_SESSION['success'] as $key => $success) {
                ?>
                <div class="toast-message anim">
                    <div class="d-flex align-items-center px-2">
                        <a class="px-2">
                            <i class="okey-icon icon-bg-green" style="zoom:1.3"></i>
                        </a>
                        <p class="text-secondary ps-0 p-1 mb-0"><?php echo $success; ?></p>
                        <a class="toasterHideBtn cursor-pointer d-flex text-warning px-1 bg-grey-400-hover rounded-circle">✖</a>
                    </div>
                </div>
            <?php }
            unset($_SESSION['success']);
        }
        if (isset($_SESSION['error'])) {
            foreach ($_SESSION['error'] as $error) {
                ?>
                <div class="toast-message anim">
                    <div class="d-flex align-items-center px-2">
                        <a class="px-2">
                            <i class="error-icon icon-bg-red" style="zoom:1.3"></i>
                        </a>
                        <p class="text-secondary ps-0 p-1 mb-0"><?php echo $error; ?></p>
                        <a class="toasterHideBtn cursor-pointer d-flex text-warning px-1 bg-grey-400-hover rounded-circle">✖</a>
                    </div>
                </div>
            <?php }
            unset($_SESSION['error']);
        } ?>
    </div>
<?php } ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(function () {
            const toasts = document.querySelectorAll('.toast-message');
            toasts.forEach(toast => {
                toast.style.display = 'none';
            });
        }, 20000);
        document.addEventListener('click', function (e) {
            if (e.target.closest('.toasterHideBtn')) {
                const toast = e.target.closest('.toast-message');
                toast.style.display = 'none';
            }
        })
    });
</script>