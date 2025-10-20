<div class="page-inner">
    @include('admin.dashboard.components.breadcrumb')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title float-left">Danh sách ca học</h4>
            </div>
            <div class="card-body">
                @include('admin.school_shift.school_shift.components.table')
            </div>
        </div>
    </div>
</div>
