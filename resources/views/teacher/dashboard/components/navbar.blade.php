<div class="main-header">
    <div class="main-header-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('teacher.teaching_schedule.index') }}" class="logo">
                <img src="{{ asset('default/logo/logo.png') }}" alt="navbar brand" class="navbar-brand"
                    height="45" />
            </a>

            <div class="d-none d-md-block ms-2">
                <div class="header-text">
                    <div class="header-title-vi">TRƯỜNG QUÂN SỰ QUÂN KHU 2</div>
                    <div class="header-title-en">MILITARY SCHOOL OF REGION MILITARY SCHOOL 2</div>
                </div>
            </div>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <!-- Navbar Header -->
    <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
        <div class="container-fluid">
            <!-- Removed top search on desktop -->

            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <!-- Removed top search on mobile -->
                <li class="nav-item topbar-icon dropdown hidden-caret">
                    <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bell"></i>
                        <span class="notification">1</span>
                    </a>
                    <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                        <li>
                            <div class="dropdown-title">
                               Bạn có 1 thông báo
                            </div>
                        </li>
                        <li>
                            <div class="notif-scroll scrollbar-outer">
                                <div class="notif-center">
                                    <a href="#">
                                        <div class="notif-icon notif-primary">
                                            <i class="fa fa-user-plus"></i>
                                        </div>
                                        <div class="notif-content">
                                            <span class="block"> Hệ thống </span>
                                            <span class="time">Bạn đang đăng nhập</span>
                                        </div>
                                    </a>
                                     
                                </div>
                            </div>
                        </li>
                        <li>
                            <a class="see-all" href="javascript:void(0);">Xem thêm<i
                                    class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item topbar-user dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                        aria-expanded="false">
                        <i class="fa fa-user ms-2 me-2"></i>
                        <span class="profile-username">
                            <span class="op-7">Xin Chào, </span>
                            <span class="fw-bold">{{ session('user_name') ?? 'Giáo Viên' }}</span>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <div class="user-box ps-0">
                                    <div class="u-text">
                                        <h4>{{ session('user_name') ?? 'Giáo Viên' }}</h4>
                                        <p class="text-muted">{{ session('user_email') }}</p>
                                        
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}">Đăng Xuất</a>
                            </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <!-- End Navbar -->
</div>
