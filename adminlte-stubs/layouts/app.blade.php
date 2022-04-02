<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title')@if(View::hasSection('title')) - @endif{{ config('app.name') }}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  @yield('stylesheet')
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        @include('layouts.header')  {{-- include header layout --}}

        <!-- Left side column. contains the logo and sidebar -->
        @include('layouts.sidebar')  {{-- include sidebar layout --}}

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->

        @include('layouts.footer')  {{-- include footer layout --}}
    </div>
    <!-- ./wrapper -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    @yield('scripts')
</body>
</html>