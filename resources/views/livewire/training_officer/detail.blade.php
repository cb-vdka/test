<div class="container">
    <div class="row">
        <div class="col-md-12 p-0">
            <div id="chat3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="border-bottom pb-3 d-flex align-items-center">
                                <a href="{{ route('training_officer_chat.index') }}" class="text-dark me-3"
                                    style="font-size: 20px;"><i class="fas fa-angle-left"></i></a>
                                <img src="https://cdn.pixabay.com/photo/2020/07/01/12/58/icon-5359553_640.png"
                                    alt="avatar 1" style="width: 45px; height: 100%;">
                                <div class="ms-3">
                                    <div>
                                        {{ session('user_chat_name') ?? 'Undefined' }}
                                    </div>
                                </div>
                            </div>
                            <div class="pt-3 pe-3 scroll-y-hidden chat-container" id="chat-container"
                                data-mdb-perfect-scrollbar-init>
                                <div class="d-flex flex-row justify-content-end mb-4 mt-3">
                                    <div>
                                        <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">
                                            <strong>Xin Chào, Phòng Đào Tạo Có Thể Giúp Được Gì Cho Bạn?</strong>
                                        </p>
                                    </div>
                                    <img src="https://cdn.pixabay.com/photo/2020/07/01/12/58/icon-5359553_640.png"
                                        alt="avatar 1" style="width: 45px; height: 100%;">
                                </div>
                                <div wire:poll.2s="fetchChat">
                                    @foreach ($allMessages as $item)
                                        @if (!empty($item->student_id == session('user_chat_id') && $item->role_id == 2))
                                            {{-- Student --}}
                                            <div class="d-flex flex-row justify-content-start">
                                                <img src="https://cdn.pixabay.com/photo/2020/07/01/12/58/icon-5359553_640.png"
                                                    alt="avatar 1" style="width: 45px; height: 100%;">
                                                <div>
                                                    <p class="small p-2 ms-3 mb-1 rounded-3 bg-body-tertiary">
                                                        {{ $item->message }}</p>
                                                    <p class="small ms-3 mb-3 rounded-3 text-muted"
                                                        style="font-size: 10px;">{{ $item->created_at }}</p>
                                                </div>
                                            </div>
                                        @elseif (!empty($item->student_id == null && $item->role_id == 4))
                                            {{-- Training Officer --}}
                                            <div class="d-flex flex-row justify-content-end">
                                                <div>
                                                    <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">
                                                        {{ $item->message }}</p>
                                                    <p class="small me-3 mb-3 rounded-3 text-muted"
                                                        style="font-size: 10px;">{{ $item->created_at }}</p>
                                                </div>
                                                <img src="https://cdn.pixabay.com/photo/2020/07/01/12/58/icon-5359553_640.png"
                                                    alt="avatar 1" style="width: 45px; height: 100%;">
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <form wire:submit.prevent="sendMessageTraining" method="POST">
                                @csrf
                                <div class="text-muted d-flex justify-content-start align-items-center pe-3 pt-3 mt-2">
                                    <img src="https://cdn.pixabay.com/photo/2020/07/01/12/58/icon-5359553_640.png"
                                        alt="avatar 3" style="width: 40px; height: 100%;">
                                    <input type="text" wire:model="replyMessage"
                                        class="form-control form-control-sm ms-3" placeholder="Câu trả lời của bạn...">
                                    <button type="submit" class="ms-3 border-0 bg-transparent"><i
                                            class="fas fa-paper-plane"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
