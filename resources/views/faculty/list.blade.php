@extends('layouts.master_admin')

{{-- thay đổi nội dung phần controll --}}
@section('controll')
School Years List
@endsection

{{-- thay đổi nội dung phần content --}}
@section('content')
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Danh sách khoa</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					@if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->position == 'Administrators')
					<div style="margin-bottom: 30px;">
						<a href="/admin/new/faculty" data-toggle="modal" class="btn btn-success btn-add">Thêm mới</a>
					</div>
					@endif
					<table id="list-data" class="table table-bordered table-striped" style="margin-top : 10px;">
						<thead>
							<tr>
								<th class="col-sm-2 text-center">STT</th>
								<th class="col-sm-2 text-center">Tên khoa</th>
								<th class="col-sm-2 text-center">Mô tả</th>
								@if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->position == 'Administrators')
								<th class="col-sm-2 text-center">Hành động</th>
								@endif
							</tr>
						</thead>
						<tbody>
							@foreach ($data as $key => $value)
							<tr>
								<td class="col-sm-2 text-center">{{$key+1}}</td>
								<td class="col-sm-2 text-center">{{$value->name}}</td>
								<td class="col-sm-2 text-center">{{$value->description}}</td>
								@if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->position == 'Administrators')
								<td class="col-sm-2 text-center">
									<button data-id="{{$value->id}}" type="button" class="btn btn-primary btn-show">
										<i class="glyphicon glyphicon-eye-open"></i>
									</button>

									<button data-id="{{$value->id}}" type="button" class="btn btn-warning btn-edit">
										<i class="glyphicon glyphicon-edit"></i>
									</button>

									<button data-id="{{$value->id}}" type="button" class="btn btn-danger btn-delete">
										<i class="glyphicon glyphicon-trash"></i>
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

	<!-- modal view -->
	<div class="col-xs-12">
		<div class="modal fade" id="showFaculty" tabindex="-1" role="dialog" aria-labelledby="formFillData" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content" style="border-radius : 10px;">
					<div class="modal-header">
						<h4 class="modal-title">Thông tin </h4>
					</div>
					<form action="" id="">
						@csrf
						<div class="modal-body">
							<input name="name" type="text" class="form-control" id="showName" placeholder="Khoa" disabled><br>
							<input name="description" type="text" class="form-control" id="showDescription" placeholder="Mô tả" disabled><br>
						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- modal edit -->
	<div class="col-xs-12">
		<div class="modal fade" id="editFaculty" tabindex="-1" role="dialog" aria-labelledby="formFillData" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content" style="border-radius : 10px;">
					<div class="modal-header">
						<h4 class="modal-title">Cập nhật thông tin</h4>
					</div>
					<form action="" id="formEditFaculty">
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
							<input name="id" type="text" class="form-control" id="editId" placeholder="Id" disabled><br>
							<input name="name" type="text" class="form-control" id="editName" placeholder="Năm học"><br>
							<input name="description" type="text" class="form-control" id="editDescription" placeholder="Mô tả"><br>
						</div>

						<div class="modal-footer">
							<button type="submit" class="btn btn-success btn-update" data-dismiss="modal">Cập nhật</button>
							<button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			$('#list-data').DataTable( {
				"lengthMenu": [[5, 10, 25, 50], [5, 10, 15, 25, "All"]],
				
				"language": {
					"lengthMenu": "Hiển thị _MENU_ bản ghi",
					"zeroRecords": "Xin lỗi không tìm thấy bản ghi",
					"info": "Hiển thị _PAGE_ trên tổng số _PAGES_",
					"infoEmpty": "Không có bản ghi nào",
					"infoFiltered": "(filtered from _MAX_ total records)",
					"search":         "Tìm kiếm:",
					"paginate": {
						"first":      "Đầu",
						"last":       "Cuối",
						"next":       "Tiếp",
						"previous":   "Trước"
					},
				}
			} );
		} );
	</script>

	<script type="text/javascript">
		// show
		$('.btn-show').click(function() {
			var id = $(this).attr('data-id');
			$.ajax({
				type: "get",
				url: "/admin/faculty/" + id,
				data: {
					_token: $('[name="_token"]').val(),
				},
				success: function(response) {
					$('#showId').val(response.id),
					$('#showName').val(response.name),
					$('#showDescription').val(response.description)
				}
			});

			$('#showFaculty').modal('show');
		});

		$('.btn-edit').click(function() {
			var id = $(this).attr('data-id');
			$.ajax({
				type: "get",
				url: "/admin/faculty/" + id,
				data: {
					_token: $('[name="_token"]').val(),
				},
				success: function(response) {
					$('#editId').val(response.id),
					$('#editName').val(response.name),
					$('#editDescription').val(response.description)
				}
			});
			$('#editFaculty').modal('show');
		});

		$('.btn-update').click(function() {
			var id = $('#editId').val();
			$.ajax({
				type: 'put',
				url: '/admin/faculty/' + id,
				data: {
					_token: $('[name="_token"]').val(),
					id: $('#editId').val(),
					name: $('#editName').val(),
					description: $('#editDescription').val(),
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
					}
					else if (response.is === 'success') {
						swal({
							title: "Hoàn thành!",
							text: response.complete,
							icon: "success",
							buttons: true,
							buttons: ["Ok"],
							timer: 1000
						});

						setTimeout(function() {
							window.location.href = "/admin/faculty";
						}, 1000);
					}
					else if (response.is === 'unsuccess') {
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

		// delete
		$('.btn-delete').click(function() {
			if (confirm('Bạn có muốn xóa không?')) {
				var _this = $(this);
				var id = $(this).attr('data-id');
				$.ajax({
					type: 'delete',
					url: '/admin/faculty/' + id,
					data: {
						_token: $('[name="_token"]').val(),
					},
					success: function(response) {
						if (response.is === 'success') {
							_this.parent().parent().remove();
							swal({
								title: "Hoàn thành!",
								text: response.complete,
								icon: "success",
								buttons: true,
								buttons: ["Ok"],
								timer: 1000
							});
							setTimeout(function() {
								window.location.href = "/admin/faculty/";
							}, 1000);
						}
						else if (response.is === 'unsuccess') {
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
				})
			}
		});
	</script>

	<script type="text/javascript" src="{{asset('home/js/sweetalert.min.js')}}"></script>
</section>
<!-- /.content -->
@endsection