<div class="table-responsive">
    @php
        $totalGpa = 0;
        $studentCount = 0;
    @endphp

    @foreach ($getAllEnrollmentStudent as $key => $items)
        @php
            if (!empty($items->final_exam)) {
                $gpa = number_format(
                    ($items->lab_1 +
                        $items->lab_2 +
                        $items->assignment_1 +
                        $items->lab_3 +
                        $items->lab_4 +
                        $items->assignment_2 +
                        $items->final_exam) /
                        7,
                    1,
                    ',',
                    '.',
                );

                $totalGpa += floatval(str_replace(',', '.', $gpa));
                $studentCount++;
            } else {
                $gpa = '';
            }
            $averageGpa = $studentCount > 0 ? number_format($totalGpa / $studentCount, 1, ',', '.') : 0;
        @endphp

        <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 mb-5 p-4 border">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <h6>{{ $key + 1 . '. ' . $items->subject_name }}</h6>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <table id="basic-datatables" class="display table table-striped table-hover dataTable" role="grid"
                        aria-describedby="basic-datatables_info">
                        <thead>
                            <tr role="row">
                                <th style="width: 10%;">Lab 1</th>
                                <th style="width: 10%;">Lab 2</th>
                                <th style="width: 10%;">Asm 1</th>
                                <th style="width: 10%;">Lab 3</th>
                                <th style="width: 10%;">Lab 4</th>
                                <th style="width: 10%;">Asm 2</th>
                                <th style="width: 10%;">Final</th>
                                <th>Điểm Trung Bình</th>
                                <th>Trạng Thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr role="row" class="odd">
                                <td>{{ $items->lab_1 }}</td>
                                <td>{{ $items->lab_2 }}</td>
                                <td>{{ $items->assignment_1 }}</td>
                                <td>{{ $items->lab_3 }}</td>
                                <td>{{ $items->lab_4 }}</td>
                                <td>{{ $items->assignment_2 }}</td>
                                <td>{{ $items->final_exam }}</td>
                                <td>
                                    {{ $gpa }}
                                </td>
                                <td>
                                    @if ($gpa >= 5)
                                        <span class="text-success">Passed</span>
                                    @elseif (empty($gpa))
                                        <span class="text-primary">Studying</span>
                                    @else
                                        <span class="text-danger">Failed</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
    <h6>Điểm Trung Bình: <span class="ms-1">{{ $averageGpa ?? '' }}</span></h6>
</div>


