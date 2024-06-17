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
                                <li class="breadcrumb-item">{{ $menu->name }}</li>
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
                        @if(!empty($blogIsMain))
                            <div class="new">
                                <div class="row">
                                    <div class="col-md-8">
                                        <a class="thumb" href="{{ $blogIsMain->generateURL() }}" title="{{ $blogIsMain->name }}">
                                            <img loading="lazy" src="{{ Config::get('app.PATH_ADMIN').$blogIsMain->image }}" alt="{{ $blogIsMain->name }}">
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a class="title" href="{{ $blogIsMain->generateURL($menu) }}" title="{{ $blogIsMain->name }}">
                                            <div class="title">{{ $blogIsMain->name }}</div>
                                        </a>
                                        <p class="desc">
                                            {{ $blogIsMain->description }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(!empty($blog))
                            @foreach($blog as $post)
                                <div class="new">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <a class="thumb" href="{{ $post->generateURL($menu) }}" title="{{$post->name}}">
                                                <img loading="lazy" src="{{Config::get('app.PATH_ADMIN').$post->image}}" alt="{{$post->name}}">
                                            </a>
                                        </div>
                                        <div class="col-md-8">
                                            <a class="title" href="{{ $post->generateURL($menu) }}" title="{{$post->name}}">
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
                    <div class="d-none d-xl-block col-xl-4">
                        @if(empty($setting))
                            @php($setting = \App\Modules\Footer\Models\Footer::find(1))
                        @endif
                        @if($setting->blog_navbar_type == \App\Modules\Blog\Models\Blog::NAVBAR_TYPE_BLOG)
                            <div class="row justify-content-end">
                            <div class="col-11">
                                <div class="list-blog-relate">
                                    @if(!empty($blog_relate))
                                        @foreach($blog_relate as $blog)
                                            <div class="blog-relate d-flex justify-content-evenly">
                                                <div class="row align-items-center flex-grow-1">
                                                    <div class="col-7 p-r-0">
                                                        <div class="blog-relate-title">
                                                            <a href="{{ $blog->generateURL() }}" title="{{$blog->name}}"> {{$blog->name}} </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-5">
                                                        <a href="{{ $blog->generateURL() }}" class="blog-relate-thumbnail">
                                                            <img loading="lazy" src="{{Config::get('app.PATH_ADMIN').$blog->image}}"  alt="{{$blog->name}}"/>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        @elseif($setting->blog_navbar_type == \App\Modules\Blog\Models\Blog::NAVBAR_TYPE_PRODUCT)
                            <div class="d-none d-lg-block single_product">
                                <div class="sidebar">
                                    <h3 class="title header-background-text-color">SẢN PHẨM BÁN CHẠY</h3>
                                    <div class="products list">
                                        @php
                                            $product_selling = \App\Modules\Product\Models\Product::where('status', 1)
                                            ->whereNotNull('selling_order')
                                            ->orderBy('selling_order')
                                            ->skip(0)
                                            ->take(!empty($data['homeSetting']->quantity) ? $data['homeSetting']->quantity : 5)
                                            ->get();
                                        @endphp
                                        @if(!empty($product_selling))
                                            @foreach($product_selling as $product)
                                                <div class="product">
                                                    <a href="{{ $product->generateURL() }}" class="product-thumbnail">
                                                        <img loading="lazy" width="255" height="330" src="{{Config::get('app.PATH_ADMIN').$product->image}}"  alt="{{$product->name}}"/>
                                                    </a>
                                                    <div class="content">
                                                        <div class="product-title">
                                                            <a href="{{ $product->generateURL() }}" title="{{$product->name}}"> {{$product->name}} </a>
                                                        </div>
                                                        <div class="product-meta">
                                                            @if(!empty($product->price_regular) && !empty($product->price_sale))
                                                                <span class="price price_sale">  {{number_format($product->price_sale,0 ,'.','.')}} <sup>đ</sup></span>
                                                                <span class="price price_regular"> {{number_format($product->price_regular,0 ,'.','.')}} <sup>đ</sup></span>
                                                            @elseif(!empty($product->price_regular) && empty($product->price_sale))
                                                                <span class="price price_sale">  {{number_format($product->price_regular,0 ,'.','.')}} <sup>đ</sup></span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
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
        .blog-relate-title a{
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