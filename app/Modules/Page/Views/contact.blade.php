@php($setting = \App\Modules\Footer\Models\Footer::find(1))
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

            <div class="content_page margin-bottom-40">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-10 margin-bottom-20">
                            <div class="content margin-bottom-20">
                                <div class="row">
                                    <div class="col-12 col-xl-6 contact-content">
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
                        <div class="col-12">
                            <div class="map">
                                {!! \App\Modules\Footer\Models\Footer::find(1)->map !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .map iframe{
            width: 100%;
        }
        .contact-form {
            padding: 20px;
            border-radius: 4px;
            box-shadow: 0px 0px 22px 6px rgba(0, 0, 0, 0.3)
        }
        .contact-content .icon {
            width: 70px;
            height: 70px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            border: 4px solid {{ $setting->header_background_color }};
            border-radius: 50%;
            color: {{ $setting->header_background_color }};
        }
        .contact-content .phone-content, .contact-content .email-content, .contact-content .address-content {
            flex: 1;
            margin-left: 20px;
        }
        .content_page p {
            margin-bottom: 6px;
        }
        #btn-submit {
            font-size: 1rem;
            transition: font-size 0.3s ease;
        }

        #btn-submit:hover {
            font-size: 1.1rem;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('public/js/contact.js') }}"></script>
@endsection