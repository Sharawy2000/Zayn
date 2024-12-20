<!DOCTYPE html>
@inject('setting','App\Models\Setting' )
@inject('category','App\Models\Category' )
<html lang="en">
	@if(auth()->guard('web-customer')->user())
		@php
			$customer = auth()->guard('web-customer')->user();
			$cart = $customer->cart;
			$items = $cart ? $cart->items : null;
			$favs = $customer->favorites;
		@endphp
	@endif
<head>	
	<title>@yield('title')</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="{{ asset('web-app/images/icons/favicon.png') }}"/>
    <!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('web-app/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('web-app/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('web-app/fonts/iconic/css/material-design-iconic-font.min.css') }}">
    <!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('web-app/fonts/linearicons-v1.0.0/icon-font.min.css') }}">
    <!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('web-app/vendor/animate/animate.css') }}">
    <!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{ asset('web-app/fonts/vendor/css-hamburgers/hamburgers.min.css') }}">
    <!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('web-app/vendor/animsition/css/animsition.min.css') }}">
    <!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('web-app/vendor/select2/select2.min.css') }}">
    <!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{ asset('web-app/vendor/daterangepicker/daterangepicker.css') }}">
    <!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('web-app/vendor/slick/slick.css') }}">
    <!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('web-app/vendor/MagnificPopup/magnific-popup.css') }}">
    <!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('web-app/vendor/perfect-scrollbar/perfect-scrollbar.css') }}">
    <!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('web-app/css/util.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('web-app/css/main.css') }}">
	{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}

    @yield('styles')
    <!--===============================================================================================-->
</head>
<body class="animsition">
	
	<!-- Header -->
	<header class="@yield('header_class')">
		<!-- Header desktop -->
		<div class="container-menu-desktop">
			<!-- Topbar -->
			<div class="top-bar">
				<div class="content-topbar flex-sb-m h-full container">
					<div class="left-top-bar">
						Free shipping for standard order over $100
					</div>

					<div class="right-top-bar flex-w h-full">
						<a href="#" class="flex-c-m trans-04 p-lr-25">
							Help & FAQs
						</a>
						@auth('web-customer')
						<a href="#" class="flex-c-m trans-04 p-lr-25">
							{{ auth()->guard('web-customer')->user()->name }}
						</a>
						@endauth

						<a href="#" class="flex-c-m trans-04 p-lr-25">
							EN
						</a>
						@auth('web-customer')
						<form id="logout-form" action="{{ route('web-logout') }}" method="post">
							@csrf
						</form>
						<a href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit()" class="flex-c-m trans-04 p-lr-25">
							Logout
						</a>
						@endauth
						@if(!auth()->guard('web-customer')->user())
							<a href="{{ route('getSignIn') }}" class="flex-c-m trans-04 p-lr-25">
								Login
							</a>
							<a href="{{ route('getSignUp') }}" class="flex-c-m trans-04 p-lr-25">
								Register
							</a>
						@endif
					</div>
				</div>
			</div>
			
			<div class="wrap-menu-desktop">
				{{-- @include('inc.success-error-msg') --}}
				<nav class="limiter-menu-desktop container">
					
					<!-- Logo desktop -->		
					<a href="{{ route('Home') }}" class="logo">
						{{-- <img src="{{ asset('web-app/images/icons/logo-01.png') }}" alt="IMG-LOGO"> --}}
						<span class="ltext-202 cl2 p-t-19 p-b-43 respon1" style="margin-top: 15px"> Zain Store</span>
					</a>

					<!-- Menu desktop -->
					<div class="menu-desktop">
						<ul class="main-menu">
							<li class="{{ Route::currentRouteName() == 'Home' ? 'active' : '' }}-menu">
								<a href="{{ route('Home') }}">Home</a>
							</li>

							<li class="{{ Route::currentRouteName() == 'shop' ? 'active' : '' }}-menu">
								<a href="{{ route('shop') }}">Shop</a>
							</li>
							<li class="{{ Route::currentRouteName() == 'about' ? 'active' : '' }}-menu">
								<a href="{{ route('about') }}">About</a>
							</li>
							<li class="{{ Route::currentRouteName() == 'contact' ? 'active' : '' }}-menu">
								<a href="{{ route('contact') }}">Contact</a>
							</li>
						</ul>
					</div>	

					<!-- Icon header -->
					<div class="wrap-icon-header flex-w flex-r-m">
						<div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
							<i class="zmdi zmdi-search"></i>
						</div>

						<div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart" {{ $items??=null}} @if($items) data-notify="{{ $items->count() }}" @else data-notify="0" @endif>
							
							<i class="zmdi zmdi-shopping-cart"></i>
						</div>

						<a href="{{route('favs')}}" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti" {{ $favs??=null}} @if($favs) data-notify="{{ $favs->count() }}" @else data-notify="0" @endif>
							<i class="zmdi zmdi-favorite-outline"></i>
						</a>
					</div>
				</nav>
			</div>	
		</div>

		<!-- Header Mobile -->
		<div class="wrap-header-mobile">
			<!-- Logo moblie -->		
			<div class="logo-mobile">
				<a href="index.html"><img src="{{ asset('web-app/images/icons/logo-01.png') }}" alt="IMG-LOGO"></a>
			</div>

			<!-- Icon header -->
			<div class="wrap-icon-header flex-w flex-r-m m-r-15">
				<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
					<i class="zmdi zmdi-search"></i>
				</div>

				<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart" {{ $items ??=null }} @if($items) data-notify="{{ $items->count() }}" @else data-notify="0" @endif>
					<i class="zmdi zmdi-shopping-cart"></i>
				</div>

				<a href="#" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti" data-notify="0">
					<i class="zmdi zmdi-favorite-outline"></i>
				</a>
			</div>

			<!-- Button show menu -->
			<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</div>
		</div>


		<!-- Menu Mobile -->
		<div class="menu-mobile">
			<ul class="topbar-mobile">
				<li>
					<div class="left-top-bar">
						Free shipping for standard order over $100
					</div>
				</li>

				<li>
					<div class="right-top-bar flex-w h-full">
						<a href="#" class="flex-c-m p-lr-10 trans-04">
							Help & FAQs
						</a>

						<a href="#" class="flex-c-m p-lr-10 trans-04">
							My Account
						</a>

						<a href="#" class="flex-c-m p-lr-10 trans-04">
							EN
						</a>

						<a href="#" class="flex-c-m p-lr-10 trans-04">
							USD
						</a>
					</div>
				</li>
			</ul>

			<ul class="main-menu-m">
				<li>
					<a href="index.html">Home</a>
					<ul class="sub-menu-m">
						<li><a href="index.html">Homepage 1</a></li>
						<li><a href="home-02.html">Homepage 2</a></li>
						<li><a href="home-03.html">Homepage 3</a></li>
					</ul>
					<span class="arrow-main-menu-m">
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</span>
				</li>

				<li>
					<a href="product.html">Shop</a>
				</li>

				<li>
					<a href="shoping-cart.html" class="label1 rs1" data-label1="hot">Features</a>
				</li>

				<li>
					<a href="blog.html">Blog</a>
				</li>

				<li>
					<a href="about.html">About</a>
				</li>

				<li>
					<a href="contact.html">Contact</a>
				</li>
			</ul>
		</div>

		<!-- Modal Search -->
		<div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
			<div class="container-search-header">
				<button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
					<img src="images/icons/icon-close2.png" alt="CLOSE">
				</button>

				<form class="wrap-search-header flex-w p-l-15">
					<button class="flex-c-m trans-04">
						<i class="zmdi zmdi-search"></i>
					</button>
					<input class="plh3" type="text" name="search" placeholder="Search...">
				</form>
			</div>
		</div>
	</header>

	<!-- Cart -->
	<div class="wrap-header-cart js-panel-cart">
		<div class="s-full js-hide-cart"></div>

		<div class="header-cart flex-col-l p-l-65 p-r-25">
			<div class="header-cart-title flex-w flex-sb-m p-b-8">
				<span class="mtext-103 cl2">
					Your Cart
				</span>

				<div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
					<i class="zmdi zmdi-close"></i>
				</div>
			</div>
			
			<div class="header-cart-content flex-w js-pscroll">
				<ul class="header-cart-wrapitem w-full">
					@php
						$cart ??=null
					@endphp
					@if(auth()->guard('web-customer')->user())
						@if($cart)
							@foreach ( $customer->cart->items()->latest()->get() as $item )
								<li class="header-cart-item flex-w flex-t m-b-12">
									<div class="header-cart-item-img">
										<img src="{{ url($item->product->images()->first() ?->url) }}" alt="IMG">
									</div>
			
									<div class="header-cart-item-txt p-t-8">
										<a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
											{{ $item->product->name }}
										</a>
			
										<span class="header-cart-item-info">
											{{ $item->quantity }} x ${{ $item->product->price }}
										</span>
									</div>
								</li>
							@endforeach
						@else
							<p>No items in the cart.</p>
						@endif
					@else
						<p>Please, <a href="{{ route('getSignIn') }}">Login</a> to continue</p>
						
					@endif

				</ul>
				
				<div class="w-full">
					<div class="header-cart-total w-full p-tb-40">
						@if ($cart)
						Total: ${{ $cart->sum('price') }}
						@else
						Total: $0.00
						@endif
					</div>

					<div class="header-cart-buttons flex-w w-full">
						<a href="{{ route('cart') }}" class="flex-c-m stext-101 cl0 size-117 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
							View Cart
						</a>

						{{-- <a href="{{ route('cart') }}" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
							Check Out
						</a> --}}
					</div>
				</div>
			</div>
		</div>
	</div>

    @yield('body')


	<!-- Footer -->
	<footer class="bg3 p-t-75 p-b-32">
		<div class="container">
			<div class="row">
				<div class="col-sm-8 col-lg-4 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Categories
					</h4>

					<ul>
						@foreach ($category::all() as $cat)
						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								{{ $cat->name }}
							</a>
						</li>
						@endforeach
					</ul>
				</div>

				<div class="col-sm-8 col-lg-4 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Help
					</h4>

					<ul>
						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Track Order
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Returns 
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Shipping
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								FAQs
							</a>
						</li>
					</ul>
				</div>

				<div class="col-sm-8 col-lg-4 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						GET IN TOUCH
					</h4>

					<p class="stext-107 cl7 size-201">
						Any questions? Let us know in store at 8th floor, 379 Hudson St, New York, NY 10018 or call us on (+1) 96 716 6879
					</p>

					<div class="p-t-27">
						<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-facebook"></i>
						</a>
						
						<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-instagram"></i>
						</a>

						<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-twitter"></i>
						</a>

						<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-youtube"></i>
						</a>
					</div>
				</div>

				{{-- <div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Newsletter
					</h4>

					<form>
						<div class="wrap-input1 w-full p-b-4">
							<input class="input1 bg-none plh1 stext-107 cl7" type="text" name="email" placeholder="email@example.com">
							<div class="focus-input1 trans-04"></div>
						</div>

						<div class="p-t-18">
							<button class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04">
								Subscribe
							</button>
						</div>
					</form>
				</div> --}}
			</div>

			<div class="p-t-40">
				<div class="flex-c-m flex-w p-b-18">
					<a href="#" class="m-all-1">
						<img src="{{ asset('web-app/images/icons/icon-pay-01.png') }}" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="{{ asset('web-app/images/icons/icon-pay-02.png') }}" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="{{ asset('web-app/images/icons/icon-pay-03.png') }}" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="{{ asset('web-app/images/icons/icon-pay-04.png') }}" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="{{ asset('web-app/images/icons/icon-pay-05.png') }}" alt="ICON-PAY">
					</a>
				</div>

				<p class="stext-107 cl6 txt-center">
					<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->

				</p>
			</div>
		</div>
	</footer>


	<!-- Back to top -->
	<div class="btn-back-to-top" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="zmdi zmdi-chevron-up"></i>
		</span>
	</div>

<!--===============================================================================================-->	
	<script src="{{ asset('web-app/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
<!--===============================================================================================-->
	<script src="{{ asset('web-app/vendor/animsition/js/animsition.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('web-app/vendor/bootstrap/js/popper.js') }}"></script>
	<script src="{{ asset('web-app/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('web-app/vendor/select2/select2.min.js') }}"></script>
	<script>
		$(".js-select2").each(function(){
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});
		})
	</script>
<!--===============================================================================================-->
	<script src="{{ asset('web-app/vendor/daterangepicker/moment.min.js') }}"></script>
	<script src="{{ asset('web-app/vendor/daterangepicker/daterangepicker.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('web-app/vendor/slick/slick.min.js') }}"></script>
	<script src="{{ asset('web-app/js/slick-custom.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('web-app/vendor/parallax100/parallax100.js') }}"></script>
	<script>
        $('.parallax100').parallax100();
	</script>
<!--===============================================================================================-->
	<script src="{{ asset('web-app/vendor/MagnificPopup/jquery.magnific-popup.min.js') }}"></script>
	<script>
		$('.gallery-lb').each(function() { // the containers for all your galleries
			$(this).magnificPopup({
		        delegate: 'a', // the selector for gallery item
		        type: 'image',
		        gallery: {
		        	enabled:true
		        },
		        mainClass: 'mfp-fade'
		    });
		});
	</script>
<!--===============================================================================================-->
	<script src="{{ asset('web-app/vendor/isotope/isotope.pkgd.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('web-app/vendor/sweetalert/sweetalert.min.js') }}"></script>
	<script>
		$('.js-addwish-b2').on('click', function(e){
			e.preventDefault();
		});

		$('.js-addwish-b2').each(function(){
			var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
			$(this).on('click', function(){
				swal(nameProduct, "is added to wishlist !", "success");

				$(this).addClass('js-addedwish-b2');
				$(this).off('click');
			});
		});

		// $('.js-addwish-detail').each(function(){
		// 	var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();
		// 	var ProductID = $(this).parent().parent().find('.js-id-detail').html();

		// 	$(this).on('click', function(){
		// 		if(!auth()->guard('web-customer')->user()->favorites->contains(productID)){
		// 			swal(nameProduct, "is added to wishlist !", "success");
		// 		}else{
		// 			swal(nameProduct, "has been removed from your wishlist !", "error");

		// 		}

		// 		$(this).addClass('js-addedwish-detail');
		// 		// $(this).off('click');
		// 	});
		// });
		// $('.js-removewish-detail').each(function(){
		// 	var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

		// 	$(this).on('click', function(){
		// 		swal(nameProduct, "has been removed from your wishlist !", "error");

		// 		$(this).addClass('js-romovedwish-detail');
		// 		// $(this).off('click');
		// 	});
		// });
		$('.js-addorder-detail').each(function(){
			var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

			$(this).on('click', function(){
				swal(nameProduct, "is added to Order !", "success");

				$(this).addClass('js-addedwish-detail');
				$(this).off('click');
			});
		});

		/*---------------------------------------------*/

		$('.js-addcart-detail').each(function(){
			var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
			$(this).on('click', function(){
				swal(nameProduct, "is added to cart !", "success");
			});
		});
	
	</script>
<!--===============================================================================================-->
	<script src="{{ asset('web-app/vendor/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
	<script>
		$('.js-pscroll').each(function(){
			$(this).css('position','relative');
			$(this).css('overflow','hidden');
			var ps = new PerfectScrollbar(this, {
				wheelSpeed: 1,
				scrollingThreshold: 1000,
				wheelPropagation: false,
			});

			$(window).on('resize', function(){
				ps.update();
			})
		});
	</script>
<!--===============================================================================================-->
	<script src="{{ asset('web-app/js/main.js') }}"></script>
	
    @yield('scripts')

</body>
</html>