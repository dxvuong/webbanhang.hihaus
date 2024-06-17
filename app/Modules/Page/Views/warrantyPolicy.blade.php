@extends('Home::Layout.master')

@section('main')
    <div class="single_product page">
        <div class="container">
            @if(!empty($page))
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
                        <div class="row">
                            <div class="col-md-12">
                                {!! str_replace('images/blog', Config::get('app.PATH_ADMIN').'images/blog', $page->content) !!}
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row justify-content-center">
                    <h2>Chưa có chính sách bảo hành</h2>
                </div>
            @endif
        </div>
    </div>
@endsection