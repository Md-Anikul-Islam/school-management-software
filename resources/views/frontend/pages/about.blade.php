@extends('frontend.layout')
@section('content')
@include('frontend.color')

    <!-- About section two start -->
    <section class="about-part-two">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <h1 class="section-page-title">About School</h1>
                    <div class="about-content mt-0">
                        <h2 class="section-title"> iNiLabs School</h2>

                            <p>
                                <span style="color: #0c1028; font-family: 'Open Sans', Bangla614, sans-serif; font-size: 18px;">
                                    iNiLabs School is an independent, non-governmental organisation, established to
                                        provide high-quality education to local and expatriate communities in Bangladesh and United
                                        State of America.&nbsp;
                                </span>
                                <span style="color: rgb(12, 16, 40); font-family: 'Open Sans', Bangla614, sans-serif; font-size: 18px; background-color: rgb(248, 247,246);">
                                    iNiLabs School is an independent, non-governmental organisation, established to
                                    provide high-quality education to local and expatriate communities in Bangladesh and United
                                    State of America.&nbsp;
                                </span>
                            </p>

                    </div>
                </div>
                <div class="col-12 col-lg-6 align-self-center">
                    <div class="about-media">
                        <img src="{{URL::to('frontend/assets/images/about/about-img-1.jpg')}}"
                             alt="about">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About section two end -->


    <!-- History section start -->
    <section class="history-part" data-background="{{URL::to('frontend/assets/images/bg/history.jpg')}}">
        <div class="history-overlay">
            <div class="container">
                <div class="history-content">
                    <h2 class="section-title">Our History</h2>
                    <div class="row row-cols-1 row-cols-md-3">
                        <div class="col">
                            <h3>Origin</h3>
                            <p>iNiLabs School is a fully accredited, independent, international school in Dhaka, Bangladesh.
                                Serving families from Dhaka’s local and international communities, we successfully deliver a
                                rigorous iNiLabs curriculum program for students from Early Childhoo</p>
                        </div>
                        <div class="col">
                            <h3>Campus</h3>
                            <p>iNiLabs School is a fully accredited, independent, international school in Dhaka, Bangladesh.
                                Serving families from Dhaka’s local and international communities, we successfully deliver a
                                rigorous iNiLabs curriculum program for students from Early Childhoo</p>
                        </div>
                        <div class="col">
                            <h3>Success</h3>
                            <p>We achieve these goals through a challenging academic program enriched by a broad and highly
                                diverse extra- curricular program, vibrant visual and performing arts, an extensive sports
                                program at both intra-mural and varsity levels, unique experiential lea</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- History section End -->

    <!-- Vision section Start -->
    <section class="vision-part">
        <div class="container">
            <div class="vision-content">
                <h2 class="section-title">Our Vision</h2>
                <p>Our Vision is to empower students to fulfil their potential as responsible, innovative, and open-minded global citizens through the development of high-quality academic skills and social competencies.</p>
            </div>
        </div>
    </section>
    <!-- Vision section End -->
@endsection
