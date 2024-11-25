@extends('dashboard.layouts.app')
@section('body')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Orders</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">orders</li>
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
                        <th>Customer ID</th>
                        <th>Status</th>
                        <th>Total Price</th>
                        <th>Price After Offer</th>
                        <th>Payment Method</th>
                        <th>Created At</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order )    
                            <tr>
                            <td><a href="{{ route('orders.show',$order->id) }}">{{ $order->id }}</a></td>
                            <td>{{$order->customer->id }}</td>
                            <td>
                            @if ($order->status->name == 'Pending')
                              <span class="badge badge-warning">{{ $order->status->name }}</span>
                            @elseif($order->status->name == 'Accepted')
                              <span class="badge badge-success">{{ $order->status->name }}</span>
                            @else
                              <span class="badge badge-danger">{{ $order->status->name }}</span>
                            @endif
                            </td>
                            <td>{{ $order->total_price }}</td>
                            <td>{{ $order->price_after_offer }}</td>
                            <td>{{ $order->paymentMethod->name }}</td>
                            <td>{{ $order->created_at->diffForHumans()}}</td>
                            <td>
                              <a href="{{ route('orders.edit',$order->id) }}" class="btn btn-primary">Edit</a>
                              <form action="{{ route('orders.destroy', $order->id) }}" method="POST"
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
              @include('inc.paginator',['paginator'=>$orders])
              <!-- /.card -->
            </div>
          </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection