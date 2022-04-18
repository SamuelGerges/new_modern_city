@extends('admin/layout')
@section('content')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header justify-content-center">
            <div class="container-fluid">
                <div class="row mb-3">

                    <div class="col-sm-7">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.home') }}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="{{route('admin.user.index') }}">User Info / </a> {{  !isset($users->user_id)  ? 'Add / ' : "Edit / ". $users->first_name }}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

    @include('admin/components/errors')

    <!-- Main content -->
        <section class="content">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{  !isset($user->user_id)  ? 'Add ' : "Edit "}} Info</h3>
                        </div>
                        <div class="card-body">
                            <?php !isset($user->user_id)  ? $id = '' : $id = $user->user_id ?>
                            <form class="form-group" method="post" action="{{ route('admin.user.edit', $id) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-6 pr-md-1 ">
                                        <label>First Name</label>
                                        <input type="text" name="data[first_name]" class="form-control" placeholder="Enter First Name"  value="{{ !isset($user->first_name) ? '' : $user->first_name }}">
                                    </div>
                                    <div class="col-md-6 pr-md-1">
                                        <label>Last Name</label>
                                        <input type="text" name="data[last_name]" class="form-control" placeholder="Enter Last Name" value="{{ !isset($user->last_name) ? '' : $user->last_name }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6 pr-md-1">
                                        <label>User Group</label>
                                        <select class="form-select form-control" name="data[user_group_id]" data-placeholder="Select a user group" style="width: 100%">
                                            @foreach($users_groups->all() as $user_group)
                                                <option value="{{$user_group->user_group_id}}" {{isset($user->user_group_id) &&  $user->user_group_id == $user_group->user_group_id ? 'selected = "selected"': ''}} >{{$user_group->user_group_name}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="col-md-6 pr-md-1">
                                        <label>gender</label>
                                        <select class="form-select form-control" name="data[gender]" data-placeholder="Select your gender" style="width: 100%">
                                                <option value="male"   {{isset($user->gender) && $user->gender ==  'male'   ? 'selected = "selected"': ''}} style="color: #269abc">Male</option>
                                                <option value="female" {{isset($user->gender) && $user->gender ==  'female' ? 'selected = "selected"': ''}} style="color: #D81B60">Female</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6 pr-md-1 ">
                                        <label>Email</label>
                                        <input type="text" name="data[email]" class="form-control" placeholder="Enter Email"  value="{{ !isset($user->email) ? '' : $user->email }}">
                                    </div>
                                    <div class="col-md-6 pr-md-1">
                                        <label>Phone</label>
                                        <input type="text" name="data[phone]" class="form-control" placeholder="Enter Phone" value="{{ !isset($user->phone) ? '' : $user->phone }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6 pr-md-1">
                                        <label>City</label>
                                        <select class="form-select form-control" name="data[city_id]" data-placeholder="Select a State" style="width: 100%">
                                            @foreach($cities->all() as $city)
                                                <option value="{{$city->city_id}}" {{isset($user->city_id) &&  $user->city_id == $city->city_id ? 'selected = "selected"': ''}} >{{$city->city_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 pr-md-1">
                                        <label>Address</label>
                                        <input type="text" name="data[address]" class="form-control" placeholder="Enter Address" value="{{ !isset($user->address) ? '' : $user->address }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6 pr-md-1">
                                        <label>Password</label>
                                        <input type="password" name="data[password]" class="form-control" placeholder="Enter Password">
                                    </div>
                                    <?php

                                        if(!isset($user->user_id)){

                                            echo '
                                                    <div class="col-md-6 pr-md-1">
                                                        <label>Confirm Password</label>
                                                        <input type="password" name="data[confirm_password]" class="form-control" placeholder="Confirm Password" value="">
                                                    </div>
                                                 ';
                                        }

                                    ?>

                                </div>
                                <div class="row mb-3">

                                    <div class="col-md-6 pr-md-1">
                                        <label>Upload Photo <span style="color: red;">@To do img</span></label>
                                        <div class="custom-file">
                                            <input type="file"  name="data[user_img][url]" class="custom-file-input" id="user_img">
                                            <label class="custom-file-label" for="exampleInputFile">Choose photo</label>
                                            <div id="user_img_holder">
                                                <div class="col-sm-6"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <button type="submit" class="btn btn-success float-right">{{  !isset($user->user_id)  ? 'Create' : 'Edit'}}</button>
                            </form>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-md-4">
                    <div class="card" style="height: 400px; width: 400px; align-items: center">
                        <div id="img_holder" style="">
                            <?php
                                if(isset($user->user_id)){
                                    //edit

                                    if(isset($user->user_img)){
                                        $img_obj = json_decode($user->user_img, true);

                                        $img_url = asset('uploads/users/'.$img_obj['url']);
                                        $img_alt = $img_obj['alt'];

                                    }
                                    else{
                                        $img_url = asset('admin/site_imgs/avatar_user.png');
                                        $img_alt = 'user_avatar_img';
                                    }

                                }
                                else{
                                    // create view
                                     $img_url = asset('admin/site_imgs/avatar_user.png');
                                    $img_alt = 'user_avatar_img';
                                }


                            ?>
                            <img class="card-img-top"  id="avatar_img" src="{{$img_url}}" alt="{{$img_alt}}"  style="height: 200px; width:200px">
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <script>
        avatar_img_preview($('#user_img'), $('#img_holder'), 'card-img-top', 'avatar_img')
    </script>

@endsection





{{--
<div class="col-md-3">

    <!-- Profile Image -->
    <div class="card card-primary card-outline">
        <div class="card-body box-profile">
            <div class="text-center">
                <img class="profile-user-img img-fluid img-circle"
                     src="../../dist/img/user4-128x128.jpg"
                     alt="User profile picture">
            </div>

            <h3 class="profile-username text-center">Nina Mcintire</h3>

            <p class="text-muted text-center">Software Engineer</p>

            <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                    <b>Followers</b> <a class="float-right">1,322</a>
                </li>
                <li class="list-group-item">
                    <b>Following</b> <a class="float-right">543</a>
                </li>
                <li class="list-group-item">
                    <b>Friends</b> <a class="float-right">13,287</a>
                </li>
            </ul>

            <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

    <!-- About Me Box -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">About Me</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <strong><i class="fas fa-book mr-1"></i> Education</strong>

            <p class="text-muted">
                B.S. in Computer Science from the University of Tennessee at Knoxville
            </p>

            <hr>

            <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

            <p class="text-muted">Malibu, California</p>

            <hr>

            <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

            <p class="text-muted">
                <span class="tag tag-danger">UI Design</span>
                <span class="tag tag-success">Coding</span>
                <span class="tag tag-info">Javascript</span>
                <span class="tag tag-warning">PHP</span>
                <span class="tag tag-primary">Node.js</span>
            </p>

            <hr>

            <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>--}}
