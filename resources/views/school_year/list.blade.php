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
					<h3 class="box-title">Danh sách kì học</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					@if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->position == 'Administrators')
					<div style="margin-bottom: 30px;">
						<a href="/admin/new/school-year" data-toggle="modal" class="btn btn-success btn-add">Thêm mới</a>
					</div>
					@endif
					<table id="list-data" class="table table-bordered table-striped" style="margin-top : 10px;">
						<thead>
							<tr>
								<th class="col-sm-2 text-center">STT</th>
								<th class="col-sm-2 text-center">Năm học</th>
								<th class="col-sm-2 text-center">Kì học</th>
								<th class="col-sm-2 text-center">Thời điểm bắt đầu</th>
								<th class="col-sm-2 text-center">Thời điểm kết thúc</th>
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
								<td class="col-sm-2 text-center">{{$value->session}}</td>
								<td class="col-sm-2 text-center">{{$value->start_time}}</td>
								<td class="col-sm-2 text-center">{{$value->end_time}}</td>
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
		<div class="modal fade" id="showSchoolYear" tabindex="-1" role="dialog" aria-labelledby="formFillData" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content" style="border-radius : 10px;">
					<div class="modal-header">
						<h4 class="modal-title">Thông tin </h4>
					</div>
					<form action="" id="">
						@csrf
						<div class="modal-body">
							<input name="name" type="text" class="form-control" id="showName" placeholder="Năm học" disabled><br>
							<input name="session" type="text" class="form-control" id="showSession" placeholder="Kì học" disabled><br>
							<input name="start_time" type="text" class="form-control" id="showStartTime" placeholder="Thời điểm bắt đầu" disabled><br>
							<input name="end_time" type="text" class="form-control" id="showEndTime" placeholder="Thời điểm kết thúc" disabled><br>
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
		<div class="modal fade" id="editSchoolYear" tabindex="-1" role="dialog" aria-labelledby="formFillData" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content" style="border-radius : 10px;">
					<div class="modal-header">
						<h4 class="modal-title">Cập nhật thông tin</h4>
					</div>
					<form action="" id="formEditSchoolYear">
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
							<input name="session" type="text" class="form-control" id="editSession" placeholder="Kì học"><br>
							<input name="start_time" type="text" class="form-control" id="editStartTime" placeholder="Thời điểm bắt đầu"><br>
							<input name="end_time" type="text" class="form-control" id="editEndTime" placeholder="Thời điểm kết thúc"><br>
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
				url: "/admin/school-year/" + id,
				data: {
					_token: $('[name="_token"]').val(),
				},
				success: function(response) {
					$('#showId').val(response.id),
					$('#showName').val(response.name),
					$('#showSession').val(response.session),
					$('#showStartTime').val(response.start_time),
					$('#showEndTime').val(response.end_time)
				}
			});

			$('#showSchoolYear').modal('show');
		});

		$('.btn-edit').click(function() {
			var id = $(this).attr('data-id');
			$.ajax({
				type: "get",
				url: "/admin/school-year/" + id,
				data: {
					_token: $('[name="_token"]').val(),
				},
				success: function(response) {
					$('#editId').val(response.id),
					$('#editName').val(response.name),
					$('#editSession').val(response.session),
					$('#editStartTime').val(response.start_time),
					$('#editEndTime').val(response.end_time)
				}
			});
			$('#editSchoolYear').modal('show');
		});

		$('.btn-update').click(function() {
			var id = $('#editId').val();
			$.ajax({
				type: 'put',
				url: '/admin/school-year/' + id,
				data: {
					_token: $('[name="_token"]').val(),
					id: $('#editId').val(),
					name: $('#editName').val(),
					session: $('#editSession').val(),
					start_time: $('#editStartTime').val(),
					end_time: $('#editEndTime').val()
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
							window.location.href = "/admin/school-year";
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
					url: '/admin/school-year/' + id,
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
								window.location.href = "/admin/school-year/";
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