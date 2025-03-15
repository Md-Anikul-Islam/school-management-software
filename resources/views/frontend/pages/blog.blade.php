@extends('frontend.layout')
@section('content')
@include('frontend.color')

<section class="blog-part">
    <div class="container">
        <h1 class="section-page-title">Blogs</h1>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="blog-card">
                    <a href="#" class="blog-figure">
                        <img src="{{URL::to('frontend/assets/images/blog/blog_img_1.jpg')}}"
                             alt="blog">
                    </a>
                    <div class="blog-content">
                        <small>Jan 08, 2025</small>
                        <h4><a href="blog-details.html">Common Mistakes In Learning
                                English</a>
                        </h4>
                        <p>
                            If you are a dedicated athlete, an amateur player, or a sport geek, than you surely are
                            familiar with the sport language. And if you overlap your ho.. </p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="blog-card">
                    <a href="#" class="blog-figure">
                        <img src="{{URL::to('frontend/assets/images/blog/blog_img_2.jpg')}}"
                             alt="blog">
                    </a>
                    <div class="blog-content">
                        <small>Jan 08, 2025</small>
                        <h4><a href="#">Popular Sports In English</a>
                        </h4>
                        <p>
                            The popularity of a particular discipline and its name variant also depend on the country
                            (there are exclusively British and American sports). In th.. </p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="blog-card">
                    <a href="#" class="blog-figure">
                        <img src="{{URL::to('frontend/assets/images/blog/blog_img_3.jpg')}}"
                             alt="blog">
                    </a>
                    <div class="blog-content">
                        <small>Jan 08, 2025</small>
                        <h4><a href="#">Latest Industry News</a>
                        </h4>
                        <p>
                            You have your morning routine, just like I do. You skim the online news and find the latest
                            trends in your industry. Why not make your morning routi.. </p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="blog-card">
                    <a href="#" class="blog-figure">
                        <img src="{{URL::to('frontend/assets/images/blog/blog_img_4.jpg')}}"
                             alt="blog">
                    </a>
                    <div class="blog-content">
                        <small>Jan 08, 2025</small>
                        <h4><a href="#">Tutorials And How To Guides</a>
                        </h4>
                        <p>
                            Tutorials and How-to guides are probably the simplest type of blog post you can work on.
                            They are easy because they involve you talking about things.. </p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="blog-card">
                    <a href="#" class="blog-figure">
                        <img src="{{URL::to('frontend/assets/images/blog/blog_img_5.jpg')}}"
                             alt="blog">
                    </a>
                    <div class="blog-content">
                        <small>Jan 08, 2025</small>
                        <h4><a href="#">Annual Sprots Day.</a>
                        </h4>
                        <p>
                            Both permanent campus and campus-2 of BUBT have separate prayer rooms for males and females.
                            All the prayer rooms of both the campuses are well deco.. </p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="blog-card">
                    <a href="#" class="blog-figure">
                        <img src="{{URL::to('frontend/assets/images/blog/blog_img_1.jpg')}}"
                             alt="blog">
                    </a>
                    <div class="blog-content">
                        <small>Jan 08, 2025</small>
                        <h4><a href="#">School Hall Room</a>
                        </h4>
                        <p>
                            The university has two spacious Hall rooms in its permanent campus. One is situated on the
                            5th&nbsp;floor and the newly built one is on the 9th&nbsp.. </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="blogs_one"></div>
        <div class="mt-4 text-center">
            <button type="button" class="btn btn-inline" id="loadMoreBtn">load more</button>
        </div>
    </div>
</section>

@endsection
