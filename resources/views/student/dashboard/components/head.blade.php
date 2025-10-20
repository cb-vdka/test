<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>Trường Quân Sự Quân Khu 2</title>
<meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
<link rel="icon" href="{{ asset('admin') }}/img/banner_home/logo_web.jpg" type="image/x-icon" />

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
<link rel="stylesheet" href="{{ asset('admin') }}/css/bootstrap.min.css" />
<link rel="stylesheet" href="{{ asset('admin') }}/css/plugins.min.css" />
<link rel="stylesheet" href="{{ asset('admin') }}/css/kaiadmin.min.css" />

<!-- CSS Just for demo purpose, don't include it in your project -->
<link rel="stylesheet" href="{{ asset('admin') }}/css/demo.css" />

@if (isset($config['css']) && is_array($config['css']))
    @foreach ($config['css'] as $key => $value)
        {!! '<link rel="stylesheet" href="' . $value . '">' !!}
    @endforeach
@endif

<script>
    var BASE_URL = '{{ config('app.url') }}'
    var SUFFIX = '{{ config('apps.general.suffix') }}'
</script>
