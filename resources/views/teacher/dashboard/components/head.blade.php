<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>Trường Quân Sự Quân Khu 2 - Giáo viên</title>
<meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" href="{{ asset('default/logo/logo.png') }}" type="image/x-icon" />

<!-- Fonts and icons -->
<script src="{{ asset('admin') }}/js/plugin/webfont/webfont.min.js"></script>
<script>
    WebFont.load({
        google: {
            families: ["Public Sans:300,400,500,600,700"]
        },
        custom: {
            families: [
                "Font Awesome 5 Solid",
                "Font Awesome 5 Regular",
                "Font Awesome 5 Brands",
                "simple-line-icons",
            ],
            urls: ["{{ asset('admin') }}/css/fonts.min.css"],
        },
        active: function() {
            sessionStorage.fonts = true;
        },
    });
</script>

<!-- CSS Files -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="{{ asset('admin') }}/css/bootstrap.min.css" />
<link rel="stylesheet" href="{{ asset('admin') }}/css/plugins.min.css" />
<link rel="stylesheet" href="{{ asset('admin') }}/css/kaiadmin.min.css" />
<link href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css" rel="stylesheet" />
<!-- Custom Pagination CSS -->
<link rel="stylesheet" href="{{ asset('css/pagination.css') }}" />
<!-- Custom Toastr CSS -->
<style>
    .toast-top-right {
        top: 20px !important;
        right: 20px !important;
        z-index: 9999 !important;
    }
    .toast-top-center {
        top: 20px !important;
        left: 50% !important;
        transform: translateX(-50%) !important;
        z-index: 9999 !important;
    }
    .toast-top-left {
        top: 20px !important;
        left: 20px !important;
        z-index: 9999 !important;
    }
    .toast-bottom-right {
        bottom: 20px !important;
        right: 20px !important;
        z-index: 9999 !important;
    }
    .toast-bottom-center {
        bottom: 20px !important;
        left: 50% !important;
        transform: translateX(-50%) !important;
        z-index: 9999 !important;
    }
    .toast-bottom-left {
        bottom: 20px !important;
        left: 20px !important;
        z-index: 9999 !important;
    }
    /* Đảm bảo toast hiển thị trên tất cả elements */
    #toast-container {
        z-index: 9999 !important;
    }
    #toast-container > div {
        z-index: 9999 !important;
        position: relative !important;
    }
</style>
<!-- CSS Just for demo purpose, don't include it in your project -->
<link rel="stylesheet" href="{{ asset('admin') }}/css/demo.css" />
<!-- Custom CSS for admin panel styling -->
<link rel="stylesheet" href="{{ asset('admin/css/custom.css') }}">
@if (isset($config['css']) && is_array($config['css']))
    @foreach ($config['css'] as $key => $value)
        {!! '<link rel="stylesheet" href="' . $value . '">' !!}
    @endforeach
@endif

<script>
    var BASE_URL = "{{ config('app.url') }}";
    var SUFFIX = "{{ config('apps.general.suffix') }}";
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
