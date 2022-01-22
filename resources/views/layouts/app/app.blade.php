<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Entrepremart - Admin Dashboard</title>

    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500|Poppins:400,500,600,700|Roboto:400,500" rel="stylesheet"/>
    <link href="https://cdn.materialdesignicons.com/3.0.39/css/materialdesignicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{ asset('css/app-style.css') }}" />
    <!-- PLUGINS CSS STYLE -->
    <link href="{{ asset('assets/app/plugins/toaster/toastr.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/app/plugins/nprogress/nprogress.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/app/plugins/flag-icons/css/flag-icon.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/app/plugins/jvectormap/jquery-jvectormap-2.0.3.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/app/plugins/ladda/ladda.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/app/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/app/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
 
    <!-- SLEEK CSS -->
    <link id="sleek-css" rel="stylesheet" href="{{ asset('assets/app/css/sleek.css') }}" />

    


    <!-- FAVICON -->
    <link href="{{ asset('assets/app/img/favicon.png') }}" rel="shortcut icon" />

    <!--
      HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries
    -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="{{ asset('assets/app/plugins/nprogress/nprogress.js') }}"></script>
  </head>
  <body class="sidebar-fixed sidebar-dark header-light header-fixed" id="body">
    <script>
      NProgress.configure({ showSpinner: false });
      NProgress.start();
    </script>
  
    <div class="mobile-sticky-body-overlay"></div>
  
    <div id="app" class="wrapper">
      @csrf
      <!-- Side bar  -->
      @include('layouts.app.sidebar')
  
      <!-- Main -->
      <div class="page-wrapper">
          <!-- Header -->
        <header class="main-header " id="header">
          <!-- Navbar -->
          @include('layouts.app.navbar')
        </header>
        
        <div class="container">
          @include('widgets.app.breadcrumbs')
          @yield('main')
        </div>
        
        @include('layouts.app.footer')
        
        
      </div>
    </div>
    
    {{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDCn8TFXGg17HAUcNpkwtxxyT9Io9B_NcM" defer></script> --}}
    <script src="{{ asset('assets/app/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.7.3/lottie.min.js" integrity="sha512-35O/v2b9y+gtxy3HK+G3Ah60g1hGfrxv67nL6CJ/T56easDKE2TAukzxW+/WOLqyGE7cBg0FR2KhiTJYs+FKrw==" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/app/js/alt-alert.js') }}"></script>
    <script src="{{ asset('assets/app/js/my-alert.js') }}"></script>
    <script src="{{ asset('assets/app/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/app/plugins/toaster/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/app/plugins/slimscrollbar/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('assets/app/plugins/charts/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/app/plugins/ladda/spin.min.js') }}"></script>
    <script src="{{ asset('assets/app/plugins/ladda/ladda.min.js') }}"></script>
    <script src="{{ asset('assets/app/plugins/jquery-mask-input/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('assets/app/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/app/plugins/jvectormap/jquery-jvectormap-2.0.3.min.js') }}"></script>
    <script src="{{ asset('assets/app/plugins/jvectormap/jquery-jvectormap-world-mill.js') }}"></script>
    <script src="{{ asset('assets/app/plugins/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('assets/app/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/app/plugins/jekyll-search.min.js') }}"></script>
    <script src="{{ asset('assets/app/js/sleek.js') }}"></script>
    <script src="{{ asset('assets/app/js/chart.js') }}"></script>
    <script src="{{ asset('assets/app/js/chart.js') }}"></script>
    <script src="{{ asset('assets/app/js/date-range.js') }}"></script>
    <script src="{{ asset('assets/app/js/map.js') }}"></script>
    <script src="{{ asset('assets/app/js/custom.js') }}"></script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    
      
  
  </body>
</html>