<div class="main-header">
    <div class="main-header-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            @if (!empty(session('user_role') == 1))
                <a href="{{ route('dashboard.index') }}" class="logo">
                    <img src="{{ asset(env('LOGO')) }}" alt="navbar brand" class="navbar-brand" height="45" />
                </a>
            @elseif(!empty(session('user_role') == 2))
                <a href="{{ route('schedule.index') }}" class="logo">
                    <img src="{{ asset(env('LOGO')) }}" alt="navbar brand" class="navbar-brand" height="45" />
                </a>
            @elseif(!empty(session('user_role') == 3))
                <a href="{{ route('teaching_schedule.index') }}" class="logo">
                    <img src="{{ asset(env('LOGO')) }}" alt="navbar brand" class="navbar-brand" height="45" />
                </a>
            @else
                <a href="{{ route('dashboard.index') }}" class="logo">
                    <img src="{{ asset(env('LOGO')) }}" alt="navbar brand" class="navbar-brand" height="45" />
                </a>
            @endif
            
        </div>
        <!-- End Logo Header -->
    </div>
    <!-- Navbar Header -->
    <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
        <div class="container-fluid">
            <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button type="submit" class="btn btn-search pe-1">
                            <i class="fa fa-search search-icon"></i>
                        </button>
                    </div>
                    <input type="text" placeholder="Tìm Kiếm..." class="form-control" />
                </div>
            </nav>

            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                        aria-expanded="false" aria-haspopup="true">
                        <i class="fa fa-search"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-search animated fadeIn">
                        <form class="navbar-left navbar-form nav-search">
                            <div class="input-group">
                                <input type="text" placeholder="Tìm Kiếm..." class="form-control" />
                            </div>
                        </form>
                    </ul>
                </li>

                <li class="nav-item topbar-user dropdown hidden-caret">
                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                        aria-expanded="false">
                        <i class="fa fa-user ms-2 me-2"></i>
                        <span class="profile-username">
                            <span class="op-7">Xin Chào, </span>
                            <span class="fw-bold">{{ session('user_name') }}</span>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <div class="user-box ps-0">
                                    <div class="u-text">
                                        <h4>{{ session('user_name') }}</h4>
                                        <p class="text-muted">{{ session('user_email') }}</p>
                                        <!-- <a href="profile.html" class="btn btn-xs btn-secondary btn-sm">Hồ Sơ</a> -->
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
