<form action="{{ route('user.catalogue.index') }}" method="GET">
    <div class="ibox-content">
        <div class="filter">
            <div class="perpage">
                @php
                    $perpage = request('perpage') ?: old('perpage');
                @endphp
                <select name="perpage" class="form-control input-sm mr10">
                    @for ($i = 10; $i < 200; $i++)
                        <option {{ $perpage == $i ? 'selected' : '' }} value="{{ $i }}">{{ $i }}
                            bản ghi</option>
                    @endfor
                </select>
            </div>

            @php
                $publish = request('publish') ?: old('publish');
            @endphp
            <div class="action">
                <select name="publish" class="form-control mr10 setupSelect2">
                    @foreach (config('apps.general.publish') as $key => $val)
                        <option {{ $publish == $key ? 'selected' : '' }} value="{{ $key }}">{{ $val }}
                        </option>
                    @endforeach
                </select>

                <div class="input-group mr10">
                    <input type="text" name="keyword" value="{{ request('keyword') ?: old('keyword') }}"
                        placeholder="Nhập từ khóa mà bạn muốn tìm kiếm" class="form-control">
                    <div class="input-group-append">
                        <button type="submit" name="search" value="search" class="btn btn-primary mb-0 btn-sm">Tìm
                            kiếm</button>
                    </div>
                </div>
                <a href="{{ route('user.catalogue.create') }}" class="btn btn-danger"><i class="fa fa-plus"></i> Thêm
                    Mới Nhóm
                    Thành Viên</a>
            </div>

        </div>
    </div>

</form>
