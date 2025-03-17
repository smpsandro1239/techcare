@extends('admin.layouts.layout')
@section('admin_page_title')
Manage Default Attribute
@endsection

@section('admin_layout')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">All Default Attribute</h5> 
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
                                <th>Attribute</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                         @foreach ($allattributes as $attribute)
                            <tr>
                                <td>{{$attribute->id}}</td>
                                <td>{{$attribute->attribute_value}}</td>
                                <td>
                                    <a href="{{route('product_attribute.edit', $attribute->id)}}" class="btn btn-info">Edit</a>
                                    
                                    <form action="{{route('product_attribute.delete', $attribute->id)}}" method="POST" style="display:inline;">
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
            </div>
        </div>
    </div>
</div>
@endsection
