<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>JOB FIT</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-philips.ico') }}"/>
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-3.3/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/skins/_all-skins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="stylesheet" href="{{ URL::asset('css/jobfit.css') }}">

    @yield('css')
</head>

<body class="skin-blue sidebar-mini fixed">

<div class="wrapper">
    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="{{ config('jobfit.direct_url') }}" class="logo">
            <b class="fa fa-arrow-left"></b>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <i class="fa fa-user"></i>
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{!! isset($user->nama_lengkap) ? $user->nama_lengkap : '' !!}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="{{ URL::asset('images/logo-philips.png') }}" alt="..." style="height: auto;border: none; width: 70px;" />
                                <p>
                                    {!!  isset($user->nama_lengkap) ? $user->nama_lengkap : '' !!}
                                    <small>{!!  isset($user->level) ? $user->level : '' !!}</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div align="center">
                                    <a href="{!! url('/logout') !!}" class="btn btn-default btn-flat"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="width: 95%">
                                        <i class="fa fa-sign-out"></i> Logout
                                    </a>
                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Left side column. contains the logo and sidebar -->
@include('layouts.sidebar')
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('content')
    </div>

    <!-- Main Footer -->
    <footer class="main-footer" style="max-height: 100px;text-align: center">
        <strong>Copyright © ADDROOSOFT 2018</strong>
    </footer>

</div>

<script src="{{ URL::asset('plugins/jquery/dist/jquery.min.js') }}"></script>
{{--<script src="{{ URL::asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.11/js/app.min.js"></script>
<script src="{{ URL::asset('plugins/bootstrap-3.3/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ URL::asset('plugins/fastclick/lib/fastclick.js') }}"></script>
<script src="{{ URL::asset('js/adminlte.js') }}"></script>
<script src="{{ URL::asset('plugins/fastclick/lib/fastclick.js') }}"></script>
<script src="{{ URL::asset('plugins/dataTables/js/jquery.datatables.min.js') }}"></script>
<script src="{{ URL::asset('plugins/dataTables/js/datatables.bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

@yield('scripts')
</body>
</html>