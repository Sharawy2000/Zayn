@extends('dashboard.layouts.app')
@inject('permission', 'Spatie\Permission\Models\Permission')
@section('body')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Role #{{ $role->id }}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">role</li>
              <li class="breadcrumb-item"><a href="{{ route('roles.index') }}"><i class="fas fa-arrow-left"> </i> back</a></li>

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
                    <form action="{{ route('roles.update',$role->id) }}" method="post">
                        @csrf
                        @method('PUT')
                    <div class="card-body">
                        @include('inc.success-error-msg')
                      <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" name='name' class="form-control" id="exampleInputEmail1" value="{{ $role->name }}">
                      </div>
                      <div class="form-group" >
                        <label for="exampleInputEmail1">Permissions</label><br>
                        <input type="checkbox" id="select-all" style="margin-right: 10px;">
                        <label for="select-all" style="font-weight: bold;margin:10px 0 20px 0">Select All</label><br>
                        @foreach ( $permission->all() as $permission )
                          <div style="display: inline-block;margin-bottom:10px">
                           <input style="margin-right: 10px" class="permission-checkbox" type="checkbox" value="{{ $permission->id }}" name="permissions[]" {{ $role->permissions->contains($permission->id)?'checked':'' }}>
                           <span style="margin-right: 20px">{{ $permission->name }}</span>
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
        const checkboxes = document.querySelectorAll('.permission-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked; // Set each checkbox's state to match "Select All"
        });
  });

</script>
@endsection