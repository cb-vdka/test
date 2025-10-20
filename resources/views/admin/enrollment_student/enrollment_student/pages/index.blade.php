<style>
/* Tab Navigation Styling */
.nav-tabs.nav-fill {
    border-bottom: 2px solid #e9ecef;
}

.nav-tabs .nav-link {
    border: none;
    border-radius: 0;
    font-weight: 500;
    transition: all 0.3s ease;
    position: relative;
}

.nav-tabs .nav-link:hover {
    background-color: #f8f9fa;
    color: #495057;
}

.nav-tabs .nav-link.active {
    background-color: #fff;
    color: #495057;
    border-bottom: 3px solid #007bff;
    font-weight: 600;
}

.nav-tabs .nav-link.active::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 0;
    border-left: 8px solid transparent;
    border-right: 8px solid transparent;
    border-top: 8px solid #007bff;
}

/* Score Sheets Table Spacing */
#score-sheets .card {
    margin-top: 1rem;
    border-radius: 8px;
}

#score-sheets .card-header {
    border-radius: 8px 8px 0 0;
}

#score-sheets .table {
    margin-bottom: 0;
}

#score-sheets .card-footer {
    border-radius: 0 0 8px 8px;
}
</style>

<div class="page-inner">
    @include('admin.dashboard.components.breadcrumb')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title float-left">Bảng Điểm</h4>
            </div>
            <div class="card-body">
                <!-- Tab Navigation -->
                <div class="bg-light border-bottom">
                    <ul class="nav nav-tabs nav-fill" id="mainTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active px-4 py-3" id="score-sheets-tab" data-bs-toggle="tab" data-bs-target="#score-sheets" type="button" role="tab" aria-controls="score-sheets" aria-selected="true">
                                <i class="fas fa-file-alt me-2"></i>Phiếu điểm
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link px-4 py-3" id="pl-hdtl1-tab" data-bs-toggle="tab" data-bs-target="#pl-hdtl1" type="button" role="tab" aria-controls="pl-hdtl1" aria-selected="false">
                                <i class="fas fa-clipboard-list me-2"></i>PL HĐTL1
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link px-4 py-3" id="pl-hdtl2-tab" data-bs-toggle="tab" data-bs-target="#pl-hdtl2" type="button" role="tab" aria-controls="pl-hdtl2" aria-selected="false">
                                <i class="fas fa-clipboard-check me-2"></i>PL HĐTL2
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Tab Content -->
                <div class="tab-content" id="mainTabsContent">
                    <!-- Tab Phiếu điểm -->
                    <div class="tab-pane fade show active" id="score-sheets" role="tabpanel" aria-labelledby="score-sheets-tab">
                        <div class="mt-4">
                            @include('admin.enrollment_student.enrollment_student.components.score_sheets_table')
                        </div>
                    </div>

                    <!-- Tab PL HĐTL1 -->
                    <div class="tab-pane fade" id="pl-hdtl1" role="tabpanel" aria-labelledby="pl-hdtl1-tab">
                        <div class="mt-3">
                            @include('admin.enrollment_student.enrollment_student.components.pl_hdtl1_tabs')
                        </div>
                    </div>

                    <!-- Tab PL HĐTL2 -->
                    <div class="tab-pane fade" id="pl-hdtl2" role="tabpanel" aria-labelledby="pl-hdtl2-tab">
                        <div class="mt-3">
                            @include('admin.enrollment_student.enrollment_student.components.pl_hdtl2_tabs')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
