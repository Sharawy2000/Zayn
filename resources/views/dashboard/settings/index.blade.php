@extends('dashboard.layouts.app')
@section('body')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Settings</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">settings</li>
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
                    
                    <form action="{{ route('settings.update',$setting->id) }}" method="post">
                        @csrf
                        @method('PUT')
                    <div class="card-body">
                        @include('inc.success-error-msg')
                      <div class="form-group">
                        <label for="exampleInputEmail1">App Title</label>
                        <input type="text" name='app_title' class="form-control" id="exampleInputEmail1" value="{{ $setting->app_title }}">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">About Us</label>
                        <textarea name="about_us" id="" cols="30" class="form-control" rows="10">{{ $setting->about_us }}</textarea>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Andriod Link</label>
                        <input type="text" name='android_link' class="form-control" id="exampleInputEmail1" value="{{ $setting->android_link }}">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">IOS Link</label>
                        <input type="text" name='ios_link' class="form-control" id="exampleInputEmail1" value="{{ $setting->ios_link }}">
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