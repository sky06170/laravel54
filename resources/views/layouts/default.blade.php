<!DOCTYPE html>
<html lang="tw">
<head>
	<meta charset="UTF-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>@yield('title')</title>
</head>
<body>
	<div id="app">
		<router-link to="/vue/hello">Go to Hello</router-link>
    	<router-link to="/vue/count">Go to Count</router-link>
    	<router-link to="/vue/article/1">Go to Article</router-link>
    	<router-link to="/vue/draggable">Go to Draggable</router-link>
    	<router-view></router-view>
		@yield('content')
	</div>
	<script src="{{ asset('/js/manifest.js') }}"></script>
	<script src="{{ asset('/js/vendor.js') }}"></script>
	<script src="{{ asset('/js/app-custom.js') }}"></script>
	@yield('script')
</body>
</html>