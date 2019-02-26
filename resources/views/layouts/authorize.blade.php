<!DOCTYPE html>
<html lang="en">
<head>
	<title>@yield('title') {{ config('app.name', 'TheHolyFamilyChurch-CRM') }}</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	{{Html::style('loginassets/vendor/bootstrap/css/bootstrap.min.css')}}
<!--===============================================================================================-->
	{{Html::style('loginassets/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}
<!--===============================================================================================-->
	{{Html::style('loginassets/vendor/animate/animate.css')}}
<!--===============================================================================================-->	
	{{Html::style('loginassets/vendor/css-hamburgers/hamburgers.min.css')}}
<!--===============================================================================================-->
	{{Html::style('loginassets/vendor/select2/select2.min.css')}}
<!--===============================================================================================-->
	{{Html::style('loginassets/css/util.css')}}
	{{Html::style('loginassets/css/main.css')}}
<!--===============================================================================================-->
</head>
<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				@yield('content')
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	{{Html::script('loginassets/vendor/jquery/jquery-3.2.1.min.js')}}
<!--===============================================================================================-->
	{{Html::script('loginassets/vendor/bootstrap/js/popper.js')}}
	{{Html::script('loginassets/vendor/bootstrap/js/bootstrap.min.js')}}
<!--===============================================================================================-->
	{{Html::script('loginassets/vendor/select2/select2.min.js')}}
<!--===============================================================================================-->
	{{Html::script('loginassets/vendor/tilt/tilt.jquery.min.js')}}
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	{{Html::script('loginassets/js/main.js')}}

</body>
</html>