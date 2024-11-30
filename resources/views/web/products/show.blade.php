@extends('web.layout.app')
@inject('size','App\Models\Size' )
@inject('color','App\Models\Color' )
@section('title')
    {{ $product->category->name }} - {{ $product->name }} 
@endsection
@section('header_class') header-v4 @endsection
@section('body')

    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="index.html" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <a href="product.html" class="stext-109 cl8 hov-cl1 trans-04">
                {{ $product->category->name }}
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <span class="stext-109 cl4">
                {{ $product->name }}
            </span>
        </div>
    </div>

    <!-- Product Detail -->
    <section class="sec-product-detail bg0 p-t-65 p-b-60">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-7 p-b-30">
                    <div class="p-l-25 p-r-30 p-lr-0-lg">
                        <div class="wrap-slick3 flex-sb flex-w">
                            <div class="wrap-slick3-dots"></div>
                            <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

                            <div class="slick3 gallery-lb">
                                @foreach ($product->images as $image )
                                <div class="item-slick3" data-thumb="{{ url($image->url) }}">
                                    <div class="wrap-pic-w pos-relative">
                                        <img src="{{ url($image->url) }}" alt="IMG-PRODUCT" width="300" height="600">

                                        <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="{{ url($image->url) }}">
                                            <i class="fa fa-expand"></i>
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                    
                <div class="col-md-6 col-lg-5 p-b-30">
                    <div class="p-r-50 p-t-5 p-lr-0-lg">
                        <h4 class="mtext-105 cl2 js-name-detail p-b-14">
                            {{ $product->name }}
                        </h4>
                        {{-- <input type="hidden" class="mtext-105 cl2 js-id-detail p-b-14" value="{{ $product->id }}"> --}}
                        <span class="mtext-106 cl2">
                            ${{ $product->price }}
                        </span>

                        {{-- <p class="stext-102 cl3 p-t-23">
                            {{ $product->description }}
                        </p> --}}
                        <form id='add-to-cart-form' action="{{ route('web-addToCart') }}" method="post">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                        </form>
                        <!--  -->
                        <div class="p-t-33">
                            @include('inc.success-error-msg')
                            <div class="flex-w flex-r-m p-b-10">
                                <div class="size-203 flex-c-m respon6">
                                    Size
                                </div>

                                <div class="size-204 respon6-next">
                                    <div class="rs1-select2 bor8 bg0">
                                        <select class="js-select2" name="size_id" form="add-to-cart-form" required>
                                            <option disabled selected>Choose an option</option>
                                            @foreach ( $size->latest()->get() as $size )
                                                <option value="{{ $size->id }}">{{ $size->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="dropDownSelect2"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex-w flex-r-m p-b-10">
                                <div class="size-203 flex-c-m respon6">
                                    Color
                                </div>

                                <div class="size-204 respon6-next">
                                    <div class="rs1-select2 bor8 bg0">
                                        <select class="js-select2" name="color_id" form="add-to-cart-form" required> 
                                            <option disabled selected>Choose an option</option>
                                            @foreach ( $color->latest()->get() as $color )
                                                <option value="{{ $color->id }}"> {{  ucfirst($color->name)  }} </option>
                                            @endforeach
                                        </select>
                                        <div class="dropDownSelect2"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex-w flex-r-m p-b-10">
                                <div class="size-204 flex-w flex-m respon6-next">
                                    <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                        <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                            <i class="fs-16 zmdi zmdi-minus"></i>
                                        </div>

                                        <input class="mtext-104 cl3 txt-center num-product" name="quantity" min="1" value="1" form="add-to-cart-form" required>

                                        <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                            <i class="fs-16 zmdi zmdi-plus"></i>
                                        </div>
                                    </div>

                                    <button type="submit" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 btn-add-cart js-addcart-detail" form="add-to-cart-form">
                                        Add to cart
                                    </button>
                                </div>
                            </div>	
                        </div>

                        {{-- <!--  --> --}}
                        <div class="flex-w flex-m p-l-100 p-t-40 respon7">
                            <div class="flex-m bor9 p-r-10 m-r-11">
                                <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 tooltip100 favourite js-addwish-detail" 
                                    data-tooltip="Add to Wishlist"
                                    data-item-id="{{ $product->id }}"
                                    data-item-name="{{ $product->name }}">
                                    @auth('web-customer')
                                    <i class="zmdi zmdi-favorite{{ auth()->guard('web-customer')->user()->favorites->contains($product->id) ? '' : '-outline' }}" id="heart-icon-{{ $product->id }}"></i>
                                    @endauth
                                </a>
                            </div>

                            <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Facebook">
                                <i class="fa fa-facebook"></i>
                            </a>

                            <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Twitter">
                                <i class="fa fa-twitter"></i>
                            </a>

                            <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Google Plus">
                                <i class="fa fa-google-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bor10 m-t-50 p-t-43 p-b-40">
                <!-- Tab01 -->
                <div class="tab01">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item p-b-10">
                            <a class="nav-link active" data-toggle="tab" href="#description" role="tab">Description</a>
                        </li>

                        <li class="nav-item p-b-10">
                            <a class="nav-link" data-toggle="tab" href="#information" role="tab">Additional information</a>
                        </li>

                        <li class="nav-item p-b-10">
                            <a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Reviews ({{ $product->reviews->count() }})</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content p-t-43">
                        <!-- - -->
                        <div class="tab-pane fade show active" id="description" role="tabpanel">
                            <div class="how-pos2 p-lr-15-md">
                                <p class="stext-102 cl6">
                                    {{ $product->description }}
                                </p>
                            </div>
                        </div>

                        <!-- - -->
                        <div class="tab-pane fade" id="information" role="tabpanel">
                            <div class="row">
                                <div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
                                    <ul class="p-lr-28 p-lr-15-sm">
                                        <li class="flex-w flex-t p-b-7">
                                            <span class="stext-102 cl3 size-205">
                                                Weight
                                            </span>

                                            <span class="stext-102 cl6 size-206">
                                                0.79 kg
                                            </span>
                                        </li>

                                        <li class="flex-w flex-t p-b-7">
                                            <span class="stext-102 cl3 size-205">
                                                Dimensions
                                            </span>

                                            <span class="stext-102 cl6 size-206">
                                                110 x 33 x 100 cm
                                            </span>
                                        </li>

                                        <li class="flex-w flex-t p-b-7">
                                            <span class="stext-102 cl3 size-205">
                                                Materials
                                            </span>

                                            <span class="stext-102 cl6 size-206">
                                                60% cotton
                                            </span>
                                        </li>

                                        <li class="flex-w flex-t p-b-7">
                                            <span class="stext-102 cl3 size-205">
                                                Color
                                            </span>
                                            <span class="stext-102 cl6 size-206" style="display:inline">
                                                @foreach ($color->all() as $color )
                                                    {{ ucfirst($color->name ) }}
                                                @endforeach
                                            </span>
                                        </li>

                                        <li class="flex-w flex-t p-b-7">
                                            <span class="stext-102 cl3 size-205">
                                                Size
                                            </span>

                                            <span class="stext-102 cl6 size-206" style="display:inline">
                                                @foreach ($size->all() as $size )
                                                    {{ ucfirst($size->name ) }}
                                                @endforeach
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- - -->
                        <div class="tab-pane fade" id="reviews" role="tabpanel">
                            <div class="row">
                                <div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
                                    <div class="p-b-30 m-lr-15-sm">
                                        <!-- Review -->
                                        <div class="flex-w flex-t p-b-68">
                                            @foreach ($product->reviews as $review )
                                            <div class="wrap-pic-s size-109 bor0 of-hidden m-r-18 m-t-6">
                                                <img src="{{ asset('web-app/images/avatar-01.jpg') }}" alt="AVATAR">
                                            </div>

                                            <div class="size-207">
                                                <div class="flex-w flex-sb-m p-b-17">
                                                    <span class="mtext-107 cl2 p-r-20">
                                                        {{ $review->customer->name }}
                                                    </span>

                                                    <span class="fs-18 cl11">
                                                        @for ($i=1;$i<=5;$i++)
                                                            @if ($i <= $review->rate)
                                                            <i class="zmdi zmdi-star"></i>
                                                            @else
                                                            <i class="zmdi zmdi-star-outline"></i>
                                                            @endif
                                                        @endfor
                                                    </span>
                                                </div>

                                                <p class="stext-102 cl6">
                                                    {{ $review->comment }}
                                                </p><br><br><br>
                                            </div>
                                            @endforeach
                                        </div>
                                        
                                        <!-- Add review -->
                                        <form class="w-full" action="{{ route('add-review') }}" method="post">
                                            @csrf
                                            <h5 class="mtext-108 cl2 p-b-7">
                                                Add a review
                                            </h5>

                                            <p class="stext-102 cl6">
                                                Your email address will not be published. Required fields are marked *
                                            </p>

                                            <div class="flex-w flex-m p-t-50 p-b-23">
                                                <span class="stext-102 cl3 m-r-16">
                                                    Your Rating
                                                </span>

                                                <span class="wrap-rating fs-18 cl11 pointer">
                                                    <i class="item-rating pointer zmdi zmdi-star-outline" data-value="1"></i>
                                                    <i class="item-rating pointer zmdi zmdi-star-outline" data-value="2"></i>
                                                    <i class="item-rating pointer zmdi zmdi-star-outline" data-value="3"></i>
                                                    <i class="item-rating pointer zmdi zmdi-star-outline" data-value="4"></i>
                                                    <i class="item-rating pointer zmdi zmdi-star-outline" data-value="5"></i>
                                                </span>
                                                <input type="hidden" name="rate" id="rating-input" value="">
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            </div>

                                            <div class="row p-b-25">
                                                <div class="col-12 p-b-5">
                                                    <label class="stext-102 cl3" for="review">Your review</label>
                                                    <textarea class="size-110 bor8 stext-102 cl2 p-lr-20 p-tb-10" id="review" name="comment"></textarea>
                                                </div>
                                            </div>

                                            <button type="submit" class="flex-c-m stext-101 cl0 size-112 bg7 bor11 hov-btn3 p-lr-15 trans-04 m-b-10">
                                                Submit
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg6 flex-c-m flex-w size-302 m-t-73 p-tb-15">
            {{-- <span class="stext-107 cl6 p-lr-25">
                SKU: JAK-01
            </span> --}}

            <span class="stext-107 cl6 p-lr-25">
                Category: {{ $product->category->name }}
            </span>
        </div>
    </section>


    <!-- Related Products -->
    <section class="sec-relate-product bg0 p-t-45 p-b-105">
        <div class="container">
            <div class="p-b-45">
                <h3 class="ltext-106 cl5 txt-center">
                    Related Products
                </h3>
            </div>

            <!-- Slide2 -->
            <div class="wrap-slick2">
                <div class="slick2">
                    @foreach ( $product->category->products as $product )
                        
                    @endforeach
                    <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                        <!-- Block2 -->
                        <div class="block2">
                            <div class="block2-pic hov-img0">
                                <img src="{{ url($product->images->first()?->url) }}" alt="IMG-PRODUCT">

                                <a href="{{ route('show-product',$product->id) }}" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
                                    View
                                </a>
                            </div>

                            <div class="block2-txt flex-w flex-t p-t-14">
                                <div class="block2-txt-child1 flex-col-l ">
                                    <a href="{{ route('show-product',$product->id) }}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                        {{ $product->name }}
                                    </a>

                                    <span class="stext-105 cl3">
                                        ${{ $product->price }}
                                    </span>
                                </div>

                                <div class="block2-txt-child2 flex-r p-t-3">
                                    <a href="#" class="btn-addwish-b2 dis-block pos-relative addTofav " data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}">
                                        @auth('web-customer')
                                        @if(auth()->guard('web-customer')->user()->favorites->contains($product->id))
                                        <!-- Filled heart for favorited products -->
                                        <img class="icon-heart1 dis-block trans-04" src="{{ asset('web-app/images/icons/icon-heart-02.png') }}" alt="ICON">
                                        <img class="icon-heart2 dis-block trans-04 ab-t-l" src="{{ asset('web-app/images/icons/icon-heart-01.png') }}" alt="ICON">
                                        @else
                                        <img class="icon-heart2 dis-block trans-04" src="{{ asset('web-app/images/icons/icon-heart-02.png') }}" alt="ICON">
                                        <img class="icon-heart1 dis-block trans-04 ab-t-l" src="{{ asset('web-app/images/icons/icon-heart-01.png') }}" alt="ICON">
                                        <!-- Outlined heart for non-favorited products -->
                                        @endif
                                        @endauth
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
        
@endsection
@section('scripts')
<script>
    document.querySelectorAll('.item-rating').forEach((star) => {
        star.addEventListener('click', function () {
            const rating = this.getAttribute('data-value');
            document.getElementById('rating-input').value = rating;

            // Reset all stars
            document.querySelectorAll('.item-rating').forEach((star) => {
                star.classList.remove('zmdi-star');
                star.classList.add('zmdi-star-outline');
            });

            // Highlight selected stars
            for (let i = 1; i <= rating; i++) {
                document.querySelector(`.item-rating[data-value="${i}"]`).classList.remove('zmdi-star-outline');
                document.querySelector(`.item-rating[data-value="${i}"]`).classList.add('zmdi-star');
            }
        });
    });
    $(document).ready(function () {

        $('.favourite').click(function (e) {
            e.preventDefault(); // Prevent default behavior.

            let productID = $(this).data('item-id'); // Get the product ID.
            let productName = $(this).data('item-name'); // Get the product ID.
            let heartIcon = $('#heart-icon-' + productID); // Target the specific heart icon.
            

            $.ajax({
                url: '{{ route('add-favs') }}', // Laravel route for adding/removing favorites.
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // CSRF token for security.
                    product_id: productID
                },
                success: function (response) {
                    // Toggle the heart icon classes between filled and outlined.
                    if ($(heartIcon).hasClass('zmdi zmdi-favorite-outline')) {
                        $(heartIcon)
                            .removeClass('zmdi zmdi-favorite-outline')
                            .addClass('zmdi zmdi-favorite');
                            swal(productName,"Added to wishlist!", "success");

                    } else {
                        $(heartIcon)
                            .removeClass('zmdi zmdi-favorite')
                            .addClass('zmdi zmdi-favorite-outline');
                            swal(productName,"Removed from wishlist!", "error");
                    }

                },
                error: function (xhr) {
                    console.error('Error:', xhr.responseText);

                    // Display an error message (optional).
                    alert('An error occurred. Please try again.');
                }
            });
        });
    });

</script>
@include('inc.add-to-favs')

@endsection
