@extends('dashboard.layouts.app')
@inject('country', 'App\Models\Country')
@inject('city', 'App\Models\City')
@inject('neighborhood', 'App\Models\Neighborhood')
@section('body')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">customer #{{ $customer->id }}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">customers</li>
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
                    <form action="{{ route('customers.update',$customer->id) }}" method="post">
                        @csrf
                        @method('PUT')
                    <div class="card-body">
                        @include('inc.success-error-msg')
                      <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" name='name' class="form-control" id="exampleInputEmail1" value="{{ $customer->name }}">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Phone</label>
                        <input type="phone" name='phone' class="form-control" id="exampleInputEmail1" value="{{ $customer->phone }}">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" name='email' class="form-control" id="exampleInputEmail1" value="{{ $customer->email }}">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Contries</label>
                        <select name="countries" class="form-control" id="exampleInputEmail1">
                          @foreach ($country->all() as $country )
                            {{-- {{ $city->name }} --}}
                            <option value="{{ $country->id }}" {{ $customer->neighborhood->city->country->id == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Cities</label>
                        <select name="cities" class="form-control" id="exampleInputEmail1">
                          @foreach ($city->all() as $city )
                            {{-- {{ $city->name }} --}}
                            <option value="{{ $city->id }}" {{ $customer->neighborhood->city->id == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Neighborhoods</label>
                        <select name="neighborhood_id" class="form-control" id="exampleInputEmail1">
                          @foreach ($neighborhood->all() as $neighborhood )
                            {{-- {{ $city->name }} --}}
                            <option value="{{ $neighborhood->id }}" {{ $customer->neighborhood->id == $neighborhood->id ? 'selected' : '' }}>{{ $neighborhood->name }}</option>
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