@extends('dashboard.layouts.app')
@section('body')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Products</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">products</li>
              
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        
        <div class="row">
          <a href="{{ route('products.create') }}" style="margin: 0px 0px 10px 8px" class="btn btn-success">Create a product</a>
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                @include('inc.success-error-msg')
                <h3 class="card-title">Table</h3>
                <div class="card-tools">
                  <form id="search-form" action="{{ route('products.index') }}" method="get">
                    @csrf
                  </form>
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="search" class="form-control float-right" placeholder="Search" form="search-form">
  
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default" form="search-form">
                        <i class="fas fa-search"></i>
                      </button>
                      <a href="{{ route('products.index') }}" class="btn btn-default" ><i class="fas fa-times-circle" ></i></a>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- ./card-header -->
              <div class="card-body">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Category</th>
                      <th>Images</th>
                      <th>Sizes</th>
                      <th>Colors</th>
                      <th>Price</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($products as $product )  
                    <tr data-widget="expandable-table" aria-expanded="true">
                      <td>{{$product->id}}</td>
                      <td>{{$product->name}}</td>
                      <td>{{$product->category->name}}</td>
                      <td>
                        @foreach ($product->images as $img )
                        <img src="{{ asset($img->url) }}" alt="No Image" width="50" height="50">
                        @endforeach
                      </td>
                      <td>
                        @foreach ($product->sizes as $size )
                        @if ($size->name == '3XL')
                        <span style="display: block;margin-top:5px" class="badge badge-danger">{{ $size->name }}</span>                          
                        @elseif ($size->name == '2XL' || $size->name == 'XL')
                        <span style="display: block;margin-top:5px" class="badge badge-warning">{{ $size->name }}</span>                          
                        @else
                        <span style="display: block;margin-top:5px" class="badge badge-success">{{ $size->name }}</span>                          
                        @endif
                        @endforeach
                      </td>
                      <td>
                        @foreach ($product->colors as $color )
                          <div style="
                              width: 50px;
                              height: 50px;
                              border-radius: 50%; /* Circle shape */
                              background-color: {{ strtolower($color->name) }};
                              display: inline-block;
                          ">
                          </div>
                        @endforeach
                      </td>
                      <td>{{$product->price}}</td>
                      <td>
                        <a href="{{ route('products.edit',$product->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                          style="display: inline-block">
                          @csrf
                          @method('DELETE')
                          <button type="submit" onclick="return confirm('Are you sure ?');" class="btn btn-danger">Delete</button>
                        </form>
                      </td>
                    </tr>
                    <tr class="expandable-body">
                      <td colspan="8">
                        <p>
                          {{ $product->description }}
                        </p>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
         
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection

{{-- 
  <div class="row">
    <div class="col-12">
      <div class="card">
        @include('inc.success-error-msg')
        <div class="card-header">
          <h3 class="card-title">Table</h3>
        </div>
        <!-- ./card-header -->
        <div class="card-body">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($products as $product )  
              <tr data-widget="expandable-table" aria-expanded="false">
                <td>{{$product->id}}</td>
                <td>{{$product->name}}</td>
                <td>
                  <a href="{{ route('products.edit',$product->id) }}" class="btn btn-primary">Edit</a>
                  <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                    style="display: inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure ?');" class="btn btn-danger">Delete</button>
                  </form>
                </td>
              </tr>
              <tr class="expandable-body">
                <td colspan="3">
                  <p>
                    {{ $product->description }}
                  </p>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
  </div>
  
  --}}