@extends('Home::Layout.master')

@section('main')
    <div class="container single_blog list_blog">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active"><a href="{{url('/')}}">Home</a></li>
                            @if(isset($menu))
                                {!! $menu->generateMenuBreadcrumb() !!}
                            @endif
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="news_list">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-xl-8 list-blog">
                        @if(!empty($theoryIsMain))
                            <div class="new">
                                <div class="row">
                                    <div class="col-md-8">
                                        <a class="thumb" href="{{ $theoryIsMain->generateURL($menu) }}"
                                           title="{{ $theoryIsMain->name }}">
                                            <img loading="lazy"
                                                 src="{{ config('app.PATH_ADMIN').$theoryIsMain->image }}"
                                                 alt="{{ $theoryIsMain->name }}">
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a class="title" href="{{ $theoryIsMain->generateURL($menu) }}"
                                           title="{{ $theoryIsMain->name }}">
                                            <div class="title">{{ $theoryIsMain->name }}</div>
                                        </a>
                                        <p class="desc">
                                            {{ $theoryIsMain->description }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(!empty($theory))
                            @foreach($theory as $post)
                                <div class="new">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <a class="thumb" href="{{ $post->generateURL($menu) }}"
                                               title="{{$post->name}}">
                                                <img loading="lazy"
                                                     src="{{config('app.PATH_ADMIN').$post->image}}"
                                                     alt="{{$post->name}}">
                                            </a>
                                        </div>
                                        <div class="col-md-8">
                                            <a class="title" href="{{ $post->generateURL($menu) }}"
                                               title="{{$post->name}}">
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

                        {{$theory->links()}}
                    </div>
                    <div class="d-none d-xl-block col-xl-4">
                        <div class="row justify-content-end">
                            <div class="col-11">
                                <div class="list-blog-relate">
                                    @if(!empty($theory_relate))
                                        @foreach($theory_relate as $theory)
                                            <div class="blog-relate d-flex justify-content-evenly">
                                                <div class="row align-items-center flex-grow-1">
                                                    <div class="col-7 p-r-0">
                                                        <div class="blog-relate-title">
                                                            <a href="{{ $theory->generateURL() }}"
                                                               title="{{$theory->name}}"> {{$theory->name}} </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-5">
                                                        <a href="{{ $theory->generateURL() }}"
                                                           class="blog-relate-thumbnail">
                                                            <img loading="lazy"
                                                                 src="{{config('app.PATH_ADMIN').$theory->image}}"
                                                                 alt="{{$theory->name}}"/>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .list-blog-relate {
            padding: 0 12px;
            border: 1px solid #ccc;
        }

        .list-blog-relate .blog-relate {
            padding: 20px 0;
            border-bottom: 1px solid #ccc;
        }

        .blog-relate-title a {
            text-decoration: none;
            color: #000000;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            line-clamp: 3;
            -webkit-box-orient: vertical;
            font-weight: 500;
        }

        .blog-relate-thumbnail img {
            object-fit: cover;
            border-radius: 4px;
        }

        .p-r-0 {
            padding-right: 0 !important;
        }

        .single_blog.list_blog {
            margin-bottom: 30px;
        }
    </style>
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