<div class="page-inner">
    @include('admin.dashboard.components.breadcrumb')

    @php
        $url = $config['method'] == 'create' ? route('class.store') : route('class.update', $getEdit->id);
        $title = $config['method'] == 'create' ? 'Thêm mới lớp học' : 'Chỉnh sửa lớp học';
    @endphp

    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title float-left">{{ $title }}</h4>
                <a href="{{ route('class.index') }}" class="btn btn-sm btn-primary">Quay lại danh sách</a>
            </div>
            <div class="card-body">
                <form action="{{ $url }}" method="POST" autocomplete="on">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            @include('admin.class.class.components.general')
                        </div>
                        {{-- <div class="col-lg-3">
                            @include('admin.class.class.components.aside')

                        </div> --}}
                        <div class="text-right">
                            <button type="submit" class="btn btn-success mb10 button-fix" name="send"
                                value="send">Lưu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
