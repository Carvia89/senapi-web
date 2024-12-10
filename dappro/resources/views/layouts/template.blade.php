<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>gestodive</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{asset('dash_assets/assets/img/favicon.png')}}" rel="icon">
  <link href="{{asset('dash_assets/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('dash_assets/assets/vendor/bootstrap/css/bootstrap.min.cs')}}s" rel="stylesheet">
  <link href="{{asset('dash_assets/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('dash_assets/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('dash_assets/assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
  <link href="{{asset('dash_assets/assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
  <link href="{{asset('dash_assets/assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{asset('dash_assets/assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{asset('dash_assets/assets/css/style.css')}}" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

</head>

<body>

@include('layouts.topbar')

@include('layouts.sidebar')

@yield('content')


  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{asset('dash_assets/assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{asset('dash_assets/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('dash_assets/assets/vendor/chart.js/chart.umd.js')}}"></script>
  <script src="{{asset('dash_assets/assets/vendor/echarts/echarts.min.js')}}"></script>
  <script src="{{asset('dash_assets/assets/vendor/quill/quill.js')}}"></script>
  <script src="{{asset('dash_assets/assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{asset('dash_assets/assets/vendor/tinymce/tinymce.min.js')}}"></script>
  <script src="{{asset('dash_assets/assets/vendor/php-email-form/validate.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('dash_assets/assets/js/main.js')}}"></script>

  <script>
    new TomSelect('select[multiple]', {plugins: {remove_button: {title: 'Supprimer'}}})
  </script>

</body>

</html>
