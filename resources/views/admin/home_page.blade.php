@extends('layouts.master_admin')

@section('controll')
Trang chủ
@endsection

@section('content')
<!-- Info boxes -->
<div class="row">
	<div class="col-md-4 col-sm-6 col-xs-12">
		<div class="info-box">
			<span class="info-box-icon" style="background: #15FC01; color: #fff;">
				<i class="glyphicon glyphicon-ok-circle"></i>
			</span>

			<div class="info-box-content">
				<span class="info-box-text">
					<a href="/admin/faculty">Số lượng khoa</a></span>
				<span class="info-box-number">
					@if(count($faculities) >= 0)
					{{count($faculities)}}
					@endif
				</span>
			</div>
			<!-- /.info-box-content -->
		</div>
		<!-- /.info-box -->
	</div>
	<!-- /.col -->
	<div class="col-md-4 col-sm-6 col-xs-12">
		<div class="info-box">
			<span class="info-box-icon" style="background: #019FFA; color: #fff;">
				<i class="fa fa-cloud-upload"></i>
			</span>

			<div class="info-box-content">
				<span class="info-box-text">
					<a href="/admin/class">Số lượng lớp chuyên nghành</a>
				</span>
				<span class="info-box-number">
					@if(count($classes) >= 0)
					{{count($classes)}}
					@endif
				</span>
			</div>
			<!-- /.info-bo	x-content -->
		</div>
		<!-- /.info-box -->
	</div>
	<!-- /.col -->

	<!-- fix for small devices only -->
	<div class="clearfix visible-sm-block"></div>

	<div class="col-md-4 col-sm-6 col-xs-12">
		<div class="info-box">
			<span class="info-box-icon bg-aqua"><i class="fa fa-list-alt"></i></span>

			<div class="info-box-content">
				<span class="info-box-text">
					<a href="/admin/credit-class">Số lượng lớp tín chỉ</a>
				</span>
				<span class="info-box-number">
					@if(count($creditclass) >= 0)
					{{count($creditclass)}}
					@endif
				</span>
			</div>
			<!-- /.info-box-content -->
		</div>
		<!-- /.info-box -->
	</div>
	<!-- /.col -->
</div>

<div class="row">
	<div class="col-md-4 col-sm-6 col-xs-12">
		<div class="info-box">
			<span class="info-box-icon" style="background: #953BE1; color: #fff;">
				<i class="fa fa-user"></i>
			</span>
			<div class="info-box-content">
				<span class="info-box-text">
					<a href="/admin/lecturer">Số lượng giảng viên</a>
				</span>
				<span class="info-box-number">
					@if(count($lecturer) >= 0)
					{{count($lecturer)}}
					@endif
				</span>
			</div>
			<!-- /.info-box-content -->
		</div>
		<!-- /.info-box -->
	</div>
	<!-- /.col -->
	<div class="col-md-4 col-sm-6 col-xs-12">
		<div class="info-box">
			<span class="info-box-icon" style="background: orange; color: #fff;"><i class="fa fa-user"></i></span>

			<div class="info-box-content">
				<span class="info-box-text">
					<a href="/admin/student">Số lượng sinh viên</a>
				</span>
				<span class="info-box-number">
					@if(count($student) >= 0)
					{{count($student)}}
					@endif
				</span>
			</div>
			<!-- /.info-box-content -->
		</div>
		<!-- /.info-box -->
	</div>
	<!-- /.col -->

	<!-- fix for small devices only -->
	<div class="clearfix visible-sm-block"></div>

	<div class="col-md-4 col-sm-6 col-xs-12">
		<div class="info-box">
			<span class="info-box-icon" style="background: #DE531F; color: #fff;"><i class="fa fa-file-text"></i></span>

			<div class="info-box-content">
				<span class="info-box-text">
					<a href="/admin/subject">Số lượng môn học giảng dạy</a>
				</span>
				<span class="info-box-number">
					@if(count($subject) >= 0)
					{{count($subject)}}
					@endif
				</span>
			</div>
			<!-- /.info-box-content -->
		</div>
		<!-- /.info-box -->
	</div>
	<!-- /.col -->
</div>
<div class="row">
	<div class="col-6 col-lg-6 col-md-6 data-chart">
		<div id="char">
			<canvas id="myChart"></canvas>
		  </div>
	</div>


	 <style>
		 .container {
            color: white;
            background: linear-gradient(145deg, #2193b0, #6dd5ed);
            width: 400px;
            margin: 0 auto;
            border-radius: 5px;
            font-size: 14px;
            font-family: 'Open Sans', sans-serif;
        }
		.search-bar {
					width: 50%;
					margin: 0 auto;
					padding-top: 20px;
					display: flex;
					position: relative;
					justify-content: center;
					align-items: center;
					border-bottom: 1px solid white;
				}
		
				.search-icon {
					margin-right: 5px;
					position: absolute;
					left: 0;
				}
		
				#search-input {
					border: 0;
					outline: 0;
					padding: 3px 3px 3px 20px;
					background: transparent;
					height: 20px;
					color: white;
				}
		
				#search-input::placeholder {
					color: rgb(206,206,206);
				}
		
				.info-wrapper {
					display: flex;
					flex-direction: column;
					justify-content: center;
					align-items: center;
					height: 30vh;
					padding: 140px 50px;
				}
		
				.city-name {
					font-size: 20px;
					margin-bottom: 3px;
					margin-top: 10px;
				}
		
				.weather-state {
					font-size: 13px;
				}
		
				.weather-icon {
					width: 70px;
					height: 70px;
				}
		
				.temperature {
					font-size: 80px;
					font-weight: lighter;
					line-height: 1;
					position: relative;
				}
		
				.temperature::after {
					content: 'o';
					position: absolute;
					font-size: 30px;
				}
		
				.additional-section {
					border-top: 1px solid white;
					display: flex;
					flex-direction: column;
					padding: 15px 20px;
					font-size: 13px;
				}
		
				.additional-section .row {
					margin-bottom: 5px;
					display: flex;
				}
		
				.additional-section .item {
					display: flex;
					flex-direction: column;
					flex: 1;
				}
		
				.additional-section .item .label {
					font-weight: bold;
				}
		</style>
	{{-- Weather --}}
	<div class="col-md-5 grid-margin stretch-card mb-3">
		<div class="container">
			<div class="main-section">
				<div class="search-bar">
					<i class="fas fa-search search-icon"></i>
					<input type="text" name="search-city" id="search-input" placeholder="Tìm kiếm thành phố...">
				</div>
				<div class="info-wrapper">
					<p class="city-name">--</p>
					<p class="weather-state">--</p>
					<img src="http://openweathermap.org/img/wn/10d@2x.png" alt="weather icon" class="weather-icon">
					<p class="temperature">--</p>
				</div>
			</div>
			<div class="additional-section">
				<div class="row">
					<div class="item">
						<div class="label">MT Mọc</div>
						<div class="value sunrise">--</div>
					</div>
					<div class="item">
						<div class="label">MT Lặn</div>
						<div class="value sunset">--</div>
					</div>
				</div>
				<div class="row">
					<div class="item">
						<div class="label">Độ ẩm</div>
						<div class="value"><span class="humidity">--</span>%</div>
					</div>
					<div class="item">
						<div class="label">Gió</div>
						<div class="value"><span class="wind-speed">--</span> km/h</div>
					</div>
				</div>
			</div>
		</div>
	</div> 
</div>

<!-- firebase 15/7/2019-->
<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/3.6.1/firebase.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#config-web-app -->

<script src="{{asset('firebase/fb.js')}}"></script>

<script>
	var database = firebase.database();

	// get data
	var lastIndexOne = 0;

	var ref = firebase.database().ref('messages');

	ref.on("value", function(snapshot) {
		var value = snapshot.val();
		var htmls = [];
		$.each(value, function(index, value) {
			if (value) {
				htmls.push('<div class="item"><img src="/images/admins/' + value.avatar + '" class="offline"><p class="message"><a href="" class="name">' + value.name + '<small class="text-muted pull-right"><i class="fa fa-clock-o"></i> ' + moment(value.created_at, "YYYY-M-D H:m:s").fromNow() + '</small></a>' + value.message + '</p></div>');
			}
			lastIndexOne = index;
		});

		$('.online-messages').html(htmls);

		var objDiv = document.getElementById("chat-scroll");
		objDiv.scrollTop = objDiv.scrollHeight;

	}, function(error) {
		console.log("Error: " + error.code);
	});
</script>

<script>
	$("#getMessage").keypress(function(e) {
		var message = $('#getMessage').val().trim();
		if (e.keyCode == 13 && message.length > 0) {
			var user_id = $('#getUserId').val();
			var name = $('#getName').val();
			var avatar = $('#getAvatar').val();
			var now = new Date();
			var created_at = now.getFullYear() + '-' + (now.getMonth() + 1) + '-' + now.getDate() + ' ' + now.getHours() + ':' + now.getMinutes() + ':' + now.getSeconds();

			$('#getMessage').val("");
			firebase.database().ref('messages').push({
				'user_id': user_id,
				'name': name,
				'avatar': avatar,
				'message': message,
				'created_at': created_at,
			});
		}
	});

	$('.btn-send-message').click(function() {
		var message = $('#getMessage').val().trim();
		if (message.length > 0) {
			var user_id = $('#getUserId').val();
			var name = $('#getName').val();
			var avatar = $('#getAvatar').val();
			var now = new Date();
			var created_at = now.getFullYear() + '-' + (now.getMonth() + 1) + '-' + now.getDate() + ' ' + now.getHours() + ':' + now.getMinutes() + ':' + now.getSeconds();

			$('#getMessage').val("");
			firebase.database().ref('messages').push({
				'user_id': user_id,
				'name': name,
				'avatar': avatar,
				'message': message,
				'created_at': created_at,
			});
		}
	})
</script>
<style>
	#char{
		width:400px;
		height:400px;
		margin:0 auto;
		padding: 20px;
	}
	.data-chart{
		background-color:white;
	}
</style>
<script>
  const ctx = document.getElementById('myChart');
  new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ['Khoa', 'Lớp chuyên nghành', 'Lớp tín chỉ', 'Giảng viên', 'Sinh viên', 'Môn học'],
      datasets: [{
        label: 'Số lượng',
		backgroundColor:['#15fc01','#009ffa','#00c0ef','#953be1','#ffa500','#de531e'],
        data: [{{ count($faculities) }}, {{count($classes)}}, {{count($creditclass)}},{{count($lecturer)}}, {{count($student)}},{{count($subject)}}],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

<script>
	const APP_ID = 'cf26e7b2c25b5acd18ed5c3e836fb235';
	const DEFAULT_VALUE = '--';
	const searchInput = document.querySelector('#search-input');
	const cityName = document.querySelector('.city-name');
	const weatherState = document.querySelector('.weather-state');
	const weatherIcon = document.querySelector('.weather-icon');
	const temperature = document.querySelector('.temperature');


	const sunrise = document.querySelector('.sunrise');
	const sunset = document.querySelector('.sunset');
	const humidity = document.querySelector('.humidity');
	const windSpeed = document.querySelector('.wind-speed');
	searchInput.addEventListener('change',TheWeather);

	function TheWeather(e){
		fetch(`https://api.openweathermap.org/data/2.5/weather?q=${e.target.value}&appid=${APP_ID}&units=metric&lang=vi`)
			.then(async res => {
				const data = await res.json();
				console.log(e.target.value)
				cityName.innerHTML = data.name || DEFAULT_VALUE;
				weatherState.innerHTML = data.weather[0].description || DEFAULT_VALUE;
				weatherIcon.setAttribute('src', `http://openweathermap.org/img/wn/${data.weather[0].icon}@2x.png`);
				temperature.innerHTML = Math.round(data.main.temp) || DEFAULT_VALUE;
				sunrise.innerHTML = moment.unix(data.sys.sunrise).format('H:mm') || DEFAULT_VALUE;
				sunset.innerHTML = moment.unix(data.sys.sunset).format('H:mm') || DEFAULT_VALUE;
				humidity.innerHTML = data.main.humidity || DEFAULT_VALUE;
				windSpeed.innerHTML = (data.wind.speed * 3.6).toFixed(2) || DEFAULT_VALUE;
			});
	}
</script>
@endsection