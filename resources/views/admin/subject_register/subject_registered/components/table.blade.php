<div class="registered-subjects-wrapper">
    <div class="row">
        <div class="col-sm-12">
            <ul id="registered-subjects" class="list-group">
                @forelse ($enrollments as $enrollment)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="subject-info">
                            <h5 class="mb-1">{{ $enrollment->class->subject->name }}</h5>
                            <small>Giảng viên: {{ $enrollment->class->teacher->name }}</small><br>
                            <small>Lớp học: {{ $enrollment->class->name }}</small><br>
                            <small>Ngày đăng ký: {{ \Carbon\Carbon::parse($enrollment->created_at)->format('Y-m-d') }}</small>
                        </div>
                        <div class="subject-actions">
                            <button class="btn btn-sm btn-info"
                                    title="Chi tiết"
                                    data-bs-toggle="modal"
                                    data-bs-target="#courseModal"
                                    data-subject="{{ $enrollment->class->subject->name }}"
                                    data-teacher="{{ $enrollment->class->teacher->name }}"
                                    data-class="{{ $enrollment->class->name }}"
                                    data-registration-date="{{ \Carbon\Carbon::parse($enrollment->created_at)->format('Y-m-d') }}"
                                    data-credits="{{ $enrollment->class->subject->credit_num }}"
                                    data-schedule="Thứ 2, Thứ 4, Thứ 6 - 9:00AM - 11:00AM">
                                <i class="fa fa-info-circle"></i>
                            </button>
                            <form action="{{ route('show_subject_register.destroy', $enrollment->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-warning" title="Hủy đăng ký" onclick="return confirm('Bạn có chắc chắn muốn hủy đăng ký môn học này?');">
                                    <i class="fa fa-ban"></i>
                                </button>
                            </form>
                        </div>
                    </li>
                @empty
                    <div class="alert alert-warning" role="alert">
                        Không tìm thấy dữ liệu.
                    </div>
                @endforelse
            </ul>
        </div>
    </div>
</div>

<!-- Modal Structure -->
<div class="modal fade" id="courseModal" tabindex="-1" aria-labelledby="courseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="courseModalLabel">Thông tin chi tiết môn học</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Giảng viên:</strong> <span id="modal-teacher"></span></p>
                        <p><strong>Lớp học:</strong> <span id="modal-class"></span></p>
                        <p><strong>Ngày đăng ký:</strong> <span id="modal-registration-date"></span></p>
                        <p><strong>Số tín chỉ:</strong> <span id="modal-credits"></span></p>
                        <p><strong>Lịch huấn luyện:</strong> <span id="modal-schedule"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Mô tả:</strong></p>
                        <p id="modal-description"></p>
                        <p><strong>Yêu cầu:</strong></p>
                        <p id="modal-requirements"></p>
                        <p><strong>Tài liệu học tập:</strong></p>
                        <ul id="modal-materials"></ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<style>
    .registered-subjects-wrapper {
        margin-top: 20px;
    }
    .list-group-item {
        border: 1px solid #ddd;
        margin-bottom: 10px;
        border-radius: 8px;
        padding: 20px;
        background-color: #f9f9f9;
        transition: all 0.3s ease;
    }
    .list-group-item:hover {
        background-color: #f1f1f1;
    }
    .subject-info h5 {
        font-size: 16px;
        margin-bottom: 10px;
    }
    .subject-info small {
        color: #666;
    }
    .subject-actions {
        display: flex;
        gap: 10px;
    }
    .btn-info {
        background-color: #17a2b8;
        color: white;
        border: none;
    }
    .btn-info:hover {
        background-color: #138496;
    }
    .btn-warning {
        background-color: #ffc107;
        color: white;
        border: none;
    }
    .btn-warning:hover {
        background-color: #e0a800;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var courseModal = document.getElementById('courseModal');
        courseModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var subject = button.getAttribute('data-subject');
            var teacher = button.getAttribute('data-teacher');
            var className = button.getAttribute('data-class');
            var registrationDate = button.getAttribute('data-registration-date');
            var credits = button.getAttribute('data-credits');
            var schedule = button.getAttribute('data-schedule');
            var description = button.getAttribute('data-description');
            var requirements = button.getAttribute('data-requirements');
            var materials = button.getAttribute('data-materials');

            var modalTitle = courseModal.querySelector('.modal-title');
            var modalTeacher = courseModal.querySelector('#modal-teacher');
            var modalClass = courseModal.querySelector('#modal-class');
            var modalRegistrationDate = courseModal.querySelector('#modal-registration-date');
            var modalCredits = courseModal.querySelector('#modal-credits');
            var modalSchedule = courseModal.querySelector('#modal-schedule');
            var modalDescription = courseModal.querySelector('#modal-description');
            var modalRequirements = courseModal.querySelector('#modal-requirements');
            var modalMaterials = courseModal.querySelector('#modal-materials');

            modalTitle.textContent = 'Thông tin chi tiết môn học: ' + subject;
            modalTeacher.textContent = teacher;
            modalClass.textContent = className;
            modalRegistrationDate.textContent = registrationDate;
            modalCredits.textContent = credits;
            modalSchedule.textContent = schedule;
            modalDescription.textContent = description;
            modalRequirements.textContent = requirements;

            var materialsArray = materials.split(';');
            modalMaterials.innerHTML = '';
            materialsArray.forEach(function (material) {
                var li = document.createElement('li');
                li.textContent = material;
                modalMaterials.appendChild(li);
            });
        });
    });
</script>
