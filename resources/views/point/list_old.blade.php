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
					<h3 class="box-title">Danh sách điểm</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table id="list-data" class="table table-bordered table-striped" style="margin-top : 10px;">
						<thead>
							<tr>
								<th class="col-sm-1 text-center">Mã lớp</th>
								<th class="col-sm-2 text-center">Tên lớp</th>
								<th class="col-sm-1 text-center">Mã sinh viên</th>
								<th class="col-sm-1 text-center">Sinh viên</th>
								<th class="col-sm-1 text-center">Điểm chuyên cần</th>
								<th class="col-sm-1 text-center">Điểm bài tập</th>
								<th class="col-sm-1 text-center">Điểm thực hành</th>
								<th class="col-sm-1 text-center">Điểm thi giữa kỳ</th>
								<th class="col-sm-1 text-center">Điểm thi cuối kỳ</th>
								<th class="col-sm-1 text-center">Điểm trung bình</th>
								<th class="col-sm-1 text-center">Nhập điểm</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($data as $value)
							<tr>
								<td class="col-sm-1 text-center">{{$value->creditClass->code}}</td>
								<td class="col-sm-2 text-center">{{$value->creditClass->name}}</td>
								<td class="col-sm-1 text-center">{{$value->students->account->code}}</td>
								<td class="col-sm-1 text-center">{{$value->students->account->first_name}} {{$value->students->account->last_name}}</td>
								<td class="col-sm-1 text-center">{{$value->attendance_point}}</td>
								<td class="col-sm-1 text-center">{{$value->revise_point}}</td>
								<td class="col-sm-1 text-center">{{$value->practice_point}}</td>
								<td class="col-sm-1 text-center">{{$value->middle_test_point}}</td>
								<td class="col-sm-1 text-center">{{$value->finish_test_point}}</td>
								<td class="col-sm-1 text-center">{{$value->avg_point}}</td>
								<td class="col-sm-1 text-center">
									<button data-student-id="{{$value->student_id}}" data-class-id="{{$value->credit_class_id}}" type="button" class="btn btn-info btn-edit">
										<i class="glyphicon glyphicon-edit"></i>
									</button>
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

	<script type="text/javascript" src="{{asset('home/js/sweetalert.min.js')}}"></script>
</section>
<!-- /.content -->
@endsection