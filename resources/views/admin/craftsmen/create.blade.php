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
                            <li class="breadcrumb-item active"><a href="{{route('admin.craft.index') }}">User Info / </a> {{  !isset($craftsman->craftsman_id)  ? 'Add / ' : "Edit / ". $craftsman->first_name }}</li>
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
                            <h3 class="card-title">{{  !isset($craftsman->craftsman_id)  ? 'Add ' : "Edit "}} Info</h3>
                        </div>
                        <div class="card-body">
                            <?php !isset($craftsman->craftsman_id)  ? $id = '' : $id = $craftsman->craftsman_id ?>
                            <form class="form-group" method="post" action="{{ route('admin.craft.edit', $id) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-6 pr-md-1 ">
                                        <label>First Name</label>
                                        <input type="text" name="data[first_name]" class="form-control" placeholder="Enter First Name"  value="{{ !isset($craftsman->first_name) ? '' : $craftsman->first_name }}">
                                    </div>
                                    <div class="col-md-6 pr-md-1">
                                        <label>Last Name</label>
                                        <input type="text" name="data[last_name]" class="form-control" placeholder="Enter Last Name" value="{{ !isset($craftsman->last_name) ? '' : $craftsman->last_name }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6 pr-md-1">
                                        <label>craftsman Type</label>
                                        <select class="form-select form-control" name="data[craftsman_type_id]" data-placeholder="Select a craftsman type" style="width: 100%">
                                            @foreach($craftsman_types->all() as $craftsman_type)
                                                <option value="{{$craftsman_type->craftsman_type_id}}" {{isset($craftsman->craftsman_type_id) &&  $craftsman->craftsman_type_id == $craftsman_type->craftsman_type_id ? 'selected = "selected"': ''}} >{{$craftsman_type->craftsman_type_name}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="col-md-6 pr-md-1">
                                        <label>gender</label>
                                        <select class="form-select form-control" name="data[gender]" data-placeholder="Select your gender" style="width: 100%">
                                                <option value="male"   {{isset($craftsman->gender) && $craftsman->gender ==  'male'   ? 'selected = "selected"': ''}} style="color: #269abc">Male</option>
                                                <option value="female" {{isset($craftsman->gender) && $craftsman->gender ==  'female' ? 'selected = "selected"': ''}} style="color: #D81B60">Female</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6 pr-md-1 ">
                                        <label>Email</label>
                                        <input type="text" name="data[email]" class="form-control" placeholder="Enter Email"  value="{{ !isset($craftsman->email) ? '' : $craftsman->email }}">
                                    </div>
                                    <div class="col-md-6 pr-md-1">
                                        <label>Phone</label>
                                        <input type="text" name="data[phone]" class="form-control" placeholder="Enter Phone" value="{{ !isset($craftsman->phone) ? '' : $craftsman->phone }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6 pr-md-1">
                                        <label>City</label>
                                        <select class="form-select form-control" name="data[city_id]" data-placeholder="Select a State" style="width: 100%">
                                            @foreach($cities->all() as $city)
                                                <option value="{{$city->city_id}}" {{isset($craftsman->city_id) &&  $craftsman->city_id == $city->city_id ? 'selected = "selected"': ''}} >{{$city->city_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 pr-md-1">
                                        <label>Address</label>
                                        <input type="text" name="data[address]" class="form-control" placeholder="Enter Address" value="{{ !isset($craftsman->address) ? '' : $craftsman->address }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6 pr-md-1">
                                        <label>Description</label>
                                        <textarea name="data[description]" class="form-control"  rows="3">{{ !isset($craftsman->description) ? '' : $craftsman->description }}</textarea>
                                    </div>




                                    <div class="col-md-6 pr-md-1 custom-control custom-switch">
                                        <label for="customSwitch1">Work State</label>


                                        <select class="form-select form-control" name="data[work_state]" data-placeholder="Select Work State" style="width: 100%">
                                            <option value="0" {{isset($craftsman->work_state) == 0 ? 'selected = "selected"': ''}} >OFF</option>
                                            <option value="1" {{isset($craftsman->work_state) == 1 ? 'selected = "selected"': ''}} >ON</option>

                                        </select>
                                    </div>
                                </div>



                                <div class="row mb-3">
                                    <div class="col-md-6 pr-md-1">
                                        <label>Password</label>
                                        <input type="password" name="data[password]" class="form-control" placeholder="Enter Password">
                                    </div>
                                    <?php
                                        if(!isset($craftsman->craftsman_id)){
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
                                        <label>Upload Photo</label>
                                        <div class="custom-file">
                                            <input type="file" name="data[craftsman_img][url]" class="custom-file-input" id="craftsman_img">
                                            <label class="custom-file-label" for="exampleInputFile">Choose photo</label>
                                            <div id="craftsman_img_holder">
                                                <div class="col-sm-6"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <button type="submit" class="btn btn-success float-right">{{  !isset($craftsman->craftsman_id)  ? 'Create' : 'Edit'}}</button>
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
                            if(isset($craftsman->craftsman_id)){
                                //edit

                                if(isset($craftsman->craftsman_img)){
                                    $img_obj = json_decode($craftsman->craftsman_img, true);

                                    $img_url = asset('uploads/craftsmen/'.$img_obj['url']);
                                    $img_alt = $img_obj['alt'];

                                }
                                else{
                                    $img_url = asset('admin/site_imgs/avatar_craftsman.png');
                                    $img_alt = 'craftsman_avatar_img';
                                }

                            }
                            else{
                                // create view
                                $img_url = asset('admin/site_imgs/avatar_craftsman.png');
                                $img_alt = 'craftsman_avatar_img';
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
        avatar_img_preview($('#craftsman_img'), $('#img_holder'), 'card-img-top', 'avatar_img')
    </script>



@endsection
