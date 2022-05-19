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
                            <li class="breadcrumb-item active"><a href="{{route('admin.place.index') }}">Place Info / </a> {{  !isset($places->place_id)  ? 'Add / ' : "Edit / ". $places->place_name }}</li>
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
                            <h3 class="card-title">{{  !isset($place->place_id)  ? 'Add ' : "Edit "}} Info</h3>
                        </div>
                        <div class="card-body">
                            <?php !isset($place->place_id)  ? $id = '' : $id = $place->place_id ?>
                            <form class="form-group" method="post" action="{{ route('admin.place.edit', $id) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-6 pr-md-1 ">
                                        <label>Place Name</label>
                                        <input type="text" id="place_name" name="data[place_name]" class="form-control" placeholder="Enter Place Name"  value="{{ !isset($place->place_name) ? '' : $place->place_name }}">
                                    </div>
                                    <div class="col-md-6 pr-md-1">
                                        <label>phone</label>
                                        <input type="text" name="data[phone]" class="form-control" placeholder="Enter phone" value="{{ !isset($place->phone) ? '' : $place->phone }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6 pr-md-1">
                                        <label>Place Type</label>
                                        <select class="form-select form-control" name="data[place_type_id]" data-placeholder="Select a place type" style="width: 100%">
                                            @foreach($places_types->all() as $place_type)
                                                <option value="{{$place_type->place_type_id}}" {{isset($place->place_type_id) &&  $place->place_type_id == $place_type->place_type_id ? 'selected = "selected"': ''}} >{{$place_type->place_type_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 pr-md-1">
                                        <label>Address</label>
                                        <input type="text" name="data[address]" class="form-control" placeholder="Enter Address" value="{{ !isset($place->address) ? '' : $place->address }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6 pr-md-1">
                                        <label>Latitude</label>
                                        <input type="text" id="geo_location_lat" name="data[geo_location_lat]" class="form-control" placeholder="Enter Location Lat"  value="{{ !isset($place->geo_location_lat) ? '' : $place->geo_location_lat }}">
                                    </div>
                                    <div class="col-md-6 pr-md-1">
                                        <label>Longitude</label>
                                        <input type="text" id="geo_location_long" name="data[geo_location_long]" class="form-control" placeholder="Enter Location Long" value="{{ !isset($place->geo_location_long) ? '' : $place->geo_location_long }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <input  hidden="hidden" id="pac-input" class="controls" type="text" placeholder="Place Search "/>
                                    <div class="col-md-12 pr-md-1" id="google_map">
                                    </div>
                                </div>



                                <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAWqX-NuL2nbJcKobC-FUKfTfDGBVpL-e4&libraries=places&sensor=false">

                                </script>




                                <script type="text/javascript" src="{{asset('admin/my_files/maps.js')}}"></script>

                                <div class="row mb-3">
                                    <div class="col-md-6 pr-md-1">
                                        <label>Description</label>
                                        <textarea name="data[description]" class="form-control"  rows="3">{{ !isset($place->description) ? '' : $place->description }}</textarea>
                                    </div>
                                    <div class="col-md-6 pr-md-1">
                                        <label>City</label>
                                        <select class="form-select form-control" name="data[city_id]" data-placeholder="Select a State" style="width: 100%">
                                            @foreach($cities->all() as $city)
                                                <option value="{{$city->city_id}}" {{isset($place->city_id) &&  $place->city_id == $city->city_id ? 'selected = "selected"': ''}} >{{$city->city_name}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6 pr-md-1">
                                        <label>Show In Ads</label>
                                        <select class="form-select form-control" name="data[show_in_ads]" data-placeholder="Select Work State" >
                                            <option value="0" {{isset($place->show_in_ads) == 0 ? 'selected = "selected"': ''}} >No</option>
                                            <option value="1" {{isset($place->show_in_ads) == 1 ? 'selected = "selected"': ''}} >Yes</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 pr-md-1">
                                        <label>Show In Famous Places</label>
                                        <select class="form-select form-control" name="data[show_in_famous_places]" data-placeholder="Select Work State" >
                                            <option value="0" {{isset($place->show_in_famous_places) == 0 ? 'selected = "selected"': ''}} >No</option>
                                            <option value="1" {{isset($place->show_in_famous_places) == 1 ? 'selected = "selected"': ''}} >Yes</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6 pr-md-1">
                                        <label>Open Time</label>
                                        <div class="input-group date" id="timepicker" >
                                            <input class="form-control time" type="time" name="data[open_time]" value="{{ !isset($place->open_time) ? '' : date('H:i',strtotime($place->open_time)) }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6 pr-md-1">
                                        <label>Close Time</label>

                                        <div class="input-group date" id="timepicker" >
                                            <input class="form-control time" type="time" name="data[close_time]" value="{{ !isset($place->close_time) ? '' : date('H:i',strtotime($place->close_time))}}">
                                        </div>

                                    </div>


                                </div>

                                <div class="row mb-3">
                                    <?php
                                    if(isset($place->place_id)){
                                        /************** big img  ***************/
                                        //edit

                                        if(isset($place->big_img)){
                                            $big_img_obj = json_decode($place->big_img, true);

                                            $big_img_url = isset($big_img_obj['url']) ? asset('uploads/places/'.$big_img_obj['url']) : asset('admin/site_imgs/place_big_img.png');
                                            $big_img_alt = $big_img_obj['alt'];
                                            $big_img_title = $big_img_obj['title'];


                                        }
                                        else{
                                            $big_img_url = asset('admin/site_imgs/place_big_img.png');
                                            $big_img_alt = 'place_avatar_img';
                                        }

                                    }
                                    else{
                                        // create view
                                        $big_img_url = asset('admin/site_imgs/place_big_img.png');
                                        $big_img_alt = 'place_avatar_img';
                                    }


                                    ?>
                                    <div class="col-md-6 pr-md-1">
                                        <label>Upload Big Image</label>
                                        <div class="custom-file" style="width: 90%;">
                                            <input type="file" name="data[big_img][url]" id="big_img" class="custom-file-input">
                                            <label class="custom-file-label" for="exampleInputFile">Choose photo</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 pr-md-1">
                                        <label>Big Image Title</label>
                                        <input type="text" name="data[big_img][title]" class="form-control" placeholder="Enter Big Image Title" value="{{ !isset($place->big_img) ? '' : $big_img_title }}">
                                    </div>
                                    <div class="col-md-3 pr-md-1">
                                        <label>Big Image Alt</label>
                                        <input type="text" name="data[big_img][alt]" class="form-control" placeholder="Enter Big Image Alt" value="{{ !isset($place->big_img) ? '' : $big_img_alt }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <?php

                                    if(isset($place->place_id)){
                                        //edit
                                        if(isset($place->small_img)){

                                            $small_img_obj = json_decode($place->small_img, true);
                                            $small_img_url = isset($small_img_obj['url']) ? asset('uploads/places/'.$small_img_obj['url']) : asset('admin/site_imgs/place_small_img.png');
                                            $small_img_alt = $small_img_obj['alt'];
                                            $small_img_title = $small_img_obj['title'];

                                        }
                                        else{
                                            $small_img_url = asset('admin/site_imgs/place_small_img.png');
                                            $small_img_alt = 'place_avatar_img';
                                        }

                                    }
                                    else{
                                        // create view
                                        $small_img_url = asset('admin/site_imgs/place_small_img.png');
                                        $small_img_alt = 'place_avatar_img';
                                    }
                                    ?>
                                    <div class="col-md-6 pr-md-1">
                                        <label>Upload Small Image</label>
                                        <div class="custom-file" style="width: 90%;">
                                            <input type="file" name="data[small_img][url]" id="small_img" class="custom-file-input">
                                            <label class="custom-file-label" for="exampleInputFile">Choose photo</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 pr-md-1">
                                        <label>Small Image Title</label>
                                        <input type="text" name="data[small_img][title]" class="form-control" placeholder="Enter Small Image Title" value="{{ !isset($place->small_img) ? '' : $small_img_title}}">
                                    </div>
                                    <div class="col-md-3 pr-md-1">
                                        <label>Small Image Alt</label>
                                        <input type="text" name="data[small_img][alt]" class="form-control" placeholder="Enter Small Image Alt" value="{{ !isset($place->small_img) ? '' : $small_img_alt}}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <?php
                                    ?>
                                    <div class="col-md-6 pr-md-1">
                                        <label>Upload Slider</label>
                                        <div class="custom-file" style="width: 90%;">
                                            <input type="file" name="data[slider_img][url][new][]" id="slider_img" class="custom-file-input" multiple>
                                            <label class="custom-file-label" for="exampleInputFile">Choose photos</label>
                                        </div>
                                    </div>
                                </div>
                                <div id="deleted_slider_imgs">

                                </div>

                                <div id="slider_img_holder">


                                        <?php
                                        if(isset($place->place_id)){
                                            //edit

                                            if(!empty($place->slider_img)){
                                                $img_obj = json_decode($place->slider_img, true);

                                                for($i = 0; $i < count($img_obj); $i++){
                                                    $slider_img_url   = $img_obj[$i]['url'];
                                                    $slider_img_path  = asset('uploads/places/sliders/'.$slider_img_url);
                                                    $slider_img_alt   = $img_obj[$i]['alt'];
                                                    $slider_img_title = $img_obj[$i]['title'];

                                                    echo"
                                                         <div class='row mb-3' id='$slider_img_url'>
                                                            <div class='col-md-2 pr-md-1'>
                                                                <img class='place_slider_img_style' src='$slider_img_path'>
                                                                <input type='hidden' name='data[slider_img][url][old][]' value='$slider_img_url'>
                                                            </div>
                                                            <div class='col-md-2 pr-md-1'>
                                                                <label>Title</label>
                                                                <input type='text' name='data[slider_img][title][]' class='form-control' placeholder='Image Title' value='$slider_img_title'>
                                                            </div>
                                                            <div class='col-md-2 pr-md-1'>
                                                                <label>Alt</label>
                                                                <input type='text' name='data[slider_img][alt][]' class='form-control' placeholder='Image Alt' value='$slider_img_alt'>
                                                            </div>
                                                            <div class='col-md-2 pr-md-1 place_slider_img_delete_btn'>
                                                                <button type='button' class='btn btn-danger float-right remover_div' onclick='remover_slider_img(this)'>Delete</button>
                                                            </div>
                                                         </div>
                                                        ";
                                                }

                                            }


                                        }


                                        ?>

                                        <input hidden id="slider_counter_id" value="{{isset($place->slider_img) ? count(json_decode($place->slider_img)): 0 }}">

                                    </div>



                                <br>
                                <button type="submit" class="btn btn-success float-right">{{  !isset($place->place_id)  ? 'Create' : 'Edit'}}</button>
                            </form>


                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>

                <div class="col-md-4">


                    <div class="card card-info">
                        <div class="card-header">
                            <h2 class="card-title img_label">Place Big Image</h2>
                        </div>
                        <div class="card-body">
                            <div id="big_img_holder">
                                <img class="card-img-top place_big_img_style"  id="place_big_img" src="{{$big_img_url}}" alt="{{$big_img_alt}}" >
                            </div>
                        </div>
                    </div>

                    <div class="card card-info">
                        <div class="card-header">
                            <h2 class="card-title img_label">Place Small Image</h2>
                        </div>
                        <div class="card-body">
                            <div id="small_img_holder">
                                <img class="card-img-top place_small_img_style"  id="place_small_img" src="{{$small_img_url}}" alt="{{$small_img_alt}}" >
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <script>
        images_previews('big_img', 'big_img_holder', 'place_big_img','place_big_img_style', 'form-control');
        images_previews('small_img', 'small_img_holder', 'place_small_img','place_small_img_style', 'form-control');
        images_previews('slider_img', 'slider_img_holder', 'slider_img','place_slider_img_style', 'form-control', 'slider', 'slider_img', 'slider_counter_id');

        console.log();



    </script>

@endsection
