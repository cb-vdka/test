<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('teacher.teaching_schedule.index') }}" class="logo">
                <img src="{{ asset(env('LOGO', 'default/logo/logo.png')) }}" alt="Logo" class="navbar-brand" height="45" />
            </a>

            <div class="d-none d-md-block ms-2">
                <div class="header-text">
                    <div class="header-title-vi">TRƯỜNG QUÂN SỰ QUÂN KHU 2</div>
                    <div class="header-title-en">MILITARY SCHOOL OF REGION MILITARY SCHOOL 2</div>
                </div>
            </div>
            <div class="nav-toggle d-flex d-lg-none">
                <button class="btn btn-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#teacherSidebarMenu" aria-controls="teacherSidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="gg-menu-right"></i>
                </button>
            </div>
            
        </div>
        <!-- End Logo Header -->
    </div>

    <div class="sidebar-wrapper scrollbar scrollbar-inner scroll-y-hidden">
        <div class="sidebar-content collapse d-lg-block" id="teacherSidebarMenu">
            <ul class="nav nav-secondary">
                <li class="nav-item">
                    <a href="{{ route('teacher.teaching_schedule.index') }}" class="nav-link">
                        <i class="fas fa-calendar-alt"></i>
                        <p>Lịch huấn luyện</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#teacher-score" class="collapsed" aria-expanded="false">
                        <i class="fas fa-file-signature"></i>
                        <p>Bảng Điểm</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="teacher-score">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('teacher.enrollment.class.list') }}">
                                    <span class="sub-item">Nhập Điểm</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('teacher.enrollment_student.index') }}">
                                    <span class="sub-item">Bảng Điểm</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link">
                        <i class="fas fa-sign-out-alt"></i>
                        <p>Đăng xuất</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
<div class="sidebar-backdrop d-lg-none"></div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var menu = document.getElementById('teacherSidebarMenu');
        var sidebar = document.querySelector('.sidebar');
        var backdrop = document.querySelector('.sidebar-backdrop');
        if (!menu || !sidebar) return;

        // Bootstrap collapse events to toggle slide-in class
        menu.addEventListener('show.bs.collapse', function () {
            sidebar.classList.add('is-open');
        });
        menu.addEventListener('hide.bs.collapse', function () {
            sidebar.classList.remove('is-open');
        });

        // Close when clicking backdrop
        if (backdrop) {
            backdrop.addEventListener('click', function () {
                if (typeof bootstrap !== 'undefined') {
                    var instance = bootstrap.Collapse.getOrCreateInstance(menu);
                    instance.hide();
                } else {
                    sidebar.classList.remove('is-open');
                    menu.classList.remove('show');
                }
            });
        }
    });

</script>
