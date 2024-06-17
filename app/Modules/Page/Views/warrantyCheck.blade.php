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
                                <li class="breadcrumb-item active" aria-current="page">Kiểm tra bảo hành</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="content_page mb-5">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-8">
                            <h1 class="text-center">KIỂM TRA BẢO HÀNH</h1>
                            <p class="text-center">Quý khách hàng vui lòng nhập <strong>số điện thoại</strong> vào khung bên dưới để kiểm tra thông tin bảo hành.</p>
                            <form id="form-contact" action="{{ route('admin.page.warrantyCheck') }}" method="get" class="contact-form">
                                <div class="row">
                                    <div class="contact-error text-center"></div>
                                </div>
                                <div class="row justify-content-evenly align-items-center">
                                    <div class="col-md-8">
                                        <div class="input-group input-group-lg align-items-center">
                                            <span class="d-none d-lg-flex me-3">NHẬP SỐ ĐIỆN THOẠI:</span>
                                            <input type="text" name="phone" class="form-control" value="{{ request('phone') }}">
                                            <input type="hidden" name="search" value="true" class="form-control" >
                                            <button class="btn header-background-text-color" type="submit" id="button-addon2" >Kiểm tra</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            @if(!empty($warranties))
                                @foreach($warranties as $warranty)
                                    <div class="row justify-content-center">
                                        <div class="col-lg-9">
                                            <div class="mt-3 header-background-text-color" style="font-family: 'Montserrat', sans-serif !important; border-radius: 4px; padding: 20px;">
                                                <h2 class="text-center">THÔNG TIN BẢO HÀNH</h2>
                                                <p><b>Khách hàng:</b> {{ $warranty->payer_name }}</p>
                                                <p><b>Ðiện thoại:</b> {{ $warranty->payer_phone }}</p>
                                                <hr>
                                                <p><b>Biển số xe:</b> {{ $warranty->car_plate }}</p>
                                                <p><b>Dòng sản phẩm:</b> {{ !empty(\App\Modules\Page\Models\Warranty::ArrayHeatproof[$warranty->item_type]) ? \App\Modules\Page\Models\Warranty::ArrayHeatproof[$warranty->item_type] : '' }}</p>
                                                @if($warranty->warrantyItems->count() > 0)
                                                    <ul>
                                                        @foreach($warranty->warrantyItems as $warrantyItem)
                                                            <li>{{ $warrantyItem->product_name }}</li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                                <p><b>Đại lý thi công:</b> {{ $warranty->construction_agent }}</p>
                                                <p><b>Người thi công:</b> {{ $warranty->construction_person }}</p>
                                                <p><b>Ngày bắt đầu bảo hành:</b> {{date('d/m/Y', strtotime($warranty->start_warranty))}}</p>
                                                <p><b>Ngày kết thúc bảo hành:</b> {{date('d/m/Y', strtotime($warranty->end_warranty))}}</p>
                                                <p><b>Ngày còn lại:</b>
                                                    @php
                                                        $endWarranty = strtotime($warranty->end_warranty) + (60 * 60 * 24);
                                                        $currentTime = time();
                                                        $remainingSeconds = $endWarranty - $currentTime;
                                                        $remainingDays = ceil($remainingSeconds / (60 * 60 * 24));
                                                        if ($remainingDays <= 0) {
                                                            echo '<span class="text-danger">Đã hết hạn bảo hành</span>';
                                                        } else {
                                                            echo $remainingDays . ' ngày';
                                                        }
                                                    @endphp
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            @if(!empty($error))
                                <div class="alert alert-danger mt-3" role="alert">
                                    {{ $error }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @if(!empty($page))
                <div class="content_page">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                {!! str_replace('images/blog', Config::get('app.PATH_ADMIN').'images/blog', $page->content) !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection