@extends('Home::Layout.master')

@section('main')
    <div class="container">
        <div class="row">
            <div class="col-3 d-none d-lg-block nav-bar">
                <nav class="margin-top-40">
                    <div class="nav nav-tabs flex-column" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Hồ sơ cá nhân</button>
                        <button class="nav-link" id="nav-order-tab" data-bs-toggle="tab" data-bs-target="#nav-order" type="button" role="tab" aria-controls="nav-order" aria-selected="true">Đơn mua</button>
                        <a class="nav-link text-center" href="{{ route('user.logout') }}">Đăng xuất</a>
                    </div>
                </nav>
            </div>
            <div class="col-12 col-lg-9">
                <nav class="margin-top-40 d-lg-none">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Hồ sơ</button>
                        <button class="nav-link" id="nav-order-tab" data-bs-toggle="tab" data-bs-target="#nav-order" type="button" role="tab" aria-controls="nav-order" aria-selected="true">Đơn mua</button>
                        <a class="nav-link text-center" href="{{ route('user.logout') }}">Đăng xuất</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="col-sm-12">
                            <div class="div-signup sections">
                                <div class="head_title text-center">
                                    <h2>Thông tin tài khoản</h2>
                                </div>
                                <form id="form-update-user" method="POST" enctype="multipart/form-data">
                                    {!! csrf_field() !!}
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="single_contant_left padding-bottom-90">
                                                <div class="col-lg-10 col-md-10 col-sm-10 offset-lg-1 offset-md-1 offset-sm-1">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="name" placeholder="Họ tên" value="{{ $user->name }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <input type="number" class="form-control" name="phone" placeholder="Số điện thoại" value="{{ $user->phone }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="email" placeholder="Email" value="{{ $user->email }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="login_name" placeholder="Tên đăng nhập" value="{{ $user->login_name }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <input type="date" class="form-control" name="birthday" placeholder="Ngày tháng năm sinh" value="{{ $user->birthday }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row display-none">
                                                        <div class="col-sm-12">
                                                            <lable>Ảnh cá nhân</lable>
                                                            <div class="avatar-image image-link" data-image-src="{{ $user->avatar }}">
                                                                <img src="{{ $user->avatar }}" alt="{{ $user->name }}">
                                                                <input type="hidden" class="form-control" name="avatar" value="{{ $user->avatar }}">
                                                            </div>
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
                                                <div class="col-lg-10 col-md-10 col-sm-10 offset-lg-1 offset-md-1 offset-sm-1">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="address" placeholder="Địa chỉ khách hàng" value="{{ $user->address }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                                            <div class="control-group-1">
                                                                <label class="control-label">Tỉnh/Thành</label>
                                                                <div class="controls">
                                                                    <select class="form-control input-sm" name="provice_id" id="them_tinh" onchange="selectProvince()">
                                                                        <option value="" selected="selected">--Chọn--</option>
                                                                        @foreach($allProvince as $item)
                                                                            <option value="{{$item['provice_id']}}" @if($user->provice_id == $item['provice_id']) selected @endif>{{$item['provice_title']}}</option>
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
                                                                <input type="number" class="form-control" name="bank_account_number" placeholder="Số tài khoản" value="{{ $user->bank_account_number }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="bank_name" placeholder="Tên ngân hàng" value="{{ $user->bank_name }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="bank_account_name" placeholder="Chủ tài khoản" value="{{ $user->bank_account_name }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row display-none">
                                                        <div class="col-sm-12">
                                                            <lable>Ảnh QR ngân hàng</lable>
                                                            <div class="qr-image image-link" data-image-src="{{ $user->bank_account_image }}">
                                                                <img src="{{ $user->bank_account_image }}" alt="{{ $user->name }}">
                                                                <input type="hidden" class="form-control" name="bank_account_image" value="{{ $user->bank_account_image }}">
                                                            </div>
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
                                        <input type="button" value="Lưu thông tin mới" class="btn btn-sm btn-primary" id="btn-luu-tai-khoan">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade margin-bottom-20" id="nav-order" role="tabpanel" aria-labelledby="nav-home-tab">

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
        .nav-tabs-vertical {
            display: flex;
            flex-direction: column;
        }
        .avatar-image img, .qr-image img {
            height: 200px;
            object-fit: cover;
            width: 200px;
        }
        .nav-bar {
            border-right: 1px solid #ccc;
        }

        .nav-bar .nav-tabs button.nav-link{
            border-bottom: 1px solid #ccc;
        }
    </style>
@endsection

@section('scripts')
    <script>
        @if(!empty($user->dictrict_id))
            selectProvince({{ $user->dictrict_id . ', ' . $user->provice_id }})
        @endif
        @if(!empty($user->ward_id))
            selectWard({{ $user->ward_id . ', ' . $user->dictrict_id }})
        @endif
        function selectProvince( ward_id = '', provice_id = ''){
            if(provice_id == ''){
                provice_id = $("#them_tinh").val();
            }
            $.ajax({
                type: "POST", url: "{{url('selectdictrict')}}",
                data: {
                    id: provice_id,
                    dictrict_id: ward_id,
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
        function selectWard( ward_id = '', dictrict_id = ''){
            if(dictrict_id == ''){
                dictrict_id = $("#them_huyen").val();
            }
            $.ajax({
                type: "POST", url: "{{url('selectward')}}",
                data: {
                    id: dictrict_id,
                    ward_id: ward_id,
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
            $("#btn-luu-tai-khoan").click(function(){
                var formStatus = $("#form-update-user").validate({
                    rules: {
                        login_name: "required",
                        phone: "required",
                        password: "required",
                        password_confirm: "required",
                    },
                    messages:{
                        login_name: "Nhập tên đăng nhập.",
                        phone: "Nhập số điện thoại.",
                        password: "Nhập mật khẩu.",
                        password_confirm: "Nhập lại mật khẩu.",
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
                    var form_data = new FormData($("#form-update-user")[0]);
                    $.ajax({
                        url: "{{ route('user.auth.update') }}",
                        data: form_data,
                        type: 'POST',
                        contentType: false,
                        processData: false,
                        success: function (result) {
                            popup_load_off();
                            if(result.status == 'true'){
                                alert('Chỉnh sửa thành công.');
                                location.reload();
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
