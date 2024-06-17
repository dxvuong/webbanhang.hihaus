@extends('Home::Layout.master')

@section('main')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="div-signup sections">
                    <div class="head_title text-center">
                        <h2>ĐĂNG KÝ TÀI KHOẢN</h2>
                        <div class="subtitle">
                            Chào mừng bạn! Hãy đăng ký tài khoản ngay để hưởng những ưu đãi đặc biệt chỉ dành riêng cho thành viên
                        </div>
                    </div>
                    <form id="form-signup" method="POST" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="single_contant_left padding-bottom-90">
                                    <div class="col-lg-9 col-md-9 col-sm-10 offset-lg-3 offset-md-3 offset-sm-1">
                                        <div class="padding-top-90">
                                            <h4>THÔNG TIN CÁ NHÂN</h4>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="name" placeholder="Họ tên">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <input type="number" class="form-control" name="phone" placeholder="Số điện thoại">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="email" placeholder="Email">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="login_name" placeholder="Tên đăng nhập">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <input type="password" class="form-control" name="password" placeholder="Mật khẩu">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <input type="password" class="form-control" name="password_confirm" placeholder="Nhập lại mật khẩu">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <input type="date" class="form-control" name="birthday" placeholder="Ngày tháng năm sinh">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row display-none">
                                            <div class="col-sm-12">
                                                Ảnh cá nhân
                                                <div class="form-group">
                                                    <input type="file" class="form-control" name="avatar" placeholder="Ảnh cá nhân">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row padding-bottom-90">
                                    <div class="col-lg-9 col-md-9 col-sm-10 offset-lg-1 offset-md-1 offset-sm-1">
                                        <div class="padding-top-90">
                                            <h4>ĐỊA CHỈ, TÀI KHOẢN NGÂN HÀNG</h4>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <lable>
                                                Địa chỉ
                                            </lable>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="address" placeholder="Địa chỉ khách hàng">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <div class="control-group-1">
                                                    <label class="control-label">Tỉnh/Thành</label>
                                                    <div class="controls">
                                                        <select class="form-control input-sm" name="provice_id" id="them_tinh" onchange="selectProvince()">
                                                            <option value="" selected="selected">--Chọn--</option>
                                                            @foreach($allProvince as $item)
                                                                <option value="{{$item['provice_id']}}">{{$item['provice_title']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <div class="control-group-1">
                                                    <label class="control-label">Quận/Huyện</label>
                                                    <div class="controls">
                                                        <select class="form-control input-sm" name="dictrict_id" id="them_huyen" onchange="selectWard()">
                                                            <option value="" selected="selected">--Chọn--</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <div class="control-group-1">
                                                    <label class="control-label">Phường/Xã</label>
                                                    <div class="controls">
                                                        <select class="form-control input-sm" name="ward_id" id="them_xa_phuong">
                                                            <option value="" selected="selected">--Chọn--</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <lable>
                                                Tài khoản ngân hàng
                                            </lable>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="bank_account_number" placeholder="Số tài khoản">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="bank_name" placeholder="Tên ngân hàng">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="bank_account_name" placeholder="Chủ tài khoản">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row display-none">
                                            <div class="col-sm-12">
                                                Ảnh QR ngân hàng
                                                <div class="form-group">
                                                    <input type="file" class="form-control" name="bank_account_image" placeholder="Ảnh QR ngân hàng">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <input type="button" value="Tạo tài khoản" class="btn btn-sm btn-primary" id="btn-tao-tai-khoan">
                            <a type="button" href="{{url('/')}}" value="HUỶ TẠO" class="btn btn-sm btn-danger">Hủy tạo</a>
                        </div>
                    </form>
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
        function selectProvince(ward_id = ''){
            $.ajax({
                type: "POST", url: "{{url('selectdictrict')}}",
                data: {
                    id: $("#them_tinh").val(),
                    _token: '{{csrf_token()}}'
                },
                success: function(result){
                    $("#them_huyen").html(result);
                    if(ward_id != ''){
                        $('#them_huyen').val(ward_id);
                    }
                }
            });
        }
        function selectWard(ward_id = ''){
            $.ajax({
                type: "POST", url: "{{url('selectward')}}",
                data: {
                    id: $("#them_huyen").val(),
                    _token: '{{csrf_token()}}'
                },
                success: function(result){
                    //console.log( $("#them_huyen").val());
                    //console.log(result);
                    $("#them_xa_phuong").html(result);
                    if(ward_id != ''){
                        $('#them_xa_phuong').val(ward_id);
                    }
                }
            });
        }
        $(document).ready(function(){
            $("#btn-tao-tai-khoan").click(function(){
                var formStatus = $("#form-signup").validate({
                    rules: {
                        login_name: "required",
                        phone: "required",
                        // address: "required",
                        password: "required",
                        password_confirm: "required",
                        // bank_account_number: "required",
                        // provice_id: "required",
                        // dictrict_id: "required",
                        // ward_id: "required",
                    },
                    messages:{
                        login_name: "Nhập tên đăng nhập.",
                        phone: "Nhập số điện thoại.",
                        password: "Nhập mật khẩu.",
                        password_confirm: "Nhập lại mật khẩu.",
                        // bank_account_number: "Nhập tài khoản ngân hàng.",
                        // provice_id: "Chọn tỉnh",
                        // dictrict_id: "Chọn huyện",
                        // ward_id: "Chọn xã",
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
                    var form_data = new FormData($("#form-signup")[0]);
                    $.ajax({
                        url: "{{ route('user.register.post') }}",
                        data: form_data,
                        type: 'POST',
                        contentType: false,
                        processData: false,
                        success: function (result) {
                            //console.log(result);
                            popup_load_off();
                            if(result.status == 'true'){
                                $('.head_title').append(`<div class="separator" style="background: #8eff6b;">Đăng ký tài khoản thành công.</div>`)
                            }else{
                                $('#titleError').text('Lỗi!!!');$('#msgError').text(result.message);$('#btnError').html("<button type='button' class='btn btn-danger' data-bs-dismiss='modal'>OK</button>");$('#errorModal').modal('show');
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
