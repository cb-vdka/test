<div class="page-inner">
    @include('admin.dashboard.components.breadcrumb')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title float-left">Danh sách lịch huấn luyện</h4>


                <div class="action">
                    <a href="{{ route('schedule.create') }}" class="btn btn-sm btn-success mr-2">
                        <i class="fa fa-plus"></i> Thêm lịch huấn luyện
                    </a>
                    <a href="{{ route('schedule.export') }}" class="btn btn-sm btn-primary">
                        <i class="fa fa-file-excel"></i> Xuất Excel
                    </a>
                </div>
            </div>
            <div class="card-body">
                @include('admin.schedule.schedule.components.calendar')
            </div>
        </div>
    </div>
</div>
