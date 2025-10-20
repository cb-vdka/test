<div class="row mb-4">
    <div class="col-sm-12">
        <!-- Bộ lọc -->
        <form method="GET" action="{{ route('school_shift.index') }}" class="row g-3 align-items-center">
            <div class="col-md-3">
                <select class="form-select setupSelect2" name="status">
                    <option value="">Tất cả trạng thái</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Không hoạt động</option>
                </select>
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control" name="search" placeholder="Tìm kiếm theo tên, mã ca học..." value="{{ request('search') }}">
            </div>

            <div class="col-md-3 d-flex">
                <div>
                    <button type="submit" class="btn btn-primary btn-sm me-2">Lọc</button>
                    <a href="{{ route('school_shift.index') }}" class="btn btn-secondary btn-sm me-2">Bỏ lọc</a>
                </div>
                <div>
                    <a href="{{ route('school_shift.create') }}" class="btn btn-sm btn-success">
                        <i class="fa fa-plus"></i> Thêm ca học
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
