@extends('layouts.master_admin')

{{-- thay đổi nội dung phần content --}}
@section('content')
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Danh sách thông báo</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div style="margin-bottom: 30px;">
						<a href="/admin/new/notify" data-toggle="modal" class="btn btn-success btn-add">Gửi thông báo</a>
					</div>
					<table id="list-data" class="table table-bordered table-striped" style="margin-top : 10px;">
						<thead>
							<tr>
								<th class="col-sm-2 text-center">Tên lớp</th>
								<th class="col-sm-2 text-center">Tiêu đề</th>
								<th class="col-sm-2 text-center">Nội dung</th>
								<th class="col-sm-1 text-center">Thời gian</th>
								
							</tr>
						</thead>
						<tbody>
						@php Carbon\Carbon::setLocale('vi'); @endphp
							@foreach ($data as $value)
							<tr>
								<td class="col-sm-2 text-center">{{$value->creditClasses->name}}</td>
								<td class="col-sm-2 text-center">{{$value->title}}</td>
								<td class="col-sm-2 text-center">{{$value->content}}</td>
								<td class="col-sm-1 text-center">
									{{Carbon\Carbon::parse($value->created_at)->diffForHumans()}}
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

	<script type="text/javascript">
		// show
		$('.btn-show').click(function() {
			var id = $(this).attr('data-id');
			$.ajax({
				type: "get",
				url: "/admin/class/" + id,
				data: {
					_token: $('[name="_token"]').val(),
				},
				success: function(response) {
					$('#showId').val(response.id),
					$('#showName').val(response.name),
					$('#showDescription').val(response.description)
				}
			});

			$('#showClass').modal('show');
		});

		$('.btn-edit').click(function() {
			var id = $(this).attr('data-id');
			$.ajax({
				type: "get",
				url: "/admin/class/" + id,
				data: {
					_token: $('[name="_token"]').val(),
				},
				success: function(response) {
					$('#editId').val(response.id),
					$('#editName').val(response.name),
					$('#editDescription').val(response.description)
				}
			});
			$('#editClass').modal('show');
		});

		$('.btn-update').click(function() {
			var id = $('#editId').val();
			$.ajax({
				type: 'put',
				url: '/admin/class/' + id,
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
							window.location.href = "/admin/class";
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
					url: '/admin/class/' + id,
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
								window.location.href = "/admin/class/";
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