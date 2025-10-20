<div class="page-inner">
    @include('teacher.dashboard.components.breadcrumb')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title float-left">Bảng Điểm</h4>
            </div>
            <div class="card-body">
                @if(!empty($selectedClassId) && ($scoreSheets->isEmpty() && $plHdtl1Files->isEmpty() && $plHdtl2Files->isEmpty()))
                    <div class="alert alert-info mb-3">
                        Không có dữ liệu cho lớp đã chọn. Giao diện vẫn giữ nguyên như bên admin.
                    </div>
                @endif
                <div class="bg-light border-bottom">
                    <ul class="nav nav-tabs nav-fill" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active px-4 py-3" data-bs-toggle="tab" data-bs-target="#score-sheets" type="button" role="tab" aria-selected="true">
                                <i class="fas fa-file-alt me-2"></i>Phiếu điểm
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link px-4 py-3" data-bs-toggle="tab" data-bs-target="#pl-hdtl1" type="button" role="tab" aria-selected="false">
                                <i class="fas fa-clipboard-list me-2"></i>PL HĐTL1
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link px-4 py-3" data-bs-toggle="tab" data-bs-target="#pl-hdtl2" type="button" role="tab" aria-selected="false">
                                <i class="fas fa-clipboard-check me-2"></i>PL HĐTL2
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="score-sheets" role="tabpanel">
                        @include('teacher.enrollment_student.components.score_sheets_table')
                    </div>
                    <div class="tab-pane fade" id="pl-hdtl1" role="tabpanel">
                        <div class="mt-3">
                            @include('teacher.enrollment_student.components.pl_hdtl1_tabs')
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pl-hdtl2" role="tabpanel">
                        <div class="mt-3">
                            @include('teacher.enrollment_student.components.pl_hdtl2_tabs')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


