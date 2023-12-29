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
					<h3 class="box-title">Điểm trung bình</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table id="list-data" class="table table-bordered table-striped" style="margin-top : 10px;">
						<thead>
							<tr>
								<th class="col-sm-1 text-center">Mã sinh viên</th>
								<th class="col-sm-1 text-center">Năm học</th>
								<th class="col-sm-1 text-center">Kỳ</th>
								<th class="col-sm-1 text-center">GPA</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($data as $value)
							<tr>
								<td class="col-sm-1 text-center">{{$student->code}}</td>
								<td class="col-sm-1 text-center">{{$value->name}}</td>
								<td class="col-sm-1 text-center">{{$value->session}}</td>
								<td class="col-sm-1 text-center">{{$value->gpa}}</td>
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