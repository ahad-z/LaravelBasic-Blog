<!doctype html>
<html class="no-js" lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title> @yield('title', 'Admin With Role')</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
     @include('backend.layouts.partials.style')
	<!-- modernizr css -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="{{ asset('backend/assets/js/vendor/modernizr-2.8.3.min.js') }}"></script>
    
</head>
@stack('styles')

<body>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<!-- preloader area start -->
<div id="preloader">
	<div class="loader"></div>
</div>
<!-- preloader area end -->
<!-- page container area start -->
<div class="page-container">
	<!-- sidebar menu area start -->
@include('backend.layouts.partials.sidebar')
	<!-- sidebar menu area end -->
	<!-- main content area start -->
	<div class="main-content">
		<!-- header area start -->
		@include('backend.layouts.partials.header_area')
		<!-- header area end -->
		<!-- page title area start -->
		@yield('admin-content')
	</div>
	<!-- main content area end -->
	<!-- footer area start-->
@include('backend.layouts.partials.footer')
	<!-- footer area end-->
</div>
<!-- page container area end -->
<!-- offset area start -->
@include('backend.layouts.partials.Offset')
<!-- offset area end -->
<!-- jquery latest version -->
@include('backend.layouts.partials.scripts')
</body>

<script type="text/javascript">
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$(document).ready(function(){
  			@if (session()->has('success'))
				toastr.success(`{{ session()->get('success') }}`)
			@elseif (session()->has('error'))
				toastr.error(`{{ session()->get('error') }}`)
			@elseif(session()->has('warning'))
				toastr.warning(`{{ session()->get('warning') }}`)	
  			@endif
  		});
</script>

@stack('scripts')
</html>
