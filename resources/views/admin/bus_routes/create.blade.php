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
                            <li class="breadcrumb-item active"><a href="{{route('admin.bus_route.index') }}">Bus Routes / </a> {{  !isset($bus_route->bus_route_id)  ? 'Add / ' : "Edit / ". $bus_route->bus_route_name}}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

    @include('admin/components/errors')

    <!-- Main content -->
        <section class="content">
            <div class="row justify-content-center">
                <div class="col-md-6 ">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{  !isset($bus_route->bus_route_id)  ? 'Add ' : "Edit "}} Info</h3>
                        </div>
                        <div class="card-body">
                            <?php !isset($bus_route->bus_route_id)  ? $id = '' : $id = $bus_route->bus_route_id ?>
                            <form class="form-group" method="post" action="{{ route('admin.bus_route.edit', $id) }}" enctype="multipart/form-data">
                                @csrf

                                <div class="row mb-6">
                                    <div class="col-md-3 pr-md-1 ">
                                        <label>Bus Route Name</label>
                                        <input type="text" name="data[bus_route_name]" class="form-control" style="text-align: right;" placeholder="Enter Bus Route Name" value="{{ !isset($bus_route->bus_route_name) ? '' : $bus_route->bus_route_name }}">
                                    </div>
                                </div>
                                <div class="row mb-6">
                                    <div class="col-md-9 pr-md-1 ">
                                        <label>Bus Route Stations</label>
                                        <textarea name="data[bus_route_stations]" class="form-control" style="text-align: right;" rows="7" placeholder="Enter Bus Route Stations" >{{ !isset($bus_route->bus_route_stations) ? '' : $bus_route->bus_route_stations }}</textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success float-right">{{  !isset($bus_route->bus_route_id)  ? 'Create' : 'Edit'}}</button>
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