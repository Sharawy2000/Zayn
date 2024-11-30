@extends('dashboard.layouts.app')
@section('body')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Contact Messages</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">contact messages</li>
              
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
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                @include('inc.success-error-msg')
                <h3 class="card-title">Table</h3>
                <div class="card-tools">
                  <form id="search-form" action="{{ route('contact-messages.index') }}" method="get">
                    @csrf
                  </form>
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="search" class="form-control float-right" placeholder="Search" form="search-form">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default" form="search-form">
                        <i class="fas fa-search"></i>
                      </button>
                      <a href="{{ route('contact-messages.index') }}" class="btn btn-default" ><i class="fas fa-times-circle" ></i></a>
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
                      <th>Email</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($contactMessages as $cMessage )  
                    <tr data-widget="expandable-table" aria-expanded="true">
                      <td>{{$cMessage->id}}</td>
                      <td>{{$cMessage->name}}</td>
                      <td>{{$cMessage->email}}</td>
                      <td>
                        <form action="{{ route('contact-messages.destroy', $cMessage->id) }}" method="POST"
                          style="display: inline-block">
                          @csrf
                          @method('DELETE')
                          <button type="submit" onclick="return confirm('Are you sure ?');" class="btn btn-danger">Delete</button>
                        </form>
                      </td>
                    </tr>
                    <tr class="expandable-body">
                      <td colspan="4">
                        <p>
                          {{ $cMessage->description }}
                        </p>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            @include('inc.paginator',['paginator'=>$contactMessages])
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
              @foreach ($contact-messages as $cMessage )  
              <tr data-widget="expandable-table" aria-expanded="false">
                <td>{{$cMessage->id}}</td>
                <td>{{$cMessage->name}}</td>
                <td>
                  <a href="{{ route('contact-messages.edit',$cMessage->id) }}" class="btn btn-primary">Edit</a>
                  <form action="{{ route('contact-messages.destroy', $cMessage->id) }}" method="POST"
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
                    {{ $cMessage->description }}
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