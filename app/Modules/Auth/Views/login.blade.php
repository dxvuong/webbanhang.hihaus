@extends('Home::Layout.master')

@section('main')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="div-signup sections">
                    <div class="head_title text-center">
                        <h2>ĐĂNG NHẬP</h2>
                        <div class="subtitle">
                            Chào mừng bạn! Hãy đăng nhập ngay để hưởng những ưu đãi đặc biệt chỉ dành riêng cho thành viên
                        </div>
                    </div>
                    <br>
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-6">
                            <div class="login-error text-center"></div>
                            <form id="form-login" class="form-horizontal" method="POST" action="{{ route('user.login.post') }}">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="account" class="control-label">Tên đăng nhập</label>
                                    <input id="account" type="text" class="form-control" name="account" value="{{ old('account') }}" required autofocus>
                                </div>

                                <div class="form-group">
                                    <label for="password" class="control-label">Mật khẩu</label>
                                    <input id="password" type="password" class="form-control" name="password" required>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Ghi nhớ tài khoản
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group text-center">
                                    <div>
                                        <button type="button" class="btn btn-primary" id="btn-login">
                                            Đăng nhập
                                        </button>
                                        <br>
                                        <p class="margin-top-20">
                                            Bạn chưa có tài khoản, <a class="btn btn-link" href="{{ route('user.register') }}" style="padding: 0">BẤM ĐÂY</a> để đăng ký mới
                                        </p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('styles')
    <style>
        .controls select.input-sm{
            height: 37px;
        }
        .controls .form-control[readonly]{
            background-color: #f7f7f7 !important;
        }
    </style>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $("#btn-login").click(function(){
                var formStatus = $("#form-login").validate({
                    rules: {
                        account: "required",
                        password: "required",
                    },
                    messages:{
                        account: "Nhập tên đăng nhập.",
                        password: "Nhập mật khẩu.",
                    },
                    onfocusout: false,
                    invalidHandler: function(form, validator) {
                        var errors = validator.numberOfInvalids();
                        if (errors) {
                            validator.errorList[0].element.focus();
                        }
                    }
                }).form();
                if(true == formStatus){
                    popup_load_on();
                    var form_data = new FormData($("#form-login")[0]);
                    $.ajax({
                        url: "{{ route('user.login.post') }}",
                        data: form_data,
                        type: 'POST',
                        contentType: false,
                        processData: false,
                        success: function (result) {
                            //console.log(result);
                            popup_load_off();
                            if(result.status == 'true'){
                                $('.login-error').html(`<p>${result.message}</p>`)
                                var previousPage = document.referrer;
                                if (previousPage) {
                                    window.location.href = previousPage;
                                } else {
                                    window.location.href = "{{ route('user.auth.detail') }}";
                                }
                            }else{
                                $('.login-error').html(`<p style="color: red">${result.message}</p>`)
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
