@extends('layouts.master_admin')

@section('content')
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
                <h3 class="box-title">Nhập điểm</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @csrf
                <div class="form-group">
                    <input type="hidden" class="form-control" id="getCreditClassId" value="{{ $data }}">

                    <label for="" style="margin-top: 5px;">Chọn file</label>
                    <input
                        name="file"
                        type="file"
                        class="form-control"
                        id="getFile"
                    /><br />

                    <div style="margin-top: 20px;">
                        <button type="button" class="btn btn-success btn-save">
                            Import
                        </button>
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
                window.location.href = "/admin/manage/point/{{$data}}";
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
        form_data.append('file', $('input[type=file]')[0].files[0]);
        form_data.append('credit_class_id', $("#getCreditClassId").val());
        $.ajax({
            type: "post",
            url: "/admin/import/point",
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
