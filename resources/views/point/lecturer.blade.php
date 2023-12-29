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
					<h3 class="box-title">Điểm theo lớp</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					@if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->position == 'Administrators')
					<div style="margin-bottom: 30px;">
						<a href="/admin/new/credit-class" data-toggle="modal" class="btn btn-success btn-add">Thêm mới</a>
					</div>
					@endif
					<table id="list-data" class="table table-bordered table-striped" style="margin-top : 10px;">
						<thead>
							<tr>
								<th class="col-sm-1 text-center">Mã lớp</th>
								<th class="col-sm-1 text-center">Tên lớp</th>
								<th class="col-sm-1 text-center">Năm học</th>
								<th class="col-sm-1 text-center">Môn học</th>
								<th class="col-sm-1 text-center">Khoa</th>
								@if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->position != 'Student')
								<th class="col-sm-1 text-center">Xử lý điểm</th>
								@endif
							</tr>
						</thead>
						<tbody>
							@foreach ($data as $value)
							<tr>
								<td class="col-sm-1 text-center">{{$value->code}}</td>
								<td class="col-sm-1 text-center">{{$value->name}}</td>
								<td class="col-sm-1 text-center">{{$value->schoolYears->name}}</td>
								<td class="col-sm-1 text-center">{{$value->subjects->name}}</td>	
								<td class="col-sm-1 text-center">{{$value->faculties->name}}</td>							
								@if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->position != 'Student')
								<td class="col-sm-1 text-center">
									<a href="/admin/manage/point/{{$value->id}}" type="button" class="btn btn-warning" >
										<i class="glyphicon glyphicon-edit"></i>
									</a>
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

	<script type="text/javascript" src="{{asset('home/js/sweetalert.min.js')}}"></script>
</section>
<!-- /.content -->
@endsection