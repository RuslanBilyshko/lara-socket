<!DOCTYPE HTML>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<title>@yield('title')</title>

	<script src="/js/jquery-1.11.3.min.js"></script>
	<!--скрипт для старых браузеров IE-->
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->


	<script src="/libs/kalendar/jquery-ui.js"></script>
	<link href="/libs/kalendar/jquery-ui.css" rel="stylesheet">
	<script src="/libs/maskedinput/jquery.maskedinput.min.js"></script>

	<link href="/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="/libs/font-awesome/css/font-awesome.min.css" rel="stylesheet">

	<script src="/libs/vex/vex.combined.min.js"></script>
	<link rel="stylesheet" href="/libs/vex/css/vex.css" />
	<link rel="stylesheet" href="/libs/vex/css/vex-theme-os.css" />

	<link href="/libs/bpopup/bpopup.css" rel="stylesheet">
	<script src="/libs/bpopup/jquery.bpopup.min.js"></script>


	<script src="/js/order.js"></script>
	<link href="/css/style.css" rel="stylesheet">

	@yield('script')

</head>
<body>
<div class="container wrapper">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<header class="col-md-12">
				@include('user.menu')
				<h1>@yield('title')</h1>
				{{--@include('user-menu')--}}
			</header>

			<main class="col-md-12">
				<div class="message">
					@include('layout.validate')
				</div>
				<article class="content-wrapper">
					<div id="res"></div>
					@yield('content')
				</article>
			</main>
			<footer class="col-md-12">
				{{-- <p>Footer</p>--}}
			</footer>
		</div>

	</div>
</div>

<div id="popup">
	<span class="button b-close"><span>X</span></span>
	<div class="content"></div>
</div>


</body>
</html>