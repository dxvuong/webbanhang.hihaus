@extends('Home::Layout.master')
@php($setting = \App\Modules\Footer\Models\Footer::find(1))
@section('main')
    <div class="container margin-top-10 margin-bottom-10">
        <div class="row">
            <div class="col-12 margin-bottom-10">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/">
                                <i class="fa fa-home" aria-hidden="true"></i>
                                Home
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-12">
                <div class="background-content p-0 mb-4">
                    <div class="content-item p-t-0">
                        <h1 style="visibility: hidden;opacity: 0;position: absolute;">{{ !empty($menu) ? $menu->name : 'Sản phẩm' }}</h1>
                        <h5 class="ps-2 pb-3 pt-3">Các sản phẩm bán chạy nhất tại {{ parse_url(env('APP_URL'))['host'] }}</h5>
                    </div>
                </div>
                <div class="background-content p-0">
                    <div class="content-item p-t-0">
                        <h4 class="ms-3 mb-2"><span class="d-inline-block pt-2" style="border-top: 3px solid #ea0000; font-weight: 600;">SẢN PHẨM BÁN CHẠY NHẤT</span></h4>
                    </div>
                    @if(!empty($products->count()))
                        <div class="content-item">
                            <div class="row product_list">
                                @if(!empty($products))
                                    @foreach($products as $product)
                                        <div class="col-6 col-sm-6 col-md-design-2 product is-sale ">
                                            <div class="inner">
                                                @php($regular = !empty($product->price_regular) ? $product->price_regular : 0)
                                                @php($sale = !empty($product->price_sale) ? $product->price_sale : 0)
                                                @if(!empty($product->price_regular) && !empty($product->price_sale))
                                                    <span class="product-tag">-{{ceil((($regular - $sale) / $regular)*100)}}%</span>
                                                @endif
                                                <a href="{{ $product->generateURL() }}" class="product-thumbnail">
                                                    <img loading="lazy" width="255" height="330"
                                                         src="{{Config::get('app.PATH_ADMIN').$product->image}}"
                                                         alt="{{$product->name}}">
                                                </a>
                                                <div class="inner-prod">
                                                    <h3 class="product-title">
                                                        <a href="{{ $product->generateURL() }}"> {{$product->name}} </a>
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
        <div class="row">
            <div class=" col-12 commitment-list">
                <div class="commitment-content">
                    <div class="row justify-content-center">
                        @foreach($commitment as $commit)
                            <div class="col-6 col-md-4 col-md-design-2">
                                <a class="item_frame_background d-flex justify-content-center align-items-center" href="{{ url($commit->slug) }}">
                                    <div class="text-center">
                                        <img loading="lazy" class="image" src="{{ config('app.PATH_ADMIN') . $commit->image }}" alt="{{ $commit->name }}">
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
    </div>
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
