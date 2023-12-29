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
                <h3 class="box-title">Đăng ký lớp</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @csrf
                <div class="form-group">
                    <label for="" style="margin-top: 20px;">Lớp học</label>
					<select id="getCreditClassId" class="form-control select2" style="width: 100%; margin-top: 0px;">
						@if(isset($credit_classes))
							@foreach($credit_classes as $value)
								<option selected="selected" value="{{$value->id}}">{{$value->name}}</option>
							@endforeach
						@endif
					</select>

                    <label for="" style="margin-top: 20px;">Sinh viên</label>
					<select id="getStudentId" class="form-control select2" style="width: 100%; margin-top: 0px;">
						@if(isset($students))
							@foreach($students as $value)
								<option selected="selected" value="{{$value->id}}">{{$value->account->first_name}} {{$value->account->last_name}}</option>
							@endforeach
						@endif
					</select>

                    <div style="margin-top: 20px;">
                        <button type="button" class="btn btn-success btn-save">
                            Lưu thông tin
                        </button>
                        <a href="/admin/register-class" class="btn btn-danger"
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
                window.location.href = "/admin/register-class";
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
        window.scroll({
            top: 0,
            behavior: 'smooth'
        });
    }

    $(".btn-save").click(function () {
        var currentDate = new Date();

        // Format the date as YYYY-MM-DD HH:mm:ss
        var formattedDate = currentDate.getFullYear() + '-' +
                            ('0' + (currentDate.getMonth() + 1)).slice(-2) + '-' +
                            ('0' + currentDate.getDate()).slice(-2) + ' ' +
                            ('0' + currentDate.getHours()).slice(-2) + ':' +
                            ('0' + currentDate.getMinutes()).slice(-2) + ':' +
                            ('0' + currentDate.getSeconds()).slice(-2);

        var form_data = new FormData();
        form_data.append("_token", "{{csrf_token()}}");
        form_data.append("student_id", $("#getStudentId").val());
        form_data.append("credit_class_id", $("#getCreditClassId").val());
        form_data.append("registered_at", formattedDate);
        $.ajax({
            type: "post",
            url: "/admin/register-class",
            data: form_data,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function (response) {
                handleResponse(response);
            },
        });
    });
</script>
@endsection
