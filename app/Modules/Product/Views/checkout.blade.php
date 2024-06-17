@extends('Home::Layout.master')

@section('main')
    <div class="page_checkout">
        <div class="container">
            @if(session()->has('error'))
                <div class="alert alert-danger" style="margin: 0 20px;margin-top: 30px;">
                    {{ session()->get('error') }}
                </div>
            @endif

            @if(session()->has('success'))
                <div class="alert alert-success" style="margin: 0 20px;margin-top: 30px;">
                    {{ session()->get('success') }}
                </div>
            @endif
            
            @if(!isset($_GET['order']))
            <form action="{{route('product.checkout.post')}}" method="post">
                <input type="hidden" name="_token" value="{{csrf_token()}}"/>

                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="single-post-title mt-3">Thanh toán</h1>
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Thông tin thanh toán</h3>

                            <div class="input_list">
                                <div class="input">
                                    <label>Họ và tên (*)</label>
                                    <input type="text" name="fullname" class="form-control" required/>
                                </div>
                                <div class="input">
                                    <label>Số điện thoại (*)</label>
                                    <input type="tel" name="phone" class="form-control" required/>
                                </div>
                                <div class="input">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control"/>
                                </div>
                                <div class="input">
                                    <label>Địa chỉ giao hàng (*)</label>
                                    <input type="text" name="address" class="form-control" required/>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h3>Thông tin bổ sung</h3>

                            <div class="input">
                                <label>Ghi chú đơn hàng</label>
                                <textarea name="note" cols="30" rows="10" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h3>ĐƠN HÀNG CỦA BẠN</h3>

                            @php($total = 0)
                            @if(!empty(session('mini_cart')))
                                <div class="woocommerce">
                                <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th class="product-thumbnail">&nbsp;</th>
                                        <th class="product-name">Sản phẩm</th>
                                        <th class="product-price">Giá</th>
                                        <th class="product-quantity">Số lượng</th>
                                        <th class="product-subtotal">Tổng</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach(session('mini_cart') as $key => $cart)
                                        @php($product = \App\Modules\Product\Models\Product::find($cart['id']))
                                        @php($total += !empty($product->price_sale) ? $product->price_sale * $cart['qty'] : $product->price_regular * $cart['qty'])
                                        <tr class="woocommerce-cart-form__cart-item cart_item">
                                            <td class="product-thumbnail">
                                                <a href="{{$product->link}}">
                                                    <img loading="lazy" width="150" height="150" src="{{Config::get('app.PATH_ADMIN').$product->image}}" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="{{$product->name}}"/>
                                                </a>
                                            </td>
                                            <td class="product-name" data-title="Sản phẩm"><a href="{{$product->link}}"> {{$product->name}} </a><br /></td>
                                            <td class="product-price" data-title="Giá">
                                                <span class="woocommerce-Price-amount amount">
                                                    <bdi>{{ number_format(!empty($product->price_sale) ? $product->price_sale : $product->price_regular, 0, '.', '.') }} <span class="woocommerce-Price-currencySymbol">₫</span> </bdi>
                                                </span>
                                            </td>
                                            <td class="product-quantity" data-title="Số lượng">
                                                <div class="quantity">
                                                    <input type="hidden" name="carts[{{$key}}][id]" value="{{$cart['id']}}"/>
                                                    <input type="number" class="input-number form-control input-text qty text" min="0" name="carts[{{$key}}][qty]" value="{{$cart['qty']}}" inputmode="numeric" disabled/>
                                                </div>
                                            </td>
                                            <td class="product-subtotal" data-title="Tổng phụ">
                                                <span class="woocommerce-Price-amount amount">
                                                    <bdi>{{ number_format(!empty($product->price_sale) ? $product->price_sale * $cart['qty'] : $product->price_regular * $cart['qty'], 0 ,'.', '.') }} <span class="woocommerce-Price-currencySymbol">₫</span> </bdi>
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="7">
                                            <div class="price">
                                                <strong>Tổng</strong>
                                                <strong>
                                                        <span class="woocommerce-Price-amount amount">
                                                            <bdi>{{number_format($total, 0, '.', '.')}} <span class="woocommerce-Price-currencySymbol">₫</span> </bdi>
                                                        </span>
                                                </strong>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                </div>
                            @endif

                            <h3>Hình thức thanh toán</h3>
                            <div class="info_pay">
                                <div class="item">
                                    <div class="input_pay">
                                        <input type="radio" name="type_bank" value="money" checked/>
                                        Thanh toán khi nhận hàng
                                    </div>
                                </div>
                                <br>
                                <div class="item">
                                    <div class="input_pay">
                                        <input type="radio" name="type_bank" value="bank"/>
                                        Chuyển khoản ngân hàng
                                    </div>

                                    <ul>
                                        <li>Thanh toán 100% để nhận quà tặng và ưu đãi tốt nhất</li>
                                        <li>Ghi chính xác SĐT hoặc nội dung sản phẩm cần đặt</li>
                                        <li>Đơn hàng sẽ được xác nhận về thời gian và vận chuyển tới tận nơi.</li>
                                        <li>Dữ liệu cá nhân của khách hàng chỉ sử dụng trong quá trình xử lý đơn hàng và được bảo mật</li>
                                    </ul>
                                </div>

                                <div class="item">
                                    {!! $bankAccountInfo !!}
                                </div>
                            </div>

                            <div class="btn">
                                <button type="submit">Đặt hàng</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @else
                <div class="success_checkout">
                    <div class="container">
                        <i class="fa fa-check-circle" aria-hidden="true"></i>
                        <h2>Đơn hàng <strong>#{{$_GET['order']}}</strong> được đặt thành công!</h2>
                        <p>Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .p-code-item{
            position: relative;
        }
        .listCode{
            position: absolute; 
            display: none;
            background-color: #8a8a8a;
            width: 100%;
            z-index: 99999;
            color: #fff;
        }
        .listCode li{
            padding: 3px 8px; cursor: pointer;
        }
        .listCode li:hover{
            background-color: #ccc;
        }
        .div_qrcode_pay{
            width: 100%; margin-top: 10px; padding: 10px 10px; background-color: #ccc; color: #000;
        }
        .div_qrcode_pay .text-ngan-hang{
            font-size: 30px; line-height: 1.5;
        }
        .div_qrcode_pay .img-logo-vietcombank{
            width: 100%; max-width: 400px;
        }
        .div_qrcode_pay .img-QR-TKHN{
            width: 100%;
        }
    </style>
@endsection

@section('scripts')
    <script>
        function nhapMaGioiThieu(e){
            let parent_e = $(e).parent();
            $.ajax({
                type: "POST", url: "{{url('/gio-hang/nhap-ma-gioi-thieu')}}",
                data: {
                    search: $(e).val(),
                    _token: '{{csrf_token()}}'
                },
                success: function(result){
                    parent_e.find('.listCode').html(result);
                    parent_e.find('.listCode').show();
                }
            });
        }
        function chonMaGioiThieu(e, ma_gioi_thieu){
            let parent_e = $(e).parent().parent();
            parent_e.find('.ma-gioi-thieu').val(ma_gioi_thieu);
            parent_e.find('.listCode').hide();
        }
    </script>
@endsection