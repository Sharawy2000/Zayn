@extends('web.layout.app')
@section('title')
    Cart
@endsection
@section('header_class') header-v4 @endsection
@section('body')
    <!-- breadcrumb -->
	<div class="container">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
			<a href="{{ route('Home') }}" class="stext-109 cl8 hov-cl1 trans-04">
				Home
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<span class="stext-109 cl4">
				Shoping Cart
			</span>
		</div>
	</div>
	
	
	<!-- Shoping Cart -->
	<form class="bg0 p-t-75 p-b-85">
		@csrf
		@method("PATCH")
		<div class="container">
			@include('inc.success-error-msg')
			<div class="row">
					<div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
						<div class="m-l-25 m-r--38 m-lr-0-xl">
							<div class="wrap-table-shopping-cart">
								<table class="table-shopping-cart">
									<tr class="table_head">
										<th class="column-1">Product</th>
										<th class="column-2"></th>
										<th class="column-3">Price</th>
										<th class="column-4">Quantity</th>
										<th class="column-5">Total</th>
									</tr>
									@foreach ($cartItems as $item )
									<tr class="table_row">
										<td class="column-1">
											<a class="how-itemcart1" href="{{ route('remove-item',$item->id) }}">
												<div style="margin-top: 30px" class="how-itemcart1">
													<img src="{{ url($item->product->images()->first()?->url) }}" alt="IMG">
												</div>
											</a>
										</td>
										<td class="column-2">{{ $item->product->name }}</td>
										<td class="column-3">$ {{ $item->product->price }}</td>
										<td class="column-4">
											<div class="wrap-num-product flex-w m-l-auto m-r-0">
												<div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
													<i class="fs-16 zmdi zmdi-minus"></i>
												</div>
												
												<input type="hidden" name="items[]" value="{{ $item->id }}" form="update-cart-form">
												<input class="mtext-104 cl3 txt-center num-product" type="number" name="quantities[]" value="{{ $item->quantity }}" form="update-cart-form" >

												<div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
													<i class="fs-16 zmdi zmdi-plus"></i>
												</div>
											</div>
										</td>
										<td class="column-5">$ {{ $item->quantity * $item->product->price }}</td>
									</tr>
									@endforeach
								</table>
							</div>
							@include('inc.paginator',['paginator'=>$cartItems])

							<div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
								<div class="flex-w flex-m m-r-20 m-tb-5">
									
									@error('name')
										<span class="badge badge-danger">{{ $message }}</span>
									@enderror
									<input class="stext-104 cl2 plh4 size-117 bor13 p-lr-20 m-r-10 m-tb-5" type="text" name="offer_coupon" form="coupon-form" placeholder="Coupon Code">
										
									<button form="coupon-form" class="flex-c-m stext-101 cl2 size-118 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-5">
										Apply coupon
									</button>
								</div>

								<button type="submit" form="update-cart-form" class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
									Update Cart
								</button>
							</div>
						</div>
					</div>
				<div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
					<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
						<h4 class="mtext-109 cl2 p-b-30">
							Cart Totals
						</h4>

						<div class="flex-w flex-t bor12 p-b-13">
							<div class="size-208">
								<span class="stext-110 cl2">
									Subtotal:
								</span>
							</div>

							<div class="size-209">
								<span class="mtext-110 cl2">
									${{ $cartItems->first()?->cart->price }}
								</span>
							</div>
						</div>

						<div class="flex-w flex-t bor12 p-t-15 p-b-30">
							<div class="size-208 w-full-ssm">
								<span class="stext-110 cl2">
									Shipping:
								</span>
							</div>

							<div class="size-209 p-r-18 p-r-0-sm w-full-ssm">
								@php
									$shipping = 100;
								@endphp
								<p >
									${{ $shipping }}
								</p>
							</div>
						</div>
						@if(session()->has('coupon_rate'))
						<div class="flex-w flex-t bor12 p-t-15 p-b-30">
							<div class="size-208 w-full-ssm">
								<span class="stext-110 cl2">
									Discount:
								</span>
							</div>
							<div class="size-209 p-r-18 p-r-0-sm w-full-ssm">
								<p >
									%{{ session()->get('coupon_rate') }}
								</p>
							</div>
						</div>
						@endif

						<div class="flex-w flex-t p-t-27 p-b-33">
							<div class="size-208">
								<span class="mtext-101 cl2">
									Total:
								</span>
							</div>

							<div class="size-209 p-t-1">
								<span class="mtext-110 cl2">
									${{ $cartItems->first()?->cart->price_after_offer ?? $cartItems->first()?->cart->price + $shipping}}
								</span>
							</div>
						</div>

						<button class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
							Proceed to Checkout
						</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	<form id="update-cart-form" action="{{ route('update-cart') }}" method="post">
		@csrf
		@method('PATCH')
	</form>
	<form id="coupon-form" action="{{ route('apply-coupon') }}" method="post">
		@csrf
	</form>
	{{-- <form id="remove-item-form" action="{{ route('apply-coupon') }}" method="post">
		@csrf
	</form> --}}
@endsection