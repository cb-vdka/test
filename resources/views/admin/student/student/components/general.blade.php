<div class="row">
    <div class="col-lg-12">
        <div class="card custom-border" style="border: 1px solid #ccc">
            <div class="card-header">
                <h5 style="margin: 0">Thông tin sinh viên</h5>
            </div>
            <div class="card-body">
                <div class="row m-0">
                    <!-- Tên sinh viên -->
                    <div class="form-group col-6">
                        <label for="name">Tên sinh viên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Nhập tên sinh viên" value="{{ isset($getEdit) ? $getEdit->name : old('name') }}" required>
                        @error('name')
                            <p class="message_error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Giới tính -->
                    <div class="form-group col-6">
                        <label for="gender">Giới tính <span class="text-danger">*</span></label>
                        <div class="d-flex align-items-center">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="genderMale" name="gender"
                                    value="1"
                                    {{ isset($getEdit) && $getEdit->gender == 1 ? 'checked' : (old('gender') == '1' ? 'checked' : '') }}>
                                <label class="form-check-label" for="genderMale" style="margin-left: 20px">
                                    Nam
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="genderFemale" name="gender"
                                    value="0"
                                    {{ isset($getEdit) && $getEdit->gender == 0 ? 'checked' : (old('gender') == '0' ? 'checked' : '') }}>
                                <label class="form-check-label" for="genderFemale" style="margin-left: 20px">
                                    Nữ
                                </label>
                            </div>
                        </div>
                        @error('gender')
                            <p class="message_error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ngày sinh -->
                    <div class="form-group col-6">
                        <label for="date_of_birth">Ngày sinh <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                            value="{{ isset($getEdit) ? $getEdit->date_of_birth : old('date_of_birth') }}" required>
                        @error('date_of_birth')
                            <p class="message_error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Địa chỉ -->
                    <div class="form-group col-6">
                        <label for="address">Địa chỉ <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="address" name="address"
                            placeholder="Nhập địa chỉ" value="{{ isset($getEdit) ? $getEdit->address : old('address') }}" required>
                        @error('address')
                            <p class="message_error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group col-6">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email"
                            value="{{ isset($getEdit) ? $getEdit->email : old('email') }}" required>
                        @error('email')
                            <p class="message_error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Số điện thoại -->
                    <div class="form-group col-6">
                        <label for="phone">Số điện thoại <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="phone" name="phone"
                            placeholder="Nhập số điện thoại" value="{{ isset($getEdit) ? $getEdit->phone : old('phone') }}" required>
                        @error('phone')
                            <p class="message_error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ngành -->
                    <div class="form-group col-6">
                        <label for="course_id">Ngành <span class="text-danger">*</span></label>
                        <select class="form-control" name="course_id" id="course_id" required>
                            <option value="">-- Chọn ngành --</option>
                            @if (isset($getEdit))
                                @foreach ($getCoures as $course)
                                    <option value="{{ $course->id }}"
                                        {{ $course->id == $getEdit->course_id ? 'selected' : '' }}>
                                        {{ $course->name }}
                                    </option>
                                @endforeach
                            @else
                                @foreach ($getCoures as $course)
                                    <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('course_id')
                            <p class="message_error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Chuyên ngành -->
                    <div class="form-group col-6">
                        <label for="major_id">Chuyên ngành <span class="text-danger">*</span></label>
                        <select class="form-control" name="major_id" id="major_id" required>
                            <option value="">-- Chọn chuyên ngành --</option>
                            @if (isset($getEdit))
                                @foreach ($getMajor as $major)
                                    <option value="{{ $major->id }}"
                                        {{ $major->id == $getEdit->major_id ? 'selected' : '' }}>
                                        {{ $major->name }}
                                    </option>
                                @endforeach
                            @else
                                @foreach ($getMajor as $major)
                                    <option value="{{ $major->id }}" {{ old('major_id') == $major->id ? 'selected' : '' }}>
                                        {{ $major->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('major_id')
                            <p class="message_error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- CCCD -->
                    <div class="form-group col-6">
                        <label for="cccd_number">Số CCCD <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="cccd_number" name="cccd_number"
                            placeholder="Nhập số CCCD" value="{{ isset($getEdit) ? $getEdit->cccd_number : old('cccd_number') }}" required>
                        @error('cccd_number')
                            <p class="message_error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ngày cấp CCCD -->
                    <div class="form-group col-6">
                        <label for="cccd_issue_date">Ngày cấp CCCD <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="cccd_issue_date" name="cccd_issue_date"
                            value="{{ isset($getEdit) ? $getEdit->cccd_issue_date : old('cccd_issue_date') }}" required>
                        @error('cccd_issue_date')
                            <p class="message_error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nơi cấp CCCD -->
                    <div class="form-group col-6">
                        <label for="cccd_place">Nơi cấp CCCD <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="cccd_place" name="cccd_place"
                            placeholder="Nhập nơi cấp CCCD" value="{{ isset($getEdit) ? $getEdit->cccd_place : old('cccd_place') }}" required>
                        @error('cccd_place')
                            <p class="message_error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ngày nhập học -->
                    <div class="form-group col-6">
                        <label for="year_of_enrollment">Ngày nhập học <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="year_of_enrollment" name="year_of_enrollment"
                            value="{{ isset($getEdit) ? $getEdit->year_of_enrollment : old('year_of_enrollment') }}" required>
                        @error('year_of_enrollment')
                            <p class="message_error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
