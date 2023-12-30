@extends('layouts.master_admin') 

@section('controll')
New Student
@endsection

@section('content')

<div class="container box box-body pad">
	<div class="row">
		<div class="col-xs-12">
			<div class="alert alert-danger error-msg" style="display:none">
				<ul></ul>
			</div>

			<div class="alert alert-success success-msg" style="display:none">
				<ul></ul>
			</div>

			<div class="alert alert-warning unsuccess-msg" style="display:none">
				<ul></ul>
			</div>
		</div>

		<div class="col-xs-12">

			<div class="box-header">
				<h3 class="box-title">Tài khoản sinh viên</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				@csrf
				<div class="form-group">
					<label for="" style="margin-top: 10px;">Tên đăng nhập</label>
					<input name="username" type="text" class="form-control" id="username" placeholder="Ví dụ : Phan_Khanh_Hung"><br>

					<label for="" style="margin-top: 10px;">Mật khẩu</label>
					<input name="password" type="password" class="form-control" id="password" placeholder="Mật khẩu"><br>

					<label for="" style="margin-top: 10px;">Bộ môn</label>
					<select id="getFacultyId" class="form-control select2" style="width: 100%; margin-top: 0px;">
						@if(isset($faculties))
							@foreach($faculties as $value)
								<option selected="selected" value="{{$value->id}}">{{$value->name}}</option>
							@endforeach
						@endif
					</select>

					<label for="" style="margin-top: 20px;">Lớp chuyên ngành</label>
					<select id="getClassId" class="form-control select2" style="width: 100%; margin-top: 0px;">
						@if(isset($classes))
							@foreach($classes as $value)
								<option selected="selected" value="{{$value->id}}">{{$value->name}}</option>
							@endforeach
						@endif
					</select>

					<label for="" style="margin-top: 10px;">Mã sinh viên</label>
					<input name="code" type="text" class="form-control" id="code" placeholder="Ví dụ : 20206789"><br>

					<label for="" style="margin-top: 10px;">Họ & tên đệm</label>
					<input name="first_name" type="text" class="form-control" id="first_name" placeholder="Ví dụ : Hưng"><br>

					<label for="" style="margin-top: 10px;">Tên</label>
					<input name="last_name" type="text" class="form-control" id="last_name" placeholder="Ví dụ : Hưng"><br>

					<label for="" style="margin-top: 10px;">Ảnh sinh viên</label>
					<input name="image" type="file" class="form-control" id="getImage" placeholder="Image" onchange="readURL(this);"><br>
					<div style="text-align : center; margin-top : 10px; margin-botom : 10px;">
						<img id="thumbnail" src="#" alt=""/>
					</div>
					<script>
						function readURL(input) {
							if (input.files && input.files[0]) {
								var reader = new FileReader();

								reader.onload = function (e) {
									$('#thumbnail')
										.attr('src', e.target.result)
										.width(150)
										.height(150);
								};

								reader.readAsDataURL(input.files[0]);
							}
						}
					</script>
						
					<label for="" style="margin-top: 10px;">Ngày sinh</label>
					<div class="input-group date">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input type="text" class="form-control pull-right" id="datepicker">
					</div>       

					<label for="" style="margin-top: 30px;">Giới tính</label>
					<select name="gender" class="form-control" id="gender">
						<option value="0">Nữ</option>
						<option value="1">Nam</option>
						<option value="2">Khác</option>
					</select><br>
						
					<label for="" style="margin-top: 10px;">Số điện thoại</label>
					<input name="phone" type="text" class="form-control" id="phone" placeholder="Ví dụ : 0982668926"><br>

					<label for="" style="margin-top: 10px;">Email</label>
					<input name="email" type="text" class="form-control" id="email" placeholder="Ví dụ : hungpk@gmail.com"><br>

					<label for="" style="margin-top: 10px;">Địa chỉ</label>
					<input name="address" type="text" class="form-control" id="address" placeholder="Số 169 Trương Định - Hai Bà Trưng - Hà Nội"><br>

					<label for="" style="margin-top: 10px;">Ghi chú & Mô tả</label>
					<input name="description" type="text" class="form-control" id="description" placeholder="Ghi chú & Mô tả"><br>

					<button type="button" class="btn btn-success btn-save" >Đăng ký</button>

					<a href="/admin/student" class="btn btn-danger">Hủy bỏ</a>
				</div>
			</div>

		</div>
	</div>
</div>

<script type="text/javascript">
    $(function () {
        //Date picker
        $('#datepicker').datepicker({
        autoclose: true
        });
    })
</script>

<script type="text/javascript">

	$('.btn-save').click(function(){
		var form_data = new FormData();
		form_data.append("_token", '{{csrf_token()}}');
		form_data.append("username", $('#username').val());
		form_data.append("password", $('#password').val());
		form_data.append("faculty_id", $('#getFacultyId').val());
		form_data.append("class_id", $('#getClassId').val());
		form_data.append("code", $('#code').val());
		form_data.append("first_name", $('#first_name').val());
		form_data.append("last_name", $('#last_name').val());

        form_data.append('avatar', $('input[type=file]')[0].files[0]);
        form_data.append("birthday", $('#datepicker').val());
        form_data.append("gender", $('#gender').val());
        form_data.append("phone", $('#phone').val());
        form_data.append("email", $('#email').val());
        form_data.append("address", $('#address').val());
		form_data.append("description", $('#description').val());

		form_data.append("position", 'Student');

		$.ajax({
			type : 'post',
			url : '/admin/student',
			data : form_data,
			dataType : 'json',
			contentType: false,
			processData: false,
			success : function(response){
				switch(response.is){
					case 'failed':
						$(".error-msg").find("ul").html('');
						$(".error-msg").css('display','block');
						$(".success-msg").css('display','none');
						$(".unsuccess-msg").css('display','none');
						$.each(response.error, function( key, value ) {
							$(".error-msg").find("ul").append('<li>'+value+'</li>');
						});
						break;
					case 'success':
						$(".success-msg").find("ul").html('');
						$(".success-msg").css('display','block');
						$(".error-msg").css('display','none');
						$(".unsuccess-msg").css('display','none');
						$(".success-msg").find("ul").append('<li>'+response.complete+'</li>');
						break;
					case 'unsuccess':
						$(".unsuccess-msg").find("ul").html('');
						$(".unsuccess-msg").css('display','block');
						$(".error-msg").css('display','none');
						$(".success-msg").css('display','none');
						$(".unsuccess-msg").find("ul").append('<li>'+response.unsuccess+'</li>');
						break;
				}
				window.scroll({
					top: 0,
					behavior: 'smooth'
				});
			}
		});
	});
</script>
@endsection