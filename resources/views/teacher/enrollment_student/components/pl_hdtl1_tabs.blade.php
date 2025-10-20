<!-- PL HĐTL1 Sub Tabs (Teacher) -->
<ul class="nav nav-pills nav-fill mb-3" id="plHdtl1Tabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="kqhttx-tab" data-bs-toggle="tab" data-bs-target="#kqhttx" type="button" role="tab" aria-controls="kqhttx" aria-selected="true">
            <i class="fas fa-chart-line"></i> KQHTTX
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="kqrl-tab" data-bs-toggle="tab" data-bs-target="#kqrl" type="button" role="tab" aria-controls="kqrl" aria-selected="false">
            <i class="fas fa-star"></i> KQRL
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="ngay-cong-tab" data-bs-toggle="tab" data-bs-target="#ngay-cong" type="button" role="tab" aria-controls="ngay-cong" aria-selected="false">
            <i class="fas fa-calendar-check"></i> Ngày công học tập
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="dieu-chinh-tab" data-bs-toggle="tab" data-bs-target="#dieu-chinh" type="button" role="tab" aria-controls="dieu-chinh" aria-selected="false">
            <i class="fas fa-edit"></i> Điều chỉnh
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="ren-luyen-kha-tab" data-bs-toggle="tab" data-bs-target="#ren-luyen-kha" type="button" role="tab" aria-controls="ren-luyen-kha" aria-selected="false">
            <i class="fas fa-medal"></i> Học viên rèn luyện khá
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="hoc-gioi-tab" data-bs-toggle="tab" data-bs-target="#hoc-gioi" type="button" role="tab" aria-controls="hoc-gioi" aria-selected="false">
            <i class="fas fa-trophy"></i> Danh sách học viên học giỏi
        </button>
    </li>
</ul>

<!-- PL HĐTL1 Tab Content (Teacher) -->
<div class="tab-content" id="plHdtl1TabsContent">
    <div class="tab-pane fade show active" id="kqhttx" role="tabpanel" aria-labelledby="kqhttx-tab">
        <div id="plHdtl1TableContainer">
            @include('teacher.enrollment_student.components.pl_hdtl1_table_content', ['fileType' => 'kqhttx', 'title' => 'KQHTTX'])
        </div>
    </div>
    <div class="tab-pane fade" id="kqrl" role="tabpanel" aria-labelledby="kqrl-tab">
        <div id="plHdtl1TableContainer">
            @include('teacher.enrollment_student.components.pl_hdtl1_table_content', ['fileType' => 'kqrl', 'title' => 'KQRL'])
        </div>
    </div>
    <div class="tab-pane fade" id="ngay-cong" role="tabpanel" aria-labelledby="ngay-cong-tab">
        <div id="plHdtl1TableContainer">
            @include('teacher.enrollment_student.components.pl_hdtl1_table_content', ['fileType' => 'ngay_cong', 'title' => 'Ngày công học tập'])
        </div>
    </div>
    <div class="tab-pane fade" id="dieu-chinh" role="tabpanel" aria-labelledby="dieu-chinh-tab">
        <div id="plHdtl1TableContainer">
            @include('teacher.enrollment_student.components.pl_hdtl1_table_content', ['fileType' => 'dieu_chinh', 'title' => 'Điều chỉnh'])
        </div>
    </div>
    <div class="tab-pane fade" id="ren-luyen-kha" role="tabpanel" aria-labelledby="ren-luyen-kha-tab">
        <div id="plHdtl1TableContainer">
            @include('teacher.enrollment_student.components.pl_hdtl1_table_content', ['fileType' => 'ren_luyen_kha', 'title' => 'Học viên rèn luyện khá'])
        </div>
    </div>
    <div class="tab-pane fade" id="hoc-gioi" role="tabpanel" aria-labelledby="hoc-gioi-tab">
        <div id="plHdtl1TableContainer">
            @include('teacher.enrollment_student.components.pl_hdtl1_table_content', ['fileType' => 'hoc_gioi', 'title' => 'Danh sách học viên học giỏi'])
        </div>
    </div>
</div>

@include('teacher.enrollment_student.components.pl_hdtl1_modals')


