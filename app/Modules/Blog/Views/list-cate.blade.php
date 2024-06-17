@extends('Home::Layout.master')

@section('main')
    <div class="single_blog list_blog">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Blog</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="event_list" style="margin-top: -75px !important;padding-top: 110px !important;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2>SỰ KIỆN SẮP DIỄN RA</h2>

                        <div class="slider">
                            <!-- Additional required wrapper -->
                            <div class="swiper-wrapper">
                                <!-- Slides -->
                                @if(!empty($event_wait))
                                    @foreach($event_wait as $event)
                                        <div class="swiper-slide">
                                            <a href="{{url('su-kien/'.$event->slug)}}" title="{{$event->name}}">
                                                <span class="thumb">
                                                    <img loading="lazy" alt="{{$event->name}}" src="{{Config::get('app.PATH_ADMIN').$event->image}}">
                                                    {{--<span class="min"><i class="fa fa-play" aria-hidden="true"></i> 01:28</span>--}}
                                                </span>
                                                <span class="title"><span class="txt">{{$event->name}}</span></span>
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <!-- If we need navigation buttons -->
                            <div class="swiper-button-prev button"><i class="fa fa-angle-left" aria-hidden="true"></i></div>
                            <div class="swiper-button-next button"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="news_list">
            <div class="container">
                @if(!empty($blog))
                    @foreach($blog as $post)
                        <div class="new">
                            <div class="row">
                                <div class="col-md-4">
                                    <a class="thumb" href="{{ $post->generateURL() }}" title="{{$post->name}}">
                                        <img loading="lazy" src="{{Config::get('app.PATH_ADMIN').$post->image}}" alt="{{$post->name}}">
                                    </a>
                                </div>
                                <div class="col-md-8">
                                    <a class="title" href="{{ $post->generateURL() }}" title="{{$post->name}}">
                                        <div class="title">{{$post->name}}</div>
                                    </a>
                                    <p class="desc">
                                        {{$post->description}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

                {{$blog->links()}}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var swiper = new Swiper(".slider", {
            slidesPerView: 4,
            spaceBetween: 30,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                // when window width is >= 320px
                320: {
                    slidesPerView: 1,
                    spaceBetween: 20
                },
                // when window width is >= 480px
                480: {
                    slidesPerView: 2,
                    spaceBetween: 30
                },
                // when window width is >= 640px
                640: {
                    slidesPerView: 2,
                    spaceBetween: 40
                },
                991: {
                    slidesPerView: 4,
                    spaceBetween: 40
                }
            }
        });
    </script>
@endsection