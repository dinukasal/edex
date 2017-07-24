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

	<p style="margin-left:30%;margin-top:35%"> A Project by Old Royalists Professionals' Engineering Association</p>
</body>
</html>