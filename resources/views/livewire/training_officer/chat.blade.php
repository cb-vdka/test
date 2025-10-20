<div class="container">
    <div class="row">
        <div class="col-md-12 p-0">
            <div id="chat3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-5 col-xl-4 mb-4 mb-md-0 border-end">
                            <div class="p-3 pt-0">
                                <div class="input-group rounded mb-3">
                                    <input type="search" class="form-control rounded" placeholder="Tìm Kiếm..."
                                        wire:model.live="searchTerm" />
                                    <span class="input-group-text border-0" id="search-addon">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                                <div>
                                    <ul class="list-unstyled mb-0 scroll-y-hidden chat-aside-height"
                                        wire:poll.2s="fetchList">
                                        @if (!empty($getAllChat->count()) > 0)
                                            @foreach ($getAllChat as $key => $item)
                                                <li class="p-2 border-bottom">
                                                    <a href="{{ route('training_officer_chat.updateNotification', $item->student_id) }}"
                                                        class="d-flex justify-content-between">
                                                        <div class="d-flex flex-row">
                                                            <div>
                                                                <img src="https://cdn.pixabay.com/photo/2020/07/01/12/58/icon-5359553_640.png"
                                                                    alt="avatar" class="d-flex align-self-center me-3"
                                                                    width="60">
                                                                <span class="badge bg-success badge-dot"></span>
                                                            </div>
                                                            <div class="pt-1">
                                                                <p class="fw-bold mb-0">
                                                                    {{ $item->student->name }}
                                                                </p>
                                                                <p class="small text-muted truncate-text-1">
                                                                    {{ $item->message }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        @if (!empty($item->unread_count) > 0)
                                                            <div class="pt-1">
                                                                <span
                                                                    class="badge bg-danger rounded-pill float-end">{{ $item->unread_count }}
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </a>
                                                </li>
                                            @endforeach
                                        @else
                                            <div class="text-center text-danger pt-3">
                                                <h6>Không Có Đoạn Chat Nào</h6>
                                            </div>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-7 col-xl-8 hidden_for_phone">
                            <div class="d-flex justify-content-center align-items-center text-center"
                                style="height: 370px;">
                                <div> 
                                    
                                    <div class="mt-3 mb-3">
                                        <img src="{{ asset(env('LOGO')) }}" alt=""
                                            width="175px">
                                    </div>
                                    <div>
                                        <small>Trang Này Có Chức Năng Hỗ Trợ Và Phản Hồi Các Thắc Mắc Của Sinh
                                            Viên</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
