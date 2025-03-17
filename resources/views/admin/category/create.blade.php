@extends('admin.layouts.layout')
@section('admin_page_title')
    Create Category
@endsection
@section('admin_layout')
<h3>Create Category Page</h3>
<div class="row">
<div class="col-12">
<div class="card">
<div class="card-header">
<h5 class="card-title mb-0">Create Category</h5>
</div>
<div class="card-body">

@if ($errors->any())
    <div class="alert alert-warning alert-dismissible fade show ">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('message'))
  <div class="alert alert-success">
    {{session('message')}}
  </div>
@endif
<form action="{{route('store.cat')}}"method="POST">
    @csrf
<label for="category_name"class="fw-bold mb-2">Give Name of Your Category</label>
<input type="text" class="form-control" name="category_name" placeholder="Computer">


<button type="submit" class="btn btn-primary w-100 mt-2">Add Category</button>
</form>
</div>
</div>

@endsection