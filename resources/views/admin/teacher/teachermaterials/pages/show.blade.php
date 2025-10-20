<div class="page-inner">
    @include('admin.dashboard.components.breadcrumb')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title float-left">{{ $teachingMaterial->title }}</h4>
                <div class="action">
                    <a href="{{ route('materials.index') }}" class="btn btn-sm btn-primary">Quay lại danh sách</a>
                </div>
            </div>
            <div class="card-body">
                <p></p>
                <a href="{{ $teachingMaterial->file_path }}" class="btn btn-info" target="_blank">Xem tài liệu</a>
            </div>
        </div>
    </div>
</div>