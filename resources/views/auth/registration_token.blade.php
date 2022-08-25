<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BookingSYSTEM | Registration</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="AdminLTE/index2.html" class="h1"><b>Booking</b>SYSTEM</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Please enter the registration token provided by the admin.</p>

      <form>
        <div class="input-group mb-3">
          <input id="token" type="text" class="form-control" placeholder="Token">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="offset-8 col-4">
            <button id="btnregister" type="button" class="btn btn-primary btn-block">Enter</button>
          </div>
        </div>
      </form>

      <a href="{{ route('login') }}" class="text-center">I already have an account</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="{{ asset('AdminLTE/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('AdminLTE/dist/js/adminlte.min.js') }}"></script>

<script>
  (function(){
	function validateEmail(email) {
        var re = /\S+@\S+\.\S+/;
        return re.test(email);
    }
	function clearForm() {
		$('#firstname').val("")
		$('#middlename').val("")
		$('#lastname').val("")
		$('#email').val("")
		$('#password').val("")
		$('#confirmpassword').val("")
	}
    $(document).on('click','#btnregister',function (params) {
		var flag = true;
		var email = $('#email').val().trim()
		var password = $('#password').val().trim()
		var confirmpassword = $('#confirmpassword').val().trim()
		if (password !== confirmpassword) {
			alert('Passwords do not match')
			flag = false;
		}
		if (validateEmail(email) === false) {
			alert('Invalid E-mail')
			flag = false;
		}
		if (flag) {
			$.ajax({
				url:"{{ route('register_create') }}",
				method:'POST',
				data:{
					_token:'{{ csrf_token() }}',
					firstname:$('#firstname').val().trim(),
					middlename:$('#middlename').val().trim(),
					lastname:$('#lastname').val().trim(),
					email:$('#email').val().trim(),
					password:$('#password').val().trim()
				},
				success:function(data){
					if (data > 0) {
						clearForm()
						alert('Account created successfully')
						window.location = "{{ route('login') }}"
					}
				}
			})
		}
    })
  })()
</script>
</body>
</html>
