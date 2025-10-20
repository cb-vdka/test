<div class="page-inner">
    @include('admin.dashboard.components.breadcrumb')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title float-left">Danh sách khoa</h4>

                <div class="action">
                    <a href="{{ route('faculty.create') }}" class="btn btn-sm btn-success float-right">
                        <i class="fa fa-plus"></i> Thêm khoa
                    </a>

                </div>
            </div>
            <div class="card-body">
                @include('admin.faculty.faculty.components.table')

            </div>
        </div>
    </div>
</div>
