@extends('Home::Layout.master')
@php($setting = \App\Modules\Footer\Models\Footer::find(1))
@section('main')
    <div class="container margin-top-10">
        <div class="row">
            <div class="col-12 margin-bottom-10">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/"><i class="fa fa-home" aria-hidden="true"></i>
                                Home</a></li>
                        @if(isset($menu))
                            {!! $menu->generateMenuBreadcrumb() !!}
                            <li class="breadcrumb-item"><a href="{{ $menu->link }}">{{ $menu->name }}</a></li>
                        @else
                            <li class="breadcrumb-item" aria-current="page">{{ $product->name }}</li>
                        @endif
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-lg-9 p-r-0">
                <div class="background-content">
                    <div class="container">
                        <div class="row single_product ">
                            <div class="col-md-6 p-l-0">
                                <div class="row slide">
                                    <div class="preview-slide">
                                        <div class="overlay"></div>
                                        <div class="swiper-container main-slider">
                                            <div class="swiper-wrapper">
                                                @if(!empty($images))
                                                    @foreach($images as $key => $img)
                                                        @if(!empty($img))
                                                            <div class="swiper-slide swiper-slide-main">
                                                                <img loading="lazy" class="image"
                                                                     src="{{Config::get('app.PATH_ADMIN').$img}}"
                                                                     alt="{{$product->name.$key}}">
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="swiper-button-next"></div>
                                            <div class="swiper-button-prev"></div>
                                        </div>
                                    </div>
                                    <div class="swiper-container swiper-container-thumbs position-relative">
                                        <div class="swiper-wrapper">
                                            @if(!empty($images))
                                                @foreach($images as $key => $img)
                                                    @if(!empty($img))
                                                        <div class="swiper-slide swiper-slide-thumb">
                                                            <img loading="lazy" class="image"
                                                                 src="{{Config::get('app.PATH_ADMIN').$img}}"
                                                                 alt="{{$product->name.$key}}">
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="swiper-button-next"></div>
                                        <div class="swiper-button-prev"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 p-r-0">
                                <div class="info">
                                    <h1 class="product-title">{{$product->name}}</h1>
                                    @if(!empty($product->description))
                                        <hr>
                                        <span>{{$product->description}}</span>
                                    @endif
                                    <hr>
                                    @if(!empty(json_decode($product->product_parameters)))
                                        <table class="table table-striped">
                                            <tbody>
                                                @foreach(json_decode($product->product_parameters) as $key => $product_parameter)
                                                    <tr class="d-flex">
                                                        <td class="d-flex align-items-center" style="gap: 6px; min-width: 30%">{!! $product_parameter->icon !!} {{ $product_parameter->title }}</td>
                                                        <td style="flex: 1">{{ $product_parameter->content }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                    <div class="d-flex align-items-center">
                                        <p class="margin-right-10 price-title">Giá (chưa VAT): </p>
                                        <div class="d-flex align-items-center price">
                                            @if(!empty($product->price_regular) && !empty($product->price_sale))
                                                <div class="sale margin-right-10">{{number_format($product->price_sale,0 ,'.','.')}}
                                                    đ
                                                </div>
                                                <div class="regular">{{number_format($product->price_regular,0 ,'.','.')}}
                                                    đ
                                                </div>
                                            @elseif(!empty($product->price_regular) && empty($product->price_sale))
                                                <div class="sale">{{number_format($product->price_regular,0 ,'.','.')}}
                                                    đ
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    @if(!empty($product->vat))
                                        <div class="d-flex align-items-center">
                                            <p class="margin-right-10 price-title">Giá (đã VAT): </p>
                                            <div class="d-flex align-items-center price">
                                                <div class="sale">
                                                    @if(!empty($product->price_regular) && !empty($product->price_sale))
                                                        {{ number_format($product->price_sale + $product->price_sale * ($product->vat / 100),0 ,'.','.') }} đ
                                                    @elseif(!empty($product->price_regular) && empty($product->price_sale))
                                                        {{ number_format($product->price_regular + $product->price_regular * ($product->vat / 100),0 ,'.','.') }} đ
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <hr>
                                    <form action="{{route('product.cart')}}" method="post" class="frm_cart">
                                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                        <div class="qty">
                                            <strong>Số lượng: </strong> <input type="number" name="qty" value="1"
                                                                               class="form-control qty_input" min="1"/>
                                            <span>(Còn 1 sản phẩm có sẵn)</span>
                                        </div>
                                        <div class="btn_group row align-items-center">
                                            <div class="col-6 btn-buy-now">
                                                <button type="submit" name="buy_now" value="{{$product->id}}"
                                                        class="btn header-background-text-color buy_now">MUA NGAY
                                                </button>
                                            </div>
                                            <div class="col-6 btn-add-cart">
                                                <button type="button" name="add_to_cart" value="{{$product->id}}"
                                                        class="btn btn-primary add_to_cart header-boder-color">Thêm giỏ hàng
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <form action="{{route('product.add.cart.post')}}" id="add_to_cart" method="post"
                                          style="position: absolute;visibility: hidden;">
                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                        <input type="hidden" name="qty" value="1" class="qty_hidden"/>
                                        <input type="hidden" name="buy_now" value="{{$product->id}}"/>
                                    </form>
                                    <div class="row">
                                        <div class="col-6 btn-send-consult">
                                            <button type="button" class="btn header-background-text-color btn-consult margin-right-10 w-100" style="font-weight: 600; padding: 10px">
                                                YÊU CẦU TƯ VẤN
                                            </button>
                                        </div>
                                        <div class="col-6 btn-hotline">
                                            <a class="btn-single-hotline btn w-100 header-boder-color" href="tel:{{ json_decode(\App\Modules\Footer\Models\Footer::find(1)->phone)[0] }}">
                                                <span class="font-bold" style="color: #0c0d0e">Hotline:</span>
                                                <span>{{ json_decode(\App\Modules\Footer\Models\Footer::find(1)->phone)[0] }}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    @php($policy = explode("\n", $product->policy))
                                    @if(!empty($product->policy))
                                        <div class="product-box mb-3 mt-3">
                                            <div class="product-box-body">
                                                <ul>
                                                    @foreach($policy as $po)
                                                        @if(!empty($po))
                                                            <li>{{$po}}</li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="background-content">
                    <div class="container">
                        <div class="row infomation">
                            <div class="col-md-12 p-0">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    @if(!empty($product->parameter))
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="parameter-tab" data-bs-toggle="tab" data-bs-target="#parameter" type="button" role="tab" aria-controls="parameter" aria-selected="true">THÔNG SỐ KỸ THUẬT</button>
                                        </li>
                                    @endif
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="content-tab" data-bs-toggle="tab" data-bs-target="#content" type="button" role="tab" aria-controls="content" aria-selected="false">MÔ TẢ</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="promotion-tab" data-bs-toggle="tab" data-bs-target="#promotion" type="button" role="tab" aria-controls="promotion" aria-selected="false">ƯU ĐÃI - TẶNG KÈM</button>
                                    </li>
                                    @if(!empty($product->product_manual))
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="use-tab" data-bs-toggle="tab" data-bs-target="#use" type="button" role="tab" aria-controls="use" aria-selected="false">HƯỚNG DẪN SỬ DỤNG</button>
                                        </li>
                                    @endif
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review" type="button" role="tab" aria-controls="review" aria-selected="false">ĐÁNH GIÁ</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane position-relative fade" id="parameter" role="tabpanel" aria-labelledby="parameter-tab">
                                        <div class="content">
                                            {!! str_replace('../../../images/product', Config::get('app.PATH_ADMIN').'images/product', $product->parameter) !!}
                                        </div>
                                        <div class="read-more-btn more">Xem thêm <i class="fa-solid fa-caret-down"></i></div>
                                        <div class="read-more-btn hide">Ẩn bớt nội dung <i class="fa-solid fa-caret-up"></i></div>
                                    </div>
                                    <div class="tab-pane position-relative fade show active" id="content" role="tabpanel" aria-labelledby="content-tab">
                                        <div class="content">
                                            {!! str_replace('../../../images/product', Config::get('app.PATH_ADMIN').'images/product', $product->content) !!}
                                        </div>
                                        <div class="read-more-btn more">Xem thêm <i class="fa-solid fa-caret-down"></i></div>
                                        <div class="read-more-btn hide">Ẩn bớt nội dung <i class="fa-solid fa-caret-up"></i></div>
                                    </div>
                                    <div class="tab-pane position-relative fade" id="promotion" role="tabpanel" aria-labelledby="promotion-tab">
                                        <div class="content">
                                            {{ $product->promotion }}
                                        </div>
                                        <div class="read-more-btn more">Xem thêm <i class="fa-solid fa-caret-down"></i></div>
                                        <div class="read-more-btn hide">Ẩn bớt nội dung <i class="fa-solid fa-caret-up"></i></div>
                                    </div>
                                    <div class="tab-pane position-relative fade" id="use" role="tabpanel" aria-labelledby="use-tab">
                                        <div class="content">
                                            {!! str_replace('../../../images/product', Config::get('app.PATH_ADMIN').'images/product', $product->product_manual) !!}
                                        </div>
                                        <div class="read-more-btn more">Xem thêm <i class="fa-solid fa-caret-down"></i></div>
                                        <div class="read-more-btn hide">Ẩn bớt nội dung <i class="fa-solid fa-caret-up"></i></div>
                                    </div>
                                    <div class="tab-pane position-relative fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                                        <div class="content">
                                            @if(Auth::check())
                                                <form action="{{ route('product.review.store', ['product_id' => $product->id]) }}" class="border" style="padding: 12px" method="POST" enctype="multipart/form-data">
                                                    <div class="star margin-bottom-10" id="starRating">
                                                        <ul class="d-flex">
                                                            <li><i class="fa-solid fa-star" data-index="1"></i></li>
                                                            <li><i class="fa-solid fa-star" data-index="2"></i></li>
                                                            <li><i class="fa-solid fa-star" data-index="3"></i></li>
                                                            <li><i class="fa-solid fa-star" data-index="4"></i></li>
                                                            <li><i class="fa-solid fa-star" data-index="5"></i></li>
                                                        </ul>
                                                        <input type="hidden" name="star" value="5">
                                                    </div>
                                                    <div class="up-image d-flex">
                                                        <div class="list-preview d-flex align-items-center">
                                                        </div>
                                                        <label class="up-image-file" for="actual-btn"><i class="fa-regular fa-image"></i></label>
                                                        <input type="file" id="actual-btn" name="images[]" multiple hidden>
                                                    </div>
                                                    <div class="content">
                                                        <textarea class="w-100" name="content" cols="30" rows="4" required></textarea>
                                                    </div>
                                                    <div class="d-flex justify-content-end">
                                                        <input name="_token" type="hidden" value="{{csrf_token()}}"/>
                                                        <button type="submit" class="btn header-background-text-color">Gửi đánh giá</button>
                                                    </div>
                                                </form>
                                            @else
                                                <div class="text-center">Bạn hãy <span class="btn-dang-nhap btn-dang-nhap-user ">Đăng nhập</span> để đánh giá sản phẩm này.</div>
                                            @endif
                                            <div class="list-review">
                                                @if($product->productReviews->count() > 0)
                                                    @foreach($product->productReviews as $productReview)
                                                        <div class="review d-flex margin-top-20">
                                                            <div class="avatar">
                                                                @if(empty($productReview->user->avatar))
                                                                    <i class="fa-regular fa-user"></i>
                                                                @else
                                                                    <img class="image" src="{{ $productReview->user->avatar }}" alt="{{ $productReview->user->name }}">
                                                                @endif
                                                            </div>
                                                            <div class="review-content">
                                                                <div class="mane margin-bottom-10">
                                                                    {{ $productReview->user->name }}
                                                                </div>
                                                                <div class="star">
                                                                    <ul class="d-flex">
                                                                        @for($i = 1; $i <= 5; $i++)
                                                                            @if($i <= $productReview->star)
                                                                                <li><i class="fa-solid fa-star" data-index="{{ $i }}"></i></li>
                                                                            @else
                                                                                <li><i class="fa-regular fa-star" data-index="{{ $i }}"></i></li>
                                                                            @endif
                                                                        @endfor
                                                                    </ul>
                                                                </div>
                                                                <div class="review-image margin-top-10">
                                                                    @if(json_decode($productReview->images))
                                                                        @foreach(json_decode($productReview->images) as $image)
                                                                            <img class="image" src="{{ $image }}" alt="{{ $product->name }}">
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                                <div class="content">
                                                                    {{ $productReview->content }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                        <div class="read-more-btn more">Xem thêm <i class="fa-solid fa-caret-down"></i></div>
                                        <div class="read-more-btn hide">Ẩn bớt nội dung <i class="fa-solid fa-caret-up"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="background-content">
                    <div class="container">
                        <div class="row infomation">
                            <div class="col-md-12 p-0">
                                <div class="comment" id="comment">
                                    <h2>Bình luận</h2>

                                    <div class="cmt_list_box">
                                        <ul>
                                            @php($comments = \App\Modules\Comment\Models\Comment::whereNull('parent')->where('status', '=', 1)->where('product_id', '=', $product->id)->orderBy('created_at', 'ASC')->paginate(10))

                                            @if(!empty($comments))
                                                @foreach($comments as $cmt)
                                                    <li>
                                                        <div class="cmt_box">
                                                            @php
                                                                $arr = explode(" ", $cmt->name);
                                                                 if(count($arr) >= 3){
                                                                    $a = substr($arr[0], 0, 1);
                                                                    $b = substr($arr[2], 0, 1);
                                                                    $name = $a.$b;
                                                                }elseif(count($arr) >= 2){
                                                                    $a = substr($arr[0], 0, 1);
                                                                    $b = substr($arr[1], 0, 1);
                                                                    $name = $a.$b;
                                                                }else{
                                                                    $name = substr($arr[0], 0, 1);
                                                                }
                                                            @endphp

                                                            <span class="avatar">{{$name}}</span>
                                                            <strong>{{$cmt->name}}</strong>
                                                            <div class="cmt_box_content">
                                                                <p>{{$cmt->content}}</p>
                                                            </div>
                                                            <div class="cmt_tool">
                                                                                    <span>
                                                                                        <a href="javascript:void(0)"
                                                                                           class="cmt_reply"
                                                                                           data-name="{{$cmt->name}}"
                                                                                           data-id="{{$cmt->id}}"
                                                                                           data-parent="">Trả lời</a>
                                                                                    </span>
                                                                <span> • </span>
                                                                <a href="javascript:void(0)" class="cmtlike"
                                                                   data-click="0" data-id="{{$cmt->id}}" title="Thích">
                                                                    <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                                                    <span class="cmt_count">{{!empty($cmt->like) ? $cmt->like : 0}}</span>
                                                                    thích
                                                                </a>
                                                            </div>
                                                        </div>

                                                        @php($comments_child = \App\Modules\Comment\Models\Comment::where('parent', '=', $cmt->id)->where('status', '=', 1)->where('product_id', '=', $product->id)->orderBy('created_at', 'ASC')->paginate(10))
                                                        @if(!empty($comments_child))
                                                            <ul class="child">
                                                                @foreach($comments_child as $child)
                                                                    <li>
                                                                        <div class="cmt_box">
                                                                            @php
                                                                                $arr_child = explode(" ", $child->name);
                                                                                if(count($arr_child) >= 3){
                                                                                    $a = substr($arr_child[0], 0, 1);
                                                                                    $b = substr($arr_child[2], 0, 1);
                                                                                    $name_child = $a.$b;
                                                                                }elseif(count($arr_child) >= 2){
                                                                                    $a = substr($arr_child[0], 0, 1);
                                                                                    $b = substr($arr_child[1], 0, 1);
                                                                                    $name_child = $a.$b;
                                                                                }else{
                                                                                    $name_child = substr($arr_child[0], 0, 1);
                                                                                }
                                                                            @endphp
                                                                            <span class="avatar">{{$name_child}}</span>
                                                                            <strong>{{$child->name}}</strong>
                                                                            <div class="cmt_box_content">
                                                                                <p>{{$child->content}}</p>
                                                                            </div>
                                                                            <div class="cmt_tool">
                                                                                <a href="javascript:void(0)"
                                                                                   class="cmtlike" data-click="0"
                                                                                   data-id="" title="Thích">
                                                                                    <i class="fa fa-thumbs-up"
                                                                                       aria-hidden="true"></i>
                                                                                    <span class="cmt_count">{{!empty($child->like) ? $child->like : 0}}</span>
                                                                                    thích
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif

                                                        <form method="POST" action="{{route('comment.product.child')}}"
                                                              accept-charset="UTF-8" id="cmt_reply"
                                                              enctype="multipart/form-data">
                                                            <input name="_token" type="hidden"
                                                                   value="{{csrf_token()}}"/>
                                                            <div class="cmt_input">
                                                                <textarea placeholder="" name="content"
                                                                          id="cmt_replycontent" required></textarea>
                                                            </div>
                                                            <div class="cmt_form_bottom">
                                                                <div class="cmt_radio">
                                                                    <label>
                                                                        <input name="gender" type="radio" value="1"
                                                                               checked=""/>
                                                                        <span>Anh</span>
                                                                    </label>
                                                                    <label>
                                                                        <input name="gender" type="radio" value="2"/>
                                                                        <span>Chị</span>
                                                                    </label>
                                                                </div>
                                                                <div class="cmt_input">
                                                                    <input name="author" type="text" value=""
                                                                           placeholder="Họ tên (bắt buộc)" required/>
                                                                </div>
                                                                <div class="cmt_input">
                                                                    <input name="phone" type="text" value=""
                                                                           aria-required="false"
                                                                           placeholder="SĐT (tùy chọn)"/>
                                                                </div>
                                                                <div class="cmt_input">
                                                                    <input name="email" type="text" value=""
                                                                           placeholder="Email (tùy chọn)"/>
                                                                </div>
                                                                <div class="cmt_submit">
                                                                    <button type="submit" id="cmt_replysubmit">Gửi
                                                                    </button>
                                                                    <input type="hidden" value="{{$product->id}}"
                                                                           name="product_id"/>
                                                                    <input type="hidden" value="" name="parent_id"
                                                                           class="parent_id"/>
                                                                    <input type="hidden"
                                                                           value="{{ $product->generateURL() }}"
                                                                           name="product_slug"/>
                                                                </div>
                                                            </div>
                                                            <a href="javascript:void(0)" class="cancel_cmt">×</a>
                                                        </form>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>

                                    <p style="color:green;">{{ !empty(session('comment')) ? session('comment') : '' }}</p>

                                    <form method="POST" action="{{route('comment.product')}}" accept-charset="UTF-8"
                                          enctype="multipart/form-data">
                                        <input name="_token" type="hidden" value="{{csrf_token()}}">
                                        <div class="cmt_input">
                                            <textarea
                                                    placeholder="Mời bạn tham gia thảo luận, vui lòng nhập tiếng Việt có dấu."
                                                    name="content_comment" required></textarea>
                                        </div>
                                        <div class="cmt_form_bottom ">
                                            <div class="cmt_radio">
                                                <label>
                                                    <input name="gender" type="radio" value="0" checked="">
                                                    <span>Anh</span>
                                                </label>
                                                <label>
                                                    <input name="gender" type="radio" value="1">
                                                    <span>Chị</span>
                                                </label>
                                            </div>
                                            <div class="cmt_input">
                                                <input name="author" type="text" value=""
                                                       placeholder="Họ tên (bắt buộc)" required/>
                                            </div>
                                            <div class="cmt_input">
                                                <input name="phone" type="text" value="" aria-required="false"
                                                       placeholder="SĐT (tùy chọn)"/>
                                            </div>
                                            <div class="cmt_input">
                                                <input name="email" type="text" value=""
                                                       placeholder="Email (tùy chọn)"/>
                                            </div>
                                            <div class="cmt_submit">
                                                <button type="submit" id="cmt_submit">Gửi</button>
                                                <input type="hidden" value="{{$product->id}}" name="product_id"/>
                                                <input type="hidden" value="{{ $product->generateURL() }}"
                                                       name="product_slug"/>
                                                <input type="hidden" value="" name="parent_id"/>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="background-content p-b-0">
                    <div class="content-item">
                        <h5 class="title-sidebar">SẢN PHẨM MỚI</h5>
                        <div class="row product_list">
                            @foreach($products_new as $product_new)
                                <div class="col-md-3 col-6 col-sm-6 product is-sale ">
                                    <div class="inner">
                                        @php($regular = !empty($product_new->price_regular) ? $product_new->price_regular : 0)
                                        @php($sale = !empty($product_new->price_sale) ? $product_new->price_sale : 0)
                                        @if(!empty($product_new->price_regular) && !empty($product_new->price_sale))
                                            <span class="product-tag">-{{ceil((($regular - $sale) / $regular)*100)}}%</span>
                                        @endif
                                        <a href="{{ $product_new->generateURL($menu) }}" class="product-thumbnail">
                                            <img loading="lazy" width="255" height="330"
                                                 src="{{Config::get('app.PATH_ADMIN').$product_new->image}}"
                                                 alt="{{$product_new->name}}">
                                        </a>
                                        <div class="inner-prod">
                                            <h3 class="product-title">
                                                <a href="{{ $product_new->generateURL($menu) }}"> {{$product_new->name}} </a>
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
                                                @if(!empty($product_new->price_regular) && !empty($product_new->price_sale))
                                                    <span class="product-price product-normal-price"> {{number_format($product_new->price_regular,0 ,'.','.')}} <sup>đ</sup> </span>
                                                    <span class="product-price product-sale-price ">  {{number_format($product_new->price_sale,0 ,'.','.')}} <sup>đ</sup>  </span>
                                                @elseif(!empty($product_new->price_regular) && empty($product_new->price_sale))
                                                    <span class="product-price product-sale-price ">  {{number_format($product_new->price_regular,0 ,'.','.')}} <sup>đ</sup>  </span>
                                                @else
                                                    <span class="product-price product-sale-price ">Liên hệ</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3 sidebar d-none d-lg-block">
                @if(!empty($commitment))
                <div class="row">
                    <div class=" col-12 commitment-list">
                        <div class="commitment-content">
                            @foreach($commitment as $commit)
                                <div class="col-12 commitment">
                                    <a class="item_frame_background d-flex justify-content-center align-items-center"
                                       href="{{ url($commit->slug) }}">
                                        <div class="col-3"><img class="image"
                                                                src="{{ config('app.PATH_ADMIN') . $commit->image }}"
                                                                alt="{{ $commit->name }}"></div>
                                        <div class="col-9 text-center">
                                            <h5 class="title">{{ $commit->name }}</h5>
                                            <i class="description">{{ $commit->description }}</i>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
                <div class="background-sidebar">
                    <div class="col-12">
                        <h5 class="title-sidebar">SẢN PHẨM BÁN CHẠY</h5>
                        <div class="product_list_sidebar">
                            @foreach($products_related as $product_related)
                                <a href="{{ $product_related->generateURL() }}" class="d-flex align-items-center product">
                                    <div class="col-4">
                                        <img class="image"
                                             src="{{ config('app.PATH_ADMIN') . $product_related->image }}"
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
                                                            <img loading="lazy" class="image"
                                                                 src="{{ config('app.PATH_ADMIN') . $brand->logo }}"
                                                                 alt="{{ $brand->name }}">
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
    </div>
    @if(!empty($contact))
        <div class="blog_list contact margin-bottom-10"
             style="background-color: {{ $contact->background_color }}; background-image: url('{{ !empty(json_decode($contact->images)->{"pc"}[0]->{'url'}) ? Config::get('app.PATH_ADMIN') . json_decode($contact->images)->{"pc"}[0]->{'url'} : '' }}')">
            <div class="container">
                <div class="title_section"
                     style="color: {{ $contact->title_color }} !important; text-align: {{ $contact->title_position }}">{!! $contact->title !!}</div>
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
                                    <form id="form-contact" action="{{ route('home.page.contact.post') }}"
                                          method="post" class="contact-form">
                                        <div class="row">
                                            <div class="contact-error text-center"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control input-style-2" id="name"
                                                           name="name" placeholder="Họ tên *">
                                                    <span class="alert alert-error"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control input-style-2" id="phone"
                                                           name="phone" placeholder="Số điện thoại *">
                                                    <span class="alert alert-error"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="email" class="form-control input-style-2"
                                                           id="email" name="email" placeholder="Email">
                                                    <span class="alert alert-error"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control input-style-2" id="web"
                                                           name="link" placeholder="Địa chỉ">
                                                    <span class="alert alert-error"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                    <textarea class="form-control input-style-2" id="comment"
                                                              name="content" placeholder="Nội dung" cols="30"
                                                              rows="5"></textarea>
                                                <div class="contact-sub-btn text-center margin-top-20">
                                                    <button type="button" name="submit"
                                                            class="btn header-background-text-color btn-submit">
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
    <div class="modal fade" id="consultModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Yêu cầu tư vấn</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 col-sm-6 margin-bottom-20">
                                <img loading="lazy" width="100%"
                                     src="{{ Config::get('app.PATH_ADMIN').$product->image }}"
                                     alt="{{ $product->name }}"/>
                                <h6 class="margin-top-20">{{ $product->name }}</h6>
                            </div>
                            <div class="col-12 col-sm-6">
                                <form id="form-contact-modal" action="{{ route('home.page.contact.post') }}" method="post"
                                      class="contact-form">
                                    <div class="row">
                                        <div class="contact-error text-center"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <input type="text" class="form-control input-style-2" id="name"
                                                       name="name"
                                                       value="{{ !empty(auth()->user()->name) ? auth()->user()->name : '' }}"
                                                       placeholder="Tên của bạn">
                                                <span class="alert alert-error"></span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <input type="text" class="form-control input-style-2" id="phone"
                                                       name="phone"
                                                       value="{{ !empty(auth()->user()->phone) ? auth()->user()->phone : '' }}"
                                                       placeholder="Số điện thoại *">
                                                <span class="alert alert-error"></span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <input type="email" class="form-control input-style-2" id="email"
                                                       name="email"
                                                       value="{{ !empty(auth()->user()->email) ? auth()->user()->email : '' }}"
                                                       placeholder="Email">
                                                <span class="alert alert-error"></span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <input type="text" class="form-control input-style-2" id="subject"
                                                       name="subject" value="{{ $product->name }}"
                                                       placeholder="Subject *">
                                                <span class="alert alert-error"></span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <textarea class="form-control input-style-2" id="comment" name="content"
                                                      placeholder="Nội dung" cols="30" rows="5"></textarea>
                                            <div class="contact-sub-btn margin-top-20">
                                                <input type="hidden" class="form-control input-style-2" id="web"
                                                       name="link" value="{{ url($_SERVER['REQUEST_URI']) }}"
                                                       placeholder="Website trang này">
                                                <button type="button" id="btn-consult"
                                                        class="btn header-background-text-color">
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
    <div class="modal fade" id="consultModalSuccess" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex">
                        <div class="text-center">
                            <p>Bạn đã gửi yêu cầu thành công, chúng tôi sẽ liên hệ lại sớm nhất.</p>
                            <p>Cảm ơn quý khách!</p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                style="margin-left: 10px"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('public/css/product/base.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('public/css/product/detail.css') }}" type="text/css">
@endsection

@section('scripts')
    <script src="{{ asset('public/js/product_detail.js') }}"></script>
    <script src="{{ asset('public/js/contact.js') }}"></script>
@endsection
