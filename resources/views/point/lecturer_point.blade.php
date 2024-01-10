@extends('layouts.master_admin')

{{-- thay đổi nội dung phần content --}}
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Danh sách điểm</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        @if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->position == 'Lecturer')
                            <div style="display: flex">
                                <div style="margin-bottom: 30px;">
                                    <a href="/admin/import/point/{{ $credit_class_id }}" data-toggle="modal"
                                        class="btn btn-success btn-add">Import Excel</a>
                                </div>
                                <div style="margin-bottom: 30px; margin-left: 10px">
                                    <a href="/admin/export/point?id={{ $credit_class_id }}"
                                        class="btn btn-danger btn-add">Export Excel</a>
                                </div>
                            </div>
                        @endif

                        <table id="list-data" class="table table-bordered table-striped" style="margin-top : 10px;">
                            <thead>
                                <tr>
                                    <th class="col-sm-1 text-center">Mã lớp</th>
                                    <th class="col-sm-2 text-center">Tên lớp</th>
                                    <th class="col-sm-1 text-center">Mã sinh viên</th>
                                    <th class="col-sm-1 text-center">Sinh viên</th>
                                    <th class="col-sm-1 text-center">Điểm chuyên cần</th>
                                    <th class="col-sm-1 text-center">Điểm bài tập</th>
                                    <th class="col-sm-1 text-center">Điểm thực hành</th>
                                    <th class="col-sm-1 text-center">Điểm thi giữa kỳ</th>
                                    <th class="col-sm-1 text-center">Điểm thi cuối kỳ</th>
                                    <th class="col-sm-1 text-center">Điểm trung bình</th>
                                    @if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->position != 'Student')
                                        <th class="col-sm-1 text-center">Nhập điểm</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $value)
                                    <tr>
                                        <td class="col-sm-1 text-center">{{ $value->creditClass->code }}</td>
                                        <td class="col-sm-2 text-center">{{ $value->creditClass->name }}</td>
                                        <td class="col-sm-1 text-center">{{ $value->students->account->code }}</td>
                                        <td class="col-sm-1 text-center">{{ $value->students->account->first_name }}
                                            {{ $value->students->account->last_name }}</td>
                                        <td class="col-sm-1 text-center">{{ $value->attendance_point }}</td>
                                        <td class="col-sm-1 text-center">{{ $value->revise_point }}</td>
                                        <td class="col-sm-1 text-center">{{ $value->practice_point }}</td>
                                        <td class="col-sm-1 text-center">{{ $value->middle_test_point }}</td>
                                        <td class="col-sm-1 text-center">{{ $value->finish_test_point }}</td>
                                        <td class="col-sm-1 text-center">{{ $value->avg_point }}</td>
                                        @if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->position != 'Student')
                                            <td class="col-sm-1 text-center">
                                                <button data-student-id="{{ $value->student_id }}"
                                                    data-class-id="{{ $value->credit_class_id }}" type="button"
                                                    class="btn btn-info btn-edit">
                                                    <i class="glyphicon glyphicon-edit"></i>
                                                </button>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- modal edit -->
        <div class="col-xs-12">
            <div class="modal fade" id="editPoint" tabindex="-1" role="dialog" aria-labelledby="formFillData"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content" style="border-radius : 10px;">
                        <div class="modal-header">
                            <h4 class="modal-title">Cập nhật thông tin</h4>
                        </div>
                        <form action="" id="formPoint">
                            @csrf
                            <div class="alert alert-danger error-msg" style="display:none">
                                <ul></ul>
                            </div>
                            <div class="alert alert-success success-msg" style="display:none">
                                <ul></ul>
                            </div>
                            <div class="alert alert-warning unsuccess-msg" style="display:none">
                                <ul></ul>
                            </div>
                            <div class="modal-body">
                                <input name="studentId" type="text" class="form-control hidden" id="editStudentId"><br>
                                <input name="creditClassId" type="text" class="form-control hidden"
                                    id="editCreditClassId"><br>
                                <input name="attendancePoint" type="text" class="form-control" id="editAttendancePoint"
                                    placeholder="Điểm chuyên cần"><br>
                                <input name="revisePoint" type="text" class="form-control" id="editRevisePoint"
                                    placeholder="Điểm bài tập"><br>
                                <input name="practicePoint" type="text" class="form-control" id="editPracticePoint"
                                    placeholder="Điểm thực hành"><br>
                                <input name="middleTestPoint" type="text" class="form-control" id="editMiddleTestPoint"
                                    placeholder="Điểm thi giữa kỳ"><br>
                                <input name="finishTestPoint" type="text" class="form-control" id="editFinishTestPoint"
                                    placeholder="Điểm thi cuối kỳ"><br>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success btn-update" data-dismiss="modal">Cập
                                    nhật</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('#list-data').DataTable({
                    "lengthMenu": [
                        [5, 10, 25, 50],
                        [5, 10, 15, 25, "All"]
                    ],

                    "language": {
                        "lengthMenu": "Hiển thị _MENU_ bản ghi",
                        "zeroRecords": "Xin lỗi không tìm thấy bản ghi",
                        "info": "Hiển thị _PAGE_ trên tổng số _PAGES_",
                        "infoEmpty": "Không có bản ghi nào",
                        "infoFiltered": "(filtered from _MAX_ total records)",
                        "search": "Tìm kiếm:",
                        "paginate": {
                            "first": "Đầu",
                            "last": "Cuối",
                            "next": "Tiếp",
                            "previous": "Trước"
                        },
                    }
                });
            });
        </script>

        <script type="text/javascript">
            $('.btn-edit').click(function() {
                var studentId = $(this).attr('data-student-id');
                var creditClassId = $(this).attr('data-class-id');
                $.ajax({
                    type: "get",
                    url: "/admin/point/detail/" + studentId + "/" + creditClassId,
                    data: {
                        _token: $('[name="_token"]').val(),
                    },
                    success: function(response) {
                        $('#editStudentId').val(response.student_id),
                            $('#editCreditClassId').val(response.credit_class_id),
                            $('#editAttendancePoint').val(response.attendance_point),
                            $('#editRevisePoint').val(response.revise_point),
                            $('#editPracticePoint').val(response.practice_point),
                            $('#editMiddleTestPoint').val(response.middle_test_point),
                            $('#editFinishTestPoint').val(response.finish_test_point)
                    }
                });
                $('#editPoint').modal('show');
            });

            $('.btn-update').click(function() {
                var studentId = $('#editStudentId').val();
                var creditClassId = $('#editCreditClassId').val();
                $.ajax({
                    type: 'post',
                    url: "/admin/point/update/" + studentId + "/" + creditClassId,
                    data: {
                        _token: $('[name="_token"]').val(),
                        attendance_point: $('#editAttendancePoint').val(),
                        revise_point: $('#editRevisePoint').val(),
                        practice_point: $('#editPracticePoint').val(),
                        middle_test_point: $('#editMiddleTestPoint').val(),
                        finish_test_point: $('#editFinishTestPoint').val(),
                    },
                    success: function(response) {
                        if (response.is === 'failed') {
                            $.each(response.error, function(key, value) {
                                message = value;
                            });

                            swal({
                                title: "Thất bại!",
                                text: message,
                                icon: "error",
                                buttons: true,
                                buttons: ["Ok"],
                                timer: 3000
                            });
                        } else if (response.is === 'success') {
                            swal({
                                title: "Hoàn thành!",
                                text: response.complete,
                                icon: "success",
                                buttons: true,
                                buttons: ["Ok"],
                                timer: 1000
                            });

                            setTimeout(function() {
                                window.location.href = "/admin/manage/point/" + creditClassId;
                            }, 1000);
                        } else if (response.is === 'unsuccess') {
                            swal({
                                title: "Thất bại!",
                                text: response.unsuccess,
                                icon: "error",
                                buttons: true,
                                buttons: ["Ok"],
                                timer: 5000
                            });
                        }
                    }
                });
            });
        </script>

        <script type="text/javascript" src="{{ asset('home/js/sweetalert.min.js') }}"></script>
    </section>
    <!-- /.content -->
@endsection
