<!DOCTYPE html>
<html>
<head>
	{{ HTML::style('css/bootstrap.min.css') }}
	<title>{{ $title }}</title>
</head>
<body>
	<div class="row">
	@yield('content')
	</div>
	@yield('end')

	{{ HTML::script('js/bootstrap.min.js') }}

</body>
</html>