@extends('Home::Layout.master')

@section('main')
    <div class="single_blog">
        <div class="container">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active"><a href="{{url('/')}}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $commitment->name }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-md-9">
                        <section class="details">
                            <h1>{{$commitment->name}}</h1>

                            <div class="content">
                                <p><strong><i>{{$commitment->description}}</i></strong></p>
                                @php
                                    $content = $commitment->content;
                                    $content = str_replace('images/commitment', Config::get('app.PATH_ADMIN').'images/commitment', $content);
                                    $content = str_replace('../../../images/commitment', Config::get('app.PATH_ADMIN').'images/commitment', $content);
                                    $content = str_replace('../../images/commitment', Config::get('app.PATH_ADMIN').'images/commitment', $content);
                                    $content = str_replace('../../../images/event', Config::get('app.PATH_ADMIN').'images/event', $content);
                                    $content = str_replace('../../images/event', Config::get('app.PATH_ADMIN').'images/event', $content);
                                    echo $content;
                                @endphp
                            </div>

                            <div class="meta meta2">
                                <div class="author"></div>

                                <ul class="social-share">
                                    <li class="">
                                        <a aria-label="Facebook" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ url($commitment->slug) }}" class="facebook" rel="nofollow noopener noreferrer">
                                            <i class="fa-brands fa-facebook-f"></i>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a aria-label="Twitter" target="_blank" href="https://twitter.com/intent/tweet?status='{{ url($commitment->slug) }}" class="twitter" rel="nofollow noopener noreferrer">
                                            <i class="fa-brands fa-twitter"></i>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a aria-label="Pinterest" target="_blank" href="https://pinterest.com/pin/create/button?url={{ url($commitment->slug) }}" class="pinterest" rel="nofollow noopener noreferrer">
                                            <i class="fa-brands fa-pinterest-p"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="comment" id="comment">
                                <h2>Bình luận</h2>

                                <div class="cmt_list_box">
                                    <ul>
                                        @php($comments = \App\Modules\Comment\Models\Comment::whereNull('parent')->where('status', '=', 1)->where('blog_id', '=', $commitment->id)->orderBy('created_at', 'ASC')->paginate(10))

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
                                                            <a href="javascript:void(0)" class="cmt_reply" data-name="{{$cmt->name}}" data-id="{{$cmt->id}}" data-parent="">Trả lời</a>
                                                        </span>
                                                            <span> • </span>
                                                            <a href="javascript:void(0)" class="cmtlike" data-click="0" data-id="{{$cmt->id}}" title="Thích">
                                                                <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                                                <span class="cmt_count">{{!empty($cmt->like) ? $cmt->like : 0}}</span> thích
                                                            </a>
                                                        </div>
                                                    </div>

                                                    @php($comments_child = \App\Modules\Comment\Models\Comment::where('parent', '=', $cmt->id)->where('status', '=', 1)->where('blog_id', '=', $commitment->id)->orderBy('created_at', 'ASC')->paginate(10))
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
                                                                            <a href="javascript:void(0)" class="cmtlike" data-click="0" data-id="" title="Thích">
                                                                                <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                                                                <span class="cmt_count">{{!empty($child->like) ? $child->like : 0}}</span> thích
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif

                                                    <form method="POST" action="{{route('comment.blog.child')}}" accept-charset="UTF-8" id="cmt_reply" enctype="multipart/form-data">
                                                        <input name="_token" type="hidden" value="{{csrf_token()}}"/>
                                                        <div class="cmt_input">
                                                            <textarea placeholder="" name="content" id="cmt_replycontent" required></textarea>
                                                        </div>
                                                        <div class="cmt_form_bottom">
                                                            <div class="cmt_radio">
                                                                <label>
                                                                    <input name="gender" type="radio" value="1" checked=""/>
                                                                    <span>Anh</span>
                                                                </label>
                                                                <label>
                                                                    <input name="gender" type="radio" value="2"/>
                                                                    <span>Chị</span>
                                                                </label>
                                                            </div>
                                                            <div class="cmt_input">
                                                                <input name="author" type="text" value="" placeholder="Họ tên (bắt buộc)" required/>
                                                            </div>
                                                            <div class="cmt_input">
                                                                <input name="phone" type="text" value="" aria-required="false" placeholder="SĐT (tùy chọn)"/>
                                                            </div>
                                                            <div class="cmt_input">
                                                                <input name="email" type="text" value="" placeholder="Email (tùy chọn)"/>
                                                            </div>
                                                            <div class="cmt_submit">
                                                                <button type="submit" id="cmt_replysubmit">Gửi</button>
                                                                <input type="hidden" value="{{$commitment->id}}" name="product_id" />
                                                                <input type="hidden" value="" name="parent_id" class="parent_id"/>
                                                                <input type="hidden" value="{{ url($commitment->slug) }}" name="product_slug" />
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

                                <form method="POST" action="{{route('comment.blog')}}" accept-charset="UTF-8" enctype="multipart/form-data">
                                    <input name="_token" type="hidden" value="{{csrf_token()}}">
                                    <div class="cmt_input">
                                        <textarea placeholder="Mời bạn tham gia thảo luận, vui lòng nhập tiếng Việt có dấu." name="content_comment" required></textarea>
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
                                            <input name="author" type="text" value="" placeholder="Họ tên (bắt buộc)" required/>
                                        </div>
                                        <div class="cmt_input">
                                            <input name="phone" type="text" value="" aria-required="false" placeholder="SĐT (tùy chọn)"/>
                                        </div>
                                        <div class="cmt_input">
                                            <input name="email" type="text" value="" placeholder="Email (tùy chọn)"/>
                                        </div>
                                        <div class="cmt_submit">
                                            <button type="submit" id="cmt_submit">Gửi</button>
                                            <input type="hidden" value="{{$commitment->id}}" name="product_id" />
                                            <input type="hidden" value="{{ url($commitment->slug) }}" name="product_slug" />
                                            <input type="hidden" value="" name="parent_id" />
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="blog_list blog_re">
                                <h2>BÀI NỔI BẬT</h2>

                                <div class="row">
                                    @if(!empty($blog_relate))
                                        @foreach($blog_relate as $post)
                                            <div class="col-md-3">
                                                <article>
                                                    <a href="{{ $post->generateURL() }}" class="img"><img loading="lazy" src="{{Config::get('app.PATH_ADMIN').$post->image}}" alt="{{$post->name}}" /></a>
                                                    <h2 class="text-start"><a href="#">{{$post->name}}</a></h2>
                                                </article>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </section>
                    </div>

                    <div class="col-md-3 single_product">
                        <sidebar class="sidebar">
                            <div class="meta">
                                <div class="author">
                                    @if(!empty($commitment->author))
                                        <i class="fa fa-user-circle-o" aria-hidden="true"></i> {{\App\Modules\Blog\Models\User::where('user_id', '=', $commitment->author)->first()->user_name}}
                                    @endif
                                </div>

                                <ul class="social-share">
                                    <li class="">
                                        <a aria-label="Facebook" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ url($commitment->slug) }}" class="facebook" rel="nofollow noopener noreferrer">
                                            <i class="fa-brands fa-facebook-f"></i>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a aria-label="Twitter" target="_blank" href="https://twitter.com/intent/tweet?status='{{ url($commitment->slug) }}" class="twitter" rel="nofollow noopener noreferrer">
                                            <i class="fa-brands fa-twitter"></i>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a aria-label="Pinterest" target="_blank" href="https://pinterest.com/pin/create/button?url={{ url($commitment->slug) }}" class="pinterest" rel="nofollow noopener noreferrer">
                                            <i class="fa-brands fa-pinterest-p"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <h3 class="title header-background-text-color">SẢN PHẨM BÁN CHẠY</h3>

                            <div class="products list">
                                @if(!empty($products_related))
                                    @foreach($products_related as $product)
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
                        </sidebar>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script>
        $('.cmt_list_box').on('click', '.cmt_reply', function () {
            let name = $(this).attr('data-name');
            let id = $(this).attr('data-id');
            $(this).parent().parent().parent().parent().find('form').show();
            $(this).parent().parent().parent().parent().find('form').find('#cmt_replycontent').val('@'+name+': ');
            $(this).parent().parent().parent().parent().find('form').find('.parent_id').val(id);
        });

        $('.cmt_list_box').on('click', '.cancel_cmt', function () {
            $(this).parent().hide();
        });
    </script>
@endsection