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
                            <li class="breadcrumb-item active"><a href="{{route('admin.user_group.index') }}">User Group / </a> {{  !isset($user_group->user_group_id)  ? 'Add / ' : "Edit / ". $user_group->user_group_name }}</li>
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
                            <h3 class="card-title">{{  !isset($user_group->user_group_id)  ? 'Add ' : "Edit "}} Info</h3>
                        </div>
                        <div class="card-body">
                            <?php !isset($user_group->user_group_id)  ? $id = '' : $id = $user_group->user_group_id ?>
                            <form class="form-group" method="post" action="{{ route('admin.user_group.edit', $id) }}">
                                @csrf
                                <label>User Group Name</label>
                                <input type="text" name="data[user_group_name]" class="form-control" placeholder="Enter User Group Name" value="{{ !isset($user_group->user_group_name) ? '' : $user_group->user_group_name }}">
                                <br>
                                <button type="submit" class="btn btn-success float-right">{{  !isset($user_group->user_group_id)  ? 'Create' : 'Edit'}}</button>
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