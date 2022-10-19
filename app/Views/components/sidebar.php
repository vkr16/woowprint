<section id="sidebar-section">
    <div class="offcanvas-lg offcanvas-start custom-sidebar" data-bs-scroll="true" tabindex="-1" id="sidebarPanelOffCanvas" style="overflow-y: auto">
        <div class="d-flex flex-column flex-shrink-0 py-3 bg-white" style="width: auto; height: 100vh;">
            <a href="<?= base_url() ?>" class=" px-3 d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                <!-- <i class="fa-brands fa-bootstrap fa-fw fa-2x"></i> -->
                <img src="<?= base_url('public/assets/img/logo.png') ?>" width="36px" alt="">
                &emsp;
                <span class="fs-4 font-nunito-sans"><span class="fw-bold">woow</span>print</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="<?= base_url('admin') ?>" class="nav-link rounded-0 link-dark" aria-current="page" id="sidebar_dashboard">
                        <i class="fa-solid fa-layer-group fa-fw"></i>&emsp;
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/orders') ?>" class="nav-link rounded-0 link-dark" id="sidebar_orders">
                        <i class="fa-solid fa-file-invoice fa-fw"></i>&emsp;
                        Orders
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/administrators') ?>" class="nav-link rounded-0 link-dark" id="sidebar_administrators">
                        <i class="fa-solid fa-user-tie fa-fw"></i>&emsp;
                        Administrators
                    </a>
                </li>
            </ul>
            <hr>
            <div class="px-3">
                <span class="d-flex align-items-center link-dark text-decoration-none">
                    <i class="fa-solid fa-user-tie me-3"></i>
                    <p class="mb-0"><?= $_SESSION['oms_cetakfoto_user_in_session'] ?></p>
                </span>
            </div>
        </div>
    </div>
</section>