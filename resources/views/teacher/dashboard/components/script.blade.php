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

<!-- Sweet Alert -->
<script src="{{ asset('admin') }}/js/plugin/sweetalert/sweetalert.min.js"></script>

<!-- jQuery Vector Maps -->
<script src="{{ asset('admin') }}/js/plugin/jsvectormap/jsvectormap.min.js"></script>
<script src="{{ asset('admin') }}/js/plugin/jsvectormap/world.js"></script>

<!-- jQuery TouchSwipe -->
<script src="{{ asset('admin') }}/js/plugin/jquery.touchSwipe/jquery.touchSwipe.min.js"></script>

<!-- jQuery UI -->
<script src="{{ asset('admin') }}/js/plugin/jquery-ui/jquery-ui.min.js"></script>

<!-- Moment JS -->
<script src="{{ asset('admin') }}/js/plugin/moment/moment.min.js"></script>

<!-- DateTimePicker -->
<script src="{{ asset('admin') }}/js/plugin/datepicker/bootstrap-datetimepicker.min.js"></script>

<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Toastr -->
<script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.js"></script>

<!-- Kaiadmin JS -->
<script src="{{ asset('admin') }}/js/kaiadmin.min.js"></script>

<!-- Custom JS -->
<script src="{{ asset('admin') }}/js/demo.js"></script>

<!-- Custom Pagination JS -->
<script src="{{ asset('js/pagination.js') }}"></script>

@if (isset($config['js']) && is_array($config['js']))
    @foreach ($config['js'] as $key => $value)
        {!! '<script src="' . $value . '"></script>' !!}
    @endforeach
@endif

<script>
    // Toastr configuration
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
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

    // CSRF token setup for AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
