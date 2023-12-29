@extends('layouts.master_admin') 

@section('controll')
users List
@endsection

@section('content')
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Danh sách sinh viên</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					@csrf
					<table id="list-collaborators" class="table table-bordered table-striped" style="margin-top : 10px;">
						<thead>
							<tr>
								<th class="col-sm-1 text-center">Ảnh</th>
								<th class="col-sm-1 text-center">Tên sinh viên</th>
								<th class="col-sm-1 text-center">Email</th>
								<th class="col-sm-1 text-center">Số điện thoại</th>
								<th class="col-sm-1 text-center">Ngày sinh</th>
								<th class="col-sm-1 text-center">Địa chỉ</th>
								<th class="col-sm-1 text-center">Lớp chuyên ngành</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($data as $value)
							<tr>
								<td class="col-sm-1 text-center">
									<div>
										<img style="width: 40px; height: 40px; border-radius: 100%;" src="{{url('images/accounts/'.$value->avatar)}}" alt="">
									</div>
								</td>
								<td class="col-sm-1 text-center">{{$value->student_name}}</td>
								<td class="col-sm-1 text-center">{{$value->email}}</td>
								<td class="col-sm-1 text-center">{{$value->phone}}</td>
								<td class="col-sm-1 text-center">{{$value->birthday}}</td>
								<td class="col-sm-1 text-center">{{$value->address}}</td>
								<td class="col-sm-1 text-center">{{$value->class_name}}</td>
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
			$('#list-collaborators').DataTable( {
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