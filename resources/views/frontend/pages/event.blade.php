@extends('frontend.layout')
@section('content')
@include('frontend.color')

<!-- Event section start -->
<section class="event-part-two">
    <div class="container">
        <h1 class="section-page-title">Events</h1>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
            <div class="col">
                <div class="event-card">
                    <a href="event-details.html" class="event-media">
                        <img src="{{URL::to('frontend/assets/images/events/event_pic_3.jpg')}}"
                             alt="event">
                    </a>
                    <div class="event-content">
                        <h4><a href="event-details.html">Annual Football Match</a>
                        </h4>
                        <h5>16 Jul, 2025 -
                            19 Jul, 2025</h5>
                        <p>
                            The 11th Annual State Championship is a school-only tournament featuring qualified squads
                            from all c... </p>
                        <a class="view" href="event-details.html">
                            <span>View Event</span>
                            <i class="lni lni-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="event-card">
                    <a href="event-details.html" class="event-media">
                        <img src="{{URL::to('frontend/assets/images/events/event_pic_2.jpg')}}"
                             alt="event">
                    </a>
                    <div class="event-content">
                        <h4><a href="event-details.html">School Grand Meeting</a>
                        </h4>
                        <h5>09 Jul, 2025 -
                            16 Jul, 2025</h5>
                        <p>
                            The 11th Annual State Championship is a school-only tournament featuring qualified squads
                            from all c... </p>
                        <a class="view" href="event-details.html">
                            <span>View Event</span>
                            <i class="lni lni-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="event-card">
                    <a href="event-details.html" class="event-media">
                        <img src="{{URL::to('frontend/assets/images/events/event_pic_3.jpg')}}"
                             alt="event">
                    </a>
                    <div class="event-content">
                        <h4><a href="event-details.html">Hackathon 2025</a>
                        </h4>
                        <h5>12 May, 2025 -
                            23 May, 2025</h5>
                        <p>
                            The 11th Annual State Championship is a school-only tournament featuring qualifi... </p>
                        <a class="view" href="event-details.html">
                            <span>View Event</span>
                            <i class="lni lni-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="event-card">
                    <a href="event-details.html" class="event-media">
                        <img src="{{URL::to('frontend/assets/images/events/event_pic_1.jpg')}}"
                             alt="event">
                    </a>
                    <div class="event-content">
                        <h4><a href="event-details.html">Hackathon 2025</a>
                        </h4>
                        <h5>12 May, 2025 -
                            23 May, 2025</h5>
                        <p>
                            The 11th Annual State Championship is a school-only tournament featuring qualifi... </p>
                        <a class="view" href="event-details.html">
                            <span>View Event</span>
                            <i class="lni lni-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="event-card">
                    <a href="event-details.html" class="event-media">
                        <img src="{{URL::to('frontend/assets/images/events/event_pic_1.jpg')}}"
                             alt="event">
                    </a>
                    <div class="event-content">
                        <h4><a href="event-details.html">Basketball Torunament (Class B)</a>
                        </h4>
                        <h5>17 Mar, 2025 -
                            20 Mar, 2025</h5>
                        <p>
                            Far far away behind the word mountains far from the countries Vokalia and Consonantia, there
                            live... </p>
                        <a class="view" href="event-details.html">
                            <span>View Event</span>
                            <i class="lni lni-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="event-card">
                    <a href="event-details.html" class="event-media">
                        <img src="{{URL::to('frontend/assets/images/events/event_pic_2.jpg')}}"
                             alt="event">
                    </a>
                    <div class="event-content">
                        <h4><a href="event-details.html">Basketball Torunament (Class A)</a>
                        </h4>
                        <h5>04 Mar, 2025 -
                            06 Mar, 2025</h5>
                        <p>
                            Far far away behind the word mountains far from the countries Vokalia and Consonantia, there
                            live... </p>
                        <a class="view" href="event-details.html">
                            <span>View Event</span>
                            <i class="lni lni-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3" id="events"></div>
        <div class="mt-4 text-center">
            <button type="button" class="btn btn-inline" id="loadMoreBtn">load more</button>
        </div>
    </div>
</section>
@endsection
