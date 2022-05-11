<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{env('meta_title')}}</title>

    <!-- jQuery -->
    <script src="{{asset('admin/plugins/jquery/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/my_files/boiar_files.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/my_files/test.js')}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{asset('admin/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

    <!-- Font Awesome version 6-->
    <script defer src="{{asset('admin/fontawesome_6/js/all.js')}}"></script>
    <link href="{{asset('admin/fontawesome_6/css/all.css')}}" rel="stylesheet">
    <link href="{{asset('admin/fontawesome_6/css/fontawesome.css')}}" rel="stylesheet">
    <link href="{{asset('admin/fontawesome_6/css/brands.css')}}" rel="stylesheet">
    <link href="{{asset('admin/fontawesome_6/css/v5-font-face.css')}}" rel="stylesheet" />




    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{asset('admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{asset('admin/plugins/jqvmap/jqvmap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('admin/dist/css/adminlte.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('admin/plugins/summernote/summernote-bs4.min.css')}}">

    <!-- My Style files Bo -->
    <link rel="stylesheet" href="{{asset('admin/my_files/style_boiar_files.css')}}">

    @yield('style')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Preloader -->
   {{-- <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{asset('admin/dist/img/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60" width="60">
    </div>--}}

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('admin.home') }}" class="nav-link">Home</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Contact</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Navbar Search -->
            <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <i class="fas fa-search"></i>
                </a>
                <div class="navbar-search-block">
                    <form class="form-inline">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>


            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 new messages
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
        </ul>
    </nav>


    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('admin.home') }}" class="brand-link">
            <img src="{{asset('admin/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-bold" style="color: #3efff6">{{env('meta_title')}}</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 d-flex">
                <div class="image">
                    <img src="{{asset('admin/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <span class="" style="color: white; font-size: 17px">
                        <?php
                            $user_data = \Illuminate\Support\Facades\Session::get('user_data');
                            echo $user_data['first_name'];
                        ?>
                    </span>
                </div>
            </div>
            <div class="user-panel d-flex">
                <div class="info">
                    <span style="color: white; font-size: 16px; font-weight: bold">Group : </span><span style="color: #3efff6; font-size: 14px">{{ $user_data['group'] }} </span>
                </div>
            </div>


            <!-- Sidebar Menu -->

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item" >
                        <a class="nav-link" href="{{route('admin.city.index')}}">
                            <i class=" nav-icon fa-solid fa-city" style="color: #4adcff;"></i> <span style="color: #ffc606; font-size: 16px; font-weight: bold">Cities</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin.user_group.index')}}">
                            <i class="nav-icon fas fa-users" style="color: #4adcff;"></i><span style="color: #ffc606; font-size: 16px; font-weight: bold">Users Groups</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin.user.index')}}">
                            <i class="nav-icon fas fa-users" style="color: #4adcff;"></i><span style="color: #ffc606; font-size: 16px; font-weight: bold">Users</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin.place_type.index')}}">
                            <i class="nav-icon fas fa-map-marker" style="color: #4adcff;"></i> <span style="color: #ffc606; font-size: 16px; font-weight: bold">Places Types</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin.place.index')}}">
                            <i class="nav-icon fa-solid fa-map-location-dot" style="color: #4adcff;"></i> <span style="color: #ffc606; font-size: 16px; font-weight: bold">Places</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin.craft_type.index')}}">
                            <i class="nav-icon fas fa-cogs" style="color: #4adcff;"></i><span style="color: #ffc606; font-size: 16px; font-weight: bold">Craftsmen Types</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin.craft.index')}}">
                            <i class="nav-icon fa-solid fa-users-gear" style="color: #4adcff;"></i><span style="color: #ffc606; font-size: 16px; font-weight: bold">Craftsman</span>
                        </a>
                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->

        </div>
        <!-- /.sidebar -->
    </aside>
