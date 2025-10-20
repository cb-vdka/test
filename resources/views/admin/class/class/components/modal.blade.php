<div class="modal fade" id="deleteModal{{$class->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="deleteModalLabel">Xác nhận xóa lớp học</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
                    
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button><span aria-hidden="true">&times;</span>
                </button>   
            </div>
            <div class="modal-body text-dark">
                Bạn có chắc chắn muốn xóa vĩnh viễn lớp học này?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal">Hủy</button>
                <form action="{{ route('class.forceDelete', $class) }}"
                    method="POST" style="display:inline-block;">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger">
                        Xóa
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>