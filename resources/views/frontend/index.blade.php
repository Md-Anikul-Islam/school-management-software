@extends('frontend.layout')
@section('content')

<!-- THEME SWITHCHER -->
<div class="theme-switcher">
    <span class="d-flex justify-content-center align-items-center"><i class="fa-solid fa-palette"></i></span>
    <button class="theme-btn pink" data-theme="pink"></button>
    <button class="theme-btn orange" data-theme="orange"></button>
    <button class="theme-btn blue" data-theme="blue"></button>
    <button class="theme-btn green" data-theme="green"></button>
</div>


<!-- Banner Section Start -->
<section class="banner-carousel owl-carousel">
    <div class="banner-part"
         style="background-image: url('{{URL::to('frontend/assets/images/banner/banner-1.png')}}')">
        <div class="banner-overlay">
            <div class="container">
                <div class="banner-group">
                    <div class="banner-content">
                        <span>a tradition since 1999</span>
                        <h1>Where Learning Meets Possibility</h1>
                        <p>Unlock your child\'s potential with our holistic approach to education. From cutting-edge
                            facilities to a passionate team of educators, inilabs School is committed to fostering
                            growth, creativity, and a lifelong love for learning.</p>
                        <a href="/admission.html" class="btn btn-inline">apply now</a>
                    </div>
                    <div class="banner-media">
                        <a class="banner--media-video popup-youtube" target="_blank" data-autoplay="true" data-vbtype="video"
                           href="https://www.youtube.com/watch?v=enrTLKqMGgo"><i class="fa-solid fa-play"></i></a>
                        <div class="banner-media-content">
                            <span>iNiLabs School</span>
                            <h3>campus tour</h3>
                            <p>Watch Video</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="banner-part"
         style="background-image: url('{{URL::to('frontend/assets/images/banner/banner-2.png')}}')">
        <div class="banner-overlay">
            <div class="container">
                <div class="banner-group">
                    <div class="banner-content">
                        <span>a tradition since 1999</span>
                        <h1>Your Partner in Excellence</h1>
                        <p>At inilabs School, every student matters. We provide personalized attention, diverse
                            extracurricular activities, and a curriculum designed to prepare students for success in the
                            global stage. Let&rsquo;s build the future together!</p>
                        <a href="/admission.html" class="btn btn-inline">apply now</a>
                    </div>
                    <div class="banner-media">
                        <a class="banner--media-video popup-youtube" target="_blank" data-autoplay="true" data-vbtype="video"
                           href="https://www.youtube.com/watch?v=pMzGDBP6Bic"><i class="fa-solid fa-play"></i></a>
                        <div class="banner-media-content">
                            <span>iNiLabs School</span>
                            <h3>campus tour</h3>
                            <p>Watch Video</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="banner-part"
         style="background-image: url('{{URL::to('frontend/assets/images/banner/banner-3.jpg')}}')">
        <div class="banner-overlay">
            <div class="container">
                <div class="banner-group">
                    <div class="banner-content">
                        <span>a tradition since 1999</span>
                        <h1>Empowering Young Minds</h1>
                        <p>At inilabs School, we nurture curiosity, inspire innovation, and shape future leaders. Join a
                            vibrant community where academic excellence meets character development in a safe,
                            inclusive, and dynamic environment.</p>
                        <a href="/admission.html" class="btn btn-inline">apply now</a>
                    </div>
                    <div class="banner-media">
                        <a class="banner--media-video popup-youtube" target="_blank" data-autoplay="true" data-vbtype="video"
                           href="https://www.youtube.com/watch?v=8cpM-NSxkZQ"><i class="fa-solid fa-play"></i></a>
                        <div class="banner-media-content">
                            <span>iNiLabs School</span>
                            <h3>campus tour</h3>
                            <p>Watch Video</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Feature section start -->
<section class="feature-part">
    <div class="feature-card">
        <i class="lab-line-education"></i>
        <p>Providing a well-rounded curriculum delivered by experienced teachers using modern, innovative teaching methods
            to prepare students for future success.</p>
    </div>
    <div class="feature-card">
        <i class="lab-line-book"></i>
        <p>Equipped with advanced classrooms, science labs, libraries, and sports amenities, creating a dynamic environment
            for learning and extracurricular activities.</p>
    </div>
    <div class="feature-card">
        <i class="lab-line-notebook"></i>
        <p>Renowned for academic excellence, consistent results, and a thriving alumni network, fostering a supportive and
            engaged community.</p>
    </div>
    <div class="feature-card">
        <i class="lab-line-certificate"></i>
        <p>Focusing on character building, inclusivity, and personal growth with mentorship, counseling, and programs that
            nurture well-rounded individuals.</p>
    </div>
</section>


<!-- About section start -->
<section class="about-part">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-5">
                <div class="about-content">
                    <h2 class="section-title">About School</h2>
                    <p>
                        iNiLabs School is an independent, non-governmental organisation, established to provide high-quality
                        education to local and expatriate communities in Bangladesh and United State of America.&nbsp; ... </p>
                    <a href="about.html" class="btn btn-outline">learn more</a>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-7">

                <div class="about-media">
                    <img
                        src="{{URL::to('frontend/assets/images/about/about-img-1.jpg')}}"
                        alt="about">


                    <ul class="about-list">
                        <li class="about-item">
                            <h4><span class="counter odometer" data-count="12"></span>+</h4>
                            <p>teachers</p>
                        </li>
                        <li class="about-item">
                            <h4><span class="counter odometer" data-count="44"></span>+</h4>
                            <p>students</p>
                        </li>
                        <li class="about-item">
                            <h4><span class="counter odometer" data-count="10"></span>+</h4>
                            <p>graduates</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Apply section start -->
<section class="apply-part">
    <div class="container">
        <div class="apply-content">
            <h2>Apply for Fall 2025</h2>
            <p>Now open for Fall 2025 applications. The closing date for this session is Friday 19 August, 2025.</p>
            <a href="/admission.html" class="btn btn-outline">apply now</a>
        </div>
    </div>
</section>


<!-- Principal section Start -->
<section class="principal-part">
    <div class="container">
        <div class="principal-group">
            <div class="principal-media">
                <img
                    src="{{URL::to('frontend/assets/images/teachers/principal.jpg')}}"
                    alt="principal">
            </div>
            <div class="principal-content">
                <h2 class="section-title">From the Principle</h2>
                <p>“iNiLabs School is a welcoming Catholic community renowned for its integrity and creative learning approaches
                    that bring out the best in boys. Our rich Salesian charism underpinned by the educational principles of
                    founder, St John Bosco, provides the foun”</p>
                <dl>
                    <dt>Jonathon Doe</dt>
                    <dd>Principle, iNiLabs School</dd>
                </dl>
            </div>
        </div>
    </div>
</section>


<!-- Teachers section Start -->
<section class="teacher-part">
    <div class="container">
        <div class="section-head">
            <h2 class="section-title">Our Teachers</h2>
        </div>
        <div class="teacher-carousel owl-carousel carousel-arrow">
            <div class="teacher-card">
                <div class="teacher-media">
                    <img class="teacher-avater" src="{{URL::to('frontend/assets/images/teachers/teacher-1.jpg')}}" alt="teacher">
                    <div class="teacher-overlay">

                        <a href="https://www.facebook.com/" target="_blank" class="lab-fill-facebook-round"></a>

                        <a href="https://twitter.com/" target="_blank" class="lab-fill-twitter-round"></a>

                        <a href="https://www.instagram.com/" target="_blank" class="lab-fill-linkedin-round"></a>

                        <a href="https://www.google.com/" target="_blank" class="lab-fill-google-plus-round"></a>

                    </div>
                </div>
                <div class="teacher-meta">
                    <h3>Ali Shohag</h3>
                    <p>Professor</p>
                </div>
            </div>
            <div class="teacher-card">
                <div class="teacher-media">
                    <img class="teacher-avater" src="{{URL::to('frontend/assets/images/teachers/teacher-2.jpg')}}" alt="teacher">
                    <div class="teacher-overlay">





                    </div>
                </div>
                <div class="teacher-meta">
                    <h3>Alisha Henry</h3>
                    <p>Chief Instructor</p>
                </div>
            </div>
            <div class="teacher-card">
                <div class="teacher-media">
                    <img class="teacher-avater" src="{{URL::to('frontend/assets/images/teachers/teacher-3.jpg')}}" alt="teacher">
                    <div class="teacher-overlay">

                        <a href="https://www.facebook.com/" target="_blank" class="lab-fill-facebook-round"></a>

                        <a href="https://twitter.com/" target="_blank" class="lab-fill-twitter-round"></a>

                        <a href="https://www.instagram.com/" target="_blank" class="lab-fill-linkedin-round"></a>

                        <a href="https://www.google.com/" target="_blank" class="lab-fill-google-plus-round"></a>

                    </div>
                </div>
                <div class="teacher-meta">
                    <h3>Archie Webb</h3>
                    <p>Instructor</p>
                </div>
            </div>
            <div class="teacher-card">
                <div class="teacher-media">
                    <img class="teacher-avater" src="{{URL::to('frontend/assets/images/teachers/teacher-4.jpg')}}" alt="teacher">
                    <div class="teacher-overlay">





                    </div>
                </div>
                <div class="teacher-meta">
                    <h3>Cooper Donin</h3>
                    <p>Lecturer</p>
                </div>
            </div>
            <div class="teacher-card">
                <div class="teacher-media">
                    <img class="teacher-avater" src="{{URL::to('frontend/assets/images/teachers/teacher-5.jpg')}}" alt="teacher">
                    <div class="teacher-overlay">

                        <a href="https://www.facebook.com/" target="_blank" class="lab-fill-facebook-round"></a>

                        <a href="https://twitter.com/" target="_blank" class="lab-fill-twitter-round"></a>

                        <a href="https://www.instagram.com/" target="_blank" class="lab-fill-linkedin-round"></a>

                        <a href="https://www.google.com/" target="_blank" class="lab-fill-google-plus-round"></a>

                    </div>
                </div>
                <div class="teacher-meta">
                    <h3>Georgina Hayward</h3>
                    <p>Instructor</p>
                </div>
            </div>
            <div class="teacher-card">
                <div class="teacher-media">
                    <img class="teacher-avater" src="{{URL::to('frontend/assets/images/teachers/teacher-6.jpg')}}" alt="teacher">
                    <div class="teacher-overlay">





                    </div>
                </div>
                <div class="teacher-meta">
                    <h3>John Kobir</h3>
                    <p>Lecturer</p>
                </div>
            </div>
            <div class="teacher-card">
                <div class="teacher-media">
                    <img class="teacher-avater" src="{{URL::to('frontend/assets/images/teachers/teacher-7.jpg')}}" alt="teacher">
                    <div class="teacher-overlay">





                    </div>
                </div>
                <div class="teacher-meta">
                    <h3>Jordan Mitchell</h3>
                    <p>Instructor</p>
                </div>
            </div>
            <div class="teacher-card">
                <div class="teacher-media">
                    <img class="teacher-avater" src="{{URL::to('frontend/assets/images/teachers/teacher-8.jpg')}}" alt="teacher">
                    <div class="teacher-overlay">

                        <a href="https://www.facebook.com/" target="_blank" class="lab-fill-facebook-round"></a>

                        <a href="https://twitter.com/" target="_blank" class="lab-fill-twitter-round"></a>

                        <a href="https://www.instagram.com/" target="_blank" class="lab-fill-linkedin-round"></a>

                        <a href="https://www.google.com/" target="_blank" class="lab-fill-google-plus-round"></a>

                    </div>
                </div>
                <div class="teacher-meta">
                    <h3>Katie Walsh</h3>
                    <p>Instructor</p>
                </div>
            </div>
            <div class="teacher-card">
                <div class="teacher-media">
                    <img class="teacher-avater" src="{{URL::to('frontend/assets/images/teachers/teacher-9.jpg')}}" alt="teacher">
                    <div class="teacher-overlay">





                    </div>
                </div>
                <div class="teacher-meta">
                    <h3>Maisie Pollard</h3>
                    <p>Instructor</p>
                </div>
            </div>
            <div class="teacher-card">
                <div class="teacher-media">
                    <img class="teacher-avater" src="{{URL::to('frontend/assets/images/teachers/teacher-10.jpg')}}" alt="teacher">
                    <div class="teacher-overlay">

                        <a href="https://www.facebook.com/" target="_blank" class="lab-fill-facebook-round"></a>

                        <a href="https://twitter.com/" target="_blank" class="lab-fill-twitter-round"></a>

                        <a href="https://www.instagram.com/" target="_blank" class="lab-fill-linkedin-round"></a>

                        <a href="https://www.google.com/" target="_blank" class="lab-fill-google-plus-round"></a>

                    </div>
                </div>
                <div class="teacher-meta">
                    <h3>Mia O'Donnell</h3>
                    <p>Instructor</p>
                </div>
            </div>
            <div class="teacher-card">
                <div class="teacher-media">
                    <img class="teacher-avater" src="{{URL::to('frontend/assets/images/teachers/teacher-11.jpg')}}" alt="teacher">
                    <div class="teacher-overlay">

                        <a href="https://www.facebook.com/" target="_blank" class="lab-fill-facebook-round"></a>

                        <a href="https://twitter.com/" target="_blank" class="lab-fill-twitter-round"></a>

                        <a href="https://www.instagram.com/" target="_blank" class="lab-fill-linkedin-round"></a>

                        <a href="https://www.google.com/" target="_blank" class="lab-fill-google-plus-round"></a>

                    </div>
                </div>
                <div class="teacher-meta">
                    <h3>Naomi Doyle</h3>
                    <p>Instructor</p>
                </div>
            </div>
            <div class="teacher-card">
                <div class="teacher-media">
                    <img class="teacher-avater" src="{{URL::to('frontend/assets/images/teachers/teacher-12.jpg')}}" alt="teacher">
                    <div class="teacher-overlay">

                        <a href="https://www.facebook.com/" target="_blank" class="lab-fill-facebook-round"></a>

                        <a href="https://twitter.com/" target="_blank" class="lab-fill-twitter-round"></a>

                        <a href="https://www.instagram.com/" target="_blank" class="lab-fill-linkedin-round"></a>

                        <a href="https://www.google.com/" target="_blank" class="lab-fill-google-plus-round"></a>

                    </div>
                </div>
                <div class="teacher-meta">
                    <h3>Riley Reynolds</h3>
                    <p>Instructor</p>
                </div>
            </div>
        </div>
        <div class="section-footer">
            <a href="/teachers.html" class="btn btn-inline">See Our All Certified
                Teacher's</a>
        </div>
    </div>
</section>


<!-- Event section Start -->
<section class="event-part">
    <div class="container">
        <div class="section-head">
            <h2 class="section-title">School Events</h2>
            <a href="/events.html" class="section-btn">
                <span>View All Events</span>
                <i class="lni lni-arrow-right"></i>
            </a>
        </div>

        <div class="event-carousel owl-carousel">
            <div class="event-card">
                <a href="event-details.html" class="event-media">
                    <img
                        src="{{URL::to('frontend/assets/images/events/event_pic_1.jpg')}}"
                        alt="event">
                </a>
                <div class="event-content">
                    <h4><a href="event-details.html">Annual Football Match</a>
                    </h4>
                    <h5>16 Jul, 2025-19 Jul, 2025 </h5>
                    <p>The 11th Annual State Championship is a school-only tournament featuring qualified squads from all c...
                    </p>
                    <a class="view" href="event-details.html">
                        <span>View Event</span>
                        <i class="lni lni-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="event-card">
                <a href="event-details.html" class="event-media">
                    <img
                        src="{{URL::to('frontend/assets/images/events/event_pic_2.jpg')}}"
                        alt="event">
                </a>
                <div class="event-content">
                    <h4><a href="event-details.html">School Grand Meeting</a>
                    </h4>
                    <h5>09 Jul, 2025-16 Jul, 2025 </h5>
                    <p>The 11th Annual State Championship is a school-only tournament featuring qualified squads from all c...
                    </p>
                    <a class="view" href="event-details.html">
                        <span>View Event</span>
                        <i class="lni lni-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="event-card">
                <a href="event-details.html" class="event-media">
                    <img
                        src="{{URL::to('frontend/assets/images/events/event_pic_3.jpg')}}"
                        alt="event">
                </a>
                <div class="event-content">
                    <h4><a href="event-details.html">Hackathon 2025</a>
                    </h4>
                    <h5>12 May, 2025-23 May, 2025 </h5>
                    <p>
                        <span xss="removed">The 11th Annual State Championship is a school-only tournament featuring qualifi...</span>
                    </p>
                    <a class="view" href="event-details.html">
                        <span>View Event</span>
                        <i class="lni lni-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Social section Start -->
<section class="social-part" data-background="assets/images/bg/social.jpg">
    <div class="social-overlay">
        <span></span>
        <h2>The School Community</h2>
        <p>Share your school pride with the world!</p>
        <nav>
            <a target="_blank" href="https://www.facebook.com/inilabs" class="lab-fill-facebook-round"></a>
            <a target="_blank" href="https://twitter.com/inilabsn" class="lab-fill-twitter-round"></a>
            <a target="_blank" href="https://www.linkedin.com/company/14437981" class="lab-fill-linkedin-round"></a>
            <a target="_blank" href="https://www.youtube.com/channel/UCB6xSPlOlec16f-v6pnI_gw"
               class="lab-fill-youtube-round"></a>
            <a target="_blank" href="https://googleplus.com/" class="lab-fill-google-plus-round"></a>
        </nav>
    </div>
</section>


<!-- Gallery section Start -->
<section class="gallery-part">
    <div class="container">
        <div class="section-head">
            <h2 class="section-title">School’s Gallery</h2>
            <a href="/gallery.html" class="section-btn">
                <span>see more</span>
                <i class="lni lni-arrow-right"></i>
            </a>
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
