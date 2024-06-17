@extends('Home::Layout.master')

@section('main')
    <div class="single_product page">
        <div class="container">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{$page->name}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="content_page">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-9 @if(!empty($page->page_type) && $page->page_type == \App\Modules\Page\Models\Page::PAGE_TYPE_COL) {{ $page->page_type_col }} @endif">
                            {!! str_replace('../../images/page', Config::get('app.PATH_ADMIN').'images/page', $page->content) !!}
                        </div>
                        @if(!empty($page->page_type) && $page->page_type == \App\Modules\Page\Models\Page::PAGE_TYPE_PRODUCT)
                            <div class="d-none d-lg-block col-md-3 single_product">
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
                        @elseif(!empty($page->page_type) && $page->page_type == \App\Modules\Page\Models\Page::PAGE_TYPE_BLOG)
                            <div class="d-none d-lg-block col-lg-3">
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
                            </div>
                        @elseif(!empty($page->page_type) && $page->page_type == \App\Modules\Page\Models\Page::PAGE_TYPE_BANNER)
                            <div class="d-none d-xl-block col-lg-3">
                                @if(!empty(json_decode($page->banner_images)))
                                    @foreach(json_decode($page->banner_images) as $key => $oldImage)
                                        @if(!empty($oldImage->image))
                                            <a href="{{ $oldImage->link }}">
                                                <img class="banner-image w-100" src="{{ config('app.PATH_ADMIN') . $oldImage->image }}" style="border-radius: 4px">
                                            </a>
                                        @endif
                                    @endforeach
                                @endif
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
        .list-blog-relate img {
            width: 100%;
        }
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
