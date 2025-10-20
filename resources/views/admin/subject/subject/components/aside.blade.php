<div class="card custom-border" style="border: 1px solid #ccc">
    <div class="card-header">
        <h5 style="margin: 0">Thông tin môn học</h5>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label for="course_id">Đối tượng đào tạo</label>
            <select class="form-control setupSelect2" id="course_id" name="course_id">
                <option value="">--Chọn đối tượng đào tạo--</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}"
                            {{ old('course_id', $subject->course_id ?? '') == $department->id ? 'selected' : '' }}>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>
            @error('course_id')
            <label id="course_id-error" class="error mt-2 text-danger" for="course_id">{{ $message }}</label>
            @enderror
        </div>


        <div class="form-group">
            <label for="major_id">Chuyên ngành</label>
            <select class="form-control setupSelect2" id="major_id" name="major_id" {{ empty(old('course_id', $subject->course_id ?? '')) ? 'disabled' : '' }}>
                <option value="">--Chọn chuyên ngành--</option>
                @if(old('course_id') || !empty($subject->course_id ?? ''))
                    @foreach ($majors as $major)
                        <option value="{{ $major->id }}" {{ old('major_id', $subject->major_id ?? '') == $major->id ? 'selected' : '' }}>
                            {{ $major->name }}
                        </option>
                    @endforeach
                @endif
            </select>
            @error('major_id')
            <label id="major_id-error" class="error mt-2 text-danger" for="major_id">{{ $message }}</label>
            @enderror
        </div>


        <div class="form-group">
            <label for="subject_type_id">Hình thức học</label>
            <select class="form-control setupSelect2" id="subject_type_id" name="subject_type_id">
                @foreach ($subjectTypes as $subjectType)
                    <option value="{{ $subjectType->id }}"
                            {{ old('subject_type_id', $subject->subject_type_id ?? '') == $subjectType->id ? 'selected' : '' }}>
                        {{ $subjectType->name }}
                    </option>
                @endforeach
            </select>
            @error('subject_type_id')
            <label id="subject_type_id-error" class="error mt-2 text-danger" for="subject_type_id">{{ $message }}</label>
            @enderror
        </div>

        <div class="form-group">
            <label for="status">Trạng thái</label>
            <select class="form-control setupSelect2" id="status" name="status">
                <option value="0" {{ old('status', $subject->status ?? '') == 0 ? 'selected' : '' }}>Hoạt động</option>
                <option value="1" {{ old('status', $subject->status ?? '') == 1 ? 'selected' : '' }}>Không hoạt động</option>
            </select>
            @error('status')
            <label id="status-error" class="error mt-2 text-danger" for="status">{{ $message }}</label>
            @enderror
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#course_id').change(function() {
            var departmentId = $(this).val();
            var selectedMajorId = '{{ old('major_id', $subject->major_id ?? '') }}';

            if(departmentId) {
                $('#major_id').prop('disabled', true).empty().append('<option value="">Chọn Đối tượng đào tạo</option>');
                $.ajax({
                    url: '{{ route('majors.by.course') }}',
                    type: 'GET',
                    data: { course_id: departmentId },
                    success: function(data) {
                        $('#major_id').empty();
                        $('#major_id').append('<option value="">Chọn Đối tượng đào tạo</option>');
                        $.each(data, function(key, value) {
                            var selected = (String(selectedMajorId) === String(value.id)) ? ' selected' : '';
                            $('#major_id').append('<option value="'+ value.id +'"'+selected+'>'+ value.name +'</option>');
                        });
                        $('#major_id').prop('disabled', false);
                    }
                });
            } else {
                $('#major_id').empty();
                $('#major_id').append('<option value="">Chọn Đối tượng đào tạo</option>');
                $('#major_id').prop('disabled', true);
            }
        });
        // Auto-load majors when editing or when old('course_id') exists
        @if(old('course_id'))
            $('#course_id').val('{{ old('course_id') }}').trigger('change');
        @elseif(!empty($subject->course_id ?? ''))
            $('#course_id').val('{{ $subject->course_id }}').trigger('change');
        @endif
    });
</script>
