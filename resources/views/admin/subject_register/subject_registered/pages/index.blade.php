<div class="page-inner">
    @include('admin.dashboard.components.breadcrumb')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title float-left">Môn học đã đăng ký</h4>
            </div>

            <div class="card-body" style="padding: 0px !important;">
                @include('admin.subject_register.subject_registered.components.table')
            </div>
        </div>
    </div>
</div>
