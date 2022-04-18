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
                <div class="col-md-9">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{  !isset($place->place_id)  ? 'Add ' : "Edit "}} Info</h3>
                        </div>
                        <div class="card-body">
                            <?php !isset($place->place_id)  ? $id = '' : $id = $place->place_id ?>
                            <form class="form-group" method="post" action="{{ route('admin.place.edit', $id) }}">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-6 pr-md-1 ">
                                        <label>Place Name</label>
                                        <input type="text" name="data[place_name]" class="form-control" placeholder="Enter Place Name"  value="{{ !isset($place->place_name) ? '' : $place->place_name }}">
                                    </div>
                                    <div class="col-md-6 pr-md-1">
                                        <label>Slug</label>
                                        <input type="text" name="data[slug]" class="form-control" placeholder="Enter Slug" value="{{ !isset($place->slug) ? '' : $place->slug }}">
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
                                    <div class="col-md-6 pr-md-1 ">
                                        <label>Location Lat</label>
                                        <input type="text" name="data[geo_location_lat]" class="form-control" placeholder="Enter Location Lat"  value="{{ !isset($place->geo_location_lat) ? '' : $place->geo_location_lat }}">
                                    </div>
                                    <div class="col-md-6 pr-md-1">
                                        <label>Location Long</label>
                                        <input type="text" name="data[geo_location_long]" class="form-control" placeholder="Enter Location Long" value="{{ !isset($place->geo_location_long) ? '' : $place->geo_location_long }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6 pr-md-1">
                                        <label>Description</label>
                                        <textarea name="description" class="form-control"  rows="3"></textarea>
                                    </div>
                                    <div class="col-md-6 pr-md-1">
                                        <label>City</label>
                                        <select class="form-select form-control" name="data[city_id]" data-placeholder="Select a State" style="width: 100%">
                                            @foreach($cities->all() as $city)
                                                <option value="{{$city->city_id}}" {{isset($craftsman->city_id) &&  $craftsman->city_id == $city->city_id ? 'selected = "selected"': ''}} >{{$city->city_name}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6 pr-md-1">
                                        <label>Show In Ads</label>
                                        <select class="form-select form-control" name="data[show_in_ads]" data-placeholder="Select Work State" style="width: 60%">
                                            <option value="0" {{isset($craftsman->show_in_ads) == 0 ? 'selected = "selected"': ''}} >No</option>
                                            <option value="1" {{isset($craftsman->show_in_ads) == 1 ? 'selected = "selected"': ''}} >Yes</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 pr-md-1">
                                        <label>Show In Famous Places</label>
                                        <select class="form-select form-control" name="data[show_in_famous_places]" data-placeholder="Select Work State" style="width: 60%">
                                            <option value="0" {{isset($craftsman->show_in_famous_places) == 0 ? 'selected = "selected"': ''}} >No</option>
                                            <option value="1" {{isset($craftsman->show_in_famous_places) == 1 ? 'selected = "selected"': ''}} >Yes</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6 pr-md-1">
                                        <label>Open Time</label>
                                        <div class="input-group date" id="timepicker" style="width: 60%">
                                            <input class="form-control time" type="time" name="open_time">
                                        </div>
                                    </div>

                                    <div class="col-md-6 pr-md-1">
                                        <label>Close Time</label>

                                        <div class="input-group date" id="timepicker" style="width: 60%">
                                            <input class="form-control time" type="time" name="close_time">
                                        </div>

                                    </div>


                                </div>

                                <div class="row mb-3">

                                    <div class="col-md-6 pr-md-1">
                                        <label>Upload Photo <span style="color: red;">@To do img</span></label>
                                        <div class="custom-file">
                                            <input type="file"  class="custom-file-input" id="exampleInputFile">
                                            <label class="custom-file-label" for="exampleInputFile">Choose photo</label>
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <button type="submit" class="btn btn-success float-right">{{  !isset($place->place_id)  ? 'Create' : 'Edit'}}</button>
                            </form>


                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection
