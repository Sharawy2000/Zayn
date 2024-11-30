@extends('web.layout.app')
@inject('category','App\Models\Category' )
@inject('product','App\Models\Product' )
@section('title')
    Favorites
@endsection
@section('header_class') header-v4 @endsection
@section('body')
<div class="bg0 m-t-23 p-b-140">
    <div class="container">
        <div class="p-b-10">
            <h3 class="ltext-103 cl5">
                Favourites
            </h3>
        </div>

        <div class="row isotope-grid">
            @foreach ($favs as $fav )
            <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item {{ StrtoLower($fav->category->name) }}">
                <!-- Block2 -->
                <div class="block2">
                    <div class="block2-pic hov-img0">
                        <img src="{{ url($fav->images->first()?->url) }}" alt="IMG-PRODUCT">

                        {{-- <a href="#" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                            Quick View
                        </a> --}}
                        <a href="{{ route('show-product',$fav->id) }}" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
                            View
                        </a>
                    </div>

                    <div class="block2-txt flex-w flex-t p-t-14">
                        <div class="block2-txt-child1 flex-col-l ">
                            <a href="{{ route('show-product',$fav->id) }}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                {{ $fav->name }}
                            </a>

                            <span class="stext-105 cl3">
                                ${{ $fav->price }}
                            </span>
                        </div>

                        <div class="block2-txt-child2 flex-r p-t-3">
                            <a href="#" class="btn-addwish-b2 dis-block pos-relative addTofav" data-product-id="{{ $fav->id }}">
                                @auth('web-customer')
                                @if(auth()->guard('web-customer')->user()->favorites->contains($fav->id))
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
            @endforeach
        </div>

        {{-- <!-- Load more -->
        <div class="flex-c-m flex-w w-full p-t-45">
            <a href="#" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04">
                Load More
            </a>
        </div> --}}
    </div>
</div>
@endsection
@section('scripts')
    @include('inc.add-to-favs')
@endsection