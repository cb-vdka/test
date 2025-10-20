    <!--   Core JS Files   -->
    <script src="{{ asset('admin') }}/js/core/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('admin') }}/js/core/popper.min.js"></script>
    <script src="{{ asset('admin') }}/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('admin') }}/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="{{ asset('admin') }}/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="{{ asset('admin') }}/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="{{ asset('admin') }}/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="{{ asset('admin') }}/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    {{-- <script src="{{ asset('admin') }}/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script> --}}

    <!-- jQuery Vector Maps -->
    <script src="{{ asset('admin') }}/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="{{ asset('admin') }}/js/plugin/jsvectormap/world.js"></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('admin') }}/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- Kaiadmin JS -->
    <script src="{{ asset('admin') }}/js/kaiadmin.min.js"></script>

    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="{{ asset('admin') }}/js/setting-demo.js"></script>
    <script src="{{ asset('admin') }}/js/demo.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.js"></script>
    <script src="{{ asset('admin') }}/js/core/lic.js"></script>
    
    <!-- Toastr Configuration -->
    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        
        // Hiển thị thông báo từ session
        @if(session('toastr'))
            @php
                $toastr = session('toastr');
            @endphp
            toastr.{{ $toastr['type'] }}('{{ $toastr['message'] }}');
        @endif
        
        // Hiển thị thông báo từ with()
        @if(session('success'))
            toastr.success('{{ session('success') }}');
        @endif
        
        @if(session('error'))
            toastr.error('{{ session('error') }}');
        @endif
        
        @if(session('warning'))
            toastr.warning('{{ session('warning') }}');
        @endif
        
        @if(session('info'))
            toastr.info('{{ session('info') }}');
        @endif
    </script>
    <script>
        $(document).ready(function() {
            $('.setupSelect2').select2({
                width: 'resolve' // Đảm bảo Select2 sử dụng chiều rộng của thẻ cha
            });
        });
    </script>
    <script>
        $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#177dff",
            fillColor: "rgba(23, 125, 255, 0.14)",
        });

        $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#f3545d",
            fillColor: "rgba(243, 84, 93, .14)",
        });

        $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#ffa534",
            fillColor: "rgba(255, 165, 52, .14)",
        });
    </script>

    {{-- Dùng để lặp các link js được config ở bên controller --}}
    @if (isset($config['js']) && is_array($config['js']))
        @foreach ($config['js'] as $key => $value)
            {!! '<script src="' . $value . '"></script>' !!}
        @endforeach
    @endif
