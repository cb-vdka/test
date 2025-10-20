<!DOCTYPE html>
<html lang="vi">
<head>
  @include('components.head') {{-- tạo file components/head.blade.php nếu chưa có --}}
  @livewireStyles
</head>
<body>
  <div class="wrapper d-flex">
    @include('components.sidebar')
    <div class="main-panel flex-grow-1">
      @include('components.header')
      <main class="content p-4">
        @if(isset($breadcrumbs))
          @include('components.breadcrumb', ['items' => $breadcrumbs])
        @endif
        @yield('content')
      </main>
      @include('components.footer')
    </div>
  </div>

  @livewireScripts
  @include('components.scripts')
</body>
</html>
