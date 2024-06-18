@php($setting = \App\Modules\Footer\Models\Footer::find(1))
@extends('Home::Layout.master')

@section('main')
    @php($about = \App\Modules\Page\Models\Page::find(1))
    @php($admin_url = Config::get('app.PATH_ADMIN'))
    <!-- Slider main container -->
    <div id="home_slider" class="carousel slide" data-bs-ride="carousel">
        <ol class="carousel-indicators container">
            @foreach($banner as $key => $slide)
                <li data-bs-target="#home_slider" data-bs-slide-to="{{ $key }}" {{ $loop->first ? 'class=active' : '' }}></li>
            @endforeach
        </ol>
        <div class="carousel-inner">
            @foreach($banner as $slide)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    @if($slide->file_type == 'video')
                        <video class="d-block draggable" playsinline muted>
                            <source class="d-none d-sm-block" src="{{ $admin_url . $slide->image_pc }}" type="video/mp4">
                            <source class="d-sm-none" src="{{ !empty($slide->image_sp) ? $admin_url.$slide->image_sp : $admin_url.$slide->image_pc }}" type="video/mp4">
                        </video>
                    @else
                        <img src="{{ $admin_url . $slide->image_pc }}" class="d-block draggable d-none d-sm-block" alt="{{ $slide->name }}">
                        <img src="{{ !empty($slide->image_sp) ? $admin_url.$slide->image_sp : $admin_url.$slide->image_pc }}" class="d-block draggable d-sm-none" alt="{{ $slide->name }}" style="width: 100%">
                    @endif
                    <div class="container slider-box">
                        <div class="row">
                            <div class="col">
                                @if(!empty($slide->name))
                                    <span style="display: block; margin-bottom: 32px">{!! $slide->name !!}</span>
                                @endif
                                @if(!empty($slide->content))
                                    <span style="display: block; margin-bottom: 32px">{!! $slide->content !!}</span>
                                @endif
                                @if(!empty($slide->link_text))
                                    <a href="{{ $slide->link }}" class="btn btn-primary btn-link">{{ $slide->link_text }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @foreach($datas as $data)
        @php( $photoLibrary = json_decode($data['homeSetting']->images))
        @if($data['homeSetting']->display_type == \App\Modules\Home\Models\HomeSetting::FOLDER_DISPLAY_TYPE)
            @if($data['homeSetting']->item_type == \App\Modules\Home\Models\HomeSetting::BLOG_TYPE)
                <div class="blog_list" style="background-color: {{ $data['homeSetting']->background_color }}">
                    <div class="container title_section" style="color: {{ $data['homeSetting']->title_color }} !important; text-align: {{ $data['homeSetting']->title_position }}">{!! $data['homeSetting']->title !!}</div>
                    <div class="container">
                        <div class="row justify-content-center">
                            @foreach($data['homeSetting']->blogs as $itemBlog)
                                <div class="col-md-3">
                                    <article>
                                        <a href="{{ $itemBlog->generateURL() }}" class="img"><img loading="lazy" src="{{$admin_url.$itemBlog->image}}" alt="{{$itemBlog->name}}" /></a>
                                        <h2><a href="{{ $itemBlog->generateURL() }}">{{$itemBlog->name}}</a></h2>
                                        <p>{{ $itemBlog->description }}</p>
                                    </article>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @elseif($data['homeSetting']->item_type == \App\Modules\Home\Models\HomeSetting::PRODUCT_TYPE)
                @if($data['homeSetting']->product_type == \App\Modules\Home\Models\HomeSetting::PRODUCT_TYPE_1)
                    <div class="product_list item_frame" style="background-color: {{ $data['homeSetting']->background_color }}; margin: 0">
                        <div class="container">
                            <div class="item_frame_background">
                                <div class="item_frame_header d-flex justify-content-between align-items-center">
                                <span class="item_frame_title d-flex justify-content-center align-items-center header-boder-color">
                                    <h2 class="d-flex" style="color: {{ $data['homeSetting']->title_color }} !important; text-align: {{ $data['homeSetting']->title_position }}">{!! $data['homeSetting']->title !!}</h2>
                                </span>
                                    <div class="d-flex justify-content-between">
                                    </div>
                                </div>
                                <div class="d-flex item_frame_content swiper productSwiper">
                                    <div class="swiper-wrapper">
                                        @foreach($data['homeSetting']->products as $product)
                                            <div class="col-md-design-2 col-6 col-sm-6 product is-sale header-boder-color swiper-slide">
                                                <div class="inner">
                                                    @php($regular = !empty($product->price_regular) ? $product->price_regular : 0)
                                                    @php($sale = !empty($product->price_sale) ? $product->price_sale : 0)
                                                    @if(!empty($product->price_regular) && !empty($product->price_sale))
                                                        <span class="product-tag">-{{ceil((($regular - $sale) / $regular)*100)}}%</span>
                                                    @endif
                                                    <a href="{{ $product->generateURL() }}" class="product-thumbnail">
                                                        <img loading="lazy" width="255" height="330" src="{{$admin_url.$product->image}}" alt="{{$product->name}}">
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
                                                                <span class="product-price product-sale-price"> Liên hệ </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button class="prev-btn"><i class="fa fa-angle-left"></i></button>
                                    <button class="next-btn"><i class="fa fa-angle-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($data['homeSetting']->product_type == \App\Modules\Home\Models\HomeSetting::PRODUCT_TYPE_2)
                    <div class="product_list item_frame folder_product_type_2" style="background-color: {{ $data['homeSetting']->background_color }}; margin: 0">
                        <div class="container">
                            <div class="d-flex justify-content-center align-items-center product_type_2_title mb-5" style="color: {{ $data['homeSetting']->title_color }} !important; text-align: {{ $data['homeSetting']->title_position }}">
                                <b class="me-3"></b>
                                {!! $data['homeSetting']->title !!}
                                <b class="ms-3"></b>
                            </div>
                            <div class="row">
                                @foreach($data['homeSetting']->products as $product)
                                    <div class="col-12 col-lg-4 mb-5">
                                        <div class="col-inner">
                                            <a href="{{ $product->generateURL() }}" class="product-thumbnail">
                                                <img loading="lazy" class="w-100" src="{{$admin_url.$product->image}}" alt="{{$product->name}}">
                                            </a>
                                            <div class="inner-prod">
                                                <h3 class="product-title mt-3 mb-0" style="font-weight: 600; font-size: 20px;">
                                                    <a href="{{ $product->generateURL() }}" style="height: auto; color: #c80808"> {{$product->name}} </a>
                                                </h3>
                                                <div class="product-meta mb-3 justify-content-end" style="font-weight: 600; font-size: 18px">
                                                    @if(!empty($product->price_regular) && !empty($product->price_sale))
                                                        <span class="product-price product-sale-price ">GIÁ TỪ:  {{number_format($product->price_sale,0 ,'.','.')}} VND  </span>
                                                    @elseif(!empty($product->price_regular) && empty($product->price_sale))
                                                        <span class="product-price product-sale-price ">  {{number_format($product->price_regular,0 ,'.','.')}} VND  </span>
                                                    @else
                                                        <span class="product-price product-sale-price"> Liên hệ </span>
                                                    @endif
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-7">
                                                        <button type="button" class="btn btn-danger w-100 btn-quote-and-promotion" data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-image="{{$admin_url.$product->image}}"><i class="fa-regular fa-envelope"></i> Đăng ký tư vấn</button>
                                                    </div>
                                                    <div class="col-5 ps-0">
                                                        <a href="{{ $product->generateURL() }}" type="button" class="btn btn-outline-dark w-100"><i class="fa-solid fa-bars"></i> Chi tiết</a>
                                                    </div>
                                                </div>
                                                <table class="table">
                                                    <tbody>
                                                    @if(!empty(json_decode($product->product_parameters)))
                                                        @foreach(json_decode($product->product_parameters) as $key => $product_parameter)
                                                            <tr class="d-flex">
                                                                <td class="d-flex align-items-center" style="gap: 6px; min-width: 40%">{!! $product_parameter->icon !!} {{ $product_parameter->title }}</td>
                                                                <td style="flex: 1">{{ $product_parameter->content }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @elseif($data['homeSetting']->item_type == \App\Modules\Home\Models\HomeSetting::NEW_PRODUCT_TYPE)
                <div class="product_list item_frame" style="background-color: {{ $data['homeSetting']->background_color }}; margin: 0">
                    <div class="container">
                        <div class="item_frame_background">
                            <div class="item_frame_header d-flex justify-content-between align-items-center">
                                <a class="item_frame_title d-flex justify-content-center align-items-center header-boder-color" href="{{ route('new.product') }}">
                                    <h2 class="d-flex" style="color: {{ $data['homeSetting']->title_color }} !important">{!! $data['homeSetting']->title !!}</h2>
                                </a>
                                <div class="d-flex justify-content-between">
                                    <a class="item_frame_more" href="{{ route('new.product') }}">Xem thêm <i class="fa fa-angle-right"></i></a>
                                </div>
                            </div>
                            <div class="d-flex item_frame_content swiper productSwiper">
                                <div class="swiper-wrapper">
                                    @php($products = \App\Modules\Product\Models\Product::where('status', 1)->orderBy('created_at', 'DESC')->skip(0)->take(!empty($data['homeSetting']->quantity) ? $data['homeSetting']->quantity : 5)->get())
                                    @foreach($products as $product)
                                        <div class="col-md-design-2 col-6 col-sm-6 product is-sale header-boder-color swiper-slide">
                                            <div class="inner">
                                                @php($regular = !empty($product->price_regular) ? $product->price_regular : 0)
                                                @php($sale = !empty($product->price_sale) ? $product->price_sale : 0)
                                                @if(!empty($product->price_regular) && !empty($product->price_sale))
                                                    <span class="product-tag">-{{ceil((($regular - $sale) / $regular)*100)}}%</span>
                                                @endif
                                                <a href="{{ $product->generateURL() }}" class="product-thumbnail">
                                                    <img loading="lazy" width="255" height="330" src="{{$admin_url.$product->image}}" alt="{{$product->name}}">
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
                                                            <span class="product-price product-sale-price"> Liên hệ </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <button class="prev-btn"><i class="fa fa-angle-left"></i></button>
                                <button class="next-btn"><i class="fa fa-angle-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($data['homeSetting']->item_type == \App\Modules\Home\Models\HomeSetting::SELLING_PRODUCT_TYPE)
                <div class="product_list item_frame product-best-selling" style="background-color: {{ $data['homeSetting']->background_color }}; margin: 0">
                    <div class="container">
                        <div class="item_frame_background" style="border: 1px solid {{ $data['homeSetting']->title_color }}">
                            <div class="item_frame_header d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="phone-vr-circle-fill me-3" style="background-color: {{ $data['homeSetting']->title_color }} !important; box-shadow: 0 0 0 0 {{ $data['homeSetting']->title_color }}"></div>
                                    <a class="item_frame_title d-flex justify-content-center align-items-center" href="{{ route('selling.product') }}" style="border-color: {{ $data['homeSetting']->title_color }}">
                                        <h2 class="d-flex position-relative align-items-center" style="color: {{ $data['homeSetting']->title_color }} !important">
                                            <span>{!! $data['homeSetting']->title !!}</span>
                                        </h2>
                                    </a>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <a class="item_frame_more" href="{{ route('selling.product') }}">Xem thêm <i class="fa fa-angle-right"></i></a>
                                </div>
                            </div>
                            <div class="d-flex item_frame_content swiper productSwiper">
                                <div class="swiper-wrapper">
                                    @php
                                        $product_selling = \App\Modules\Product\Models\Product::where('status', 1)
                                        ->whereNotNull('selling_order')
                                        ->orderBy('selling_order')
                                        ->skip(0)
                                        ->take(!empty($data['homeSetting']->quantity) ? $data['homeSetting']->quantity : 5)
                                        ->get();
                                    @endphp
                                    @foreach($product_selling as $product)
                                        <div class="col-md-design-2 col-6 col-sm-6 product is-sale swiper-slide">
                                            <div class="inner">
                                                @php($regular = !empty($product->price_regular) ? $product->price_regular : 0)
                                                @php($sale = !empty($product->price_sale) ? $product->price_sale : 0)
                                                @if(!empty($product->price_regular) && !empty($product->price_sale))
                                                    <span class="product-tag">-{{ceil((($regular - $sale) / $regular)*100)}}%</span>
                                                @endif
                                                <a href="{{ $product->generateURL() }}" class="product-thumbnail">
                                                    <img loading="lazy" width="255" height="330" src="{{$admin_url.$product->image}}" alt="{{$product->name}}">
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
                                                            <span class="product-price product-sale-price"> Liên hệ </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <button class="prev-btn"><i class="fa fa-angle-left"></i></button>
                                <button class="next-btn"><i class="fa fa-angle-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($data['homeSetting']->item_type == \App\Modules\Home\Models\HomeSetting::INTRODUCTION_TYPE)
                <div class="home_about home_about-background-image" style="background-color: {{ $data['homeSetting']->background_color }}">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <div class="in">
                                    <h3><a href="{{route('admin.page.about')}}" style="text-decoration: none; color: {{ $data['homeSetting']->title_color }}">{!! $data['homeSetting']->title !!}</a></h3>

                                    <p class="description">
                                        <a href="{{route('admin.page.about')}}" style="text-decoration: none; color: {{ $data['homeSetting']->title_color }}">
                                            {{$about->description}}
                                        </a>
                                    @if(!empty(json_decode($about->image)->{'description'}))
                                        <div class="image-desc">
                                            <img class="image-description" src="{{ $admin_url.json_decode($about->image)->{'description'} }}">
                                        </div>
                                        @endif
                                        </p>

                                        <a href="{{url('/lien-he')}}">Liên hệ tư vấn</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($data['homeSetting']->item_type == \App\Modules\Home\Models\HomeSetting::MAKE_AN_APPOINTMENT_TYPE)
                <div class="booking" id="frm_booking" style="background-color: {{ $data['homeSetting']->background_color }}">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-5 img">
                                @if(!empty(\App\Modules\Footer\Models\Footer::find(1)->image_booking))
                                    <img loading="lazy" src="{{$admin_url.\App\Modules\Footer\Models\Footer::find(1)->image_booking}}" alt="booking" />
                                @endif
                            </div>

                            <div class="col-md-7">
                                <h2 style="color: {{ $data['homeSetting']->title_color }} !important;">{!! $data['homeSetting']->title !!}</h2>

                                <form action="{{route('booking.post')}}" method="post">
                                    <div class="input">
                                        <input type="text" name="fullname" placeholder="Họ và tên (*)" required/>
                                        <input type="tel" name="phone" class="phone" placeholder="SĐT (*)" required/>
                                        <input type="email" name="email" placeholder="Email (*)" required/>
                                        <input type="text" name="link" placeholder="Link Facebook (*)" required/>
                                    </div>

                                    <div class="first">
                                        <span>Chọn ngày giờ (*)</span>

                                        <ul class="label">
                                            <li>Hết chỗ</li>
                                            <li>Còn chỗ</li>
                                            <li>Đang chọn</li>
                                        </ul>
                                    </div>
                                    <ul class="choose choose_week">
                                        <li>Thứ 5</li>
                                        <li>Thứ 6</li>
                                        <li>Thứ 7</li>
                                        <li>Chủ nhật</li>
                                        <li>Thứ 2</li>
                                        <li>Thứ 3</li>
                                        <li>Thứ 4</li>
                                    </ul>
                                    <ul class="choose choose_hours">
                                        <li>8-10h</li>
                                        <li>10-12h</li>
                                        <li>12-14h</li>
                                        <li>14-16h</li>
                                        <li>16-18h</li>
                                        <li>18-20h</li>
                                        <li>20-23h</li>
                                    </ul>
                                    <input type="hidden" name="week" class="week" />
                                    <input type="hidden" name="hour" class="hour" />
                                    <p class="alert_form"></p>
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">

                                    @if(isset($_GET['success']))
                                        <div class="alert alert-success">Đặt lịch thành công!</div>
                                    @else
                                        <button type="button" class="btn">Đặt lịch</button>
                                        <button type="submit" class="submit">Đặt lịch</button>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($data['homeSetting']->item_type == \App\Modules\Home\Models\HomeSetting::FEEL_TYPE)
                <div class="testimonial" style="background-color: {{ $data['homeSetting']->background_color }}; background-image: url('{{ !empty($photoLibrary[0]->{"url"}) ? $admin_url . $photoLibrary[0]->{"url"} : '' }}')">
                    <div class="container title_section" style="color: {{ $data['homeSetting']->title_color }} !important; text-align: {{ $data['homeSetting']->title_position }}">{!! $data['homeSetting']->title !!}</div>
                    <div class="container">
                        <div class="row">
                            <div class="list_testimonial">
                                @php($testimonial = \App\Modules\Testimonial\Models\Testimonial::where('status', '=', 1)->orderBy('order', '=', 'ASC')->skip(0)->take(6)->get())
                                <!-- Additional required wrapper -->
                                <div class="swiper-wrapper">
                                    <!-- Slides -->
                                    @if(!empty($testimonial))
                                        @foreach($testimonial as $tes)
                                            <div class="swiper-slide">
                                                <div class="in">
                                                    <div class="first">
                                                        <img loading="lazy" src="{{$admin_url.$tes->image}}" alt="{{$tes->name}}" width="70" height="70"/>

                                                        <div class="info">
                                                            <h3>{{$tes->name}}</h3>
                                                            <p>{{$tes->position}}</p>
                                                        </div>
                                                    </div>
                                                    <p>{!! $tes->content !!}</p>
                                                </div>
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
            @elseif($data['homeSetting']->item_type == \App\Modules\Home\Models\HomeSetting::PARTNER_TYPE)
                <div class="blog_list partner" style="background-color: {{ $data['homeSetting']->background_color }}">
                    <div class="container title_section" style="margin-bottom: 0; color: {{ $data['homeSetting']->title_color }} !important; text-align: {{ $data['homeSetting']->title_position }}">{!! $data['homeSetting']->title !!}</div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-8">
                                <p style="text-align: center;"><i>{{ $data['homeSetting']->description }}</i></p>
                            </div>
                        </div>
                        <div class="owl-carousel owl-theme mb-4 row justify-content-center" data-col="{{ $data['homeSetting']->quantity }}">
                            @foreach($photoLibrary as $image)
                                <div class="item">
                                    <a href="{{ $image->link }}">
                                        <img loading="lazy" class="w-100" src="{{ $admin_url . $image->url }}" alt="{{ $data['homeSetting']->description }}" style="{{ $data['homeSetting']->css }}">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @elseif($data['homeSetting']->item_type == \App\Modules\Home\Models\HomeSetting::CONTACT_TYPE)
                <div class="blog_list contact home_contact-background-image-pc" style="background-color: {{ $data['homeSetting']->background_color }}; background-image: url('{{ !empty($photoLibrary->{"pc"}[0]->{'url'}) ? $admin_url . $photoLibrary->{"pc"}[0]->{'url'} : '' }}')">
                    <div class="container title_section" style="color: {{ $data['homeSetting']->title_color }} !important; text-align: {{ $data['homeSetting']->title_position }}">{!! $data['homeSetting']->title !!}</div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-10 margin-bottom-40">
                                <div class="content margin-bottom-20">
                                    <div class="row">
                                        <div class="col-12 col-xl-6 contact-content home_contact-background-image-sp" style="background-image: url('{{ !empty($photoLibrary->{"sp"}[0]->{'url'}) ? $admin_url . $photoLibrary->{"sp"}[0]->{'url'} : '' }}'); background-size: cover;">
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
            @elseif($data['homeSetting']->item_type == \App\Modules\Home\Models\HomeSetting::NEWS_TYPE)
                @php
                    $news = \App\Modules\Blog\Models\Blog::where('status', 1)->orderBy('order', 'ASC')->orderBy('created_at', 'DESC')->take(4)->get();
                    $mainNews = \App\Modules\Blog\Models\Blog::where('status', 1)->where('is_main', '=', 1)->orderBy('updated_at', 'DESC')->first();
                @endphp
                <div class="div-tin-tuc" style="background-color: {{ $data['homeSetting']->background_color }}">
                    <h3 class="tin-tuc-title">Tin tức</h3>
                    <div class="container">
                        <div class="row">
                            @foreach($news as $keyNew => $new)
                                <div class="col-md-6">
                                    <div class="tin-tuc-all-item">
                                        @if($keyNew < 2)
                                            <div class="div-line-top">
                                            </div>
                                        @endif
                                        <div class="tin-tuc-item">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="tin-tuc-item-img">
                                                        <a href="{{ $new->generateURL() }}">
                                                            <img loading="lazy" class="image" src="{{ $admin_url . $new->image }}" alt="{{ $new->name }}">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="tin-tuc-item-content">
                                                        <a href="{{ $new->generateURL() }}">
                                                            <p class="p1">{{ $new->name }}</p>
                                                        </a>
                                                        <p class="p2">{{ $new->description }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="div-line-bottom">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <?php /*
                <div class="news-list item_frame" style="background-color: {{ $data['homeSetting']->background_color }}">
                    <div class="container">
                        <div class="item_frame_background">
                            <div class="item_frame_header d-flex justify-content-between align-items-center">
                                <span class="item_frame_title d-flex justify-content-center align-items-center header-boder-color">
                                    <h2 class="d-flex"><i class="fa-regular fa-newspaper" style="margin-right: 6px"></i>{!! $data['homeSetting']->title !!}</h2>
                                </span>
                                <div class="d-flex justify-content-between">
                                    <a class="item_frame_more" href="/tin-tuc">Xem thêm <i class="fa fa-angle-right"></i></a>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center item_frame_content">
                                <div class="row padding-bottom-10">
                                    @if(!empty($mainNews))
                                        <a href="{{ $mainNews->generateURL() }}" class="col-12 col-sm-6 main-news">
                                            @if(!empty($mainNews))
                                                <img loading="lazy" class="image" src="{{ $admin_url . $mainNews->image  }}" alt="{{ $mainNews->name }}">
                                                <p class="title margin-top-10">
                                                    {{ $mainNews->name }}
                                                </p>
                                                <p class="description">
                                                    {{ $mainNews->description }}
                                                </p>
                                            @endif
                                        </a>
                                    @endif
                                    <div class="col-12 col-sm-6 list-main-news">
                                        @foreach($news as $new)
                                            <a href="{{ $new->generateURL() }}" class="new row">
                                                <div class="col-3 d-flex align-items-center">
                                                    <img loading="lazy" class="image" src="{{ $admin_url . $new->image }}" alt="{{ $new->name }}">
                                                </div>
                                                <div class="col-9 content d-flex align-items-center d-lg-block">
                                                    <p class="title mb-2">{{ $new->name }}</p>
                                                    <p class="description d-none d-md-webkit-box">{{ $new->description }}</p>
                                                </div>
                                            </a>
                                            <div class="border_bottom"></div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                */ ?>
            @elseif($data['homeSetting']->item_type == \App\Modules\Home\Models\HomeSetting::BRAND_TYPE)
                @php
                    $brands = \App\Modules\Home\Models\Brand::where('status', 1)->orderBy('order', 'ASC')->orderBy('created_at', 'DESC')->get();
                @endphp
                <div class="brand-list item_frame" style="background-color: {{ $data['homeSetting']->background_color }}">
                    <div class="container">
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
                                                    @foreach($brands as $brand)
                                                        <a href="{{ url($brand->slug) }}" class="swiper-slide">
                                                            <img loading="lazy" class="image" src="{{ $admin_url . $brand->logo }}" alt="{{ $brand->name }}">
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
            @elseif($data['homeSetting']->item_type == \App\Modules\Home\Models\HomeSetting::COMMITMENT_TYPE)
                @php
                    $commitment = \App\Modules\Home\Models\Commitment::where('status', 1)->orderBy('order', 'ASC')->orderBy('created_at', 'DESC')->get();
                @endphp
                <div class="commitment-list item_frame" style="background-color: {{ $data['homeSetting']->background_color }}">
                    <div class="container">
                        <div class="commitment-content">
                            <div class="row justify-content-center">
                                @foreach($commitment as $commit)
                                    <div class="col-6 col-md-4 col-md-design-2">
                                        <a class="item_frame_background d-flex justify-content-center align-items-center" href="{{ url($commit->slug) }}">
                                            <div class="text-center">
                                                <img loading="lazy" class="image" src="{{ $admin_url . $commit->image }}" alt="{{ $commit->name }}">
                                                <p class="title mb-1">{{ $commit->name }}</p>
                                                <i class="description">{!! $commit->description !!}</i>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($data['homeSetting']->item_type == \App\Modules\Home\Models\HomeSetting::QUOTES_AND_PROMOTIONS)
                <div class="product_list item_frame" style="background-color: {{ $data['homeSetting']->background_color }}; margin: 0">
                    <div class="container">
                        <div class="item_frame_background">
                            <div class="row">
                                <div class="col-12 col-md-6 order-1 @if(!empty(json_decode($data['homeSetting']->images)[0]->{'position'}) && json_decode($data['homeSetting']->images)[0]->{'position'} == 'right') order-sm-1 @else order-sm-2 @endif">
                                    <div class="item_frame_header p-0 pt-3 pb-2" style="text-align: {{ $data['homeSetting']->title_position }}; background: #EEEEEE; border-top-left-radius: 6px; border-top-right-radius: 6px;">
                                        <span class="d-flex justify-content-center align-items-center header-boder-color">
                                            <span class="d-flex" style="color: {{ $data['homeSetting']->title_color }} !important;">{!! $data['homeSetting']->title !!}</span>
                                        </span>
                                        <span>
                                            <p class="ps-3 pe-3">{{ $data['homeSetting']->description }}</p>
                                        </span>
                                    </div>
                                    <div class="item_frame_content">
                                        <form id="form-quote-and-promotion" method="POST" action="#" accept-charset="UTF-8" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="contact-error text-center"></div>
                                            </div>
                                            <input name="_token" type="hidden" value="{{csrf_token()}}">
                                            <div class="row mt-3 mb-3">
                                                <div class="col-6">
                                                    <input type="text" name="name" class="form-control" placeholder="Họ tên (Bắt buộc)" required>
                                                </div>
                                                <div class="col-6">
                                                    <input type="text" name="phone" class="form-control" placeholder="Điện thoại (Bắt buộc)" required>
                                                </div>
                                            </div>
                                            @if(empty(json_decode($data['homeSetting']->images)[0]->{'hide_select'}))
                                                <div class="row mb-3">
                                                    <div class="col-12">
                                                        <select class="form-select" aria-label="Default select example" name="product_id" required>
                                                            <option selected>{{ !empty(json_decode($data['homeSetting']->images)[0]->{'select'}) ? json_decode($data['homeSetting']->images)[0]->{'select'} : '-- Chọn dòng xe --' }}</option>
                                                            @foreach($data['homeSetting']->products as $product)
                                                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="row">
                                                @if(!empty(json_decode($data['homeSetting']->parameters)))
                                                    @foreach(json_decode($data['homeSetting']->parameters) as $parameter)
                                                        <div class="col-12 mb-3">
                                                            <input type="text" name="parameters[{{ $parameter }}]" class="form-control" placeholder="{{ $parameter }}">
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <textarea class="form-control" name="content" rows="3" placeholder="Nội dung"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            @if(empty(json_decode($data['homeSetting']->images)[0]->{'hide_pay'}))
                                                <div class="row justify-content-center mb-3 text-center">
                                                    <div class="col-3 col-md-2 form-check">
                                                        <input class="form-check-input" type="radio" name="pay" value="{{ \App\Modules\Page\Models\QuoteAndPromotion::INSTALLMENT }}" id="pay-1" checked>
                                                        <label class="form-check-label" for="pay-1">
                                                            Trả góp
                                                        </label>
                                                    </div>
                                                    <div class="col-3 col-md-2 form-check">
                                                        <input class="form-check-input" type="radio" name="pay" value="{{ \App\Modules\Page\Models\QuoteAndPromotion::PAY_IN_FULL }}" id="pay-2">
                                                        <label class="form-check-label" for="pay-2">
                                                            Trả hết
                                                        </label>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="row justify-content-center mb-3">
                                                <div class="col-12 text-center">
                                                    <button type="button" class="btn btn-primary btn-submit">{!! !empty(json_decode($data['homeSetting']->images)[0]->{'icon'}) ? json_decode($data['homeSetting']->images)[0]->{'icon'} : ''  !!} {{ !empty(json_decode($data['homeSetting']->images)[0]->{'button'}) ? json_decode($data['homeSetting']->images)[0]->{'button'} : 'NHẬN BÁO GIÁ NGAY' }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @if($data['homeSetting']->product_type == \App\Modules\Home\Models\HomeSetting::PRODUCT_TYPE_1 && !empty(json_decode($data['homeSetting']->images)[0]->{'url'}))
                                    <div class="col-12 col-md-6 @if(!empty(json_decode($data['homeSetting']->images)[0]->{'hide_mobile'})) d-none d-sm-block @endif @if(!empty(json_decode($data['homeSetting']->images)[0]->{'position'}) && json_decode($data['homeSetting']->images)[0]->{'position'} == 'right') order-sm-2 @else order-sm-1 @endif">
                                        <img src="{{ config('app.PATH_ADMIN') . json_decode($data['homeSetting']->images)[0]->{'url'} }}" alt="{{ $data['homeSetting']->description }}" style="max-width: 100%; border-radius: 6px;">
                                    </div>
                                @elseif($data['homeSetting']->product_type == \App\Modules\Home\Models\HomeSetting::PRODUCT_TYPE_2)
                                    <div class="col-12 col-md-6 @if(!empty(json_decode($data['homeSetting']->images)[0]->{'position'}) && json_decode($data['homeSetting']->images)[0]->{'position'} == 'right') order-sm-2 @else order-sm-1 @endif">
                                        @php
                                            $content = $data['homeSetting']->content;
                                            $content = str_replace('../../../images/blog', Config::get('app.PATH_ADMIN').'images/blog', $content);
                                            $content = str_replace('../../images/blog', Config::get('app.PATH_ADMIN').'images/blog', $content);
                                            echo $content;
                                        @endphp
                                    </div>
                                @elseif($data['homeSetting']->product_type == \App\Modules\Home\Models\HomeSetting::PRODUCT_TYPE_3)
                                    <div class="col-12 col-md-6 @if(!empty(json_decode($data['homeSetting']->images)[0]->{'position'}) && json_decode($data['homeSetting']->images)[0]->{'position'} == 'right') order-sm-2 @else order-sm-1 @endif">
                                        {!! $data['homeSetting']->content !!}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @elseif($data['homeSetting']->display_type == \App\Modules\Home\Models\HomeSetting::MENU_DISPLAY_TYPE)
            @if($data['homeSetting']->item_type == \App\Modules\Home\Models\HomeSetting::BLOG_TYPE)
                <div class="blog_list" style="background-color: {{ $data['homeSetting']->background_color }}">
                    <div class="container title_section" style="color: {{ $data['homeSetting']->title_color }} !important; text-align: {{ $data['homeSetting']->title_position }}">{!! $data['homeSetting']->title !!}</div>
                    <div class="container">
                        <div class="row justify-content-center">
                            @foreach( $data['item'] as $itemBlog)
                                <div class="col-md-3">
                                    <article>
                                        <a href="{{ $itemBlog->generateURL() }}" class="img"><img loading="lazy" src="{{$admin_url.$itemBlog->image}}" alt="{{$itemBlog->name}}" /></a>
                                        <h2><a href="{{ $itemBlog->generateURL() }}">{{$itemBlog->name}}</a></h2>
                                        <p>{{ $itemBlog->description }}</p>
                                    </article>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @elseif($data['homeSetting']->item_type == \App\Modules\Home\Models\HomeSetting::PRODUCT_TYPE)
                @php $menu = \App\Modules\Home\Models\Menu::find($data['homeSetting']->menu_id) @endphp
                @if($data['homeSetting']->product_type == \App\Modules\Home\Models\HomeSetting::PRODUCT_TYPE_1)
                    <div class="product_list item_frame" style="background-color: {{ $data['homeSetting']->background_color }}; margin: 0">
                        <div class="container">
                            <div class="item_frame_background">
                                <div class="item_frame_header d-flex justify-content-between align-items-center">
                                    <a class="item_frame_title d-flex justify-content-center align-items-center header-boder-color" href="{{ $menu->link }}">
                                        <span class="d-flex align-items-center me-1">{!! $menu->menuIcon() !!}</span>
                                        <h2 style="color: {{ $data['homeSetting']->title_color }} !important">{!! $data['homeSetting']->title !!}</h2>
                                    </a>
                                    <div class="d-flex justify-content-between">
                                        <ul class="d-flex sub_menu_title">
                                            @if($menu->slug == 'thiet-bi-kiem-tra-thuc-pham-dung-dich')
                                                @foreach($menu->children->take(2) as $child)
                                                    <li>
                                                        <a href="{{ $child->link }}">{{ $child->name }}</a>
                                                    </li>
                                                @endforeach
                                            @else
                                                @foreach($menu->children->take(5) as $child)
                                                    <li>
                                                        <a href="{{ $child->link }}">{{ $child->name }}</a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                        <a class="item_frame_more" href="{{ $menu->link }}">Xem thêm <i class="fa fa-angle-right"></i></a>
                                    </div>
                                </div>
                                <div class="d-flex item_frame_content swiper productSwiper">
                                    <div class="swiper-wrapper">
                                        @foreach( $data['item'] as $product)
                                            <div class="col-md-design-2 col-6 col-sm-6 product is-sale header-boder-color swiper-slide">
                                                <div class="inner">
                                                    @php($regular = !empty($product->price_regular) ? $product->price_regular : 0)
                                                    @php($sale = !empty($product->price_sale) ? $product->price_sale : 0)
                                                    @if(!empty($product->price_regular) && !empty($product->price_sale))
                                                        <span class="product-tag">-{{ceil((($regular - $sale) / $regular)*100)}}%</span>
                                                    @endif
                                                    <a href="{{ $product->generateURL() }}" class="product-thumbnail">
                                                        <img loading="lazy" width="255" height="330" src="{{$admin_url.$product->image}}" alt="{{$product->name}}">
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
                                                                <span class="product-price product-sale-price"> Liên hệ </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button class="prev-btn"><i class="fa fa-angle-left"></i></button>
                                    <button class="next-btn"><i class="fa fa-angle-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($data['homeSetting']->product_type == \App\Modules\Home\Models\HomeSetting::PRODUCT_TYPE_2)
                    <div class="product_list item_frame product_type_2" style="background-color: {{ $data['homeSetting']->background_color }}; margin: 0">
                        <div class="container">
                            <div class="item_frame_background">
                                <div class="item_frame_header d-flex justify-content-between align-items-center">
                                    <a class="item_frame_title d-flex justify-content-center align-items-center header-boder-color" href="{{ route('new.product') }}">
                                        <h2 class="d-flex">{!! $data['homeSetting']->title !!}</h2>
                                    </a>
                                    <div class="d-flex justify-content-between">
                                        <ul class="d-flex sub_menu_title">
                                            @if($menu->slug == 'thiet-bi-kiem-tra-thuc-pham-dung-dich')
                                                @foreach($menu->children->take(2) as $child)
                                                    <li>
                                                        <a href="{{ $child->link }}">{{ $child->name }}</a>
                                                    </li>
                                                @endforeach
                                            @else
                                                @foreach($menu->children->take(5) as $child)
                                                    <li>
                                                        <a href="{{ $child->link }}">{{ $child->name }}</a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                        <a class="item_frame_more" href="{{ $menu->link }}">Xem thêm <i class="fa fa-angle-right"></i></a>
                                    </div>
                                </div>
                                <div class="d-flex item_frame_content swiper productSwiper">
                                    <div class="swiper-wrapper">
                                        @foreach(collect($data['item'])->chunk(2) as $chunk)
                                            <div class="col-md-design-2 col-6 col-sm-6 product is-sale header-boder-color swiper-slide">
                                                @foreach($chunk as $product)
                                                    <div class="inner">
                                                        @php($regular = !empty($product->price_regular) ? $product->price_regular : 0)
                                                        @php($sale = !empty($product->price_sale) ? $product->price_sale : 0)
                                                        @if(!empty($product->price_regular) && !empty($product->price_sale))
                                                            <span class="product-tag">-{{ceil((($regular - $sale) / $regular)*100)}}%</span>
                                                        @endif
                                                        <a href="{{ $product->generateURL() }}" class="product-thumbnail">
                                                            <img loading="lazy" width="255" height="330" src="{{$admin_url.$product->image}}" alt="{{$product->name}}">
                                                        </a>
                                                        <div class="inner-prod">
                                                            <h3 class="product-title">
                                                                <a href="{{ $product->generateURL() }}"> {{$product->name}} </a>
                                                            </h3>
                                                            <div class="product-sku">
                                                                @if(!empty($product->code))
                                                                    <p>Mã sản phẩm: {{ $product->code }}</p>
                                                                @endif
                                                            </div>
                                                            <div class="product-meta">
                                                                @if(!empty($product->price_regular) && !empty($product->price_sale))
                                                                    <span class="product-price product-normal-price"> {{number_format($product->price_regular,0 ,'.','.')}} <sup>đ</sup> </span>
                                                                    <span class="product-price product-sale-price ">  {{number_format($product->price_sale,0 ,'.','.')}} <sup>đ</sup>  </span>
                                                                @elseif(!empty($product->price_regular) && empty($product->price_sale))
                                                                    <span class="product-price product-sale-price ">  {{number_format($product->price_regular,0 ,'.','.')}} <sup>đ</sup>  </span>
                                                                @else
                                                                    <span class="product-price product-sale-price"> Liên hệ </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                    <button class="prev-btn"><i class="fa fa-angle-left"></i></button>
                                    <button class="next-btn"><i class="fa fa-angle-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        @elseif($data['homeSetting']->display_type == \App\Modules\Home\Models\HomeSetting::BANNER_DISPLAY_TYPE)
            @if($data['homeSetting']->item_type == \App\Modules\Home\Models\HomeSetting::BANNER_1PHOTO_TYPE)
                <div id="home_slider" class="carousel slide" data-bs-ride="carousel" style="background-color: {{ $data['homeSetting']->background_color }}">
                    @php
                        $banners = \App\Modules\Home\Models\Banner::where('status', '=', 1)->where('type', 'homeSetting')->where('banner_type', $data['homeSetting']->id)->orderBy('order', 'ASC')->get();
                    @endphp
                    <ol class="carousel-indicators container">
                        @foreach($banners as $key => $slide)
                            <li data-bs-target="#home_slider" data-bs-slide-to="{{ $key }}" {{ $loop->first ? 'class=active' : '' }}></li>
                        @endforeach
                    </ol>
                    <div class="carousel-inner">
                        @foreach($banners as $slide)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                @if($slide->file_type == 'video')
                                    <video class="d-block draggable" playsinline muted>
                                        <source class="d-none d-sm-block" src="{{ $admin_url . $slide->image_pc }}" type="video/mp4">
                                        <source class="d-sm-none" src="{{ !empty($slide->image_sp) ? $admin_url.$slide->image_sp : $admin_url.$slide->image_pc }}" type="video/mp4">
                                    </video>
                                @else
                                    <img src="{{ $admin_url . $slide->image_pc }}" class="d-block draggable d-none d-sm-block" alt="{{ $slide->name }}">
                                    <img src="{{ !empty($slide->image_sp) ? $admin_url.$slide->image_sp : $admin_url.$slide->image_pc }}" class="d-block draggable d-sm-none" alt="{{ $slide->name }}" style="width: 100%">
                                @endif
                                <div class="container slider-box">
                                    <div class="row">
                                        <div class="col">
                                            @if(!empty($slide->name))
                                                <h2><a href="{{ $slide->link }}">{{ $slide->name }}</a></h2>
                                            @endif
                                            @if(!empty($slide->content))
                                                <p>{!! $slide->content !!}</p>
                                            @endif
                                            @if(!empty($slide->link_text))
                                                <a href="{{ $slide->link }}" class="btn btn-primary btn-link">{{ $slide->link_text }}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @elseif($data['homeSetting']->item_type == \App\Modules\Home\Models\HomeSetting::BANNER_3PHOTO_TYPE)
                <div class="banner_slider banner-3photo_slider d-flex" style="background-color: {{ $data['homeSetting']->background_color }}">
                    <div class="container" style="padding: 12px">
                        <div class="row">
                            <div class="slider">
                                <!-- Additional required wrapper -->
                                <div class="swiper-wrapper">
                                    <!-- Slides -->
                                    @if(!empty($photoLibrary->{"pc"}))
                                        @foreach($photoLibrary->{"pc"} as $image)
                                            <div class="swiper-slide">
                                                <a href="{{ $image->link }}">
                                                    <img loading="lazy" src="{{ $admin_url . $image->url }}" width="auto" height="100%" alt="banner"/>
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
                <div class="banner_slider banner-3photo_slider d-none" style="background-color: {{ $data['homeSetting']->background_color }}">
                    <div class="container" style="padding: 12px">
                        <div class="row">
                            <div class="slider">
                                <!-- Additional required wrapper -->
                                <div class="swiper-wrapper">
                                    <!-- Slides -->
                                    @if(!empty($photoLibrary->{"mobile"}))
                                        @foreach($photoLibrary->{"mobile"} as $image)
                                            <div class="swiper-slide">
                                                <a href="{{ $image->link }}">
                                                    <img loading="lazy" src="{{ $admin_url . $image->url }}" width="auto" height="100%" alt="banner"/>
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
            @endif

        @elseif($data['homeSetting']->display_type == \App\Modules\Home\Models\HomeSetting::IMAGE_DISPLAY_TYPE)
            @if($data['homeSetting']->item_type == \App\Modules\Home\Models\HomeSetting::IMAGE_TYPE)
                <div class="blog_list blog_list-image" style="background-color: {{ $data['homeSetting']->background_color }}">
                    <div class="container title_section" style="margin-bottom: 0;color: {{ $data['homeSetting']->title_color }} !important; text-align: {{ $data['homeSetting']->title_position }}">{!! $data['homeSetting']->title !!}</div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-8">
                                <p style="text-align: center;"><i>{{ $data['homeSetting']->description }}</i></p>
                            </div>
                        </div>
                        <div class="row list-image">
                            <div class="col-12 col-sm-6">
                                <div class="image-1 mb-3 mb-md-4">
                                    @if(!empty($photoLibrary->{"image-1"}->{"link_youtube"}))
                                        {!! $photoLibrary->{"image-1"}->{"link_youtube"} !!}
                                    @else
                                        <div class="image-link mb-3 mb-md-4 h-100" data-image-src="{{ !empty($photoLibrary->{"image-1"}->{"url_big"}) ? $admin_url.$photoLibrary->{"image-1"}->{"url_big"} : $admin_url.$photoLibrary->{"image-1"}->{"url"} }}">
                                            <img loading="lazy" src="{{ $admin_url.$photoLibrary->{"image-1"}->{"url"} }}" class="w-100 shadow-1-strong rounded" alt="image"/>
                                        </div>
                                    @endif
                                </div>
                                <div class="row image-4-5 mb-3 mb-md-4">
                                    <div class="col-6">
                                        <div class="image-link image-4" data-image-src="{{ !empty($photoLibrary->{"image-4"}->{"url_big"}) ? $admin_url.$photoLibrary->{"image-4"}->{"url_big"} : $admin_url.$photoLibrary->{"image-4"}->{"url"} }}">
                                            <img loading="lazy" src="{{ $admin_url.$photoLibrary->{"image-4"}->{"url"} }}" class="w-100 shadow-1-strong rounded" alt="image"/>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="image-link image-5" data-image-src="{{ !empty($photoLibrary->{"image-5"}->{"url_big"}) ? $admin_url.$photoLibrary->{"image-5"}->{"url_big"} : $admin_url.$photoLibrary->{"image-5"}->{"url"} }}">
                                            <img loading="lazy" src="{{ $admin_url.$photoLibrary->{"image-5"}->{"url"} }}" class="w-100 shadow-1-strong rounded" alt="image"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <div class="row h-100">
                                    <div class="col-6">
                                        <div class="image-link image-2 mb-3 mb-md-4" data-image-src="{{ !empty($photoLibrary->{"image-2"}->{"url_big"}) ? $admin_url.$photoLibrary->{"image-2"}->{"url_big"} : $admin_url.$photoLibrary->{"image-2"}->{"url"} }}">
                                            <img loading="lazy" src="{{ $admin_url.$photoLibrary->{"image-2"}->{"url"} }}" class="w-100 shadow-1-strong rounded" alt="image"/>
                                        </div>

                                        <div class="image-link image-3 mb-3 mb-md-4" data-image-src="{{ !empty($photoLibrary->{"image-3"}->{"url_big"}) ? $admin_url.$photoLibrary->{"image-3"}->{"url_big"} : $admin_url.$photoLibrary->{"image-3"}->{"url"} }}">
                                            <img loading="lazy" src="{{ $admin_url.$photoLibrary->{"image-3"}->{"url"} }}" class="w-100 shadow-1-strong rounded" alt="image"/>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="image-link image-6 mb-3 mb-md-4" data-image-src="{{ !empty($photoLibrary->{"image-6"}->{"url_big"}) ? $admin_url.$photoLibrary->{"image-6"}->{"url_big"} : $admin_url.$photoLibrary->{"image-6"}->{"url"} }}">
                                            <img loading="lazy" src="{{ $admin_url.$photoLibrary->{"image-6"}->{"url"} }}" class="w-100 shadow-1-strong rounded" alt="image"/>
                                        </div>

                                        <div class="image-link image-7 mb-3 mb-md-4" data-image-src="{{ !empty($photoLibrary->{"image-7"}->{"url_big"}) ? $admin_url.$photoLibrary->{"image-7"}->{"url_big"} : $admin_url.$photoLibrary->{"image-7"}->{"url"} }}">
                                            <img loading="lazy" src="{{ $admin_url.$photoLibrary->{"image-7"}->{"url"} }}" class="w-100 shadow-1-strong rounded" alt="image"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($data['homeSetting']->item_type == \App\Modules\Home\Models\HomeSetting::IMAGE_TYPE_RECTANGLE)
                <div class="blog_list blog_list-image" style="background-color: {{ $data['homeSetting']->background_color }}">
                    <div class="container title_section" style="margin-bottom: 0;color: {{ $data['homeSetting']->title_color }} !important; text-align: {{ $data['homeSetting']->title_position }}">{!! $data['homeSetting']->title !!}</div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-8">
                                <p style="text-align: center;"><i>{{ $data['homeSetting']->description }}</i></p>
                            </div>
                        </div>
                        <div class="row list-image">
                            @foreach($photoLibrary as $image)
                                <div class="@if($data['homeSetting']->quantity == 4) col-3 @elseif($data['homeSetting']->quantity == 3) col-4 @elseif($data['homeSetting']->quantity == 2) col-6 @endif image-link mb-3 mb-md-4 h-100" data-image-src="{{ $admin_url.$image }}">
                                    <img loading="lazy" src="{{ $admin_url.$image }}" class="w-100 shadow-1-strong" style="{{ $data['homeSetting']->css }}" alt="image"/>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        @elseif($data['homeSetting']->display_type == \App\Modules\Home\Models\HomeSetting::BLOG_DISPLAY_TYPE)
            <div class="blog_list blog_display_type" style="background-color: {{ $data['homeSetting']->background_color }}; padding-bottom: 30px">
                <div class="container title_section @if($data['homeSetting']->title == 'null' || $data['homeSetting']->title == '<p>null</p>') d-none @endif" style="color: {{ $data['homeSetting']->title_color }} !important; text-align: {{ $data['homeSetting']->title_position }}">{!! $data['homeSetting']->title !!}</div>
                <div class="container @if($data['homeSetting']->quantity == 0) content @endif">
                    <div class="row justify-content-center">
                        <div class="col {{ $data['homeSetting']->css }}">
                            <div class="row justify-content-center @if(empty($data['homeSetting']->description)) d-none @endif">
                                <div class="col-12 col-md-8">
                                    <p style="text-align: center;"><i>{{ $data['homeSetting']->description }}</i></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-6 image @if($data['homeSetting']->item_type == \App\Modules\Home\Models\HomeSetting::LEFT_BLOG_TYPE) order-1 @elseif( $data['homeSetting']->item_type == \App\Modules\Home\Models\HomeSetting::RIGHT_BLOG_TYPE ) order-2 @else d-none @endif">
                                    @if(!empty($data['homeSetting']->images))
                                        <div class="image-link" data-image-src="{{ $admin_url.$data['homeSetting']->images }}">
                                            <img loading="lazy" src="{{ $admin_url.$data['homeSetting']->images }}" class="w-100 shadow-1-strong rounded" alt="image"/>
                                        </div>
                                    @endif
                                </div>
                                <div class="blog-content mt-3 mt-md-0 col-12 @if($data['homeSetting']->item_type == \App\Modules\Home\Models\HomeSetting::LEFT_BLOG_TYPE) col-sm-6 order-2 @elseif( $data['homeSetting']->item_type == \App\Modules\Home\Models\HomeSetting::RIGHT_BLOG_TYPE ) col-sm-6 order-1 @else col-sm-12 @endif d-flex flex-column justify-content-center">
                                    @if(!empty($data['homeSetting']->content))
                                        @php
                                            $content = $data['homeSetting']->content;
                                            $content = str_replace('images/blog', $admin_url.'images/blog', $content);
                                            echo $content;
                                        @endphp
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container text-center @if($data['homeSetting']->quantity == 1) d-none @endif">
                    <p class="showMoreButton">
                        <span>...</span>
                        <br>
                        <span>Xem thêm <i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                    </p>
                    <p class="showHideButton">
                        <span>Thu gọn <i class="fa fa-angle-double-up" aria-hidden="true"></i></span>
                    </p>
                </div>
            </div>
        @elseif($data['homeSetting']->display_type == \App\Modules\Home\Models\HomeSetting::SERVICE_DISPLAY_TYPE)
            @if($data['homeSetting']->item_type == \App\Modules\Home\Models\HomeSetting::OTHER_SERVICE_TYPE)
                @if($data['homeSetting']->quantity == \App\Modules\Home\Models\HomeSetting::SERVICE_TWO)
                    <section id="home_service_two" style="background-color: {{ $data['homeSetting']->background_color }}">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="container title_section" style="color: {{ $data['homeSetting']->title_color }} !important; text-align: {{ $data['homeSetting']->title_position }}">{!! $data['homeSetting']->title !!}</div>
                                <div style="margin-bottom: 15px;">{!! $data['homeSetting']->description !!}</div>
                                @foreach( $data['homeSetting']->services as $itemService)
                                    <div class="col-md-6 mb-4">
                                        <div class="col-box">
                                            @if($itemService->image)
                                                <div class="box-image {{ !empty($itemService->link) ? 'hover' : '' }} text-center" >
                                                    @if(!empty($itemService->link))
                                                        <a href="{{ $itemService->link }}" class="img" >
                                                            <img loading="lazy" src="{{$admin_url.$itemService->image}}" alt="{{ $itemService->name }}" style="{{ !empty(json_decode($data['homeSetting']->css)->{'service_border'}) ? json_decode($data['homeSetting']->css)->{'service_border'} : ''}}"/>
                                                        </a>
                                                    @else
                                                        <span class="img" >
                                                            <img loading="lazy" src="{{$admin_url.$itemService->image}}" alt="{{ $itemService->name }}" style="{{ !empty(json_decode($data['homeSetting']->css)->{'service_border'}) ? json_decode($data['homeSetting']->css)->{'service_border'} : ''}}"/>
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif
                                            <div class="box-content mt-3">
                                                <div class="@if($data['homeSetting']->item_title_position == 'center') text-center @endif">
                                                    @if(!empty($itemService->link))
                                                        <a href="{{ $itemService->link }}" class="text-decoration-none" style="color: unset">{!! $itemService->name !!}</a>
                                                    @else
                                                        <span>{!! $itemService->name !!}</span>
                                                    @endif
                                                </div>
                                                <p class="@if($data['homeSetting']->item_title_position == 'center') text-center @endif">{!! $itemService->description !!}</p>
                                                <div>
                                                    {!! $itemService->content !!}
                                                </div>
                                            </div>
                                            @if(!empty(json_decode($itemService->button)->{'button'}))
                                                <div class="box-button mt-2 mb-3 @if($data['homeSetting']->item_title_position == 'center') text-center @else text-left @endif">
                                                    <a class="btn btn-primary @if($itemService->button_type == 'popup') btn-quote-and-promotion @endif" href="{{ $itemService->link }}" data-id="{{$itemService->id}}" data-name="{{$itemService->name}}">
                                                        {!! !empty(json_decode($itemService->button)->{'icon'}) ? json_decode($itemService->button)->{'icon'} : '' !!}
                                                        {{ !empty(json_decode($itemService->button)->{'button'}) ? json_decode($itemService->button)->{'button'} : '' }}
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
                @elseif($data['homeSetting']->quantity == \App\Modules\Home\Models\HomeSetting::SERVICE_THREE)
                    <section id="home_service_three" style="background-color: {{ $data['homeSetting']->background_color }}">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="container title_section" style="color: {{ $data['homeSetting']->title_color }} !important; text-align: {{ $data['homeSetting']->title_position }}">{!! $data['homeSetting']->title !!}</div>
                                <div style="margin-bottom: 15px;">{!! $data['homeSetting']->description !!}</div>
                                @foreach( $data['homeSetting']->services as $itemService)
                                    <div class="col-md-4 mb-4">
                                        <div class="col-box">
                                            @if($itemService->image)
                                                <div class="box-image {{ !empty($itemService->link) ? 'hover' : '' }}" >
                                                    @if(!empty($itemService->link))
                                                        <a href="{{ $itemService->link }}" class="img" >
                                                            <img loading="lazy" src="{{$admin_url.$itemService->image}}" alt="{{ $itemService->name }}" style="{{ !empty(json_decode($data['homeSetting']->css)->{'service_border'}) ? json_decode($data['homeSetting']->css)->{'service_border'} : ''}}"/>
                                                        </a>
                                                    @else
                                                        <span class="img" >
                                                            <img loading="lazy" src="{{$admin_url.$itemService->image}}" alt="{{ $itemService->name }}" style="{{ !empty(json_decode($data['homeSetting']->css)->{'service_border'}) ? json_decode($data['homeSetting']->css)->{'service_border'} : ''}}"/>
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif
                                            <div class="box-content mt-3">
                                                <div class="@if($data['homeSetting']->item_title_position == 'center') text-center @endif">
                                                    @if(!empty($itemService->link))
                                                        <a href="{{ $itemService->link }}" class="text-decoration-none" style="color: unset">{!! $itemService->name !!}</a>
                                                    @else
                                                        <span>{!! $itemService->name !!}</span>
                                                    @endif
                                                </div>
                                                <p class="@if($data['homeSetting']->item_title_position == 'center') text-center @endif">{!! $itemService->description !!}</p>
                                                <div>
                                                    {!! $itemService->content !!}
                                                </div>
                                            </div>
                                            @if(!empty(json_decode($itemService->button)->{'button'}))
                                                <div class="box-button mt-2 mb-3 @if($data['homeSetting']->item_title_position == 'center') text-center @else text-left @endif">
                                                    <a class="btn btn-primary @if($itemService->button_type == 'popup') btn-quote-and-promotion @endif" href="{{ $itemService->link }}" data-id="{{$itemService->id}}" data-name="{{$itemService->name}}">
                                                        {!! !empty(json_decode($itemService->button)->{'icon'}) ? json_decode($itemService->button)->{'icon'} : '' !!}
                                                        {{ !empty(json_decode($itemService->button)->{'button'}) ? json_decode($itemService->button)->{'button'} : '' }}
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
                @elseif($data['homeSetting']->quantity == \App\Modules\Home\Models\HomeSetting::SERVICE_THREE_SPECIAL)
                    <section id="home_service_2" style="background-color: {{ $data['homeSetting']->background_color }}">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="container title_section" style="color: {{ $data['homeSetting']->title_color }} !important; text-align: {{ $data['homeSetting']->title_position }}">{!! $data['homeSetting']->title !!}</div>
                                <div style="margin-bottom: 15px;">{!! $data['homeSetting']->description !!}</div>
                                @foreach( $data['homeSetting']->services as $itemService)
                                    <div class="col-md-4 text-center">
                                        <div class="col-box">
                                            @if($itemService->image)
                                                <div class="box-image">
                                                    @if(!empty($itemService->link))
                                                        <a href="{{ $itemService->link }}" class="img" >
                                                            <img loading="lazy" src="{{$admin_url.$itemService->image}}" alt="{{ $itemService->name }}" />
                                                        </a>
                                                    @else
                                                        <span class="img" >
                                                            <img loading="lazy" src="{{$admin_url.$itemService->image}}" alt="{{ $itemService->name }}" />
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif
                                            <div class="box-content">
                                                <div class="@if($data['homeSetting']->item_title_position == 'center') text-center @endif">
                                                    @if(!empty($itemService->link))
                                                        <a href="{{ $itemService->link }}" class="text-decoration-none" style="color: unset">{!! $itemService->name !!}</a>
                                                    @else
                                                        <span>{!! $itemService->name !!}</span>
                                                    @endif
                                                </div>
                                                <p class="@if($data['homeSetting']->item_title_position == 'center') text-center @endif">{!! $itemService->description !!}</p>
                                                <div>
                                                    {!! $itemService->content !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
                @elseif($data['homeSetting']->quantity == \App\Modules\Home\Models\HomeSetting::SERVICE_FOUR)
                    <section id="home_service_4" style="background-color: {{ $data['homeSetting']->background_color }}">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="container title_section" style="color: {{ $data['homeSetting']->title_color }} !important; text-align: {{ $data['homeSetting']->title_position }}">{!! $data['homeSetting']->title !!}</div>
                                <div style="margin-bottom: 15px;">{!! $data['homeSetting']->description !!}</div>
                                @foreach( $data['homeSetting']->services as $itemService)
                                    <div class="col-6 col-md-4">
                                        <div class="col-box">
                                            @if($itemService->image)
                                                <div class="box-image {{ !empty($itemService->link) ? 'hover' : '' }}" >
                                                    @if(!empty($itemService->link))
                                                        <a href="{{ $itemService->link }}" class="img" >
                                                            <img loading="lazy" src="{{$admin_url.$itemService->image}}" alt="{{ $itemService->name }}" style="{{ !empty(json_decode($data['homeSetting']->css)->{'service_border'}) ? json_decode($data['homeSetting']->css)->{'service_border'} : ''}}"/>
                                                        </a>
                                                    @else
                                                        <span class="img" >
                                                            <img loading="lazy" src="{{$admin_url.$itemService->image}}" alt="{{ $itemService->name }}" style="{{ !empty(json_decode($data['homeSetting']->css)->{'service_border'}) ? json_decode($data['homeSetting']->css)->{'service_border'} : ''}}"/>
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif
                                            <div class="box-content">
                                                <div class="@if($data['homeSetting']->item_title_position == 'center') text-center @endif">
                                                    @if(!empty($itemService->link))
                                                        <a href="{{ $itemService->link }}" class="text-decoration-none" style="color: unset">{!! $itemService->name !!}</a>
                                                    @else
                                                        <span>{!! $itemService->name !!}</span>
                                                    @endif
                                                </div>
                                                <p class="@if($data['homeSetting']->item_title_position == 'center') text-center @endif">{!! $itemService->description !!}</p>
                                                <div>
                                                    {!! $itemService->content !!}
                                                </div>
                                            </div>
                                            @if(!empty(json_decode($itemService->button)->{'button'}))
                                                <div class="box-button mt-2 mb-3 @if($data['homeSetting']->item_title_position == 'center') text-center @else text-left @endif">
                                                    <a class="btn btn-primary @if($itemService->button_type == 'popup') btn-quote-and-promotion @endif" href="{{ $itemService->link }}" data-id="{{$itemService->id}}" data-name="{{$itemService->name}}">
                                                        {!! !empty(json_decode($itemService->button)->{'icon'}) ? json_decode($itemService->button)->{'icon'} : '' !!}
                                                        {{ !empty(json_decode($itemService->button)->{'button'}) ? json_decode($itemService->button)->{'button'} : '' }}
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
                @elseif($data['homeSetting']->quantity == \App\Modules\Home\Models\HomeSetting::SERVICE_FOUR_SPECIAL)
                    <section id="home_service_3" style="background-color: {{ $data['homeSetting']->background_color }}">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="container title_section" style="color: {{ $data['homeSetting']->title_color }} !important; text-align: {{ $data['homeSetting']->title_position }}">{!! $data['homeSetting']->title !!}</div>
                                <div style="margin-bottom: 15px;">{!! $data['homeSetting']->description !!}</div>
                                @foreach( $data['homeSetting']->services as $itemService)
                                    <div class="col-6 col-md-4 text-center" style="margin-bottom: 30px">
                                        <div class="col-box">
                                            @if($itemService->image)
                                                <div class="box-image">
                                                    @if(!empty($itemService->link))
                                                        <a href="{{ $itemService->link }}" class="img" >
                                                            <img loading="lazy" src="{{$admin_url.$itemService->image}}" alt="{{ $itemService->name }}" />
                                                        </a>
                                                    @else
                                                        <span class="img" >
                                                                <img loading="lazy" src="{{$admin_url.$itemService->image}}" alt="{{ $itemService->name }}" />
                                                            </span>
                                                    @endif
                                                </div>
                                            @endif
                                            <div class="box-content">
                                                <div class="@if($data['homeSetting']->item_title_position == 'center') text-center @endif">
                                                    @if(!empty($itemService->link))
                                                        <a href="{{ $itemService->link }}" class="text-decoration-none" style="color: unset">{!! $itemService->name !!}</a>
                                                    @else
                                                        <span>{!! $itemService->name !!}</span>
                                                    @endif
                                                </div>
                                                <p class="@if($data['homeSetting']->item_title_position == 'center') text-center @endif">{!! $itemService->description !!}</p>
                                                <div>
                                                    {!! $itemService->content !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
                @elseif($data['homeSetting']->quantity == \App\Modules\Home\Models\HomeSetting::SERVICE_FIVE)
                    <section id="home_service_five" style="background-color: {{ $data['homeSetting']->background_color }}">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="container title_section" style="color: {{ $data['homeSetting']->title_color }} !important; text-align: {{ $data['homeSetting']->title_position }}">{!! $data['homeSetting']->title !!}</div>
                                <div style="margin-bottom: 15px;">{!! $data['homeSetting']->description !!}</div>
                                @foreach( $data['homeSetting']->services as $itemService)
                                    <div class="col-6 col-md-4 col-md-design-2">
                                        <div class="col-box">
                                            @if($itemService->image)
                                                <div class="box-image {{ !empty($itemService->link) ? 'hover' : '' }}" >
                                                    @if(!empty($itemService->link))
                                                        <a href="{{ $itemService->link }}" class="img" >
                                                            <img loading="lazy" src="{{$admin_url.$itemService->image}}" alt="{{ $itemService->name }}" style="{{ !empty(json_decode($data['homeSetting']->css)->{'service_border'}) ? json_decode($data['homeSetting']->css)->{'service_border'} : ''}}"/>
                                                        </a>
                                                    @else
                                                        <span class="img" >
                                                            <img loading="lazy" src="{{$admin_url.$itemService->image}}" alt="{{ $itemService->name }}" style="{{ !empty(json_decode($data['homeSetting']->css)->{'service_border'}) ? json_decode($data['homeSetting']->css)->{'service_border'} : ''}}"/>
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif
                                            <div class="box-content mt-2">
                                                <div class="@if($data['homeSetting']->item_title_position == 'center') text-center @endif">
                                                    @if(!empty($itemService->link))
                                                        <a href="{{ $itemService->link }}" class="text-decoration-none" style="color: unset">{!! $itemService->name !!}</a>
                                                    @else
                                                        <span>{!! $itemService->name !!}</span>
                                                    @endif
                                                </div>
                                                <p class="@if($data['homeSetting']->item_title_position == 'center') text-center @endif">{!! $itemService->description !!}</p>
                                                <div>
                                                    {!! $itemService->content !!}
                                                </div>
                                            </div>
                                            @if(!empty(json_decode($itemService->button)->{'button'}))
                                                <div class="box-button mt-2 mb-3 @if($data['homeSetting']->item_title_position == 'center') text-center @else text-left @endif">
                                                    <a class="btn btn-primary @if($itemService->button_type == 'popup') btn-quote-and-promotion @endif" href="{{ $itemService->link }}" data-id="{{$itemService->id}}" data-name="{{$itemService->name}}">
                                                        {!! !empty(json_decode($itemService->button)->{'icon'}) ? json_decode($itemService->button)->{'icon'} : '' !!}
                                                        {{ !empty(json_decode($itemService->button)->{'button'}) ? json_decode($itemService->button)->{'button'} : '' }}
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
                @elseif($data['homeSetting']->quantity == \App\Modules\Home\Models\HomeSetting::SERVICE_SIX)
                    <section id="home_service_five" style="background-color: {{ $data['homeSetting']->background_color }}">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="container title_section" style="color: {{ $data['homeSetting']->title_color }} !important; text-align: {{ $data['homeSetting']->title_position }}">{!! $data['homeSetting']->title !!}</div>
                                <div style="margin-bottom: 15px;">{!! $data['homeSetting']->description !!}</div>
                                @foreach( $data['homeSetting']->services as $itemService)
                                    <div class="col-6 col-md-2">
                                        <div class="col-box">
                                            @if($itemService->image)
                                                <div class="box-image {{ !empty($itemService->link) ? 'hover' : '' }}" >
                                                    @if(!empty($itemService->link))
                                                        <a href="{{ $itemService->link }}" class="img" >
                                                            <img loading="lazy" src="{{$admin_url.$itemService->image}}" alt="{{ $itemService->name }}" style="{{ !empty(json_decode($data['homeSetting']->css)->{'service_border'}) ? json_decode($data['homeSetting']->css)->{'service_border'} : ''}}"/>
                                                        </a>
                                                    @else
                                                        <span class="img" >
                                                            <img loading="lazy" src="{{$admin_url.$itemService->image}}" alt="{{ $itemService->name }}" style="{{ !empty(json_decode($data['homeSetting']->css)->{'service_border'}) ? json_decode($data['homeSetting']->css)->{'service_border'} : ''}}"/>
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif
                                            <div class="box-content mt-2">
                                                <div class="@if($data['homeSetting']->item_title_position == 'center') text-center @endif">
                                                    @if(!empty($itemService->link))
                                                        <a href="{{ $itemService->link }}" class="text-decoration-none" style="color: unset">{!! $itemService->name !!}</a>
                                                    @else
                                                        <span>{!! $itemService->name !!}</span>
                                                    @endif
                                                </div>
                                                <p class="@if($data['homeSetting']->item_title_position == 'center') text-center @endif">{!! $itemService->description !!}</p>
                                                <div>
                                                    {!! $itemService->content !!}
                                                </div>
                                            </div>
                                            @if(!empty(json_decode($itemService->button)->{'button'}))
                                                <div class="box-button mt-2 mb-3 @if($data['homeSetting']->item_title_position == 'center') text-center @else text-left @endif">
                                                    <a class="btn btn-primary @if($itemService->button_type == 'popup') btn-quote-and-promotion @endif" href="{{ $itemService->link }}" data-id="{{$itemService->id}}" data-name="{{$itemService->name}}">
                                                        {!! !empty(json_decode($itemService->button)->{'icon'}) ? json_decode($itemService->button)->{'icon'} : '' !!}
                                                        {{ !empty(json_decode($itemService->button)->{'button'}) ? json_decode($itemService->button)->{'button'} : '' }}
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
                @endif
            @elseif($data['homeSetting']->item_type == \App\Modules\Home\Models\HomeSetting::BORDER_SERVICE_TYPE)
                <section id="home-border-service-type" style="background-color: {{ $data['homeSetting']->background_color }}">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="container title_section" style="color: {{ $data['homeSetting']->title_color }} !important; text-align: {{ $data['homeSetting']->title_position }}">{!! $data['homeSetting']->title !!}</div>
                            @if(!empty($data['homeSetting']->description))
                                <div style="margin-bottom: 15px;">{!! $data['homeSetting']->description !!}</div>
                            @endif
                            @foreach( $data['homeSetting']->services as $itemService)
                                @if($data['homeSetting']->quantity == \App\Modules\Home\Models\HomeSetting::BORDER_SERVICE_TWO)
                                    <div class="col-12 col-md-6 text-center" style="margin-bottom: 30px">
                                @elseif($data['homeSetting']->quantity == \App\Modules\Home\Models\HomeSetting::BORDER_SERVICE_THREE)
                                    <div class="col-12 col-md-4 text-center" style="margin-bottom: 30px">
                                @elseif($data['homeSetting']->quantity == \App\Modules\Home\Models\HomeSetting::BORDER_SERVICE_FOUR)
                                    <div class="col-6 col-md-3 text-center" style="margin-bottom: 30px">
                                @elseif($data['homeSetting']->quantity == \App\Modules\Home\Models\HomeSetting::BORDER_SERVICE_FIVE)
                                    <div class="col-6 col-md-design-2 text-center" style="margin-bottom: 30px">
                                @elseif($data['homeSetting']->quantity == \App\Modules\Home\Models\HomeSetting::BORDER_SERVICE_SIX)
                                    <div class="col-6 col-md-2 text-center" style="margin-bottom: 30px">
                                @else
                                    <div class="col-6 col-md-4 text-center" style="margin-bottom: 30px">
                                @endif
                                    <div class="col-box" style="{{ !empty(json_decode($data['homeSetting']->css)->{'service_border'}) ? json_decode($data['homeSetting']->css)->{'service_border'} : ''}}">
                                        @if($itemService->image)
                                            <div class="box-image">
                                                @if(!empty($itemService->link))
                                                    <a href="{{ $itemService->link }}" class="img" >
                                                        <img loading="lazy" src="{{$admin_url.$itemService->image}}" alt="{{ $itemService->name }}" style="{{ !empty(json_decode($data['homeSetting']->css)->{'service_border'}) ? json_decode($data['homeSetting']->css)->{'service_border'} : ''}}"/>
                                                    </a>
                                                @else
                                                    <span class="img" >
                                                                <img loading="lazy" src="{{$admin_url.$itemService->image}}" alt="{{ $itemService->name }}" style="{{ !empty(json_decode($data['homeSetting']->css)->{'service_border'}) ? json_decode($data['homeSetting']->css)->{'service_border'} : ''}}"/>
                                                            </span>
                                                @endif
                                            </div>
                                        @endif
                                        <div class="box-content">
                                            <div class="@if($data['homeSetting']->item_title_position == 'center') text-center @endif">
                                                @if(!empty($itemService->link))
                                                    <a href="{{ $itemService->link }}" class="text-decoration-none" style="color: unset">{!! $itemService->name !!}</a>
                                                @else
                                                    <span>{!! $itemService->name !!}</span>
                                                @endif
                                            </div>
                                            <p class="@if($data['homeSetting']->item_title_position == 'center') text-center @endif">{!! $itemService->description !!}</p>
                                            <div>
                                                {!! $itemService->content !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @elseif($data['homeSetting']->item_type == \App\Modules\Home\Models\HomeSetting::FULL_SERVICE_TYPE)
                <div class="blog_list service" style="background-color: {{ $data['homeSetting']->background_color }}">
                    <div class="container title_section" style="color: {{ $data['homeSetting']->title_color }} !important; text-align: {{ $data['homeSetting']->title_position }}">{!! $data['homeSetting']->title !!}</div>
                    <div style="margin-bottom: 15px;">{!! $data['homeSetting']->description !!}</div>
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            @foreach( $data['homeSetting']->services as $itemService)
                                <div class="col-6 col-md-6 col-md-design-6 service-product">
                                    <article>
                                        <div style="width: 100%; height: auto; {{ !empty(json_decode($data['homeSetting']->css)->{'service_padding'}) ? json_decode($data['homeSetting']->css)->{'service_padding'} : ''}};">
                                            @if(!empty($itemService->link))
                                                <a href="{{ $itemService->link }}" class="img" style="@if($data['homeSetting']->item_type == \App\Modules\Home\Models\HomeSetting::ROUND_CORNER_SERVICE_TYPE) border-radius: 50% @endif">
                                                    <img loading="lazy" src="{{$admin_url.$itemService->image}}" alt="{{$itemService->name}}" />
                                                </a>
                                            @else
                                                <span class="img" style="height: 25vw;padding:0;@if($data['homeSetting']->item_type == \App\Modules\Home\Models\HomeSetting::ROUND_CORNER_SERVICE_TYPE) border-radius: 50% @endif">
                                                    <img loading="lazy" src="{{$admin_url.$itemService->image}}" alt="{{$itemService->name}}"/>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="child-p-0 mt-3 mb-1">
                                            @if(!empty($itemService->link))
                                                <a href="{{ $itemService->link }}" class="text-decoration-none" style="color: unset">{!! $itemService->name !!}</a>
                                            @else
                                                <span>{!! $itemService->name !!}</span>
                                            @endif
                                        </div>
                                        <div>{!! $itemService->description !!}</div>
                                        <div>
                                            {!! $itemService->content !!}
                                        </div>
                                    </article>
                                    @if(!empty(json_decode($itemService->button)->{'button'}))
                                        <div class="box-button mt-2 mb-3 @if($data['homeSetting']->item_title_position == 'center') text-center @else text-left @endif">
                                            <a class="btn btn-primary @if($itemService->button_type == 'popup') btn-quote-and-promotion @endif" href="{{ $itemService->link }}" data-id="{{$itemService->id}}" data-name="{{$itemService->name}}" style="width: fit-content; margin: 0 auto;">
                                                {!! !empty(json_decode($itemService->button)->{'icon'}) ? json_decode($itemService->button)->{'icon'} : '' !!}
                                                {{ !empty(json_decode($itemService->button)->{'button'}) ? json_decode($itemService->button)->{'button'} : '' }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @elseif($data['homeSetting']->item_type == \App\Modules\Home\Models\HomeSetting::SLIDE_4_SERVICE_TYPE)
                <div class="blog_list service" style="background-color: {{ $data['homeSetting']->background_color }}">
                    <div class="container title_section" style="color: {{ $data['homeSetting']->title_color }} !important; text-align: {{ $data['homeSetting']->title_position }}">{!! $data['homeSetting']->title !!}</div>
                    <div style="margin-bottom: 15px;">{!! $data['homeSetting']->description !!}</div>
                    <div class="container">
                        <div class="owl-carousel owl-theme" id="div-tin-4-chay-ngang">
                            @foreach( $data['homeSetting']->services as $itemService)
                                <div class="item" style="border: 1px solid #fff;">
                                    @if(!empty($itemService->link))
                                        <a href="{{ $itemService->link }}">
                                            <img loading="lazy" class="w-100" src="{{$admin_url.$itemService->image}}" alt="{{$itemService->name}}" style="max-width: none; max-height: none;" />
                                        </a>
                                    @else
                                        <img loading="lazy" class="w-100" src="{{$admin_url.$itemService->image}}" alt="{{$itemService->name}}" style="max-width: none; max-height: none;"/>
                                    @endif
                                    <div style="padding: 15px 5px 0 5px; color: #fff; text-transform: uppercase; font-size: 15px;">
                                        @if(!empty($itemService->link))
                                            <a href="{{ $itemService->link }}" class="text-decoration-none" style="color: unset">{!! $itemService->name !!}</a>
                                        @else
                                            <span>{!! $itemService->name !!}</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @elseif($data['homeSetting']->item_type == \App\Modules\Home\Models\HomeSetting::ROUND_CORNER_SERVICE_TYPE)
                <div class="blog_list service service_round_corner" style="background-color: {{ $data['homeSetting']->background_color }}">
                    <div class="container title_section" style="color: {{ $data['homeSetting']->title_color }} !important; text-align: {{ $data['homeSetting']->title_position }}">{!! $data['homeSetting']->title !!}</div>
                    <div style="margin-bottom: 15px;">{!! $data['homeSetting']->description !!}</div>
                    <div class="container">
                        <div class="owl-carousel owl-theme">
                            @foreach( $data['homeSetting']->services as $itemService)
                                <div class="service-product item w-100">
                                    <article>
                                        @if(!empty($itemService->link))
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ $itemService->link }}" class="img" style="border-radius: 50%">
                                                <img loading="lazy" src="{{$admin_url.$itemService->image}}" alt="{{$itemService->name}}" />
                                            </a>
                                        </div>
                                        @else
                                            <div class="d-flex justify-content-center">
                                                <span class="img" style="border-radius: 50%">
                                                <img loading="lazy" src="{{$admin_url.$itemService->image}}" alt="{{$itemService->name}}" />
                                            </span>
                                            </div>
                                        @endif
                                        <div class="child-p-0 mt-3 mb-1">
                                            @if(!empty($itemService->link))
                                                <a href="{{ $itemService->link }}" class="text-decoration-none" style="color: unset">{!! $itemService->name !!}</a>
                                            @else
                                                <span>{!! $itemService->name !!}</span>
                                            @endif
                                        </div>
                                        <div>{!! $itemService->description !!}</div>
                                        <div>
                                            {!! $itemService->content !!}
                                        </div>
                                    </article>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @elseif($data['homeSetting']->item_type == \App\Modules\Home\Models\HomeSetting::SQUARE_CORNER_SERVICE_TYPE)
                <div class="blog_list service" style="background-color: {{ $data['homeSetting']->background_color }}">
                    <div class="container title_section" style="color: {{ $data['homeSetting']->title_color }} !important; text-align: {{ $data['homeSetting']->title_position }}">{!! $data['homeSetting']->title !!}</div>
                    <div style="margin-bottom: 15px;">{!! $data['homeSetting']->description !!}</div>
                    <div class="container">
                        <div class="row justify-content-center">
                            @foreach( $data['homeSetting']->services as $itemService)
                                <div class="col-6 col-md-3 col-md-design-2 service-product">
                                    <article>
                                        @if(!empty($itemService->link))
                                            <a href="{{ $itemService->link }}" class="img">
                                                <img loading="lazy" src="{{$admin_url.$itemService->image}}" alt="{{$itemService->name}}" />
                                            </a>
                                        @else
                                            <span class="img">
                                                <img loading="lazy" src="{{$admin_url.$itemService->image}}" alt="{{$itemService->name}}" />
                                            </span>
                                        @endif
                                        <div class="child-p-0 mt-3 mb-1">
                                            @if(!empty($itemService->link))
                                                <a href="{{ $itemService->link }}" class="text-decoration-none" style="color: unset">{!! $itemService->name !!}</a>
                                            @else
                                                <span>{!! $itemService->name !!}</span>
                                            @endif
                                        </div>
                                        <div>{!! $itemService->description !!}</div>
                                        <div>
                                            {!! $itemService->content !!}
                                        </div>
                                    </article>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        @endif
    @endforeach

    <div class="modal fade" id="quoteAndPromotionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl justify-content-center">
            <div class="modal-content" style="width: auto">
                <div class="modal-body">
                    @php($quoteAndPromotion = \App\Modules\Home\Models\HomeSetting::where('status', 1)->where('home_setting_type', \App\Modules\Home\Models\HomeSetting::HOME_PAGE)->where('display_type', \App\Modules\Home\Models\HomeSetting::FOLDER_DISPLAY_TYPE)->where('item_type', \App\Modules\Home\Models\HomeSetting::QUOTES_AND_PROMOTIONS)->first())
                    @if(!empty($quoteAndPromotion))
                        <div class="product_list item_frame" style="background-color: {{ $quoteAndPromotion->background_color }}; margin: 0">
                            <div class="container">
                                <div class="item_frame_background">
                                    <div class="row">
                                        <div class="col-12 col-md-6 order-1 @if(!empty(json_decode($quoteAndPromotion->images)[0]->{'position'}) && json_decode($quoteAndPromotion->images)[0]->{'position'} == 'right') order-sm-1 @else order-sm-2 @endif">
                                            <div class="item_frame_header p-0 pt-3 pb-2" style="text-align: {{ $quoteAndPromotion->title_position }}; background: #EEEEEE; border-top-left-radius: 6px; border-top-right-radius: 6px;">
                                        <span class="d-flex justify-content-center align-items-center header-boder-color">
                                            <span class="d-flex" style="color: {{ $quoteAndPromotion->title_color }} !important;">{!! $quoteAndPromotion->title !!}</span>
                                        </span>
                                        <span>
                                            <p class="ps-3 pe-3">{{ $quoteAndPromotion->description }}</p>
                                        </span>
                                            </div>
                                            <div class="item_frame_content">
                                                <form id="form-quote-and-promotion-modal" method="POST" action="#" accept-charset="UTF-8" enctype="multipart/form-data">
                                                    <div class="row">
                                                        <div class="quote-and-promotion-error text-center"></div>
                                                    </div>
                                                    <input name="_token" type="hidden" value="{{csrf_token()}}">
                                                    <div class="row mt-3 mb-3">
                                                        <div class="col-12 col-sm-6">
                                                            <input type="text" name="name" class="form-control" placeholder="Họ tên (Bắt buộc)" required>
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <input type="text" name="phone" class="form-control" placeholder="Điện thoại (Bắt buộc)" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-12">
                                                            <select id="select_product_id" class="form-select" aria-label="Default select example" name="product_id" required>
                                                                <option selected value="">{{ !empty(json_decode($quoteAndPromotion->images)[0]->{'select'}) ? json_decode($quoteAndPromotion->images)[0]->{'select'} : '-- Chọn dòng xe --' }}</option>
                                                                @foreach($quoteAndPromotion->products as $product)
                                                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-12">
                                                            <div class="mb-3">
                                                                <textarea class="form-control" name="content" rows="3" placeholder="Nội dung"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-center mb-3 text-center">
                                                        <div class="col-3 col-md-3 form-check text-start">
                                                            <input class="form-check-input" type="radio" name="pay" value="{{ \App\Modules\Page\Models\QuoteAndPromotion::INSTALLMENT }}" id="pay-1-modal" checked>
                                                            <label class="form-check-label" for="pay-1-modal">
                                                                Trả góp
                                                            </label>
                                                        </div>
                                                        <div class="col-3 col-md-3 form-check text-start">
                                                            <input class="form-check-input" type="radio" name="pay" value="{{ \App\Modules\Page\Models\QuoteAndPromotion::PAY_IN_FULL }}" id="pay-2-modal">
                                                            <label class="form-check-label" for="pay-2-modal">
                                                                Trả hết
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-center mb-3">
                                                        <div class="col-12 text-center">
                                                            <button type="button" class="btn btn-primary btn-submit">{!! !empty(json_decode($quoteAndPromotion->images)[0]->{'icon'}) ? json_decode($quoteAndPromotion->images)[0]->{'icon'} : ''  !!} {{ !empty(json_decode($quoteAndPromotion->images)[0]->{'button'}) ? json_decode($quoteAndPromotion->images)[0]->{'button'} : 'NHẬN BÁO GIÁ NGAY' }}</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        @if(!empty(json_decode($quoteAndPromotion->images)[0]->{'url'}))
                                            <div class="col-12 col-md-6 @if(!empty(json_decode($quoteAndPromotion->images)[0]->{'position'}) && json_decode($quoteAndPromotion->images)[0]->{'position'} == 'right') order-sm-2 @else order-sm-1 @endif">
                                                <img id="quote-and-promotion-product-image" src="{{ config('app.PATH_ADMIN') . json_decode($quoteAndPromotion->images)[0]->{'url'} }}" alt="{{ $quoteAndPromotion->description }}" style="max-width: 100%; border-radius: 6px;">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection


@section('styles')
    <link href="{{asset('public/assets/home.css')}}" rel="stylesheet" type="text/css">
    <style>
        .home_about-background-image {
            background-image: url('@if(!empty(json_decode($about->image)->{'pc'})) {{ $admin_url.json_decode($about->image)->{'pc'} }} @endif');
            height: 620.59px;
        }
        @media (max-width: 576px) {
            .home_about-background-image {
                background-image: url('@if(!empty(json_decode($about->image)->{'mobile'})) {{ $admin_url.json_decode($about->image)->{'mobile'} }} @endif');
            }
        }
        .contact-content .icon {
            border: 4px solid {{ $setting->header_background_color }};
            color: {{ $setting->header_background_color }};
        }

        #div-tin-4-chay-ngang{
            width: 100%; padding: 0 5px; overflow: hidden;
        }
        #div-tin-4-chay-ngang .owl-carousel .owl-stage-outer {
            overflow: unset !important;
        }
        #div-tin-4-chay-ngang .nav-btn{
            height: 47px;
            position: absolute;
            width: 26px;
            cursor: pointer;
            top: 45% !important;
        }
        #div-tin-4-chay-ngang .nav-btn i{
            color: #fff; font-size: 24px;
        }
        #div-tin-4-chay-ngang .owl-prev.disabled,
        #div-tin-4-chay-ngang .owl-next.disabled{
            pointer-events: none;
            opacity: 0.2;
        }
        #div-tin-4-chay-ngang .prev-slide{
            left: -0px;
        }
        #div-tin-4-chay-ngang .next-slide{
            right: -0px;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="{{ asset('public/js/home.js') }}"></script>
    <script src="{{ asset('public/js/contact.js') }}"></script>
    <script src="{{ asset('public/js/quote_and_promotion.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#div-tin-4-chay-ngang').owlCarousel({
                loop: true,
                margin: 10,
                nav: true,
                navText:["<div class='nav-btn prev-slide'><i class='fa fa-angle-left'></i></div>","<div class='nav-btn next-slide'><i class='fa fa-angle-right'></i></div>"],
                autoplay: true,
                autoplayTimeout: 2000,
                dots: false,
                responsive: {
                    0: {
                        items: 2
                    },
                    600: {
                        items: 2
                    },
                    1000: {
                        items: 4
                    }
                }
            });
        });
    </script>
@endsection
