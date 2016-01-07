@if(!isset($_SESSION))
	<p style="visibility:hidden">{{ session_start()  }}</p>
@endif
@if(isset($_SESSION['username']) and $_SESSION['username']!='')
<!DOCTYPE html>
<html>
<head>
	{{ HTML::style('css/bootstrap.min.css') }}
	<title>{{ $title }}</title>
	<style>
	.inline{
		display:inline;
	}
	</style>
</head>
<body>
	<div class="row">
	@yield('content')
	</div>
	@yield('end')
	<div class="row" style="margin-left:1%">
		<br />
		 <button type="button" class='btn btn-default ' onclick="location.href='/view'">
		 	View All 
		 </button> 
		 <button type="button" class='btn btn-default ' onclick="location.href='/upload'">
		 	Submit 
		 </button> 
		 <button type="button" class='btn btn-default ' onclick="location.href='/list'">
		 	Delete 
		 </button> 
		 <button type="button" class='btn btn-default ' onclick="location.href='/logout'">
		 	Logout
		 </button> 
	</div>

	{{ HTML::script('js/bootstrap.min.js') }}

	<p style="margin-left:30%;margin-top:50%"> 
		A Project by Old Royalists Professionals' Engineering Association and Consec Technologies
	</p>
</body>

</html>
@else
	{{ Redirect::away('/login') }}
@endif