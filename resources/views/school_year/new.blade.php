@extends('layouts.master_admin') @section('controll') New School Year
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
                    <input
                        name="name"
                        type="text"
                        class="form-control"
                        id="getName"
                        placeholder="Năm học (VD: 2022-2023)"
                    /><br />
                    <input
                        name="session"
                        type="text"
                        class="form-control"
                        id="getSession"
                        placeholder="Kì học (VD: Kỳ A)"
                    /><br />
                    <input
                        name="start_time"
                        type="text"
                        class="form-control"
                        id="getStartTime"
                        placeholder="Thời điểm bắt đầu (VD: 2022-09-05)"
                    /><br />
                    <input
                        name="end_time"
                        type="text"
                        class="form-control"
                        id="getEndTime"
                        placeholder="Thời điểm kết thúc (VD: 2023-01-31)"
                    /><br />
                    <button type="button" class="btn btn-success btn-save">
                        Lưu thông tin
                    </button>
                    <a href="/admin/school-year" class="btn btn-danger"
                        >Hủy bỏ</a
                    >
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
                window.location.href = "/admin/school-year";
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
        var form_data = new FormData();
        form_data.append("_token", "{{csrf_token()}}");
        form_data.append("name", $("#getName").val());
        form_data.append("session", $("#getSession").val());
        form_data.append("start_time", $("#getStartTime").val());
        form_data.append("end_time", $("#getEndTime").val());
        $.ajax({
            type: "post",
            url: "/admin/school-year",
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
