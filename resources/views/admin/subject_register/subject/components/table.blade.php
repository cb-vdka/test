<div class="table-responsive">
    <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
        <div class="row">
            <div class="col-sm-12">
                <table id="basic-datatables" class="display table table-striped table-hover dataTable" role="grid">
                    <thead>
                    <tr role="row">
                        <th style="width: 200px;">Chọn môn học</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td>
                                <a class="text-dark" href="{{ route('get.class', $item->id) }}" style="font-size: 14px;">
                                    <i class="fas fa-folder" style="font-size: 20px;"></i> {{ $item->name }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
