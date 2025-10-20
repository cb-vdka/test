<div class="page-inner">
    @include('admin.dashboard.components.breadcrumb')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title float-left">Danh sách đối tượng đào tạo</h4>

                <div class="action">
                    <a href="{{ route('course.create') }}" class="btn btn-sm btn-success float-right">
                        <i class="fa fa-plus"></i> Thêm đối tượng đào tạo
                    </a>

                    <a href="" class="btn btn-sm btn-primary mr-2">Xuất Excel</a>
                </div>
            </div>
            <div class="card-body">
                @include('admin.course.course.components.table')
            </div>
        </div>
    </div>
</div>
