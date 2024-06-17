@extends('Home::Layout.master')

@section('main')
    <div class="page_cart">
        <div class="container">
            <h1 class="single-post-title mt-3">Giỏ hàng</h1>
            @php($total = 0)
            @if(!empty(session('mini_cart')))
            <div class="entry-content entry">
                <div class="woocommerce">
                    <div class="woocommerce-notices-wrapper"></div>
                    <div class="row">
                        <div class="col-md-9">
                            <form class="woocommerce-cart-form" action="{{route('product.cart.update.post')}}" method="post">
                                <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th class="product-thumbnail">&nbsp;</th>
                                        <th class="product-name">Sản phẩm</th>
                                        <th class="product-price">Giá</th>
                                        <th class="product-quantity">Số lượng</th>
                                        <th class="product-subtotal">Tổng</th>
                                        <th class="product-remove">Xóa</th>
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
                                                        <input type="number" class="input-number form-control input-text qty text" min="0" name="carts[{{$key}}][qty]" value="{{$cart['qty']}}" inputmode="numeric"/>
                                                    </div>
                                                </td>
                                                <td class="product-subtotal" data-title="Tổng phụ">
                                                    <span class="woocommerce-Price-amount amount">
                                                        <bdi>{{ number_format(!empty($product->price_sale) ? $product->price_sale * $cart['qty'] : $product->price_regular * $cart['qty'], 0 ,'.', '.') }} <span class="woocommerce-Price-currencySymbol">₫</span> </bdi>
                                                    </span>
                                                </td>
                                                <td class="product-remove"><a href="{{url('/gio-hang/xoa/'.$key)}}" class="remove" aria-label="Xóa sản phẩm này">×</a></td>
                                            </tr>
                                        @endforeach
                                    <tr>
                                        <td colspan="6" class="actions">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}" />
                                            <button type="submit" class="button" name="update_cart" value="Cập nhật giỏ hàng">Cập nhật giỏ hàng</button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>

                        <div class="col-md-3">
                            <div class="cart-collaterals">
                                <div class="cart_totals">
                                    <h2>Cộng giỏ hàng</h2>

                                    <div class="price">
                                        <strong>Tổng</strong>
                                        <strong>
                                            <span class="woocommerce-Price-amount amount">
                                                <bdi>{{number_format($total, 0, '.', '.')}} <span class="woocommerce-Price-currencySymbol">₫</span> </bdi>
                                            </span>
                                        </strong>
                                    </div>
                                    <div class="wc-proceed-to-checkout"><a href="{{route('product.checkout')}}" class="checkout-button button alt wc-forward"> Tiến hành thanh toán</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <p></p>
            </div>
            @else
                <div class="alert alert-danger" role="alert">
                    Giỏ hàng trống!
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>

    </script>
@endsection