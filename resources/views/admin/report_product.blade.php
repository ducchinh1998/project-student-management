@extends('layouts.master_admin') 

@section('controll')
Products List
@endsection

@section('content')
<!-- Main content -->
<section class="content">
	@csrf
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Danh sách sản phẩm</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div style="margin-bottom: 30px;">
						@if(isset($parameter))
						@if($parameter == 'max_view')
							<div class="col-xs-3">
								<input type="radio" id="max_view" name="product" value="max_view" checked = "checked">
								<label for="max_view">Sản phẩm quan tâm nhiều</label><br>
							</div>
							<div class="col-xs-3">
								<input type="radio" id="max_bought" name="product" value="max_bought">
								<label for="max_bought">Sản phẩm mua nhiều</label><br>
							</div>
							<div class="col-xs-3">
								<input type="radio" id="sold_out" name="product" value="sold_out">
								<label for="sold_out">Sản phẩm đang hết</label>
							</div>
						@elseif($parameter == 'max_bought')
							<div class="col-xs-3">
								<input type="radio" id="max_view" name="product" value="max_view">
								<label for="max_view">Sản phẩm quan tâm nhiều</label><br>
							</div>
							<div class="col-xs-3">
								<input type="radio" id="max_bought" name="product" value="max_bought" checked = "checked">
								<label for="max_bought">Sản phẩm mua nhiều</label><br>
							</div>
							<div class="col-xs-3">
								<input type="radio" id="sold_out" name="product" value="sold_out">
								<label for="sold_out">Sản phẩm đang hết</label>
							</div>
						@elseif($parameter == 'sold_out')
							<div class="col-xs-3">
								<input type="radio" id="max_view" name="product" value="max_view">
								<label for="max_view">Sản phẩm quan tâm nhiều</label><br>
							</div>
							<div class="col-xs-3">
								<input type="radio" id="max_bought" name="product" value="max_bought">
								<label for="max_bought">Sản phẩm mua nhiều</label><br>
							</div>
							<div class="col-xs-3">
								<input type="radio" id="sold_out" name="product" value="sold_out" checked = "checked">
								<label for="sold_out">Sản phẩm đang hết</label>
							</div>
						@endif
							<div class="col-xs-3">
								<button type="button" class="btn btn-info btn-search" >Tìm kiếm</button>
							</div>
						@else
							<div class="col-xs-3">
								<input type="radio" id="max_view" name="product" value="max_view" checked = "checked">
								<label for="max_view">Sản phẩm quan tâm nhiều</label><br>
							</div>
							<div class="col-xs-3">
								<input type="radio" id="max_bought" name="product" value="max_bought">
								<label for="max_bought">Sản phẩm mua nhiều</label><br>
							</div>
							<div class="col-xs-3">
								<input type="radio" id="sold_out" name="product" value="sold_out">
								<label for="sold_out">Sản phẩm đang hết</label>
							</div>
							<div class="col-xs-3">
								<button type="button" class="btn btn-info btn-search" >Tìm kiếm</button>
							</div>
						@endif


					</div>
					<br>
					<table id="list-products" class="table table-bordered table-striped" style="margin-top : 10px;">
						<thead>
							<tr>
								<th class="col-sm-2" style="text-align: center;">Tên sản phẩm</th>
								<th class="col-sm-1" style="text-align: center;">Mã</th>
								<th class="col-sm-1" style="text-align: center;">Số lượng còn</th>
								<th class="col-sm-1" style="text-align: center;">Số lượng đã bán</th>
								<th class="col-sm-1" style="text-align: center;">Lượt xem</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($products))
							@foreach ($products as $value)
							<tr>
								<td class="col-sm-2">{{$value->name}}</td>
								<td class="col-sm-1">{{$value->code}}</td>
								<td class="col-sm-1" style="text-align: right;">{{$value->quantity}}</td>
								<td class="col-sm-1" style="text-align: right;">{{$value->bought}}</td>
								<td class="col-sm-1" style="text-align: right;">{{$value->view_count}}</td>
							</tr>
							@endforeach
							@endif
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
    		$('#list-products').DataTable( {
    			"lengthMenu": [[15, 25, -1], [15, 25, "All"]],
				"ordering": false
    		} );
    	} );
    </script>

	<script type="text/javascript">
		// search
		$('.btn-search').click(function(){
			var $radio = $('input[name=product]:checked');
			var product = $radio.val();
			var id = $radio.attr('id');
			$.ajax({
				type: 'post',
				url: '/admin/report_product/' + id,
				data:{
					_token :$('[name="_token"]').val(),
					id : id,
				},
				success: function(response){
					setTimeout(function() {
						window.location.href = "/admin/report_product/" + id;
					}, 1000);
				}
			});
		});
	</script>
	<script type="text/javascript" src="{{asset('home/js/sweetalert.min.js')}}"></script>
</section>
<!-- /.content -->
@endsection