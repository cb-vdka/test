@include('admin.dashboard.components.breadcrumb', ['title' => $config['seo']['delete']['title']])
<div class="wrapper wrapper-content">
    <div class="row" style="margin-top: 77px; padding: 42px;">
        <form action="{{ route('user.catalogue.destroy', $userCatalogue->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="row">
                <div class="col-lg-5">
                    <div class="panel-head">
                        <div class="panel-title">Thông tin chung</div>
                        <div class="panel-description">
                            <p>Bạn đang muốn xóa nhóm thành viên có tên là: <strong>{{ $userCatalogue->email }}</strong>
                            </p>
                            <p>Lưu ý: Không thể khôi phục thành viên sao khi xóa. Hãy chắc chắn khi muốn thực hiện chức
                                năng này</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="row mb10">
                                <div class="col-lg-6">
                                    <div class="form-row">
                                        <label for="" class="control-label text-right">Tên nhóm thành viên <span
                                                class="text-danger">(*)</span></label>
                                        <input value="{{ old('name', $userCatalogue->name ?? '') }}" type="text"
                                            name="text" class="form-control" placeholder="" autocomplete="off"
                                            readonly>

                                        @error('name')
                                            <label id="firstname-error" class="error mt-2 text-danger"
                                                for="firstname">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-row">
                                        <label for="" class="control-label text-right">Ghi chú <span
                                                class="text-danger">(*)</span></label>
                                        <input value="{{ old('description', $userCatalogue->description ?? '') }}"
                                            type="text" name="description" class="form-control" placeholder=""
                                            autocomplete="off" readonly>

                                        @error('description')
                                            <label id="firstname-error" class="error mt-2 text-danger"
                                                for="firstname">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-danger mb10" name="send" value="send">Xóa</button>
            </div>
        </form>
    </div>
</div>
