@extends('dashboard.layouts.app')
@inject('country', 'App\Models\Country')
@inject('city', 'App\Models\City')
@section('body')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">neighborhood #{{ $city->id }}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">city</li>
              <li class="breadcrumb-item"><a href="{{ route('neighborhoods.index') }}"><i class="fas fa-arrow-left"> </i> back</a></li>

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
                    <form action="{{ route('neighborhoods.update',$neighborhood->id) }}" method="post">
                        @csrf
                        @method('PUT')
                    <div class="card-body">
                        @include('inc.success-error-msg')
                      <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" name='name' class="form-control" id="exampleInputEmail1" value="{{ $neighborhood->name }}">
                      </div>

                      <div class="form-group">
                        <label for="exampleInputEmail1">City</label>
                         <select name="city_id" class="form-control" id="exampleInputEmail1">
                          @foreach ($city->all() as $city )
                            <option value="{{ $city->id }}" {{ $neighborhood->city->id == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                          @endforeach
                         </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Country</label>
                         <select name="country_id" class="form-control" id="exampleInputEmail1">
                          @foreach ($country->all() as $country )
                            <option value="{{ $country->id }}" {{ $neighborhood->city->country->id == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                          @endforeach
                         </select>
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