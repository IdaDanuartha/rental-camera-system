<nav class="layout-navbar mb-3 navbar rounded px-3 align-items-center bg-navbar-theme"
id="layout-navbar" style="z-index: 1 !important">
    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        <form action="" class="navbar-nav align-items-center">
            <div class="nav-item d-flex align-items-center">
            <i class="bx bx-search fs-4 lh-0"></i>
            <input
                type="text"
                class="form-control border-0 shadow-none ps-1 ps-sm-2"
                placeholder="Search..."
                name="query"
                value="{{ request()->get('query') }}"
                aria-label="Search..." />
            </div>            
        </form>
        <!-- /Search -->

        {{ $slot }}
    </div>
</nav>