
@extends('admin/layout')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{$num_of_new_users}}</h3>

                                <p>User Registrations</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{$num_of_new_craftsmen}}</h3>

                                <p>Craftsman Registrations</p>
                            </div>
                            <div class="icon">
                                <i class="fa-solid fa-users-gear"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">

                            <div class="inner">
                                <h3>{{$top_rate_of_craftsmen}}</h3>

                                <p>Top Rate Craftsman</p>
                            </div>
                            <div class="icon">
                                <i class="fa-solid fa-user-gear"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{$num_of_ads}}</h3>

                                <p>Ads Last Week</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->
                <!-- Main row -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-fuchsia">
                            <div class="inner">
                                <h3>{{ $num_of_new_places }}</h3>
                                <p>New Places</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-android-pin"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->

                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-gradient-orange">
                            <div class="inner">
                                <h3>{{$top_rate_of_places}}</h3>

                                <p>Top Rate Places</p>
                            </div>
                            <div class="icon">
                                <i class="fa-solid fa-chart-line"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->


                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-gradient-blue">
                            <div class="inner">
                                <h3>{{$num_of_famous_places}}</h3>

                                <p>Famous Places</p>
                            </div>
                            <div class="icon">
                                <i class="fa-solid fa-ranking-star"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

        <div id="say_hello_modal_id" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content" style="align-items: center">

                    <div class="modal-body" style="padding: 25px 15px">
                        <span style="color: #007bff; font-size: 22px; font-weight: bold">

                        <?php
                            $user_data = Session::get('user_data');
                            $time = date('H');
                            if (($time < "12")) {
                                echo '<span style="font-size: 30px">&#127780</span>' . "  Good Morning, ";
                            }

                            elseif ($time >= "12" && $time < "17") {
                                echo '<span style="font-size: 30px">&#127774</span>' . "  Good Afternoon, ";
                            }

                            elseif ($time >= "17" && $time < "19") {
                                echo '<span style="font-size: 30px">&#127772</span>' . "  Good Evening, ";
                            }

                            elseif ($time >= "19") {
                                echo '<span style="font-size: 30px">&#127770</span>' . "  Good Night, ";
                            }
                            ?>
                    </span>
                        <span style="color: #f63e92; font-size: 22px; font-weight: bold">
                        {{ $user_data['first_name']}}
                    </span>
                    </div>

                </div>
            </div>
        </div>
        <!-- /.modal -->

        <script>
            say_hello_modal('say_hello_modal_id');
        </script>
    </div>
    <!-- /.content-wrapper -->



@endsection







