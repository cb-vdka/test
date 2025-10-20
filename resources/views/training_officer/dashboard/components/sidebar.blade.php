<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            @if (!empty(session('user_role') == 1))
                <a href="{{ route('dashboard.index') }}" class="logo">
                    <img src="{{ asset(env('LOGO', 'default/logo/logo.png')) }}" alt="Logo" class="navbar-brand" height="45" />
                </a>
            @elseif(!empty(session('user_role') == 2))
                <a href="{{ route('schedule.index') }}" class="logo">
                    <img src="{{ asset(env('LOGO', 'default/logo/logo.png')) }}" alt="Logo" class="navbar-brand" height="45" />
                </a>
            @elseif(!empty(session('user_role') == 3))
                <a href="{{ route('teaching_schedule.index') }}" class="logo">
                    <img src="{{ asset(env('LOGO', 'default/logo/logo.png')) }}" alt="Logo" class="navbar-brand" height="45" />
                </a>
            @else
                <a href="{{ route('dashboard.index') }}" class="logo">
                    <img src="{{ asset(env('LOGO', 'default/logo/logo.png')) }}" alt="Logo" class="navbar-brand" height="45" />
                </a>
            @endif
            <div class="d-none d-md-block ms-2">
                <div class="header-text">
                    <div class="header-title-vi">TRƯỜNG QUÂN SỰ QUÂN KHU 2</div>
                    <div class="header-title-en">MILITARY SCHOOL OF REGION MILITARY SCHOOL 2</div>
                </div>
            </div>
            
        </div>
        <!-- End Logo Header -->
    </div>

    <div class="sidebar-wrapper scrollbar scrollbar-inner scroll-y-hidden">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">

                {{-- Dùng để lọc sidebar từ trong config/apps/module.php --}}
                @foreach (config('apps.module') as $key => $value)
                    @foreach ($value as $index => $item)
                        @if (in_array(session('user_role'), (array) $item['user_role']))
                            <li class="nav-item">
                                <a data-bs-toggle="collapse" href="#dashboard-{{ $key }}-{{ $index }}"
                                    class="collapsed" aria-expanded="false">
                                    <i class="{{ $item['icon'] }}"></i>
                                    <p>{{ $item['title'] }}</p>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse" id="dashboard-{{ $key }}-{{ $index }}">
                                    <ul class="nav nav-collapse">
                                        @foreach ($item['subModule'] as $subKey => $sub)
                                            @if (in_array(session('user_role'), (array) $sub['user_role']))
                                                <li>
                                                    @if (Route::has($sub['route']))
                                                        <a href="{{ route($sub['route']) }}">
                                                            <span class="sub-item">{{ $sub['title'] }}</span>
                                                        </a>
                                                    @else
                                                        <span class="sub-item text-danger">Route [{{ $sub['route'] }}]
                                                            not defined</span>
                                                    @endif
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        @endif
                    @endforeach
                @endforeach
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
