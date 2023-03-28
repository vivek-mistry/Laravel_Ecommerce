<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> {{ env('APP_NAME') }} </title>

    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- End CSRF Token -->

    @include ('components/backend/master/style')
    @yield('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <input type="hidden" id="base_url" value="{{ url('') }}" >

        <!-- Preloader -->
        <x-backend-page-loader/>
        <!-- End Preloader -->

        <!-- Header & SideBar -->
        <x-backend-header-and-sidebar />
        <!-- End Header & SideBar -->

        <div class="content-wrapper">
            @yield('contents')
        </div>
        <x-backend-footer />
    </div>

    @include ('components/backend/master/script')

    @yield('scripts')

</body>

</html>
