<div class="page-inner">
    @include('admin.dashboard.components.breadcrumb')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title float-left">Danh sách địa điểm học</h4>
            </div>
            <div class="card-body">
                @include('admin.classroom.classroom.components.table')
            </div>
        </div>
    </div>
</div>