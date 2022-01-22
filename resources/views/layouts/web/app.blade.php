<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>Porto - Bootstrap eCommerce Template</title>

	<meta name="keywords" content="HTML5 Template" />
	<meta name="description" content="Porto - Bootstrap eCommerce Template">
	<meta name="author" content="SW-THEMES">

	<!-- Favicon -->
	<link rel="icon" type="image/x-icon" href="{{ asset('/assets/web/images/icons/favicon.ico') }}">

	{{-- <script type="text/javascript">
		WebFontConfig = {
			google: { families: [ 'Open+Sans:300,400,600,700,800','Poppins:300,400,500,600,700,800' ] }
		};
		(function(d) {
			var wf = d.createElement('script'), s = d.scripts[0];
			wf.src = '/assets/web/js/webfont.js';
			wf.async = true;
			s.parentNode.insertBefore(wf, s);
		})(document);
	</script> --}}

	<!-- Plugins CSS File -->
	<link rel="stylesheet" href="{{ asset('assets/web/css/bootstrap.min.css')}}">
  {{-- <link rel="stylesheet" href="assets/web/css/bootstrap.min.css"> --}}
  <!-- Bootstrap CSS -->
  {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous"> --}}

	<!-- Main CSS File -->
	<link rel="stylesheet" href="{{ asset('/css/style.css') }}">
	<link rel="stylesheet" href="{{ asset('/assets/web/css/style.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('/assets/web/vendor/fontawesome-free/css/all.min.css')}}">
	<style>
		body{
			font-family: Avenir, Helvetica, Arial, sans-serif !important;
			-webkit-font-smoothing: antialiased !important;
			-moz-osx-font-smoothing: grayscale !important;
			text-align: center !important;
			color: #2c3e50;
		}
	</style>
</head>
<body>
	<div class="page-wrapper">
		@include('widgets.web.top-notice')

		<header class="header">
      @include('layouts.web.top-nav')
			@include('layouts.web.info-nav')
			@include('layouts.web.bottom-nav')
		</header><!-- End .header -->

    @yield('main')
		@include('layouts.web.footer')

    <!--  Mobile Menu  -->
	<div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->
	<div class="mobile-menu-container">
		@include('widgets.web.mobile-menu')
	</div><!-- End .mobile-menu-container -->


  <!--  Newsletter  -->
	<div class="newsletter-popup mfp-hide bg-img" id="newsletter-popup-form" style="background: #f1f1f1 no-repeat center/cover url('/assets/web/images/newsletter_popup_bg.jpg')">
		@include('widgets.web.newsletter')
	</div><!-- End .newsletter-popup -->

	

	<a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>


  <!-- Bootstrap JS -->
  <script src="{{ asset('assets/web/js/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/web/js/bootstrap.bundle.min.js') }}"></script>
  <!-- CDN -->
  {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script> --}}
  <!-- Font Awesome -->
  <script src="https://kit.fontawesome.com/71824c57ac.js" crossorigin="anonymous"></script>

	<!-- Plugins JS File -->
  {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> --}}
	<script src="{{ asset('assets/web/js/plugins.min.js') }}"></script>

	<!-- Main JS File -->
	<script src="{{ asset('assets/web/js/main.min.js') }}"></script>



    <!-- Add Cart Modal -->
	<div class="modal fade" id="addCartModal" tabindex="-1" role="dialog" aria-labelledby="addCartModal" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-body add-cart-box text-center">
			<p>You've just added this product to the<br>cart:</p>
			<h4 id="productTitle"></h4>
			<img src="#" id="productImage" width="100" height="100" alt="adding cart image">
			<div class="btn-actions">
				<a href="cart.html"><button class="btn-primary">Go to cart page</button></a>
				<a href="#"><button class="btn-primary" data-dismiss="modal">Continue</button></a>
			</div>
		  </div>
		</div>
	  </div>
	</div>
</body>
</html>