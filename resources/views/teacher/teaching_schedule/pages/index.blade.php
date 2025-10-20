<div class="page-inner">
    @include('teacher.dashboard.components.breadcrumb')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title float-left">
                    Lịch huấn luyện của tôi
                    @if (isset($teacher) && $teacher)
                        - {{ $teacher->name }}
                    @endif
                </h4>

                <div class="action">
                    @if (isset($getAllTeachingSchedule) && $getAllTeachingSchedule->count() > 0)
                        <span class="badge badge-info mr-2">
                            {{ $getAllTeachingSchedule->count() }} lịch huấn luyện
                        </span>
                    @endif
                    <button type="button" class="btn btn-sm btn-primary" onclick="printCalendar()">
                        <i class="fa fa-print"></i> In lịch
                    </button>
                </div>
            </div>
            <div class="card-body" id="calendar-content">
                @include('teacher.teaching_schedule.components.calendar')
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    #calendar-content, #calendar-content * {
        visibility: visible;
    }
    #calendar-content {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    .card-header {
        display: none !important;
    }
    .breadcrumb {
        display: none !important;
    }
    .sidebar {
        display: none !important;
    }
    .main-header {
        display: none !important;
    }
}
</style>

<script>
function printCalendar() {
    window.print();
}
</script>
