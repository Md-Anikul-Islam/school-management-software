@extends('frontend.layout')
@section('content')
@include('frontend.color')

<section class="gallery-part page">
    <div class="container">
        <div class="section-head">
            <h2 class="section-title">School’s Gallery</h2>
        </div>
        <div class="row ">
            <div class="col-12 col-sm-6 col-md-4">
                <a class="image-popup" data-gall="gallery" href="{{URL::to('frontend/assets/images/gallery/gallery_1.jpg')}}">
                    <img src="{{URL::to('frontend/assets/images/gallery/gallery_1.jpg')}}" alt="gallery">
                </a>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <a class="image-popup" data-gall="gallery" href="{{URL::to('frontend/assets/images/gallery/gallery_2.jpg')}}">
                    <img src="{{URL::to('frontend/assets/images/gallery/gallery_2.jpg')}}" alt="gallery">
                </a>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <a class="image-popup" data-gall="gallery" href="{{URL::to('frontend/assets/images/gallery/gallery_3.jpg')}}">
                    <img src="{{URL::to('frontend/assets/images/gallery/gallery_3.jpg')}}" alt="gallery">
                </a>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <a class="image-popup" data-gall="gallery" href="{{URL::to('frontend/assets/images/gallery/gallery_4.jpg')}}">
                    <img src="{{URL::to('frontend/assets/images/gallery/gallery_4.jpg')}}" alt="gallery">
                </a>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <a class="image-popup" data-gall="gallery" href="{{URL::to('frontend/assets/images/gallery/gallery_5.jpg')}}">
                    <img src="{{URL::to('frontend/assets/images/gallery/gallery_5.jpg')}}" alt="gallery">
                </a>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <a class="image-popup" data-gall="gallery" href="{{URL::to('frontend/assets/images/gallery/gallery_6.jpg')}}">
                    <img src="{{URL::to('frontend/assets/images/gallery/gallery_6.jpg')}}" alt="gallery">
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
