@extends('seller.layouts.layout')
@section('seller_page_title')
Manage Store
@endsection

@section('seller_layout')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">All Store Created by You</h5> 
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
                                <th>Store Name</th>
                                <th>Slug</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                         @foreach ($stores as $store)
                            <tr>
                                <td>{{$store->id}}</td>
                                <td>{{$store->store_name}}</td>
                                <td>{{$store->slug}}</td>
                                <td>{{$store->description}}</td>
                                <td>
                                    <a href="{{}}" class="btn btn-info">Edit</a>
                                    
                                    <for action="" method="POST">
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
