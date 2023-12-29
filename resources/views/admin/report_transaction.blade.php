@extends('layouts.master_admin') 

@section('controll')
Transactions List
@endsection

@section('content')
<!-- Main content -->
<section class="content">
	@csrf
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Danh sách giao dịch</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div style="margin-bottom: 30px;">
						@if(isset($from_date))
							<div class="col-xs-3">
								<label for="">Từ ngày</label>
								<div class="input-group date">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input class="form-control pull-right" id="getFromDate" type="date" data-date="" placeholder = "MM/DD/YYYY" value = {{$from_date}}>
								</div><br>
							</div>
						@else
							<div class="col-xs-3">
								<label for="">Từ ngày</label>
								<div class="input-group date">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input class="form-control pull-right" id="getFromDate" type="date" data-date="" placeholder = "MM/DD/YYYY" value = {{Carbon\Carbon::now()->format('Y-m-d')}}>
								</div><br>
							</div>						
						@endif
						@if(isset($to_date))
							<div class="col-xs-3">
								<label for="">Đến ngày</label>
								<div class="input-group date">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input class="form-control pull-right" id="getToDate" type="date" data-date="" placeholder = "MM/DD/YYYY" value = {{$to_date}}>
								</div><br>
							</div>
						@else
							<div class="col-xs-3">
								<label for="">Đến ngày</label>
								<div class="input-group date">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input class="form-control pull-right" id="getToDate" type="date" data-date="" placeholder = "MM/DD/YYYY" value = {{Carbon\Carbon::now()->format('Y-m-d')}}>
								</div><br>
							</div>
						@endif
						@if(isset($status))
							<div class="col-xs-3">
								<label for="">Trạng thái</label>
								<select name="transaction_statuses[]" id="select-state-transaction-status" class="form-control" style="width: 100%; margin-top: 0px;">
									@if($status == -1)
									<option selected class="isblue" value=-1>Tất cả</option>
									<option class="isblue" value=0>Đang chờ</option>
									<option class="isblue" value=1>Đang giao</option>
									<option class="isblue" value=2>Đã giao</option>
									<option class="isblue" value=3>Đã hủy</option>	
									@elseif($status == 0)
									<option class="isblue" value=-1>Tất cả</option>
									<option selected class="isblue" value=0>Đang chờ</option>
									<option class="isblue" value=1>Đang giao</option>
									<option class="isblue" value=2>Đã giao</option>
									<option class="isblue" value=3>Đã hủy</option>
									@elseif($status == 1)
									<option class="isblue" value=-1>Tất cả</option>
									<option class="isblue" value=0>Đang chờ</option>
									<option selected class="isblue" value=1>Đang giao</option>
									<option class="isblue" value=2>Đã giao</option>
									<option class="isblue" value=3>Đã hủy</option>
									@elseif($status == 2)
									<option class="isblue" value=-1>Tất cả</option>
									<option class="isblue" value=0>Đang chờ</option>
									<option class="isblue" value=1>Đang giao</option>
									<option selected class="isblue" value=2>Đã giao</option>
									<option class="isblue" value=3>Đã hủy</option>
									@elseif($status == 3)
									<option class="isblue" value=-1>Tất cả</option>
									<option class="isblue" value=0>Đang chờ</option>
									<option class="isblue" value=1>Đang giao</option>
									<option class="isblue" value=2>Đã giao</option>
									<option selected class="isblue" value=3>Đã hủy</option>
									@endif
								</select><br>
								<script>
									$('#select-state-transaction-status').selectize({
										maxItems: 1,
										closeAfterSelect:true,
										highlight:true,
										selectOnTab:true,
									});
								</script>
								<br>
							</div>
						@else
							<div class="col-xs-3">
								<label for="">Trạng thái</label>
								<select name="transaction_statuses[]" id="select-state-transaction-status" class="form-control" style="width: 100%; margin-top: 0px;">
									<option class="isblue" value=-1>Tất cả</option>
									<option class="isblue" value=0>Đang chờ</option>
									<option class="isblue" value=1>Đang giao</option>
									<option class="isblue" value=2>Đã giao</option>
									<option class="isblue" value=3>Đã hủy</option>
								</select><br>
								<script>
									$('#select-state-transaction-status').selectize({
										maxItems: 1,
										closeAfterSelect:true,
										highlight:true,
										selectOnTab:true,
									});
								</script>
								<br>
							</div>
						@endif				
						<div class="col-xs-3">
							<button type="button" class="btn btn-info btn-search" style="margin-top: 25px;">Tìm kiếm</button>
						</div>				

					</div>
					<br>
					<table id="list-transactions" class="table table-bordered table-striped" style="margin-top : 10px;">
						<thead>
							<tr>
							<th class="col-sm-2" style="text-align: center;">Mã đơn hàng</th>
							<th class="col-sm-2" style="text-align: center;">Họ và tên</th>
							<th class="col-sm-2" style="text-align: center;">Số điện thoại</th>
							<th class="col-sm-2" style="text-align: center;">Thời gian đặt hàng</th>
							<th class="col-sm-2" style="text-align: center;">Tổng thanh toán</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($transactions))
							@foreach ($transactions as $value)
							<tr>
							<td class="col-sm-2"><a href="/admin/transaction/{{$value->order_id}}">{{$value->order_id}}</a></td>
							<td class="col-sm-2">{{$value->name}}</td>
							<td class="col-sm-2" style="text-align: right;">{{$value->phone_number}}</td>
							<td class="col-sm-2" style="text-align: right;">{{$value->created_at}}</td>
							<td class="col-sm-2" style="text-align: right;">{{number_format(($value->amount+$value->score_awards)*1000 ,0 ,'.' ,'.')}} VND</td>
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
    		$('#list-transactions').DataTable( {
    			"lengthMenu": [[30, 50, 100, 500, -1],[30, 50, 100, 500, "All"]],
				"ordering": false
    		} );
    	} );
    </script>

	<script type="text/javascript">
		// search
		$('.btn-search').click(function(){
			// var form_data = new FormData();
			// form_data.append("from_date", $('#getFromDate').val());
			// form_data.append("to_date", $('#getToDate').val());
			// form_data.append("status", $('select[name="transaction_statuses[]"]').val());
			var from_date = $('#getFromDate').val();
			var to_date = $('#getToDate').val();
			var status = $('select[name="transaction_statuses[]"]').val();
			$.ajax({
				type: 'post',
				// url: '/report_transaction/search',
				url: '/admin/report_transaction/from_date=' + from_date + '&to_date=' + to_date + '&status=' + status,
				data:{
					_token :$('[name="_token"]').val(),
					from_date : from_date,
					to_date : to_date,
					status : status,
				},
				success: function(response){
					setTimeout(function() {
						// window.location.href = "/report_transaction/search";
						window.location.href = "/admin/report_transaction/from_date=" + from_date + "&to_date=" + to_date + "&status=" + status;
					}, 1000);
				}
			});
		});
	</script>
	<script type="text/javascript" src="{{asset('home/js/sweetalert.min.js')}}"></script>
</section>
<!-- /.content -->
@endsection