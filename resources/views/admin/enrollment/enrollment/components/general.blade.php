<style>
    .stage-section {
        border: 1px solid #e0e6ed;
        border-radius: 12px;
        margin-bottom: 25px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        background: white;
    }
    .stage-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 18px 25px;
        font-weight: 600;
        font-size: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .stage-header.bang-diem {
        background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
    }
    .stage-header.giai-doan-1 {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    .stage-header.giai-doan-2 {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }
    .stage-body {
        padding: 25px;
        background-color: #fafbfc;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
        display: block;
        font-size: 14px;
    }
    .form-control {
        border: 1px solid #d1d5db;
        border-radius: 8px;
        padding: 12px 15px;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    .upload-section {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border: 2px dashed #cbd5e0;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }
    .upload-section:hover {
        border-color: #667eea;
        background: linear-gradient(135deg, #f0f4ff 0%, #e6f0ff 100%);
    }
    .upload-section h6 {
        color: #4a5568;
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 14px;
    }
    .upload-section p {
        color: #718096;
        font-size: 13px;
        margin-bottom: 15px;
    }
    .upload-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
        font-size: 13px;
    }
    .upload-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }
    .upload-btn:disabled {
        background: #cbd5e0;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }
    .alert {
        border-radius: 10px;
        border: none;
        padding: 15px 20px;
    }
    .alert-info {
        background: linear-gradient(135deg, #e6f3ff 0%, #cce7ff 100%);
        color: #1e40af;
        border-left: 4px solid #3b82f6;
    }
    .alert-warning {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
        border-left: 4px solid #f59e0b;
    }
    .result-display {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 12px 15px;
        font-weight: 500;
    }
    .text-success { color: #059669 !important; }
    .text-danger { color: #dc2626 !important; }
    .text-info { color: #0891b2 !important; }
    .text-muted { color: #6b7280 !important; }
    
    /* Modal enhancements */
    .modal .close:hover {
        opacity: 1 !important;
    }
    .modal .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    .modal .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    /* Responsive improvements */
    @media (max-width: 768px) {
        .stage-body {
            padding: 20px 15px;
        }
        .upload-section {
            padding: 15px;
        }
        .modal-content {
            width: 95% !important;
            margin: 5% auto !important;
        }
    }
</style>

        @if(isset($getEdit) && $getEdit->student)
            <div class="alert alert-info">
                <strong>Thông tin sinh viên:</strong><br>
                <strong>Tên:</strong> {{ $getEdit->student->name }}<br>
                <strong>MSSV:</strong> {{ $getEdit->student->student_code }}<br>
                <strong>Lớp:</strong> {{ $getEdit->classSubject->class->name ?? 'N/A' }} - {{ $getEdit->classSubject->subject->name ?? 'N/A' }}
            </div>
        @endif
        
<!-- Phần Bảng Điểm -->
<div class="stage-section">
    <div class="stage-header bang-diem">
        📊 Phần Bảng Điểm
    </div>
    <div class="stage-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="assignment_1">L1 (Lab 1)</label>
                    <input type="number" class="form-control" id="assignment_1" name="assignment_1" 
                           min="0" max="10" step="0.1"
                           value="{{ isset($getEdit) ? $getEdit->assignment_1 : old('assignment_1') }}">
                </div>
                <div class="form-group">
                    <label for="lab_3">L2 (Lab 2)</label>
                    <input type="number" class="form-control" id="lab_3" name="lab_3" 
                           min="0" max="10" step="0.1"
                           value="{{ isset($getEdit) ? $getEdit->lab_3 : old('lab_3') }}">
                </div>
                <div class="form-group">
                    <label for="lab_4">L3 (Lab 3)</label>
                    <input type="number" class="form-control" id="lab_4" name="lab_4" 
                           min="0" max="10" step="0.1"
                           value="{{ isset($getEdit) ? $getEdit->lab_4 : old('lab_4') }}">
                </div>
            </div>
            <div class="col-md-6">
        <div class="form-group">
                    <label for="assignment_2">L4 (Lab 4)</label>
                    <input type="number" class="form-control" id="assignment_2" name="assignment_2" 
                           min="0" max="10" step="0.1"
                           value="{{ isset($getEdit) ? $getEdit->assignment_2 : old('assignment_2') }}">
        </div>
        <div class="form-group">
                    <label for="final_exam">ASM (Assignment)</label>
                    <input type="number" class="form-control" id="final_exam" name="final_exam" 
                           min="0" max="10" step="0.1"
                           value="{{ isset($getEdit) ? $getEdit->final_exam : old('final_exam') }}">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Kết quả tính toán -->
<div class="stage-section">
    <div class="stage-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        📊 Kết quả tính toán
    </div>
    <div class="stage-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>GPA (Điểm trung bình)</label>
                    <div class="result-display">
                        <strong>GPA: </strong>
                        <span id="gpa-display">
                            @php
                                $gpa = !empty($getEdit->final_exam)
                                 ? number_format(
                                     ($getEdit->assignment_1 +
                                         $getEdit->lab_3 +
                                         $getEdit->lab_4 +
                                         $getEdit->assignment_2 +
                                         $getEdit->final_exam) / 5,
                                     1,
                                     ',',
                                     '.',
                                 )
                                 : 'Chưa có điểm';
                            @endphp
                            {{ $gpa }}
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label>Kết quả học tập</label>
                    <div class="result-display">
                        <span id="ket-qua-thi">
                            @if($gpa === 'Chưa có điểm')
                                <span class="text-info">Chưa có điểm</span>
                            @elseif($gpa < 5)
                                <span class="text-danger">Không đạt</span>
                            @elseif($gpa >= 5)
                                <span class="text-success">Đạt</span>
                            @else
                                <span class="text-info">Chưa có điểm</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
        <div class="form-group">
                    <label>Xếp loại</label>
                    <div class="result-display">
                        <span id="xep-loai">
                            @if($gpa === 'Chưa có điểm')
                                <span class="text-info">Chưa xét</span>
                            @elseif($gpa < 5)
                                <span class="text-danger">Yếu</span>
                            @elseif($gpa < 6.5)
                                <span class="text-warning">Trung bình</span>
                            @elseif($gpa < 8)
                                <span class="text-primary">Khá</span>
                            @else
                                <span class="text-success">Giỏi</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto calculate GPA when inputs change
function calculateGPA() {
    const assignment1 = parseFloat(document.getElementById('assignment_1').value) || 0;
    const lab3 = parseFloat(document.getElementById('lab_3').value) || 0;
    const lab4 = parseFloat(document.getElementById('lab_4').value) || 0;
    const assignment2 = parseFloat(document.getElementById('assignment_2').value) || 0;
    const finalExam = parseFloat(document.getElementById('final_exam').value) || 0;
    
    const gpa = (assignment1 + lab3 + lab4 + assignment2 + finalExam) / 5;
    
    document.getElementById('gpa-display').textContent = gpa.toFixed(1);
    
    // Update results
    const ketQuaThi = document.getElementById('ket-qua-thi');
    const xepLoai = document.getElementById('xep-loai');
    
    if (finalExam === 0) {
        ketQuaThi.innerHTML = '<span class="text-info">Chưa có điểm</span>';
        xepLoai.innerHTML = '<span class="text-info">Chưa xét</span>';
    } else if (gpa < 5) {
        ketQuaThi.innerHTML = '<span class="text-danger">Không đạt</span>';
        xepLoai.innerHTML = '<span class="text-danger">Yếu</span>';
    } else if (gpa < 6.5) {
        ketQuaThi.innerHTML = '<span class="text-success">Đạt</span>';
        xepLoai.innerHTML = '<span class="text-warning">Trung bình</span>';
    } else if (gpa < 8) {
        ketQuaThi.innerHTML = '<span class="text-success">Đạt</span>';
        xepLoai.innerHTML = '<span class="text-primary">Khá</span>';
    } else {
        ketQuaThi.innerHTML = '<span class="text-success">Đạt</span>';
        xepLoai.innerHTML = '<span class="text-success">Giỏi</span>';
    }
}

// Add event listeners to all input fields
document.addEventListener('DOMContentLoaded', function() {
    const inputs = ['assignment_1', 'lab_3', 'lab_4', 'assignment_2', 'final_exam'];
    inputs.forEach(id => {
        document.getElementById(id).addEventListener('input', calculateGPA);
    });
});


</script>
