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
					<h3 class="box-title">Số sinh viên theo lớp</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table id="list-data" class="table table-bordered table-striped" style="margin-top : 10px;">
						<thead>
							<tr>
								<th class="col-sm-1 text-center">Năm học</th>
								<th class="col-sm-1 text-center">Bộ môn</th>
								<th class="col-sm-1 text-center">Mã lớp</th>
								<th class="col-sm-1 text-center">Tên lớp</th>
								<th class="col-sm-1 text-center">Môn học</th>
								<th class="col-sm-1 text-center">Giảng viên</th>
								<th class="col-sm-1 text-center">Số sinh viên</th>
								<th class="col-sm-1 text-center">Danh sách sinh viên</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($data as $value)
							<tr>
								<td class="col-sm-1 text-center">{{$value->school_year_name}}</td>
								<td class="col-sm-1 text-center">{{$value->faculty_name}}</td>
								<td class="col-sm-1 text-center">{{$value->code}}</td>
								<td class="col-sm-1 text-center">{{$value->subject_name}}</td>
								<td class="col-sm-1 text-center">{{$value->subject_name}}</td>
								<td class="col-sm-1 text-center">{{$value->lecturer_name}}</td>								
								<td class="col-sm-1 text-center">{{$value->total_students}}</td>
								<td class="col-sm-1 text-center">
									<a href="/admin/report/student/credit-class/{{$value->id}}" type="button" class="btn btn-info" >
										<i class="glyphicon glyphicon-eye-open"></i>
									</a>
								</td>
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
		<div class="modal fade" id="showCreditClass" tabindex="-1" role="dialog" aria-labelledby="formFillData" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content" style="border-radius : 10px;">
					<div class="modal-header">
						<h4 class="modal-title">Thông tin </h4>
					</div>
					<form action="" id="">
						@csrf
						<div class="modal-body">
							<input name="name" type="text" class="form-control" id="showName" placeholder="Tên lớp" disabled><br>
							<input name="code" type="text" class="form-control" id="showCode" placeholder="Mã lớp học" disabled><br>
							<input name="start_time" type="text" class="form-control" id="showStartTime" placeholder="Thời gian vào học" disabled><br>
							<input name="end_time" type="text" class="form-control" id="showEndTime" placeholder="Thời gian kết thúc" disabled><br>
						</div>

						<div class="modal-footer">
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
				url: "/admin/report/stduent/credit-class/" + id,
				data: {
					_token: $('[name="_token"]').val(),
				},
				success: function(response) {
					$('#showId').val(response.id);
					$('#showName').val(response.name);
					$('#showStartTime').val(response.start_time);
					$('#showCode').val(response.code);
					$('#showEndTime').val(response.end_time);
				}
			});

			$('#showCreditClass').modal('show');
		});
	</script>

	<script type="text/javascript" src="{{asset('home/js/sweetalert.min.js')}}"></script>
</section>
<!-- /.content -->
@endsection