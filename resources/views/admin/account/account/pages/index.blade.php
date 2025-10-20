<div class="page-inner">
    @include('admin.dashboard.components.breadcrumb')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title float-left">Danh sách thành viên</h4>

                <div class="action">
                    <a href="{{ route('account.create') }}" class="btn btn-sm btn-success float-right">
                        <i class="fa fa-plus"></i> Thêm thành viên
                    </a>

                    <a href="{{ route('account.export') }}" class="btn btn-sm btn-primary me-2">
                        <i class="fa fa-file-excel"></i> Xuất Excel
                    </a>
                </div>
            </div>
            <div class="card-body">
                @include('admin.account.account.components.table')
            </div>
        </div>
    </div>
</div>
<script>
    function handleRedirect(select) {
        const value = select.value;
        if (value) {
            window.location.href = value;
        }
    }
</script>
