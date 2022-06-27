@extends('admin/layout')


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Craftsmen Data</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Craftsmen</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Craftsmen </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <a class="btn btn-success btn-sm mb-3" href="{{ route('admin.craft.edit')}}"><i class="fas fa-plus"></i>  Add New User</a>

                                <table id="example2" class="table table-bordered table-hover" >
                                    <thead class="thead-dark" style=" font-size: larger">
                                    <tr>
                                        <th style="width: 3%" class="text-center">#</th>
                                        <th style="width: 13%" class="text-center">First Name</th>
                                        <th style="width: 13%" class="text-center">Last Name</th>
                                        <th style="width: 15%" class="text-center">Craftsman Type</th>
                                        <th style="width: 20%" class="text-center">Work State</th>
                                        <th style="width: 15%" class="text-center">City</th>
                                        <th style="width: 20%" class="text-center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tbody>


                                        @foreach($craftsmen->all() as $craftsman)
                                            <tr>
                                                <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $craftsman->first_name }}</td>
                                                <td class="text-center">{{ $craftsman->last_name }}</td>
                                                <td class="text-center">{{ $craftsman->show_craftsman_type($craftsman->craftsman_type_id) }}</td>
                                                <td class="text-center">{{ $craftsman->work_state  == 0 ? 'Not Available' : 'Available'}}</td>
                                                <td class="text-center">{{ $craftsman->show_craftsman_city($craftsman->city_id) }}</td>



                                                <td class="project-actions text-center">
                                                    <a class="btn btn-info btn-sm" href="{{ route('admin.craft.edit', $craftsman->craftsman_id) }}">
                                                        <i class="fas fa-pencil-alt">
                                                        </i>
                                                        Edit
                                                    </a>
                                                    <a class="btn btn-danger btn-sm" href="{{ route('admin.craft.delete', $craftsman->craftsman_id) }}">
                                                        <i class="fas fa-trash">
                                                        </i>
                                                        Delete
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection