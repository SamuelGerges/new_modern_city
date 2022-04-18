@extends('admin/layout')
@section('content')



    <?php



          if(isset($cat) && gettype($cat) == 'array'){
              $cat = (object) $cat;
          }
    ?>
    <div class="d-flex justify-content-between mb-3">
        <h6>Category / {{  !isset($cat->cat_id)  ? 'Add' : "Edit / ". $cat->cat_name }} </h6>
        <a class="btn btn-sm btn-primary" href="{{ route('admin.cat.index') }}"> <= back</a>
    </div>

    @include('admin/components/errors')

    <?php !isset($cat->cat_id)  ? $id = '' : $id = $cat->cat_id ?>
    <form method="post" action="{{ route('admin.cat.edit', $id) }}">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Category Name</label>
            <input type="text" name="data[cat_name]" class="form-control" value="{{ !isset($cat->cat_name) ? '' : $cat->cat_name }}">

        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

@endsection