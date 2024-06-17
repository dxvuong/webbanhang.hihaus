@extends('Home::Layout.master')
@php($setting = \App\Modules\Footer\Models\Footer::find(1))
@section('main')
    <div class="container-fluid p-0 banner-main">
        @if(!empty($banners))
            <div class="swiper-initialized">
                <div class="swiper-wrapper">
                    @foreach($banners as $banner)
                        <div class="swiper-slide text-center">
                            <a class="d-flex justify-content-center" href="{{ $banner->link }}"
                               data-image-src="{{ config('app.PATH_ADMIN') . $banner->image_pc }}">
                                <img src="{{ config('app.PATH_ADMIN') . $banner->image_pc }}" class="image d-none d-sm-flex" alt="{{ $banner->name }}">
                                <img src="{{ !empty($banner->image_sp) ? config('app.PATH_ADMIN') . $banner->image_sp : config('app.PATH_ADMIN') . $banner->image_pc }}" class="image d-sm-none" alt="{{ $banner->name }}" style="width: 100%">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
    <div class="container margin-top-20 margin-bottom-10">
        <div class="row">
            <div class="col-3 sidebar d-none d-lg-block">
                <div class="background-sidebar">
                    <div class="col-12">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-phone margin-left-10 margin-right-10"></i>
                            <div class="company-phone-number margin-left-10"></div>
                        </div>
                    </div>
                </div>
                <div class="background-sidebar">
                    <div class="col-12 social">
                        <h5 class="title-sidebar social-title">KẾT NỐI MẠNG XÃ HỘI</h5>
                        <div class="social-content">
                            <ul class="d-flex flex-wrap">
                                @if(!empty($setting->facebook))
                                    <li>
                                        <a href="{{$setting->facebook}}" style="color: #1773ea">
                                            <i class="fa-brands fa-square-facebook"></i>
                                        </a>
                                    </li>
                                @endif
                                @if(!empty($setting->twitter))
                                    <li>
                                        <a href="{{$setting->twitter}}" style="color: #2ca8ee">
                                            <i class="fa-brands fa-square-twitter"></i>
                                        </a>
                                    </li>
                                @endif
                                @if(!empty($setting->google))
                                    <li>
                                        <a href="{{$setting->google}}" style="color: #d64a37">
                                            <i class="fa-brands fa-square-google-plus"></i>
                                        </a>
                                    </li>
                                @endif
                                @if(!empty($setting->linkedin))
                                    <li>
                                        <a href="{{$setting->linkedin}}" style="color: #0a63bc">
                                            <i class="fa-brands fa-linkedin"></i>
                                        </a>
                                    </li>
                                @endif
                                @if(!empty($setting->youtube))
                                    <li>
                                        <a href="{{$setting->youtube}}" style="color: #f70000">
                                            <i class="fa-brands fa-square-youtube"></i>
                                        </a>
                                    </li>
                                @endif
                                @if(!empty($setting->zalo))
                                    <li>
                                        <a href="{{$setting->zalo}}" aria-label="zalo">
                                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                                 width="40" height="44" viewBox="0 0 50 50" style="fill: #0963f2">
                                                <path d="M 9 4 C 6.2504839 4 4 6.2504839 4 9 L 4 41 C 4 43.749516 6.2504839 46 9 46 L 41 46 C 43.749516 46 46 43.749516 46 41 L 46 9 C 46 6.2504839 43.749516 4 41 4 L 9 4 z M 9 6 L 15.580078 6 C 12.00899 9.7156859 10 14.518083 10 19.5 C 10 24.66 12.110156 29.599844 15.910156 33.339844 C 16.030156 33.549844 16.129922 34.579531 15.669922 35.769531 C 15.379922 36.519531 14.799687 37.499141 13.679688 37.869141 C 13.249688 38.009141 12.97 38.430859 13 38.880859 C 13.03 39.330859 13.360781 39.710781 13.800781 39.800781 C 16.670781 40.370781 18.529297 39.510078 20.029297 38.830078 C 21.379297 38.210078 22.270625 37.789609 23.640625 38.349609 C 26.440625 39.439609 29.42 40 32.5 40 C 36.593685 40 40.531459 39.000731 44 37.113281 L 44 41 C 44 42.668484 42.668484 44 41 44 L 9 44 C 7.3315161 44 6 42.668484 6 41 L 6 9 C 6 7.3315161 7.3315161 6 9 6 z M 33 15 C 33.55 15 34 15.45 34 16 L 34 25 C 34 25.55 33.55 26 33 26 C 32.45 26 32 25.55 32 25 L 32 16 C 32 15.45 32.45 15 33 15 z M 18 16 L 23 16 C 23.36 16 23.700859 16.199531 23.880859 16.519531 C 24.050859 16.829531 24.039609 17.219297 23.849609 17.529297 L 19.800781 24 L 23 24 C 23.55 24 24 24.45 24 25 C 24 25.55 23.55 26 23 26 L 18 26 C 17.64 26 17.299141 25.800469 17.119141 25.480469 C 16.949141 25.170469 16.960391 24.780703 17.150391 24.470703 L 21.199219 18 L 18 18 C 17.45 18 17 17.55 17 17 C 17 16.45 17.45 16 18 16 z M 27.5 19 C 28.11 19 28.679453 19.169219 29.189453 19.449219 C 29.369453 19.189219 29.65 19 30 19 C 30.55 19 31 19.45 31 20 L 31 25 C 31 25.55 30.55 26 30 26 C 29.65 26 29.369453 25.810781 29.189453 25.550781 C 28.679453 25.830781 28.11 26 27.5 26 C 25.57 26 24 24.43 24 22.5 C 24 20.57 25.57 19 27.5 19 z M 38.5 19 C 40.43 19 42 20.57 42 22.5 C 42 24.43 40.43 26 38.5 26 C 36.57 26 35 24.43 35 22.5 C 35 20.57 36.57 19 38.5 19 z M 27.5 21 C 27.39625 21 27.29502 21.011309 27.197266 21.03125 C 27.001758 21.071133 26.819727 21.148164 26.660156 21.255859 C 26.500586 21.363555 26.363555 21.500586 26.255859 21.660156 C 26.148164 21.819727 26.071133 22.001758 26.03125 22.197266 C 26.011309 22.29502 26 22.39625 26 22.5 C 26 22.60375 26.011309 22.70498 26.03125 22.802734 C 26.051191 22.900488 26.079297 22.994219 26.117188 23.083984 C 26.155078 23.17375 26.202012 23.260059 26.255859 23.339844 C 26.309707 23.419629 26.371641 23.492734 26.439453 23.560547 C 26.507266 23.628359 26.580371 23.690293 26.660156 23.744141 C 26.819727 23.851836 27.001758 23.928867 27.197266 23.96875 C 27.29502 23.988691 27.39625 24 27.5 24 C 27.60375 24 27.70498 23.988691 27.802734 23.96875 C 28.487012 23.82916 29 23.22625 29 22.5 C 29 21.67 28.33 21 27.5 21 z M 38.5 21 C 38.39625 21 38.29502 21.011309 38.197266 21.03125 C 38.099512 21.051191 38.005781 21.079297 37.916016 21.117188 C 37.82625 21.155078 37.739941 21.202012 37.660156 21.255859 C 37.580371 21.309707 37.507266 21.371641 37.439453 21.439453 C 37.303828 21.575078 37.192969 21.736484 37.117188 21.916016 C 37.079297 22.005781 37.051191 22.099512 37.03125 22.197266 C 37.011309 22.29502 37 22.39625 37 22.5 C 37 22.60375 37.011309 22.70498 37.03125 22.802734 C 37.051191 22.900488 37.079297 22.994219 37.117188 23.083984 C 37.155078 23.17375 37.202012 23.260059 37.255859 23.339844 C 37.309707 23.419629 37.371641 23.492734 37.439453 23.560547 C 37.507266 23.628359 37.580371 23.690293 37.660156 23.744141 C 37.739941 23.797988 37.82625 23.844922 37.916016 23.882812 C 38.005781 23.920703 38.099512 23.948809 38.197266 23.96875 C 38.29502 23.988691 38.39625 24 38.5 24 C 38.60375 24 38.70498 23.988691 38.802734 23.96875 C 39.487012 23.82916 40 23.22625 40 22.5 C 40 21.67 39.33 21 38.5 21 z"></path>
                                            </svg>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                @if(!empty($menu))
                    <div class="background-sidebar">
                        <div class="col-12 position-relative">
                            <h5 class="title-sidebar">{{ $menu->name }}</h5>
                            @if($menu->children->count() > 0)
                                    <ul class="list-group list-group-flush list-group-product more-content">
                                        @foreach($menu->children as $childMenu)
                                            <li class="list-group-item">
                                                @if($childMenu->children->count() > 0)
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <a href="{{ $childMenu->link }}">
                                                            <span class="title level-1">{{ $childMenu->name }}</span>
                                                        </a>
                                                        <i class="fa-solid fa-angle-down nav-toggle"></i>
                                                    </div>
                                                    <ul class="list-group-flush collapse navbar-collapse toggleMenu">
                                                        @foreach($childMenu->children as $grandchildMenu)
                                                            <li class="list-group-item">
                                                                <a href="{{ $grandchildMenu->link }}" class="d-flex align-items-center justify-content-between flex-1">
                                                                    <span class="title level-2">{{ $grandchildMenu->name }}</span>
                                                                    <i class="fa-solid fa-angle-right"></i>
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <a href="{{ $childMenu->link }}" class="d-flex align-items-center justify-content-between flex-1">
                                                        <span class="title level-1">{{ $childMenu->name }}</span>
                                                    </a>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="read-more-btn more">Xem thêm <i class="fa-solid fa-caret-down"></i></div>
                                    <div class="read-more-btn hide">Ẩn bớt nội dung <i class="fa-solid fa-caret-up"></i></div>
                                @endif
                        </div>
                    </div>
                @endif
                <div class="background-sidebar">
                    <div class="col-12 position-relative">
                        <h5 class="title-sidebar">DANH MỤC SẢN PHẨM</h5>
                        <ul class="list-group list-group-flush list-group-product more-content">
                            @foreach($menu_list as $menu_cate)
                                @if($menu_cate->children->count() > 0)
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="{{ $menu_cate->link }}">
                                                <span class="title level-1">{{ $menu_cate->name }}</span>
                                            </a>
                                            <i class="fa-solid fa-angle-down nav-toggle"></i>
                                        </div>
                                        <ul class="list-group-flush collapse navbar-collapse toggleMenu">
                                            @foreach($menu_cate->children as $childMenu)
                                                <li class="list-group-item">
                                                    @if($childMenu->children->count() > 0)
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <a href="/">
                                                                <span class="title level-2">{{ $childMenu->name }}</span>
                                                            </a>
                                                            <i class="fa-solid fa-angle-down nav-toggle"></i>
                                                        </div>
                                                        <ul class="list-group-flush collapse navbar-collapse toggleMenu">
                                                            @foreach($childMenu->children as $grandchildMenu)
                                                                <li class="list-group-item">
                                                                    <a href="{{ $grandchildMenu->link }}" class="d-flex align-items-center justify-content-between flex-1">
                                                                        <span class="title level-3">{{ $grandchildMenu->name }}</span>
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <a href="{{ $childMenu->link }}" class="d-flex align-items-center justify-content-between flex-1">
                                                            <span class="title level-2">{{ $childMenu->name }}</span>
                                                        </a>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @else
                                    <li class="list-group-item">
                                        <a href="{{ $menu_cate->link }}" class="d-flex align-items-center justify-content-between flex-1">
                                            <span class="title level-1">{{ $menu_cate->name }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                        <div class="read-more-btn more">Xem thêm <i class="fa-solid fa-caret-down"></i></div>
                        <div class="read-more-btn hide">Ẩn bớt nội dung <i class="fa-solid fa-caret-up"></i></div>
                    </div>
                </div>
                <div class="background-sidebar">
                    <div class="col-12">
                        <h5 class="title-sidebar">SẢN PHẨM MỚI</h5>
                        <div class="product_list_sidebar">
                            @foreach($products_new as $product_new)
                                <a href="{{ $product_new->generateURL() }}" class="d-flex align-items-center product">
                                    <div class="col-4">
                                        <img class="image" src="{{ config('app.PATH_ADMIN') . $product_new->image }}"
                                             alt="{{ $product_new->name }}" width="100%">
                                    </div>
                                    <div class="col-8">
                                        <h5 class="title">{{ $product_new->name }}</h5>
                                        <span class="price">
                                            @if(!empty($product_new->price_regular) && !empty($product_new->price_sale))
                                                {{ number_format($product_new->price_sale,0 ,'.','.') }} đ
                                            @elseif(!empty($product_new->price_regular) && empty($product_new->price_sale))
                                                {{ number_format($product_new->price_regular,0 ,'.','.') }} đ
                                            @else
                                                Liên hệ
                                            @endif
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="background-sidebar">
                    <div class="col-12">
                        <h5 class="title-sidebar">SẢN PHẨM BÁN CHẠY</h5>
                        <div class="product_list_sidebar">
                            @foreach($products_related as $product_related)
                                <a href="{{ $product_related->generateURL() }}" class="d-flex align-items-center product">
                                    <div class="col-4">
                                        <img class="image" src="{{ config('app.PATH_ADMIN') . $product_related->image }}"
                                             alt="{{ $product_related->name }}" width="100%">
                                    </div>
                                    <div class="col-8">
                                        <h5 class="title">{{ $product_related->name }}</h5>
                                        <span class="price">
                                            @if(!empty($product_related->price_regular) && !empty($product_related->price_sale))
                                                {{ number_format($product_related->price_sale,0 ,'.','.') }} đ
                                            @elseif(!empty($product_related->price_regular) && empty($product_related->price_sale))
                                                {{ number_format($product_related->price_regular,0 ,'.','.') }} đ
                                            @else
                                                Liên hệ
                                            @endif
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-9">
                <div class="background-content">
                    <div class="content-item p-t-0">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
                                @if(isset($menu))
                                    {!! $menu->generateMenuBreadcrumb() !!}
                                    <li class="breadcrumb-item">{{ $menu->name }}</li>
                                @endif
                                @if(!empty(old('search')))
                                    <li class="breadcrumb-item">{{ old('search') }}</li>
                                @endif
                            </ol>
                        </nav>
                        <h1 style="visibility: hidden;opacity: 0;position: absolute;">{{ !empty($menu) ? $menu->name : 'Sản phẩm' }}</h1>
                    </div>
                    <form id="formFilter" action="" method="get">
                        @if(!$brands->isEmpty())
                            <div class="content-item">
                                <div class="item-data d-flex align-items-center flex-wrap" style="max-height: 275px; overflow-x: auto;">
                                    <h5 class="content-item-title margin-top-10 margin-right-10">THƯƠNG HIỆU</h5>
                                    @foreach($brands as $brand)
                                        <div class="col-3 col-lg-2 col-xl-design-100-8 item filter-brand" data-brand-id="{{ $brand->id }}" data-brand-name="{{ $brand->name }}">
                                            <img class="image" src="{{ config('app.PATH_ADMIN') . $brand->logo }}" alt="{{ $brand->name }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <div class="content-item p-t-0 d-none">
                            <div class="item-data d-flex align-items-center flex-wrap">
                                <h5 class="col-2 col-sm-1 content-item-title margin-top-10">GIÁ</h5>
                                <div class="col-4 col-md-3 col-lg-2 item filter-price" data-price-from="1" data-price-to="3000000" data-price-name="Đến 3 Triệu">
                                    <p class="price">Dưới 3 Triệu</p>
                                </div>
                                <div class="col-5 col-md-3 col-lg-2 item filter-price" data-price-from="3000000" data-price-to="5000000" data-price-name="Từ 3 - 5 Triệu">
                                    <p class="price">Từ 3 - 5 Triệu</p>
                                </div>
                                <div class="col-5 col-md-3 col-lg-3 col-xl-2 item filter-price" data-price-from="5000000" data-price-to="10000000" data-price-name="Từ 5 - 10 Triệu">
                                    <p class="price">Từ 5 - 10 Triệu</p>
                                </div>
                                <div class="col-5 col-md-3 col-lg-3 col-xl-2 item filter-price" data-price-from="10000000" data-price-to="20000000" data-price-name="Từ 10 - 20 Triệu">
                                    <p class="price">Từ 10 - 20 Triệu</p>
                                </div>
                                <div class="col-5 col-md-3 col-lg-2 item filter-price" data-price-from="20000000" data-price-to="200000000" data-price-name="Trên 20 Triệu">
                                    <p class="price">Trên 20 Triệu</p>
                                </div>
                            </div>
                        </div>
                        <div class="content-item value-filter d-none">
                            {{-- xử lí js --}}
                        </div>
                        <div class="content-item">
                            <div class="d-xxl-flex align-items-center justify-content-between">
                                <p class="mb-2 mb-xxl-0">Hiển thị {{ $products->perPage() * ( $products->currentPage() - 1 ) }}–{{ $products->perPage() * ( $products->currentPage() - 1 ) + $products->perPage() }} của {{ $products->total() }} kết quả</p>
                                <div class="filter d-flex flex-wrap align-items-center justify-content-lg-end">
                                    <div class="form-check filter-item">
                                        <input class="form-check-input" type="radio" name="orderby" value="randum"
                                               id="bestseller">
                                        <label class="form-check-label" for="bestseller">
                                            Bán chạy nhất
                                        </label>
                                    </div>
                                    <div class="form-check filter-item">
                                        <input class="form-check-input" type="radio" name="orderby" value="date"
                                               id="created_at">
                                        <label class="form-check-label" for="created_at">
                                            Mới nhất
                                        </label>
                                    </div>
                                    <div class="form-check filter-item">
                                        <input class="form-check-input" type="radio" name="orderby" value="price" id="price_asc">
                                        <label class="form-check-label" for="price_asc">
                                            Giá thấp đến cao
                                        </label>
                                    </div>
                                    <div class="form-check filter-item">
                                        <input class="form-check-input" type="radio" name="orderby" value="price-desc"
                                               id="price_desc">
                                        <label class="form-check-label" for="price_desc">
                                            Giá cao đến thấp
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="background-content">
                    @if(!empty($products->count()))
                        <div class="content-item">
                            <div class="description">
                                @if(!empty($menu))
                                    {{ $menu->description }}
                                @endif
                            </div>
                        </div>
                        <div class="content-item">
                            <div class="row product_list">
                                @if(!empty($products))
                                    @foreach($products as $product)
                                        <div class="col-md-3 col-6 col-sm-6 product is-sale ">
                                            <div class="inner">
                                                @php($regular = !empty($product->price_regular) ? $product->price_regular : 0)
                                                @php($sale = !empty($product->price_sale) ? $product->price_sale : 0)
                                                @if(!empty($product->price_regular) && !empty($product->price_sale))
                                                    <span class="product-tag">-{{ceil((($regular - $sale) / $regular)*100)}}%</span>
                                                @endif
                                                <a href="{{ $product->generateURL($menu) }}" class="product-thumbnail">
                                                    <img loading="lazy" width="255" height="330"
                                                         src="{{Config::get('app.PATH_ADMIN').$product->image}}"
                                                         alt="{{$product->name}}">
                                                </a>
                                                <div class="inner-prod">
                                                    <h3 class="product-title">
                                                        <a href="{{ $product->generateURL($menu) }}"> {{$product->name}} </a>
                                                    </h3>
                                                    <div class="product-rate">
                                                        <ul>
                                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                        </ul>
                                                    </div>
                                                    <div class="product-meta">
                                                        @if(!empty($product->price_regular) && !empty($product->price_sale))
                                                            <span class="product-price product-normal-price"> {{number_format($product->price_regular,0 ,'.','.')}} <sup>đ</sup> </span>
                                                            <span class="product-price product-sale-price ">  {{number_format($product->price_sale,0 ,'.','.')}} <sup>đ</sup>  </span>
                                                        @elseif(!empty($product->price_regular) && empty($product->price_sale))
                                                            <span class="product-price product-sale-price ">  {{number_format($product->price_regular,0 ,'.','.')}} <sup>đ</sup>  </span>
                                                        @else
                                                            <span class="product-price product-sale-price ">Liên hệ</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="content-item">
                            <div class="showListPage d-flex justify-content-center">{{ $products->links() }}</div>
                        </div>
                        @if(!empty($menu->menu_content))
                            <div class="content-item description position-relative">
                                <div class="description-content more-content">
                                    {!! str_replace('images/menu', Config::get('app.PATH_ADMIN').'images/menu', $menu->menu_content) !!}
                                </div>
                                <div class="read-more-btn more">Xem thêm <i class="fa-solid fa-caret-down"></i></div>
                                <div class="read-more-btn hide">Ẩn bớt nội dung <i class="fa-solid fa-caret-up"></i></div>
                            </div>
                        @endif
                    @else
                        <div class="content-item">
                            <div class="d-flex justify-content-center align-items-center margin-bottom-10">
                                <h5>Rất tếc! sản phẩm đã hết, hãy thay đổi bộ lọc để xem sản phẩm khác.</h5>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @if(!empty($brand_all))
        <div class="row">
            <div class="col-12">
                <div class="background-content p-0">
                    <div class="brand-list item_frame p-0">
                        <div class="item_frame_background">
                            <div class="item_frame_content">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-2 brand-title d-flex align-items-center">
                                        THƯƠNG HIỆU
                                        <i class="fa fa-angle-right"></i>
                                    </div>
                                    <div class="col-12 col-md-10">
                                        <div class="row brand-content">
                                            <button class="prev-btn"><i class="fa fa-angle-left"></i></button>
                                            <div class="flex-1 swiper brandSwiper">
                                                <div class="swiper-wrapper">
                                                    @foreach($brand_all as $brand)
                                                        <a href="{{ url($brand->slug) }}" class="swiper-slide">
                                                            <img loading="lazy" class="image" src="{{ config('app.PATH_ADMIN') . $brand->logo }}" alt="{{ $brand->name }}">
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <button class="next-btn"><i class="fa fa-angle-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if(!empty($commitment))
        <div class="row">
            <div class=" col-12 commitment-list">
                <div class="commitment-content">
                    <div class="row justify-content-center">
                        @foreach($commitment as $commit)
                            <div class="col-6 col-md-4 col-md-design-2">
                                <a class="item_frame_background d-flex justify-content-center align-items-center" href="{{ url($commit->slug) }}">
                                    <div class="text-center">
                                        <img class="image" src="{{ config('app.PATH_ADMIN') . $commit->image }}" alt="{{ $commit->name }}">
                                        <h5 class="title">{{ $commit->name }}</h5>
                                        <i class="description">{{ $commit->description }}</i>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    @if(!empty($contact))
        <div class="blog_list contact margin-bottom-20" style="background-color: {{ $contact->background_color }}; background-image: url('{{ !empty(json_decode($contact->images)->{"pc"}[0]->{'url'}) ? Config::get('app.PATH_ADMIN') . json_decode($contact->images)->{"pc"}[0]->{'url'} : '' }}')">
            <div class="container">
                <div class="title_section" style="color: {{ $contact->title_color }} !important; text-align: {{ $contact->title_position }}">{!! $contact->title !!}</div>
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="content margin-bottom-20">
                            <div class="row">
                                <div class="col-12 col-xl-6 contact-content">
                                    <div class="phone d-flex margin-bottom-40">
                                        <div class="icon">
                                            <i class="fa fa-home" aria-hidden="true"></i>
                                        </div>
                                        <div class="home-content d-flex align-items-center">
                                            <b>{{$setting->company_name}}</b>
                                        </div>
                                    </div>
                                    <div class="phone d-flex margin-bottom-40">
                                        <div class="icon">
                                            <i class="fa fa-phone" aria-hidden="true"></i>
                                        </div>
                                        <div class="phone-content">
                                            <b>Điện thoại</b>
                                            @if(json_decode($setting->phone))
                                                @foreach(json_decode($setting->phone) as $phone)
                                                    <p>{{$phone}}</p>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="email d-flex margin-bottom-40">
                                        <div class="icon"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                                        <div class="email-content">
                                            <b>Email</b>
                                            @if(json_decode($setting->email))
                                                @foreach(json_decode($setting->email) as $email)
                                                    <p>{{ $email }}</p>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="address d-flex margin-bottom-40">
                                        <div class="icon">
                                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                        </div>
                                        <div class="address-content">
                                            <b>Địa chỉ</b>
                                            @if(!empty(json_decode($setting->address)[0]->{'content'}))
                                                @foreach(json_decode($setting->address) as $address)
                                                    <p>{{ $address->{'content'} }}</p>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-xl-6">
                                    <form id="form-contact" action="{{ route('home.page.contact.post') }}" method="post" class="contact-form">
                                        <div class="row">
                                            <div class="contact-error text-center"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control input-style-2" id="name" name="name" placeholder="Họ tên *">
                                                    <span class="alert alert-error"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control input-style-2" id="phone" name="phone" placeholder="Số điện thoại *">
                                                    <span class="alert alert-error"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="email" class="form-control input-style-2" id="email" name="email" placeholder="Email">
                                                    <span class="alert alert-error"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control input-style-2" id="web" name="link" placeholder="Địa chỉ">
                                                    <span class="alert alert-error"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <textarea class="form-control input-style-2" id="comment" name="content" placeholder="Nội dung" cols="30" rows="5"></textarea>
                                                <div class="contact-sub-btn text-center margin-top-20">
                                                    <button type="button" name="submit" class="btn header-background-text-color btn-submit">
                                                        <b>Gửi yêu cầu</b>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('public/css/product/base.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('public/css/product/list.css') }}" type="text/css">
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            var swiper = new Swiper(".swiper-initialized", {
                spaceBetween: 20,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
            });

            var swiper4 = new Swiper(".brandSwiper", {
                slidesPerView: 6,
                spaceBetween: 30,
                loop: true,
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: ".brand-list .next-btn",
                    prevEl: ".brand-list .prev-btn",
                },
                breakpoints: {
                    320: {
                        slidesPerView: 3,
                        spaceBetween: 20
                    },
                    576: {
                        slidesPerView: 4,
                    },
                    992: {
                        slidesPerView: 5,
                    },
                    1200: {
                        slidesPerView: 6,
                    },
                },
            });

            $('.nav-toggle').click(function () {
                $(this).parent().siblings('.toggleMenu').toggleClass('show');
            });

            // load more description-content
            $(".read-more-btn").click(function () {
                $(this).parent().toggleClass("expanded");
            });

            $(".read-more-btn.more").each(function () {
                var content = $(this).siblings(".more-content");
                var maxHeight = parseInt(content.css("max-height"));
                if (content.height() >= maxHeight -12) {
                    $(this).show();
                }
            });

            // Mảng để lưu trữ các bộ lọc đã chọn
            var selectedFilters = {
                brands: [],
                prices: {},
                order: ''
            };

            var currentURL = window.location.href;
            var urlSearchParams = new URLSearchParams(new URL(currentURL).search);
            var params = {};
            urlSearchParams.forEach(function(value, key) {
                if (key.endsWith("[]")) {
                    var arrayKey = key.slice(0, -2);
                    if (!params[arrayKey]) {
                        params[arrayKey] = [];
                    }
                    params[arrayKey].push(value);
                } else {
                    params[key] = value;
                }
            });

            if(params.brands) {
                params.brands.map(function (brandId){
                    var elementBrand = $('[data-brand-id="' + brandId + '"]');
                    $(elementBrand).addClass('active')
                    var brandName = elementBrand.data('brand-name')
                    if (!selectedFilters.brands.some(brand => brand.id === brandId)) {
                        selectedFilters.brands.push({ id: brandId, name: brandName });
                    } else {
                        selectedFilters.brands = selectedFilters.brands.filter(brand => brand.id !== brandId);
                    }
                })
            }
            if(params.price_from || params.price_to) {
                if (params.price_from) {
                    var elementPrice = $('[data-price-from="' + params.price_from + '"]');
                    var priceName = elementPrice.data('price-name')
                }else {
                    var elementPrice = $('[data-price-to="' + params.price_to + '"]');
                    var priceName = elementPrice.data('price-name')
                }
                $(elementPrice).addClass('active')

                selectedFilters.prices = { from: params.price_from, to: params.price_to, name: priceName };
            }
            if (params.orderby) {
                $('input[name="orderby"][value="' + params.orderby + '"]').prop('checked', true);
            }else {
                $('input[name="orderby"][value="date"]').prop('checked', true);
            }

            updateSelectedFilters()

            $('input[name="orderby"]').change(function () {
                $('#formFilter').submit();
            });

            $('.filter-brand').on('click', function (e) {
                e.preventDefault();
                var brandId = $(this).data('brand-id');
                var brandName = $(this).data('brand-name');

                if (!selectedFilters.brands.some(brand => brand.id === brandId)) {
                    selectedFilters.brands.push({ id: brandId, name: brandName });
                } else {
                    selectedFilters.brands = selectedFilters.brands.filter(brand => brand.id !== brandId);
                }
                updateSelectedFilters()

                $("#formFilter").submit();
            });

            $('.filter-price').on('click', function (e) {
                e.preventDefault();
                var priceFrom = '';
                if($(this).data('price-from')) {
                    priceFrom = $(this).data('price-from')
                }
                var priceTo = '';
                if($(this).data('price-to')) {
                    priceTo = $(this).data('price-to')
                }
                var priceName = $(this).data('price-name');

                selectedFilters.prices = { from: priceFrom, to: priceTo, name: priceName };

                updateSelectedFilters()
                $("#formFilter").submit();
            });

            // Hàm cập nhật hiển thị các bộ lọc đã chọn
            function updateSelectedFilters() {
                var selectedBrandsHtml = selectedFilters.brands.map(function ({id, name}) {
                    return `<div class="filter-value">
                                <input type="hidden" name="brands[]" class="value-filter" value="${id}">
                                <span>${name} <span class="close">x</span></span>
                            </div>`;
                }).join('');

                var selectedPricesHtml = '';
                if (selectedFilters.prices.name) {
                    var selectedPricesHtml = `<div class="filter-value">
                                <input type="hidden" name="price_from" class="value-filter" value="${selectedFilters.prices.from}">
                                <input type="hidden" name="price_to" class="value-filter" value="${selectedFilters.prices.to}">
                                <span>${selectedFilters.prices.name} <span class="close">x</span></span>
                            </div>`;
                }
                var selectedSearchHtml = '';
                if (params.search) {
                    selectedSearchHtml = `<div class="filter-value">
                                <input type="hidden" name="search" class="value-filter" value="${params.search}">
                                <span>${params.search} <span class="close">x</span></span>
                            </div>`;
                }

                // Hiển thị các bộ lọc đã chọn trong content-item d-none
                if(selectedBrandsHtml || selectedPricesHtml || selectedSearchHtml) {
                    $('.content-item.value-filter').html('<h5 class="content-item-title">ĐÃ CHỌN</h5><div class="d-flex margin-top-10">' + selectedSearchHtml + selectedBrandsHtml + selectedPricesHtml + '<div class="closeAll"><span>xóa lọc</span></div></div>');
                    $('.content-item.value-filter.d-none').removeClass('d-none');
                }
            }

            $(".content-item").on('click', '.filter-value .close', function () {
                $(this).parents(".filter-value").remove();
                $("#formFilter").submit();
            })

            $(".content-item.value-filter").on('click', '.closeAll', function () {
                $(".content-item.value-filter").html("");
                $("#formFilter").submit();
            })
        });
    </script>
    <script src="{{ asset('public/js/contact.js') }}"></script>
@endsection
