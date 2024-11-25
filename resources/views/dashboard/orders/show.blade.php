@extends('dashboard.layouts.app')
@section('body')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Order</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">order</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            {{-- <div class="callout callout-info">
              <h5><i class="fas fa-info"></i> Note:</h5>
              This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
            </div> --}}


            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> Zain, Inc.
                    <small class="float-right">{{ $order->created_at->format('d M Y') }}</small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  From
                  <address>
                    <strong>Admin, {{" ". auth()->user()->name }}</strong><br>
                    795 Folsom Ave, Suite 600<br>
                    San Francisco, CA 94107<br>
                    Phone: (804) 123-5432<br>
                    Email: info@almasaeedstudio.com
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  To
                  <address>
                    <strong>{{ $order->customer->name }}</strong><br>
                    {{ $order->customer->neighborhood->name }}<br>
                    {{ $order->customer->neighborhood->city->name }}, {{ $order->customer->neighborhood->city->country->name }}<br>
                    Phone: {{ $order->customer->phone }}<br>
                    Email: {{ $order->customer->email }}
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>Invoice #007612</b><br>
                  <br>
                  <b>Order ID:</b> {{ $order->id }}<br>
                  <b>Payment Due:</b> 2/22/2014<br>
                  <b>Account:</b> 968-34567
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>Qty</th>
                      <th>Product</th>
                      <th>Description</th>
                      <th>Color</th>
                      <th>Size</th>
                      <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($order->products as $product )
                        <tr>
                        <td>{{ $product->pivot->quantity }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->colors->where('id', $product->pivot->color_id)->pluck('name')->first() }}</td>
                        <td>{{ $product->sizes->where('id', $product->pivot->size_id)->pluck('name')->first() }}</td>
                        <td>{{ $product->pivot->price_at_order }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                {{-- <div class="col-6">
                  <p class="lead">Payment Methods:</p>
                  <img src="../../dist/img/credit/visa.png" alt="Visa">
                  <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
                  <img src="../../dist/img/credit/american-express.png" alt="American Express">
                  <img src="../../dist/img/credit/paypal2.png" alt="Paypal">

                  <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                    plugg
                    dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                  </p>
                </div> --}}
                <!-- /.col -->
                <div class="col-12">
                  <p class="lead">Amount Due 2/22/2014</p>

                  @php
                    $tax_price = $order->price_after_offer == 0 ? $order->total_price * 9.3 / 100 : $order->price_after_offer * 9.3 / 100;
                    $total_price = $order->price_after_offer == 0 ? $order->total_price - $tax_price - $order->shipping_fees : $order->price_after_offer - $tax_price - $order->shipping_fees;
                  @endphp
                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>${{ $order->price_after_offer == 0 ? $order->total_price : $order->price_after_offer  }}</td>
                      </tr>
                      <tr>
                        <th>Tax (9.3%)</th>
                        <td>${{ $tax_price  }}</td>
                      </tr>
                      <tr>
                        <th>Shipping:</th>
                        <td>${{ $order->shipping_fees }}</td>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td>${{ $total_price }}</td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a href="" onclick="window.print()" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
    
@endsection
