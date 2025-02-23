<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ isset($title) ? $title . ' | ' . config('app.name') : config('app.name') }}</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <!-- Icon -->
    <link rel="stylesheet" href="{{ asset('fonts/line-icons.css') }}">

    <!-- Owl carousel -->
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.css') }}">

    
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nivo-lightbox.css') }}">

    <!-- Animate -->
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">

    <!-- Visual Style -->
    <link rel="stylesheet" href="{{ asset('css/visual.css') }}">

    <!-- Main Style -->
    <link rel="stylesheet" href="{{ asset('css/tiny-slider.css') }}">

    <!-- Main Style -->
    <link rel="stylesheet" href="{{ asset('css/lindy-uikit.css') }}">

    <!-- Responsive Style -->
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>
  @include('partials.header-visual')

  @yield('content')

  @include('partials.footer')

  <script src="{{ asset('js/jquery-min.js') }}"></script>
  <script src="{{ asset('js/popper.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('js/wow.js') }}"></script>
  <script src="{{ asset('js/jquery.nav.js') }}"></script>
  <script src="{{ asset('js/scrolling-nav.js') }}"></script>
  <script src="{{ asset('js/jquery.easing.min.js') }}"></script>
  <script src="{{ asset('js/jquery.counterup.min.js') }}"></script>      
  <script src="{{ asset('js/waypoints.min.js') }}"></script>   
  <script src="{{ asset('js/main.js') }}"></script>
  <script src="{{ asset('js/custom-toast.js') }}"></script>
  <script src="{{ asset('js/tiny-slider.js') }}"></script>
  
  <script src="{{ asset('js/visual.js') }}"></script>
</body>
</html>
