@extends('layouts.master_admin')

{{-- thay đổi nội dung phần controll --}}
@section('controll')
Register Class List
@endsection

{{-- thay đổi nội dung phần content --}}
@section('content')
<!-- Main content -->
<section class="content">
	@csrf
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Danh sách đăng ký</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					@if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->position == 'Administrators')
					<div style="margin-bottom: 30px;">
						<a href="/admin/register/credit-class" data-toggle="modal" class="btn btn-success btn-add">Đăng ký lớp</a>
					</div>
					@endif
					<table id="list-data" class="table table-bordered table-striped" style="margin-top : 10px;">
						<thead>
							<tr>
								<th class="col-sm-1 text-center">Mã lớp</th>
								<th class="col-sm-2 text-center">Tên lớp</th>
								<th class="col-sm-2 text-center">Bộ môn</th>
								<th class="col-sm-2 text-center">Sinh viên</th>
								<th class="col-sm-1 text-center">Mã sinh viên</th>
								<th class="col-sm-2 text-center">Thời điểm đăng ký</th>
								@if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->position == 'Administrators')
								<th class="col-sm-2 text-center">Hành động</th>
								@endif
							</tr>
						</thead>
						<tbody>
							@foreach ($data as $value)
							<tr>
								<td class="col-sm-1 text-center">{{$value->creditClass->code}}</td>
								<td class="col-sm-2 text-center">{{$value->creditClass->name}}</td>
								<td class="col-sm-2 text-center">{{$value->creditClass->faculties->name}}</td>
								<td class="col-sm-2 text-center">{{$value->students->account->first_name}} {{$value->students->account->last_name}}</td>
								<td class="col-sm-2 text-center">{{$value->students->account->code}}</td>
								<td class="col-sm-2 text-center">{{$value->registered_at}}</td>
								@if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->position == 'Administrators')
								<td class="col-sm-2 text-center">
									<button data-student-id="{{$value->student_id}}" data-class-id="{{$value->credit_class_id}}" type="button" class="btn btn-danger btn-delete">
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
		// delete
		$('.btn-delete').click(function() {
			if (confirm('Bạn có muốn xóa không?')) {
				var _this = $(this);
				var student_id = $(this).attr('data-student-id');
				$.ajax({
					type: 'post',
					url: '/admin/register/class/delete',
					data: {
						_token: $('[name="_token"]').val(),
						student_id,
						credit_class_id: $(this).attr('data-class-id'),
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
								window.location.href = "/admin/register-class/";
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