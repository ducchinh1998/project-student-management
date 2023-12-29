<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Đăng nhập</title>

  <link rel="shortcut icon" type="image" href="{{asset('images/icons/logo.png')}}" />

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('bower_components/font-awesome/css/font-awesome.min.css')}}">

  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('bower_components/Ionicons/css/ionicons.min.css')}}">

  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
  
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('plugins/iCheck/square/blue.css')}}">

<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-box-body">
      <p class="login-box-msg" style="font-weight:600; font-size: 18px;">Student Management</p>

      <form>
        @csrf
        <div class="alert alert-danger login-faile-msg" style="display:none">
          <ul></ul>
        </div>

        <div class="alert alert-warning user-incorrect-msg" style="display:none">
          <ul></ul>
        </div>

        <div class="alert alert-danger user-block-msg" style="display:none">
          <ul></ul>
        </div>


        <div class="form-group has-feedback">
          <input type="username" id="username" class="form-control" placeholder="Tên đăng nhập" name="username" value="{{ old('username') }}" required autofocus>
        </div>

        <div class="form-group has-feedback">
          <input type="password" id="password" class="form-control" placeholder="Mật khẩu" name="password" required>
        </div>

        <div class="row">
          <!-- /.col -->
          <div class="col-xs-12">
            <button type="button" class="btn btn-primary btn-block btn-flat btn-login">Đăng nhập</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery 3 -->
  <script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
  <!-- iCheck -->
  <script src="{{asset('plugins/iCheck/icheck.min.js')}}"></script>

  <script type="text/javascript">
    // detect enter keypress
    $(document).keypress(function(e) {
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if (keycode == '13') {
          var form_data = new FormData();
          form_data.append("_token", '{{csrf_token()}}');
          form_data.append("username", $('#username').val());
          form_data.append("password", $('#password').val());

          $.ajax({
            type : 'post',
            url : '/admin/login',
            data : form_data,
            dataType : 'json',
            contentType: false,
            processData: false,
            success : function(response){
              if(response.is === 'login-failed'){
                $(".login-faile-msg").find("ul").html('');
                $(".login-faile-msg").css('display','block');
                $(".user-incorrect-msg").css('display','none');
                $(".user-block-msg").css('display','none');
                $.each(response.error, function( key, value ) {
                  $(".login-faile-msg").find("ul").append('<li>'+value+'</li>');
                });
              }

              if(response.is === 'block'){
                $(".user-block-msg").find("ul").html('');
                $(".user-block-msg").css('display','block');
                $(".user-incorrect-msg").css('display','none');
                $(".login-faile-msg").css('display','none');

                $(".user-block-msg").find("ul").append('<li>'+response.block+'</li>');
              }
              
              if(response.is === 'incorrect'){
                $(".user-incorrect-msg").find("ul").html('');
                $(".user-incorrect-msg").css('display','block');
                $(".login-faile-msg").css('display','none');
                $(".user-block-msg").css('display','none');

                $(".user-incorrect-msg").find("ul").append('<li>'+response.incorrect+'</li>');
              }

              if(response.is === 'login-success'){
                setTimeout(function () {
                  window.location.href="/admin/home";
                },200);
              }
            }
          });
        }
    });
  </script>

  <script type="text/javascript">
    $('.btn-login').click(function(){
      var form_data = new FormData();
      form_data.append("_token", '{{csrf_token()}}');
      form_data.append("username", $('#username').val());
      form_data.append("password", $('#password').val());

      $.ajax({
        type : 'post',
        url : '/admin/login',
        data : form_data,
        dataType : 'json',
        contentType: false,
        processData: false,
        success : function(response){
          if(response.is === 'login-failed'){
            $(".login-faile-msg").find("ul").html('');
            $(".login-faile-msg").css('display','block');
            $(".user-incorrect-msg").css('display','none');
            $(".user-block-msg").css('display','none');
            $.each(response.error, function( key, value ) {
              $(".login-faile-msg").find("ul").append('<li>'+value+'</li>');
            });
          }

          if(response.is === 'block'){
            $(".user-block-msg").find("ul").html('');
            $(".user-block-msg").css('display','block');
            $(".user-incorrect-msg").css('display','none');
            $(".login-faile-msg").css('display','none');

            $(".user-block-msg").find("ul").append('<li>'+response.block+'</li>');
          }
          
          if(response.is === 'incorrect'){
            $(".user-incorrect-msg").find("ul").html('');
            $(".user-incorrect-msg").css('display','block');
            $(".login-faile-msg").css('display','none');
            $(".user-block-msg").css('display','none');

            $(".user-incorrect-msg").find("ul").append('<li>'+response.incorrect+'</li>');
          }

          if(response.is === 'login-success'){
            setTimeout(function () {
              window.location.href="/admin/home";
            },200);
          }
        }
      });
    });
  </script>
</body>
</html>
