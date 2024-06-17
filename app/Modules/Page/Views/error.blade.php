@extends('Home::Layout.master')

@section('main')
    <div class="container">
        <div class="row">
            <div class="col-12" style="padding: 40px">
                <h4 style="margin-bottom: 20px">
                    THÔNG BÁO LỖI WEBSITE: BẠN ĐÃ THAO TÁC CHƯA ĐÚNG QUY CHUẨN DẪN ĐẾN LỖI WEBSITE, DƯỚI ĐÂY LÀ 1 SỐ THÔNG BÁO LỖI CODE.
                    <br>
                    Vui lòng chụp màn hình gửi cho chúng tôi để fix lỗi.
                </h4>
                @if(isset($exception))
                    <div class="error" style="background-color: #ffffff">
                        <p>Error Message: {{ $exception->getMessage() }}</p>
                        <p>Error File: {{ $exception->getFile() }}</p>
                        <p>Error Line: {{ $exception->getLine() }}</p>
{{--                        <pre>Error Trace: {{ $exception->getTraceAsString() }}</pre>--}}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection