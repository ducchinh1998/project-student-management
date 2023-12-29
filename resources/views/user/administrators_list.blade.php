@extends('layouts.master_admin') 

@section('controll')
Users List
@endsection

@section('content')
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Danh sách trợ lý phòng đào tạo</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					@csrf
					<div style="margin-bottom: 30px;">
						<a href="/admin/new/administrator" data-toggle="modal" class="btn btn-info btn-add">Thêm trợ lý phòng đào tạo</a>
					</div>
					<table id="list-collaborators" class="table table-bordered table-striped" style="margin-top : 10px;">
						<thead>
							<tr>
								<th class="col-sm-1 text-center">Tên đăng nhập</th>
								<th class="col-sm-1 text-center">Tên trợ lý phòng đào tạo</th>
								<th class="col-sm-1 text-center">Ảnh</th>
								<th class="col-sm-1 text-center">Email</th>
								<th class="col-sm-1 text-center">Số điện thoại</th>
								<th class="col-sm-1 text-center">Tham gia</th>
								<th class="col-sm-2 text-center"> Hành động</th>
							</tr>
						</thead>
						<tbody>
						    @php Carbon\Carbon::setLocale('vi'); @endphp
							@foreach ($users as $value)
							<tr>
								<td class="col-sm-1 text-center">{{$value->username}}</td>
								<td class="col-sm-1 text-center">{{$value->first_name}} {{$value->last_name}}</td>
								<td class="col-sm-1 text-center">
									<div>
										<img style="width: 40px; height: 40px; border-radius: 100%;" src="{{url('images/accounts/'.$value->avatar)}}" alt="">
									</div>
								</td>
								<td class="col-sm-1 text-center">{{$value->email}}</td>
								<td class="col-sm-1 text-center">{{$value->phone}}</td>
								<td class="col-sm-1 text-center">
									{{Carbon\Carbon::parse($value->created_at)->diffForHumans()}}
								</td>
								<td class="col-sm-2 text-center">
									<a href="/admin/administrator/{{$value->id}}" type="button" class="btn btn-warning btn-edit" >
										<i class="glyphicon glyphicon-edit"></i>
									</a>

									@if($value->status == 0)
									<button data-id="{{$value->id}}" type="button" title="Kích hoạt sử dụng" class="btn btn-warning btn-edit" >
										<i class="fa fa-unlock"></i>
									</button>
									@else
									<button data-id="{{$value->id}}" type="button" title="Tạm dừng hoạt động" class="btn btn-success btn-edit" >
										<i class="fa fa-stop-circle"></i>
									</button>
									@endif

									<button data-id="{{$value->id}}" type="button" title="Xóa" class="btn btn-danger btn-delete">
										<i class="fa fa-user-times"></i>
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

	{{-- <script>
		$(document).ready(function() {
			$('#list-collaborators').DataTable( {
				"lengthMenu": [[25, 50, 100, 500, -1], [25, 50, 100, 500, "All"]],
				"order": [[7, "desc" ]],
			} );
		} );
	</script> --}}
	<script>
		$(document).ready(function() {
			$('#list-collaborators').DataTable( {
				"lengthMenu": [[5, 10, 25, 50], [5, 10, 15, 25, "All"]],
				"order": [[7, "desc" ]],
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
		// block or unblock
		$('.btn-edit').click(function(){
			var id = $(this).attr('data-id');
			$.ajax({
				type: 'put',
				url: '/admin/administrator/' + id,
				data:{
					_token :$('[name="_token"]').val(),
					id : id,
				},
				success: function(response){
					if (response.is === 'success') {
						swal({
							title: "Hoàn thành!",
							text: response.complete,
							icon: "success",
							buttons: true,
							buttons: ["Ok"],
							timer: 1000
						});
						setTimeout(function() {
							window.location.href = "/admin/administrator/";
						}, 1000);
					}
					if (response.is === 'unsuccess') {
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
		$('.btn-delete').click(function(){
			if(confirm('Bạn có muốn xóa không?')){
				var _this = $(this);
				var id = $(this).attr('data-id');
				$.ajax({
					type: 'delete',
					url: '/admin/administrator/' + id,
					data:{
						_token : $('[name="_token"]').val(),
					},
					success: function(response){
						_this.parent().parent().remove();
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
								window.location.href = "/admin/administrator/";
							}, 1000);
						}
						if (response.is === 'unsuccess') {
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