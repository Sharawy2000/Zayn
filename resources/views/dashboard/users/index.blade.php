@extends('dashboard.layouts.app')
@section('body')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Users</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
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
          <a href="{{ route('users.create') }}" style="margin: 0px 0px 10px 8px" class="btn btn-success">Create a user</a>
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  @include('inc.success-error-msg')
                  <h3 class="card-title">Table</h3>
  
                  <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                      <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
  
                      <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                          <i class="fas fa-search"></i>
                        </button>
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
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Created</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user )    
                            <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                              @foreach ($user->roles as $role )
                              @if ($role->name == 'Super-Admin')
                                <span class="badge badge-danger">{{ $role->name }}</span>
                              @elseif ($role->name == 'Admin' || $role->name == 'Manager' )
                                <span class="badge badge-success">{{ $role->name }}</span>
                              @elseif ($role->name == 'Leader' || $role->name == 'Lead' )
                                <span class="badge badge-warning">{{ $role->name }}</span>
                              @else
                                <span class="badge badge-primary">{{ $role->name }}</span>
                              @endif
                              @endforeach
                            </td>
                            <td>{{ $user->created_at->diffForHumans()}}</td>
                            <td>
                              <a href="{{ route('users.edit',$user->id) }}" class="btn btn-primary">Edit</a>
                              <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                style="display: inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure ?');" {{ $user->id == auth()->user()->id ? 'disabled' : '' }} class="btn btn-danger">Delete</button>
                              </form>
                            </td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              @include('inc.paginator',['paginator'=>$users])
              <!-- /.card -->
            </div>
          </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection