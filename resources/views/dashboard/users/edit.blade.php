@extends('dashboard.layouts.app')
@inject('role', 'Spatie\Permission\Models\Role')
@section('body')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">User #{{ $user->id }}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
              <li class="breadcrumb-item"><a href="{{ route('users.index') }}"><i class="fas fa-arrow-left"> </i> back</a></li>
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
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    
                    <form action="{{ route('users.update',$user->id) }}" method="post">
                        @csrf
                        @method('PUT')
                    <div class="card-body">
                        @include('inc.success-error-msg')
                      <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" name='name' class="form-control" id="exampleInputEmail1" value="{{ $user->name }}">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" name='email' class="form-control" id="exampleInputEmail1" value="{{ $user->email }}">
                      </div>
                      <div class="form-group" >
                        <label for="exampleInputEmail1">Roles</label><br>
                        <input type="checkbox" id="select-all" style="margin-right: 10px;">
                        <label for="select-all" style="font-weight: bold;margin:10px 0 20px 0">Select All</label><br>
                        @foreach ( $role->all() as $role )
                          <div style="display: inline-block;margin-bottom:10px">
                           <input style="margin-right: 10px" class="role-checkbox" type="checkbox" value="{{ $role->id }}" name="roles[]" {{ $user->roles->contains($role->id)?'checked':'' }}>
                           <span style="margin-right: 20px">{{ $role->name }}</span>
                          </div>
                           @endforeach
                      </div>
                    </div>
                    <!-- /.card-body -->
    
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                  </form>
                </div>

            </div>
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection
@section('scripts')
<script>
  document.getElementById('select-all').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('.role-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked; 
        });
  });

</script>
@endsection