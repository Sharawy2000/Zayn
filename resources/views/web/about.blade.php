@extends('web.layout.app')
@inject('setting','App\Models\Setting' )
@section('title')
    About
@endsection
@section('header_class') header-v4 @endsection
@section('body')

<!-- Title page -->
<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('{{ asset('web-app/images/bg-01.jpg') }}');">
    <h2 class="ltext-105 cl0 txt-center">
        About
    </h2>
</section>	


<!-- Content page -->
<section class="bg0 p-t-75 p-b-120">
    <div class="container">
        <div class="row p-b-148">
            <div class="col-md-7 col-lg-8">
                <div class="p-t-7 p-r-85 p-r-15-lg p-r-0-md">
                    <h3 class="mtext-111 cl2 p-b-16">
                        Our Story
                    </h3>

                    <p class="stext-113 cl6 p-b-26">
                        {{ $setting::first()?->about_us }}
                    </p>

                    
                </div>
            </div>

            <div class="col-11 col-md-5 col-lg-4 m-lr-auto">
                <div class="how-bor1 ">
                    <div class="hov-img0">
                        <img src="{{ asset('web-app/images/about-01.jpg') }}" alt="IMG">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>	

@endsection