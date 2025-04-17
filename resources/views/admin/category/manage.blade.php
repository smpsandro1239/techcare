@extends('admin.layouts.layout')
@section('admin_page_title')
Manage Category
@endsection

@section('admin_layout')
@include('layouts.partials.navbar')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">All Categories</h5>
            </div>

            @if (session('message'))
  <div class="alert alert-success my-2">
    {{session('message')}}
  </div>
@endif
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                         @foreach ($categories as $cat)
                            <tr>
                                <td>{{$cat->id}}</td>
                                <td>{{$cat->category_name}}</td>
                                <td>
                                    <a href="{{route('admin.category.show', $cat->id)}}" class="btn btn-info">Edit</a>

                                    <form action="{{route('admin.category.delete', $cat->id)}}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" value="Delete" class="btn btn-danger">
                                    </form>
                                </td>
                            </tr>
                         @endforeach
                        </tbody>
                    </table>
                </div>
                {{$categories->appends(request()->query())->links()}}
            </div>
        </div>
    </div>
</div>
@endsection
