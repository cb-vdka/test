<div class="table-responsive">
    <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
        <div class="row">
            <div class="col-sm-12">
                <table id="basic-datatables" class="display table table-striped dataTable" role="grid">
                    <thead>
                    <tr role="row">
                        <th style="width: 200px;">Tên lớp học</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $item)
                        <tr role="row" class="odd d-flex justify-content-between">
                            <td class="sorting_1">
                                <i class="fas fa-folder" style="font-size: 20px;"></i>

                                <span>{{ $item->class->name . ' - ' . $item->subject->name . ' - ' . $item->teacher->name }}</span>
                            </td>
                            <td>
                                @if($item->is_joined)
                                    <button class="badge badge-secondary" disabled>Đã tham gia</button>
                                @else
                                    <form action="{{ route('insert.class') }}" method="POST" class="join-form">
                                        @csrf
                                        <input type="hidden" name="student_id" value="{{ session('user_id') }}">
                                        <input type="hidden" name="class_id" value="{{ $item->id  }}">
                                        <button type="submit" class="badge badge-success join-button">Tham gia</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
