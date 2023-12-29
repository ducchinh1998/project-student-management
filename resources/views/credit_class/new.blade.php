@extends('layouts.master_admin') @section('controll') New Class
@endsection @section('content')
<div class="container box box-body pad">
    <div class="row">
        <div class="col-xs-12">
            <div class="alert alert-danger error-msg" style="display: none">
                <ul></ul>
            </div>

            <div class="alert alert-success success-msg" style="display: none">
                <ul></ul>
            </div>

            <div
                class="alert alert-warning unsuccess-msg"
                style="display: none"
            >
                <ul></ul>
            </div>
        </div>

        <div class="col-xs-12">
            <div class="box-header">
                <h3 class="box-title">Thêm mới</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @csrf
                <div class="form-group">
                    <label for="" style="margin-top: 5px;">Năm học</label>
					<select id="getSchoolYearId" class="form-control select2" style="width: 100%; margin-top: 0px;">
						@if(isset($school_years))
							@foreach($school_years as $value)
								<option selected="selected" value="{{$value->id}}">{{$value->name}} {{$value->session}}</option>
							@endforeach
						@endif
					</select>

                    <label for="" style="margin-top: 20px;">Khoa</label>
					<select id="getFacultyId" class="form-control select2" style="width: 100%; margin-top: 0px;">
						@if(isset($faculties))
							@foreach($faculties as $value)
								<option selected="selected" value="{{$value->id}}">{{$value->name}}</option>
							@endforeach
						@endif
					</select>

                    <label for="" style="margin-top: 20px;">Môn học</label>
					<select id="getSubjectId" class="form-control select2" style="width: 100%; margin-top: 0px;">
						@if(isset($subjects))
							@foreach($subjects as $value)
								<option selected="selected" value="{{$value->id}}">{{$value->name}}</option>
							@endforeach
						@endif
					</select>

                    <label for="" style="margin-top: 20px;">Giảng viên phụ trách</label>
					<select id="getLecturerId" class="form-control select2" style="width: 100%; margin-top: 0px;">
						@if(isset($lecturers))
							@foreach($lecturers as $value)
								<option selected="selected" value="{{$value->id}}">{{$value->first_name}} {{$value->last_name}}</option>
							@endforeach
						@endif
					</select>

                    <label for="" style="margin-top: 20px;">Tên lớp học tín chỉ</label>
                    <input
                        name="name"
                        type="text"
                        class="form-control"
                        id="getName"
                        placeholder="Cấu trúc dữ liệu & giải thuật"
                    /><br />

                    <label for="" style="margin-top: 10px;">Mã lớp học tín chỉ</label>
                    <input
                        name="code"
                        type="text"
                        class="form-control"
                        id="getCode"
                    /><br />

                    <label for="" style="margin-top: 10px;">Trọng số điểm bài tập</label>
                    <input
                        name="revise_weight"
                        type="text"
                        class="form-control"
                        id="getReviseWeight"
                    /><br />

                    <label for="" style="margin-top: 10px;">Trọng số điểm kiểm tra</label>
                    <input
                        name="middle_test_weight"
                        type="text"
                        class="form-control"
                        id="getMiddleTestWeight"
                    /><br />

                    <label for="" style="margin-top: 10px;">Trọng số điểm thực hành</label>
                    <input
                        name="practice_weight"
                        type="text"
                        class="form-control"
                        id="getPracticeWeight"
                    /><br />

                    <label for="" style="margin-top: 10px;">Trọng số điểm chuyên cần</label>
                    <input
                        name="attendance_weight"
                        type="text"
                        class="form-control"
                        id="getAttendanceWeight"
                    /><br />

                    <label for="" style="margin-top: 10px;">Trọng số điểm thi</label>
                    <input
                        name="finish_test_weight"
                        type="text"
                        class="form-control"
                        id="getFinishTestWeight"
                    /><br />

                    <label for="" style="margin-top: 10px;">Thời gian vào học</label>
                    <input
                        name="start_time"
                        type="text"
                        class="form-control"
                        id="getStartTime"
                    /><br />

                    <label for="" style="margin-top: 10px;">Thời gian kết thúc</label>
                    <input
                        name="end_time"
                        type="text"
                        class="form-control"
                        id="getEndTime"
                    /><br />

                    <div style="margin-top: 20px;">
                        <button type="button" class="btn btn-success btn-save">
                            Lưu thông tin
                        </button>
                        <a href="/admin/credit-class" class="btn btn-danger"
                            >Hủy bỏ</a
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function handleResponse(response) {
        if (response.is === "failed") {
            $(".error-msg").find("ul").html("");
            $(".error-msg").css("display", "block");
            $(".success-msg").css("display", "none");
            $(".unsuccess-msg").css("display", "none");
            $.each(response.error, function (key, value) {
                $(".error-msg")
                    .find("ul")
                    .append("<li>" + value + "</li>");
            });
        } else if (response.is === "success") {
            $(".success-msg").find("ul").html("");
            $(".success-msg").css("display", "block");
            $(".error-msg").css("display", "none");
            $(".unsuccess-msg").css("display", "none");
            $(".success-msg")
                .find("ul")
                .append("<li>" + response.complete + "</li>");
            setTimeout(function () {
                window.location.href = "/admin/credit-class";
            }, 1000);
        } else if (response.is === "unsuccess") {
            $(".unsuccess-msg").find("ul").html("");
            $(".unsuccess-msg").css("display", "block");
            $(".error-msg").css("display", "none");
            $(".success-msg").css("display", "none");
            $(".unsuccess-msg")
                .find("ul")
                .append("<li>" + response.unsuccess + "</li>");
        }
    }

    $(".btn-save").click(function () {
        var form_data = new FormData();
        var revise_weight = +$("#getReviseWeight").val() || 0;
        var middle_test_weight = +$("#getMiddleTestWeight").val() || 0;
        var practice_weight = +$("#getPracticeWeight").val() || 0;
        var attendance_weight = +$("#getAttendanceWeight").val() || 0;
        var finish_test_weight = +$("#getFinishTestWeight").val() || 0;

        console.log("Total = ", revise_weight + middle_test_weight + practice_weight + attendance_weight + finish_test_weight)

        if(revise_weight + middle_test_weight + practice_weight + attendance_weight + finish_test_weight != 1){
            $(".error-msg").find("ul").html("");
            $(".error-msg").css("display", "block");
            $(".success-msg").css("display", "none");
            $(".unsuccess-msg").css("display", "none");
            $(".error-msg").find("ul").append("<li>" + 'Tổng trọng số các điểm phải bằng 1' + "</li>");
            return;
        }

        form_data.append("_token", "{{csrf_token()}}");
        form_data.append("school_year_id", $("#getSchoolYearId").val());
        form_data.append("faculty_id", $("#getFacultyId").val());
        form_data.append("subject_id", $("#getSubjectId").val());
        form_data.append("lecturer_id", $("#getLecturerId").val());

        form_data.append("name", $("#getName").val());
        form_data.append("code", $("#getCode").val());
        form_data.append("revise_weight", $("#getReviseWeight").val());
        form_data.append("middle_test_weight", $("#getMiddleTestWeight").val());
        form_data.append("practice_weight", $("#getPracticeWeight").val());
        form_data.append("attendance_weight", $("#getAttendanceWeight").val());
        form_data.append("finish_test_weight", $("#getFinishTestWeight").val());
        form_data.append("start_time", $("#getStartTime").val());
        form_data.append("end_time", $("#getEndTime").val());

        $.ajax({
            type: "post",
            url: "/admin/credit-class",
            data: form_data,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function (response) {
                handleResponse(response);
                window.scroll({
                    top: 0,
                    behavior: 'smooth'
                });
            },
        });
    });
</script>
@endsection
