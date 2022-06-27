@extends('admin/layout')


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">User Profile</li>
                            <span style="color: red"> @TODO</span>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row" style="  display: flex; justify-content: center;" >
                    <div class="col-md-8 card card-blue card-outline" style="box-shadow: 0 19px 38px rgba(0,0,0,0.30), 0 15px 12px rgba(0,0,0,0.22);">
                        <!-- Profile Image -->
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <?php

                                    if(isset($user_profile['user_img'])){

                                        $img_obj = json_decode($user_profile['user_img'], true);
                                        $img_url = asset('uploads/users/'.$img_obj['url']);
                                        $img_alt = $img_obj['alt'];

                                    }
                                    else{
                                        $img_url = asset('admin/site_imgs/avatar_user.png');
                                        $img_alt = 'user_avatar_img';
                                    }

                                ?>
                                <img class="profile-user-img img-bordered-sm img-circle"
                                     src="{{$img_url}}"
                                     alt="{{$img_alt}}" style="width: 256px; height: 256px">
                            </div>

                            <h2 class="text-center" style="font-weight: bold; font-size: 30px">{{ $user_profile['first_name'] ." " . $user_profile['last_name']}} </h2>

                            <p class="text-center" style=" font-size: 20px; font-weight: bold; color: #7437ec">{{ $user_profile['group'] }}</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <i class="fa-solid fa-city mr-1" style="color: #ff4053; font-size: 18px"></i>
                                    <b>City</b> <a class="float-right" style="font-size: 18px; font-weight: bold" >{{$user_profile['city_name']}}</a>
                                </li>
                                <li class="list-group-item">
                                    <i class="fa-solid fa-location-dot mr-1" style="color: #ff4053; font-size: 18px"></i>
                                    <b>Address</b> <a class="float-right" style="font-size: 18px; font-weight: bold">{{$user_profile['address']}}</a>
                                </li>
                                <li class="list-group-item">
                                    <i class="fa-solid fa-envelope mr-1" style="color: #ff4053; font-size: 18px"></i>
                                    <b>Email</b> <a class="float-right" style="font-size: 18px; font-weight: bold">{{$user_profile['email']}}</a>
                                </li>
                                <li class="list-group-item">
                                    <i class="fa-solid fa-phone mr-1" style="color: #ff4053; font-size: 18px"></i>
                                    <b>Phone</b> <a class="float-right" style="font-size: 18px; font-weight: bold">{{$user_profile['phone']}}</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- /.row -->

            </div><!-- /.container-fluid -->


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection