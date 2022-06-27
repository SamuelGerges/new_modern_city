@extends('admin/layout')


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Users Data</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Users</li>
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
                                <h3 class="card-title">Users </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <a class="btn btn-success btn-sm mb-3" href="{{ route('admin.user.edit')}}"><i class="fas fa-plus"></i>  Add New User</a>

                                <table id="example2" class="table table-bordered table-hover" >
                                    <thead class="thead-dark" style=" font-size: larger">
                                    <tr>
                                        <th style="width: 3%" class="text-center">#</th>
                                        <th style="width: 13%" class="text-center">First Name</th>
                                        <th style="width: 13%" class="text-center">Last Name</th>
                                        <th style="width: 15%" class="text-center">User Group</th>
                                        <th style="width: 20%" class="text-center">Email</th>
                                        <th style="width: 15%" class="text-center">City</th>
                                        <th style="width: 20%" class="text-center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tbody>
                                        @foreach($users->all() as $user)
                                            <tr>
                                                <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $user->first_name }}</td>
                                                <td class="text-center">{{ $user->last_name }}</td>
                                                <td class="text-center">{{ $user->show_user_group($user->user_group_id) }}</td>
                                                <td class="text-center">{{ $user->email }}</td>
                                                <td class="text-center">{{ $user->show_user_city($user->city_id) }}</td>


                                                <td class="project-actions text-center">
                                                    <a class="btn btn-info btn-sm" href="{{ route('admin.user.edit', $user->user_id) }}">
                                                        <i class="fas fa-pencil-alt">
                                                        </i>
                                                        Edit
                                                    </a>
                                                    <a class="btn btn-danger btn-sm" href="{{ route('admin.user.delete', $user->user_id) }}">
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