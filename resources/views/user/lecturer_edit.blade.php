@extends('layouts.master_admin') 

@section('controll')
User Detail
@endsection

@section('content')

<script src="{{ asset("layout_user/plugins/selectize.min.js") }}"></script>
<link rel="stylesheet" href="{{ asset("layout_user/plugins/selectize.bootstrap3.min.css") }}">

<div class="container box pad">
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
		@if(isset($user))
		<div class="col-xs-12">
				<div class="box-body">
					<legend></legend>
					<div class="form-group">
						@csrf
						<input type="hidden" class="form-control" id="getUserID" value="{{ $user->id }}"><br>
						
						<label for="" style="margin-top: 10px;">Tên đăng nhập</label>
						<input name="username" type="text" class="form-control" id="username" placeholder="Ví dụ : Phan Khánh Hưng" value="{{$user->username}}"><br>

						<label for="" style="margin-top: 5px;">Bộ môn - Phòng ban</label>
						<select id="getFacultyId" class="form-control select2" style="width: 100%; margin-top: 0px;">
							@if(isset($faculties))
								@foreach($faculties as $value)
									<option selected="selected" value="{{$value->id}}">{{$value->name}}</option>
								@endforeach
							@endif
						</select>

						<label for="" style="margin-top: 20px;">Lĩnh vực nghiên cứu</label>
						<input name="field" type="field" class="form-control" id="field" placeholder="Lĩnh vực nghiên cứu" value="{{$user->field}}"><br>

						<label for="" style="margin-top: 10px;">Quá trình giảng dạy</label>
						<textarea name="workingProcess" id="getWorkingProcess" rows="20" cols="100">
							{{$user->working_process}}
						</textarea>
						<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
						<script>
							var workingProcess = CKEDITOR.replace( 'workingProcess', {
								filebrowserBrowseUrl: '{{ asset('ckfinder/ckfinder.html') }}',
								filebrowserImageBrowseUrl: '{{ asset('ckfinder/ckfinder.html?type=Images') }}',
								filebrowserFlashBrowseUrl: '{{ asset('ckfinder/ckfinder.html?type=Flash') }}',
								filebrowserUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files') }}',
								filebrowserImageUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images') }}',
								filebrowserFlashUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash') }}'
							} );
						</script>

						<label for="" style="margin-top: 20px;">Lớp chủ nhiệm</label>
						<select id="getClassId" class="form-control select2" style="width: 100%; margin-top: 0px;">
							@if(isset($classes))
								@foreach($classes as $value)
									@if ($value->id == $user->class_id)
										<option selected="selected" value="{{$value->id}}">{{$value->name}}</option>
									@else
										<option value="{{$value->id}}">{{$value->name}}</option>
									@endif
								@endforeach
							@endif
						</select>

						<label for="" style="margin-top: 10px;">Mã giảng viên</label>
						<input name="code" type="text" class="form-control" id="code" placeholder="Ví dụ : 20206789" value="{{$user->code}}"><br>

						<label for="" style="margin-top: 10px;">Họ & tên đệm</label>
						<input name="first_name" type="text" class="form-control" id="first_name" placeholder="Ví dụ : Hưng" value="{{$user->first_name}}"><br>

						<label for="" style="margin-top: 10px;">Tên</label>
						<input name="last_name" type="text" class="form-control" id="last_name" placeholder="Ví dụ : Hưng" value="{{$user->last_name}}"><br>


						<label for="" style="margin-top: 10px;">Ảnh giảng viên</label>
						<input name="image" type="file" class="form-control" id="getAvatar" placeholder="Image" onchange="readURL(this);"><br>
						<div style="text-align : center; margin-top : 10px; margin-botom : 10px;">
							<img id="thumbnail" src="#" alt=""/>
						</div>
						<script>
							var user_avatar = "<?php echo $user->avatar ?>";
							$('#thumbnail').attr('src', '/images/accounts/'+user_avatar).width(150).height(150);
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
							<input class="form-control pull-right" id="birthday" type="date" data-date="" value="{{$user->birthday}}">
						</div>

						<label for="" style="margin-top: 10px;">Giới tính</label>
						<div class="input-box">
							<select name="gender" id="gender" class="form-control pull-right">
								@if($user->gender=='Female'){
								<option value="Female" selected>Nữ</option>
								<option value="Male">Nam</option>
								<option value="Other">Khác</option>
								}
								@elseif($user->gender=='Male'){
								<option value="Female">Nữ</option>
								<option value="Male" selected>Nam</option>
								<option value="Other">Khác</option>
								}
								@else{
								<option value="Female">Nữ</option>
								<option value="Male">Nam</option>
								<option value="Other" selected>Khác</option>
								}
								@endif
							</select><br>
						</div><br>
							
						<label for="" style="margin-top: 10px;">Số điện thoại</label>
						<input name="phone" type="text" class="form-control" id="phone" placeholder="Ví dụ : 0982668926" value="{{$user->phone}}"><br>

						<label for="" style="margin-top: 10px;">Email</label>
						<input name="email" type="text" class="form-control" id="email" placeholder="Ví dụ : hungpk@gmail.com" value="{{$user->email}}" disable><br>

						<label for="" style="margin-top: 10px;">Địa chỉ</label>
						<input name="address" type="text" class="form-control" id="address" placeholder="Số 169 Trương Định - Hai Bà Trưng - Hà Nội" value="{{$user->address}}"><br>
						
						<label for="" style="margin-top: 10px;">Ghi chú & Mô tả</label>
						<input name="description" type="description" class="form-control" id="description" placeholder="Ghi chú & Mô tả" value="{{$user->description}}"><br>

						</div>
					<button type="button" class="btn btn-primary btn-save">Cập nhật</button>
				</div>
		</div>
		@endif
	</div>

	<script type="text/javascript">
		$('.btn-save').click(function(){
			var form_data = new FormData();
			form_data.append("_token", '{{csrf_token()}}');
			form_data.append("id", $('#getUserID').val());
			if($('input[type=file]')[0].files[0]){
				form_data.append('avatar', $('input[type=file]')[0].files[0]);
			}
			
			form_data.append("username", $('#username').val());
			form_data.append("faculty_id", $('#getFacultyId').val());
			form_data.append("class_id", $('#getClassId').val());
			form_data.append("code", $('#code').val());
			form_data.append("first_name", $('#first_name').val());
			form_data.append("last_name", $('#last_name').val());

			if($('#birthday').val()){
				form_data.append("birthday", $('#birthday').val());
			}
			form_data.append("gender", $('#gender').val());
			form_data.append("phone", $('#phone').val());
			form_data.append("email", $('#email').val());
			form_data.append("address", $('#address').val());
			form_data.append("description", $('#description').val());
			form_data.append("field", $('#field').val());

			form_data.append("position", 'Lecturer');

			form_data.append("working_process", workingProcess.getData());

			$.ajax({
				type : 'post',
				url : '/admin/lecturer/update',
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