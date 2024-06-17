@extends('Home::Layout.master')

@section('main')

    <div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="div-signup sections">
					<div class="head_title text-center">
						<h2>ĐĂNG KÝ THÀNH VIÊN</h2>
						<div class="subtitle">
						Chào mừng bạn! Hãy đăng ký ngay để trở thành 1 đại lý bán hàng, của cộng đồng doanh nghiệp với hơn 10.000 sản phẩm.
						</div>
						<div class="separator"></div>
					</div><!-- End off Head_title -->
					<form id="form-signup" action="" name="" method="POST" enctype="multipart/form-data">
						{!! csrf_field() !!}
						<div class="row">
							<div class="col-sm-6">

								<div class="padding-top-90 p_l_r">
									<div class="single_info_text">
										<h3>TẠO ĐƠN HÀNG</h3>
									</div>
								</div>

								<div class="row padding-bottom-90">
									<div class="col-lg-8 col-md-8 col-sm-10 offset-lg-2 offset-md-2 offset-sm-1">

										<div class="row">
											<div class="col-sm-12">
												<div class="form-group">
													<input type="text" class="form-control" name="name" placeholder="Tên khách">
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-12">
												<div class="form-group">
													<input type="text" class="form-control" name="phone" placeholder="Số điện thoại">
												</div>
											</div>
											<div class="col-sm-12">
												<div class="form-group">
													<input type="text" class="form-control" name="dia_chi" placeholder="Địa chỉ khách hàng">
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
												<div class="row">
												
													<div class="col-lg-12 col-md-12 col-sm-12">
														<div class="control-group-1">
															<div class="controls masp_dv">
																<label class="control-label">Mã SP&DV</label>
															</div>
														</div>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-12">
														<div class="control-group-1">
															<label class="control-label">Mã</label>
															<div class="controls">
																<input name="pcode[]" value="MA-GIOITHIEU" placeholder="Mã" autocomplete="off" class="pcode form-control" readonly>
															</div>
														</div>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-12">
														<div class="control-group-1">
															<label class="control-label">Số lượng</label>
															<div class="controls">
																<input name="pnum[]" placeholder="Số lượng" value="1" autocomplete="off" class="pnum form-control" readonly>
															</div>
														</div>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-12">
														<div class="control-group-1">
															<label class="control-label">Giá bán</label>
															<div class="controls">
																<input name="pprice[]" placeholder="Giá bán" value="300000" autocomplete="off" class="pprice form-control" readonly>
															</div>
														</div>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-12">
														<div class="control-group-1">
															<label class="control-label">Thành tiền</label>
															<div class="controls">
																<input name="ptotal[]" placeholder="Thành tiền" value="300000" autocomplete="off" class="ptotal form-control" readonly="">
															</div>
														</div>
													</div>
												</div>

										{{--<div class="form-group">
											<textarea class="form-control" name="message" rows="7" placeholder="Message"></textarea>
										</div>--}}

										{{--<div class="">
											<input type="submit" value="SEND MESSAGE" class="btn btn-lg">
										</div>--}}
										<input type="hidden" class="form-control" name="id_tinh" value="0">
										<input type="hidden" class="form-control" name="id_huyen" value="0">
										<input type="hidden" class="form-control" name="id_xa" value="0">
										<!-- <input type="hidden" class="form-control" name="provice_id" value="0">
										<input type="hidden" class="form-control" name="dictrict_id" value="0">
										<input type="hidden" class="form-control" name="ward_id" value="0"> -->
										<input type="hidden" class="form-control" name="id_kenh_ban" value="0">
										<input type="hidden" class="form-control" name="id_store" value="1">
										<input type="hidden" class="form-control" name="phi_van_chuyen" value="0">
										<input type="hidden" class="form-control" name="phi_thu_ho" value="0">
										<input type="hidden" class="form-control" name="vat_phan_tram" value="0">
										<input type="hidden" class="form-control" name="vat_thanh_tien" value="0">
										<input type="hidden" class="form-control" name="chiet_khau_phan_tram" value="0">
										<input type="hidden" class="form-control" name="chiet_khau_thanh_tien" value="0">
									</div>
								</div>
							</div>

							<div class="col-sm-6">

								<div class="padding-top-90 p_l_r">
									<div class="single_info_text">
										<h3>THÔNG TIN CÁ NHÂN</h3>
									</div>
								</div>

								<div class="single_contant_left padding-bottom-90">
									<div class="col-lg-8 col-md-8 col-sm-10 offset-lg-2 offset-md-2 offset-sm-1">

										<div class="row">
											<div class="col-sm-12">
												<div class="form-group">
													<input type="text" class="form-control" name="ma_gioi_thieu" placeholder="Mã giới thiệu">
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-12">
												<div class="form-group">
													<input type="text" class="form-control" name="user_full_name" placeholder="Họ tên">
												</div>
											</div>
											<div class="col-sm-12">
												<div class="form-group">
													<input type="text" class="form-control" name="user_phone" placeholder="Số điện thoại">
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-12">
												<div class="form-group">
													<input type="text" class="form-control" name="user_name" placeholder="Tên đăng nhập">
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
													<input type="date" class="form-control" name="ngay_sinh" placeholder="Ngày sinh">
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-12">
												<div class="form-group">
													<input type="text" class="form-control" name="thuong_tru" placeholder="Địa chỉ thường trú">
												</div>
											</div>
											<div class="col-sm-12">
												<div class="form-group">
													<input type="text" class="form-control" name="tam_tru" placeholder="Địa chỉ tạm trú">
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-12">
												<div class="form-group">
													<input type="text" class="form-control" name="user_mail" placeholder="Email">
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<input type="text" class="form-control" name="so_tai_khoan" placeholder="Số tài khoản">
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<input type="text" class="form-control" name="ngan_hang" placeholder="Tên ngân hàng">
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-12">
												<div class="form-group">
													<input type="text" class="form-control" name="ten_tai_khoan" placeholder="Chủ tài khoản">
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

										{{--<div class="form-group">
											<textarea class="form-control" name="message" rows="7" placeholder="Message"></textarea>
										</div>--}}

										{{--<div class="">
											<input type="submit" value="GỬI HỢP ĐỒNG" class="btn btn-sm btn-primary">
										</div>--}}
									</div>
								</div>
							</div>
						</div>

						<div class="text-center">
							<input type="button" value="GỬI HỢP ĐỒNG" class="btn btn-sm btn-primary" id="btn-gui-hop-dong">
							<a type="button" href="{{url('/')}}" value="HUỶ TẠO" class="btn btn-sm btn-danger">HUỶ TẠO</a>
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
        .masp_dv{
            display: flex;
            justify-content: center;
            margin-top: 10px;
            margin-bottom: 7px;
        }
        .controls .form-control[readonly]{
            background-color: #f7f7f7 !important; 
        }
        .absolute-vnd{
            position: absolute;
            text-align: center;
            top: 30px;
            right: 20px;
        }
    </style>
@endsection

@section('scripts')
    <script>
        var ma_gioi_thieu = document.querySelector('input[name="ma_gioi_thieu"]');
        ma_gioi_thieu.value = localStorage.getItem('ma_gioi_thieu');
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
            $("#btn-gui-hop-dong").click(function(){
                var formStatus = $("#form-signup").validate({
                    rules: {
                        {{--name: {
                            required: true,
                            maxlength: 50
                        },--}}
                        {{--user_mail: {
                            required: true,
                            email: true
                        },--}}
                        {{--phone: "required",--}}
                        user_full_name: "required",
                        user_phone: "required",
                        thuong_tru: "required",
                        tam_tru: "required",
                        ngan_hang: "required",
                        provice_id: "required",
                        dictrict_id: "required",
                        ward_id: "required",
                    },
                    messages:{
                        {{--name: {
                            required: "Nhập tên.",
                            maxlength: "Tên dưới 50 ký tự."
                        },--}}
                        {{--user_mail: {
                            required: "Nhập email.",
                            email: "Email không đúng định dạng."
                        },--}}
                        {{--phone: "Nhập số điện thoại.",--}}
                        user_full_name: "Nhập họ tên.",
                        user_phone: "Nhập số điện thoại.",
                        thuong_tru: "Nhập địa chỉ thường trú.",
                        tam_tru: "Nhập địa chỉ tạm trú.",
                        ngan_hang: "Nhập tài khoản ngân hàng.",
                        provice_id: "Chọn tỉnh",
                        dictrict_id: "Chọn huyện",
                        ward_id: "Chọn xã",
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
                        url: "{{url('/signup_submit')}}",
                        data: form_data,
                        type: 'POST',
                        contentType: false,
                        processData: false,
                        success: function (result) {
                            //console.log(result);
                            popup_load_off();
                            if(result.status == 'true'){
                                alert('Đã gửi thành công!');
                                window.location.reload();
                            }else{
                                $('#titleError').text('Lỗi!!!');$('#msgError').text(result.message);$('#btnError').html("<button type='button' class='btn btn-danger' data-bs-dismiss='modal'>OK</button>");$('#errorModal').modal('show');
                            }
                        }
                    });
                }
            });
        });

        function nhapProductCode(e){
            let parent_e = $(e).parent().parent();
            $.ajax({
                type: "POST", url: "{{url('/admin/khachhangvip/loadProductCode')}}",
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
    </script>
@endsection
