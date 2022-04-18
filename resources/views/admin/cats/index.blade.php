@extends('admin/layout')
@section('content')

    <script>

        CustomAlert()
    </script>

    <div class="d-flex justify-content-between mb-3">
        <h6>Category</h6>
        <a class="btn btn-sm btn-primary" href="{{ route('admin.cat.edit') }}">+ Add new</a>
    </div>

    <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Category Name</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>

            @foreach($cats as $cat)
                <tr>
                    <td scope="row">{{ $loop->iteration }}</td>
                    <td>{{ $cat->cat_name }}</td>
                    <td>
                        <a class="btn btn-sm btn-info" href="{{ route('admin.cat.edit', $cat->cat_id) }}">Edit</a>
                        <a class="btn btn-sm btn-danger" href="{{ route('admin.cat.delete', $cat->cat_id) }}" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
