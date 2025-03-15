@extends('frontend.layout')
@section('content')
@include('frontend.color')

<section class="notice-part">
    <div class="container">
        <h1 class="section-page-title">Notices</h1>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
            <div class="col">
                <div class="notice-card">
                    <h4><a href="notice-details.html">Farewell Ceremony</a>
                    </h4>
                    <p>
                        <span xss="removed">The most of the words adopted by the Russian language in their original
                                    phonetic form represent a linguistic calque. For example, football, basketball, volleyball,
                                    tennis. There ..
                        </span>
                    </p>
                    <span>Jun 03 2025</span>
                </div>
            </div>
            <div class="col">
                <div class="notice-card">
                    <h4><a href="notice-details.html">Second Semester Exam</a>
                    </h4>
                    <p>
                        <span xss="removed">Dedicated athlete, an amateur player, or a sport geek, than you surely are
                                    familiar with the sport language. And if you overlap your hobby and learning English, then
                                    you can be c..
                        </span>
                    </p>
                    <span>Aug 13 2025</span>
                </div>
            </div>
            <div class="col">
                <div class="notice-card">
                    <h4><a href="notice-details.html">First Semester Exam</a>
                    </h4>
                    <p>
                        <span xss="removed">If you are a dedicated athlete, an amateur player, or a sport geek, than you
                                    surely are familiar with the sport language. And if you overlap your hobby and learning
                                    English, then..
                        </span>
                    </p>
                    <span>Apr 03 2025</span>
                </div>
            </div>
            <div class="col">
                <div class="notice-card">
                    <h4><a href="notice-details.html">Annual Sports Day</a>
                    </h4>
                    <p>
                        <span xss="removed">You surely are familiar with the sport language. And if you overlap your
                                    hobby and learning English, then you can be curious what do you call these sport terms in
                                    English. This w..
                        </span>
                    </p>
                    <span>Mar 18 2025</span>
                </div>
            </div>
            <div class="col">
                <div class="notice-card">
                    <h4><a href="notice-details.html">Teachers Reunion</a>
                    </h4>
                    <p>An amateur player, or a sport geek, than you surely are familiar with the sport language. And if
                        you overlap your hobby and learning English, then you can be curious what do you call these
                        sport ter..</p>
                    <span>Jul 19 2025</span>
                </div>
            </div>
            <div class="col">
                <div class="notice-card">
                    <h4><a href="notice-details.html">Reunions 2024 , batch 75.</a>
                    </h4>
                    <p>The most of the words adopted by the Russian language in their original phonetic form represent a
                        linguistic calque. For example, football, basketball, volleyball, tennis. There are, however,
                        certai..</p>
                    <span>Apr 13 2025</span>
                </div>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3" id="notice"></div>
        <div class="mt-4 text-center">
            <button type="button" class="btn btn-inline" id="loadMoreBtn">load more</button>
        </div>
    </div>
</section>

@endsection
