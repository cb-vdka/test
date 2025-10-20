<?php
return [
    'module' => [
        [
            'user_role' => [1],
            'title' => 'Bảng Điều Khiển',
            'icon' => 'fas fa-tachometer-alt',
            'name' => 'dashboard',
            'subModule' => [
                [
                    'title' => 'Thống Kê',
                    'route' => 'dashboard.index',
                    'user_role' => [1]
                ]
            ]
        ],
        [
            'user_role' => [1],
            'title' => 'Quản Trị Viên',
            'icon' => 'fas fa-users', // Icon cho quản lý thành viên
            'name' => 'user',
            'subModule' => [
                [
                    'title' => 'Tài Khoản',
                    'route' => 'account.index',
                    'user_role' => [1]
                ],
            ]
        ],
        [
            'user_role' => [1],
            'title' => 'Cán Bộ Đào Tạo',
            'icon' => 'fas fa-hands-helping', // Icon cho quản lý CBDT
            'name' => '',
            'subModule' => [
                [
                    'title' => 'Phòng',
                    'route' => 'office.index',
                    'user_role' => [1],
                ],
                [
                    'title' => 'Khoa',
                    'route' => 'faculty.index',
                    'user_role' => [1],
                ],
                [
                    'title' => 'Ban',
                    'route' => 'division.index',
                    'user_role' => [1],
                ],
                [
                    'title' => 'Tài Khoản',
                    'route' => 'training_officer_account.index',
                    'user_role' => [1],
                ],
            ]
        ],
        [
            'user_role' => [1, 3],
            'title' => 'Lịch Huấn Luyện',
            'icon' => 'fas fa-calendar-alt', // Icon cho lịch dạy
            'name' => '',
            'subModule' => [
                [
                    'title' => 'Lịch Huấn Luyện',
                    'route' => 'teaching_schedule.index',
                    'user_role' => [1, 3],
                ]
            ]
        ],
        [
            'user_role' => [],
            'title' => 'Lịch huấn luyện',
            'icon' => 'fas fa-calendar', // Icon cho lịch huấn luyện
            'name' => '',
            'subModule' => [
                [
                    'title' => 'Lịch huấn luyện',
                    'route' => 'schedule.index',
                    'user_role' => [1, 2, 4]
                ]
            ]
        ],
        [
            'user_role' => [1, 4],
            'title' => 'Địa điểm học',
            'icon' => 'fas fa-door-open', // Icon cho phòng học
            'name' => '',
            'subModule' => [
                [
                    'title' => 'Địa điểm học',
                    'route' => 'classroom.index',
                    'user_role' => [1, 4]
                ]
            ]
        ],
        [
            'user_role' => [1, 4],
            'title' => 'Tiết học',
            'icon' => 'fas fa-clock', // Icon cho ca học
            'name' => '',
            'subModule' => [
                [
                    'title' => 'Tiết học',
                    'route' => 'school_shift.index',
                    'user_role' => [1, 4]
                ]
            ]
        ],
        [
            'user_role' => [1, 3, 16],
            'title' => 'Bảng Điểm',
            'icon' => 'fas fa-file-signature', // Icon cho Bảng Điểm
            'name' => '',
            'subModule' => [
                [
                    'title' => 'Nhập Điểm',
                    'route' => 'enrollment.class.list',
                    'user_role' => [1, 3, 16],
                ],
                // Bảng Điểm cho Admin/Student: đi tới trang bảng điểm hiện tại
                [
                    'title' => 'Bảng Điểm',
                    'route' => 'enrollment_student.index',
                    'user_role' => [1, 2],
                ],
                // Bảng Điểm cho Giáo Viên: điều hướng sang lịch dạy
                [
                    'title' => 'Bảng Điểm',
                    'route' => 'teacher.teaching_schedule.index',
                    'user_role' => [3, 16],
                ]
            ]
        ],
        [
            'user_role' => [1],
            'title' => 'Học Viên',
            'icon' => 'fas fa-graduation-cap', // Icon cho học sinh
            'name' => '',
            'subModule' => [
                [
                    'title' => 'Học Viên',
                    'route' => 'student.index',
                    'user_role' => [1]
                ]
            ]
        ],
        [
            'user_role' => [1],
            'title' => 'Giáo Viên',
            'icon' => 'fas fa-chalkboard-teacher', // Icon cho giáo viên
            'name' => '',
            'subModule' => [
                [
                    'title' => 'Giáo Viên',
                    'route' => 'teacher.index',
                    'user_role' => [1]
                ],
                [
                    'title' => 'Buổi Dạy',
                    'route' => 'teacher.day',
                    'user_role' => [1]
                ],
                [
                    'title' => 'Tài Liệu Giáo Viên',
                    'route' => 'materials.index',
                    'user_role' => [1]
                ] ,
                [
                    'title' => 'Xác thực giáo viên',
                    'route' => 'teacher.scan',
                    'user_role' => [1]
                ]
            ]

        ],
        [
            'user_role' => [1],
            'title' => 'Lớp Học',
            'icon' => 'fas fa-chalkboard', // Icon cho lớp học
            'name' => '',
            'subModule' => [
                [
                    'title' => 'Lớp Học',
                    'route' => 'class.index',
                    'user_role' => [1]
                ]
            ]
        ],
        // Reordered block: Đối tượng đào tạo -> Ngành đào tạo -> Môn Học
        [
            'user_role' => [1, 3],
            'title' => 'Đối Tượng Đào Tạo',
            'icon' => 'fas fa-chalkboard-teacher', // Icon cho Đối tượng đào tạo
            'name' => '',
            'subModule' => [
                [
                    'title' => 'Đối Tượng Đào Tạo',
                    'route' => 'course.index',
                    'user_role' => [1, 3],
                ]
            ]
        ],
        [
            'user_role' => [1],
            'title' => 'Ngành đào tạo',
            'icon' => 'fas  fa-graduation-cap', // Icon cho môn học
            'name' => '',
            'subModule' => [
                [
                    'title' => 'Ngành đào tạo',
                    'route' => 'major.index',
                    'user_role' => [1]
                ]
            ]
        ],
        [
            'user_role' => [1],
            'title' => 'Môn Học',
            'icon' => 'fas fa-book', // Icon cho môn học
            'name' => '',
            'subModule' => [
                [
                    'title' => 'Môn Học',
                    'route' => 'subject.index',
                    'user_role' => [1]
                ]
            ]
        ],
        [
            'user_role' => [1,2, 3],
            'title' => 'Tài Liệu Học Tập',
            'icon' => 'fas fa-pencil-alt', // Icon cho Đánh Giá
            'name' => '',
            'subModule' => [
                [
                    'title' => 'Tài Liệu Học Tập',
                    'route' => 'materials.index',
                    'user_role' => [1,2,3]
                ]
            ]
        ],
        [
            'user_role' => [2, 4],
            'title' => 'Hỗ Trợ Học Viên',
            'icon' => 'fab fa-rocketchat', // Icon cho Hỗ Trợ Học Viên
            'name' => '',
            'subModule' => [
                [
                    'title' => 'Hỗ Trợ Học Viên',
                    'route' => 'training_officer_chat.index',
                    'user_role' => [4]
                ],
                [
                    'title' => 'Chat Với Phòng Đào Tạo',
                    'route' => 'student_chat.index',
                    'user_role' => [2]
                ]
            ]
        ],
        [
            'user_role' => [1],
            'title' => 'Phân Quyền',
            'icon' => 'fas fa-shield-alt', // Icon cho phân quyền
            'name' => 'permissions',
            'subModule' => [
                [
                    'title' => 'Quản lý Quyền hạn',
                    'route' => 'admin.permissions.index',
                    'user_role' => [1]
                ],
                [
                    'title' => 'Quản lý Vai trò',
                    'route' => 'admin.roles.index',
                    'user_role' => [1]
                ]
            ]
        ],
//        [
//            'user_role' => [2],
//            'title' => 'Đăng ký môn học',
//            'icon' => 'fas fa-book', // Icon cho môn học
//            'name' => '',
//            'subModule' => [
//                [
//                    'title' => 'Môn học',
//                    'route' => 'get.course',
//                    'user_role' => [2]
//                ]
//            ]
//        ],
//        [
//            'user_role' => [2],
//            'title' => 'Môn học đã đăng ký',
//            'icon' => 'fas fa-check-circle',
//            'name' => '',
//            'subModule' => [
//                [
//                    'title' => 'Môn học',
//                    'route' => 'show_subject_register.index',
//                    'user_role' => [2]
//                ]
//            ]
//        ]
    ]
];