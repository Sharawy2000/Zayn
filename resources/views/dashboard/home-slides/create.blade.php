@extends('dashboard.layouts.app')
@section('body')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Home Slide</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">home slides</li>
              <li class="breadcrumb-item"><a href="{{ route('home-slides.index') }}"><i class="fas fa-arrow-left"> </i> back</a></li>

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
                    <form action="{{ route('home-slides.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                    <div class="card-body">
                        @include('inc.success-error-msg')
                      <div class="form-group">
                        <label for="exampleInputEmail1">Title</label>
                        <input type="text" name='title' class="form-control" id="exampleInputEmail1" placeholder="Enter a slide title">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Description</label>
                        <textarea name="description" class="form-control" id="exampleInputEmail1" cols="30" rows="10" placeholder="Write a description . . ."></textarea>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Image</label>
                        <input type="file" class="form-control" name="image">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Order</label>
                        <input type="number" name='order' class="form-control" id="exampleInputEmail1" placeholder="Enter an order">
                      </div>
                    </div>
                    <!-- /.card-body -->
    
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Create</button>
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