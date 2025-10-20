<div class="page-inner">
    @include('admin.dashboard.components.breadcrumb')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title float-left">Tài liệu cán bộ</h4>
                <div class="action">
                    @if (session('user_role') == 1)
                        <a href="{{ route('teacher.create-materials') }}" class="btn btn-primary">Tải lên tài liệu mới</a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <form action="{{ route('materials.index') }}" method="GET" id="filter-form">
                                    <div class="form-group">
                                        <label for="course_id">Khóa Học</label>
                                        <select name="course_id" id="course_id" class="form-control"
                                            onchange="document.getElementById('filter-form').submit();">
                                            <option value="">Tất cả</option>
                                            @foreach ($courses as $course)
                                                <option value="{{ $course->id }}"
                                                    {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                                    {{ $course->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="dataTables_length" id="basic-datatables_length">
                                    <!-- Optional: Can be used to set page length if needed -->
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-sm-12">
                                <table id="basic-datatables" class="display table table-striped table-hover dataTable"
                                    role="grid" aria-describedby="basic-datatables_info">
                                    <thead>
                                        <tr role="row">
                                            <th>Tiêu đề</th>
                                            <th>Mô tả</th>
                                            <th>Cán Bộ</th>
                                            <th>Khóa Học</th> <!-- Add a column for Course -->
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($materials as $material)
                                            <tr>
                                                <td>{{ $material->title }}</td>
                                                <td>{{ $material->description }}</td>
                                                <td>{{ $material->officer->name }}</td>
                                                <!-- Use officer instead of teacher -->
                                                <td>{{ $material->course->name }}</td> <!-- Display the course name -->
                                                <td class="d-flex gap-2">
                                                    <a href="{{ route('materials.show', $material->id) }}"
                                                        class="btn btn-info">Xem</a>
                                                    @if (session('user_role') == 1)
                                                        <a href="{{ route('materials.edit', $material->id) }}"
                                                            class="btn btn-warning">Sửa</a>
                                                        <form
                                                            action="{{ route('teacher.materials.destroy', $material->id) }}"
                                                            method="POST" style="display:inline-block;"
                                                            onsubmit="return confirmDelete()">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Xóa</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="basic-datatables_paginate">
                                    <ul class="pagination"></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
