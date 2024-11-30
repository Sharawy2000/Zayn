@extends('dashboard.layouts.app')
@section('body')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Roles</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">roles</li>
              
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
          <a href="{{ route('roles.create') }}" style="margin: 0px 0px 10px 8px" class="btn btn-success">Create a role</a>
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  @include('inc.success-error-msg')
                  <h3 class="card-title">Table</h3>
                  <div class="card-tools">
                    <form id="search-form" action="{{ route('roles.index') }}" method="get">
                      @csrf
                    </form>
                    <div class="input-group input-group-sm" style="width: 150px;">
                      <input type="text" name="search" class="form-control float-right" placeholder="Search" form="search-form">
  
                      <div class="input-group-append">
                        <button type="submit" class="btn btn-default" form="search-form">
                          <i class="fas fa-search"></i>
                        </button>
                        <a href="{{ route('roles.index') }}" class="btn btn-default" ><i class="fas fa-times-circle" ></i></a>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                  <table class="table table-hover text-nowrap">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role )    
                            <tr>
                            <td>{{ $role->id }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                              <a href="{{ route('roles.edit',$role->id) }}" class="btn btn-primary">Edit</a>
                              <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                style="display: inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure ?');" class="btn btn-danger">Delete</button>
                              </form>
                            </td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              @include('inc.paginator',['paginator'=>$roles])
              <!-- /.card -->
            </div>
          </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection