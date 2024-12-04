<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ env('APP_NAME') }}</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS Connection -->
    @include('layouts.public-css')

    <!-- =======================================================
  * Template Name: QuickStart
  * Template URL: https://bootstrapmade.com/quickstart-bootstrap-startup-website-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/======================================================== -->
</head>

<body class="starter-page-page">

    <!-- Connection Header -->
    @include('layouts.header-public')

    <main class="main">

        <!-- Start Content -->
        @yield('content');

    </main>

    <!-- Connection Footer -->
    @include('layouts.footer-public')

    <!-- JS Connection -->
    @include('layouts.public-js');

</body>

</html>
