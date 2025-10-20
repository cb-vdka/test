<style>
    /* Điều chỉnh kích thước và kiểu dáng của Select2 */
    .select2-container--default .select2-selection--single {
        width: 100% !important;
        /* Đảm bảo Select2 sử dụng chiều rộng đầy đủ */
        height: inherit !important;
        /* Đảm bảo chiều cao giống như form-control */
        border-radius: .25rem !important;
        /* Border-radius giống như form-control */
        border: 2px solid #ebedf2 !important;
        /* Border giống như form-control */
        box-shadow: none !important;
        /* Loại bỏ box-shadow mặc định của Select2 */
        padding: .6rem 1rem !important;
        /* Padding giống như form-control */
        font-size: 1rem !important;
        /* Font-size giống như form-control */
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 1.5rem !important;
        /* Căn chỉnh văn bản theo chiều cao */
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: inherit !important;
        /* Chiều cao của mũi tên */
        top: 0 !important;
        /* Căn chỉnh mũi tên */
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        margin-top: 19px !important;
    }

    .table-responsive{
        overflow-x: hidden;
    }
</style>