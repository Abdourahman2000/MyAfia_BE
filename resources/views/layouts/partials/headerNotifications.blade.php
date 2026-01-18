<!-- Start::main-header-dropdown -->
<div class="main-header-dropdown dropdown-menu dropdown-menu-end main-header-message" data-popper-placement="none">
    <div class="menu-header-content bg-primary text-fixed-white">
        <div class="d-flex align-items-center justify-content-between">
            <h6 class="mb-0 fs-15 fw-semibold text-fixed-white">Notifications</h6>
            <span class="badge rounded-pill bg-warning pt-1 text-fixed-black">Mark All
                Read</span>
        </div>
        <p class="dropdown-title-text subtext mb-0 text-fixed-white op-6 pb-0 fs-12 ">You have
            4 unread Notifications</p>
    </div>
    <div>
        <hr class="dropdown-divider">
    </div>
    <ul class="list-unstyled mb-0" id="header-notification-scroll">
        {{-- @include('layouts.partials.headerNotificationsContent') --}}
    </ul>
    <div class="text-center dropdown-footer">
        <a href="mail.html" class="text-primary fs-13">VIEW ALL</a>
    </div>
</div>
<!-- End::main-header-dropdown -->
