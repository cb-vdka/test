<!-- PL HĐTL2 Sub Tabs -->
<ul class="nav nav-pills nav-fill mb-3" id="plHdtl2Tabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="kq-thi-tn-hang-ngay-tab" data-bs-toggle="tab" data-bs-target="#kq-thi-tn-hang-ngay" type="button" role="tab" aria-controls="kq-thi-tn-hang-ngay" aria-selected="true">
            <i class="fas fa-calendar-day"></i> KQ thi TN (hàng ngày)
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="kq-thi-tn-dieu-chinh-tab" data-bs-toggle="tab" data-bs-target="#kq-thi-tn-dieu-chinh" type="button" role="tab" aria-controls="kq-thi-tn-dieu-chinh" aria-selected="false">
            <i class="fas fa-edit"></i> KQ thi TN (Điều chỉnh)
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="kq-tot-nghiep-tab" data-bs-toggle="tab" data-bs-target="#kq-tot-nghiep" type="button" role="tab" aria-controls="kq-tot-nghiep" aria-selected="false">
            <i class="fas fa-graduation-cap"></i> KQ tốt nghiệp
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="ds-hoc-vien-tn-gioi-tab" data-bs-toggle="tab" data-bs-target="#ds-hoc-vien-tn-gioi" type="button" role="tab" aria-controls="ds-hoc-vien-tn-gioi" aria-selected="false">
            <i class="fas fa-star"></i> DS Học Viên TN Giỏi
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="ds-hoc-vien-khen-thuong-tab" data-bs-toggle="tab" data-bs-target="#ds-hoc-vien-khen-thuong" type="button" role="tab" aria-controls="ds-hoc-vien-khen-thuong" aria-selected="false">
            <i class="fas fa-trophy"></i> DS học viên khen thưởng
        </button>
    </li>
</ul>

<!-- PL HĐTL2 Tab Content -->
<div class="tab-content" id="plHdtl2TabsContent">
    <!-- KQ thi TN (hàng ngày) Tab -->
    <div class="tab-pane fade show active" id="kq-thi-tn-hang-ngay" role="tabpanel" aria-labelledby="kq-thi-tn-hang-ngay-tab">
        @include('admin.enrollment_student.enrollment_student.components.pl_hdtl2_table_content', ['fileType' => 'kq_thi_tn_hang_ngay', 'title' => 'KQ thi TN (hàng ngày)'])
    </div>

    <!-- KQ thi TN (Điều chỉnh) Tab -->
    <div class="tab-pane fade" id="kq-thi-tn-dieu-chinh" role="tabpanel" aria-labelledby="kq-thi-tn-dieu-chinh-tab">
        @include('admin.enrollment_student.enrollment_student.components.pl_hdtl2_table_content', ['fileType' => 'kq_thi_tn_dieu_chinh', 'title' => 'KQ thi TN (Điều chỉnh)'])
    </div>

    <!-- KQ tốt nghiệp Tab -->
    <div class="tab-pane fade" id="kq-tot-nghiep" role="tabpanel" aria-labelledby="kq-tot-nghiep-tab">
        @include('admin.enrollment_student.enrollment_student.components.pl_hdtl2_table_content', ['fileType' => 'kq_tot_nghiep', 'title' => 'KQ tốt nghiệp'])
    </div>

    <!-- DS Học Viên TN Giỏi Tab -->
    <div class="tab-pane fade" id="ds-hoc-vien-tn-gioi" role="tabpanel" aria-labelledby="ds-hoc-vien-tn-gioi-tab">
        @include('admin.enrollment_student.enrollment_student.components.pl_hdtl2_table_content', ['fileType' => 'ds_hoc_vien_tn_gioi', 'title' => 'DS Học Viên TN Giỏi'])
    </div>

    <!-- DS học viên khen thưởng Tab -->
    <div class="tab-pane fade" id="ds-hoc-vien-khen-thuong" role="tabpanel" aria-labelledby="ds-hoc-vien-khen-thuong-tab">
        @include('admin.enrollment_student.enrollment_student.components.pl_hdtl2_table_content', ['fileType' => 'ds_hoc_vien_khen_thuong', 'title' => 'DS học viên khen thưởng'])
    </div>
</div>

<!-- Shared Modals for PL HĐTL2 -->
@include('admin.enrollment_student.enrollment_student.components.pl_hdtl2_modals')
