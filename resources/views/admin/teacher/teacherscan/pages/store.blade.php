<div class="page-inner">
    @include('admin.dashboard.components.breadcrumb')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title float-left"></h4>
                <a href="{{ route('teacher.scan') }}" class="btn btn-sm btn-primary">Quay lại danh sách</a>
            </div>
            <div class="card-body">
                <!-- Form to upload CCCD images -->
                <form action="{{ route('scan.store') }}" method="POST" autocomplete="on" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card custom-border" style="border: 1px solid #ccc">
                                <div class="card-header">
                                    <h5 style="margin: 0">Xác thực CCCD</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="cccd_front">CCCD Mặt Trước</label>
                                        <input type="file" name="cccd_front" id="cccd_front" class="form-control" accept="image/*" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="cccd_back">CCCD Mặt Sau</label>
                                        <input type="file" name="cccd_back" id="cccd_back" class="form-control" accept="image/*" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 text-right">
                            <button type="submit" class="btn btn-success mb10 button-fix" name="send" value="send">Kiểm tra thông tin</button>
                        </div>
                    </div>
                </form>
            </div>
            @if(isset($data))
            <div class="card-body">
                <!-- Form to save verified information -->
                <form action="{{ route('scan.save') }}" method="POST" autocomplete="on">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card custom-border" style="border: 1px solid #ccc">
                                <div class="card-header">
                                    <h5 style="margin: 0">Thông tin đã được xác thực</h5>
                                </div>
                                <input type="hidden" name="cccd_front_image" value="{{ $data['cccd_front_image'] ?? '' }}">
                                <input type="hidden" name="cccd_back_image" value="{{ $data['cccd_back_image'] ?? '' }}">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Tên</label>
                                        <input type="text" name="name" id="name" class="form-control" value="{{ $data['name'] ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="dob">Ngày sinh</label>
                                        <input type="text" name="dob" id="dob" class="form-control" value="{{ $data['dob'] ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="sex">Giới tính</label>
                                        <input type="text" name="sex" id="sex" class="form-control" value="{{ $data['sex'] ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="id_number">Số CCCD</label>
                                        <input type="text" name="id_number" id="id_number" class="form-control" value="{{ $data['id'] ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="nationality">Quốc tịch</label>
                                        <input type="text" name="nationality" id="nationality" class="form-control" value="{{ $data['nationality'] ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="home">Hộ khẩu thường trú</label>
                                        <input type="text" name="home" id="home" class="form-control" value="{{ $data['home'] ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Địa chỉ</label>
                                        <input type="text" name="address" id="address" class="form-control" value="{{ $data['address'] ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="province">Tỉnh/Thành phố</label>
                                        <input type="text" name="province" id="province" class="form-control" value="{{ $data['address_entities']['province'] ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="district">Quận/Huyện</label>
                                        <input type="text" name="district" id="district" class="form-control" value="{{ $data['address_entities']['district'] ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="ward">Phường/Xã</label>
                                        <input type="text" name="ward" id="ward" class="form-control" value="{{ $data['address_entities']['ward'] ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="street">Đường</label>
                                        <input type="text" name="street" id="street" class="form-control" value="{{ $data['address_entities']['street'] ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="doe">Ngày hết hạn</label>
                                        <input type="text" name="doe" id="doe" class="form-control" value="{{ $data['doe'] ?? '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 text-right">
                            <button type="submit" class="btn btn-success mb10 button-fix">Lưu thông tin</button>
                        </div>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
