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
                            <li class="breadcrumb-item active"><a href="{{route('admin.city.index') }}">User Group / </a> {{  !isset($users_groups->user_group_id)  ? 'Add / ' : "Edit / ". $users_groups->user_group_name }}</li>
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
                            <h3 class="card-title">{{  !isset($city->city_id)  ? 'Add ' : "Edit "}} Info</h3>
                        </div>
                        <div class="card-body">
                            <?php !isset($city->city_id)  ? $id = '' : $id = $city->city_id ?>
                            <form class="form-group" method="post" action="{{ route('admin.city.edit', $id) }}" enctype="multipart/form-data">
                                @csrf

                                <div class="row mb-3">
                                    <div class="col-md-12 pr-md-1 ">
                                        <label>City Name</label>
                                        <input type="text" name="data[city_name]" class="form-control" placeholder="Enter City Name" value="{{ !isset($city->city_name) ? '' : $city->city_name }}">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success float-right">{{  !isset($city->city_id)  ? 'Create' : 'Edit'}}</button>
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