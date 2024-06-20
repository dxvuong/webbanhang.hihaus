@if(empty($setting))
	@php($setting = \App\Modules\Footer\Models\Footer::find(1))
@endif
@php($seoSetting = \App\Modules\Home\Models\SeoSetting::find(1))
@php($headerSettings = \App\Modules\Home\Models\HeaderSetting::where('status', 1)->orderBy('order')->get())
<!DOCTYPE html>
<html lang="vi">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>{{ app('metaTagManager')->getMetaData('meta_title') }}</title>
	{!! app('metaTagManager')->getSeo() !!}
	@if(!empty($setting->favicon))<link rel="icon" type="image/x-icon" href="{{Config::get('app.PATH_ADMIN').$setting->favicon}}">@endif
	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet" type="text/css">
	<!-- icons -->
	<link href="{{asset('public/assets/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('public/assets/css/swiper-bundle.min.css')}}" rel="stylesheet" type="text/css">
	<!--bootstrap -->
	<link href="{{asset('public/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('public/assets/style.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('public/css/custom.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('public/css/vuong.css?v=1.0.3')}}" rel="stylesheet" type="text/css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet" type="text/css">
	 <!--Owl Carousel -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
	<link rel="stylesheet"
		  href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
	<!--css -->
	@yield('styles')
	<style>
		:root {
			--background-color-main: {{ $setting->header_background_color }};
			--company-phone-number: '{{ !empty(json_decode($setting->phone)) ? (string)json_decode($setting->phone)[0] : '' }}';
		}
		.header-background-text-color {
			background-color: {{ $setting->header_background_color }}!important;
			color: {{ $setting->header_text_color }}!important;
		}
		.header-boder-color {
			border-color: {{ $setting->header_background_color }}!important;
		}
	</style>
	<link href="{{asset('public/assets/master.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('public/assets/style_responsive.css')}}" rel="stylesheet" type="text/css">

	<!-- seo script -->
	{!! $seoSetting->header_script !!}

	{!! app('metaTagManager')->getSeoScript() !!}
</head>
<body>
{!! $setting->chat_facebook !!}
{!! $setting->chat_zalo !!}
{!! $setting->google_analytics !!}
@php($lang =  \Illuminate\Support\Facades\Session::get('language'))
@php($menu = \App\Modules\Home\Models\Menu::where('parent', '=', NULL)
	->where('status', '=', 1)
	->where('position', \App\Modules\Home\Models\Menu::HORIZONTAL_POSITION)
	->with(['children' => function ($query) {
		$query->orderBy('order', 'asc');
		$query->with(['children' => function ($query) {
			$query->orderBy('order', 'asc');
		}]);
	}])
	->orderBy('order', 'asc')->get())
@php($menuVertical = \App\Modules\Home\Models\Menu::where('parent', '=', NULL)
	->where('status', '=', 1)
	->where('position', \App\Modules\Home\Models\Menu::VERTICAL_POSITION)
	->with(['children' => function ($query) {
		$query->orderBy('order', 'asc');
		$query->with(['children' => function ($query) {
			$query->orderBy('order', 'asc');
		}]);
	}])
	->orderBy('order', 'asc')->get())
@php($total = 0)
@php($appMenu = \App\Modules\App\Models\Menu::where('parent', '=', NULL)
	->where('status', '=', 1)
	->with(['children' => function ($query) {
		$query->orderBy('order', 'asc');
		$query->with(['children' => function ($query) {
			$query->orderBy('order', 'asc');
		}]);
	}])
	->orderBy('order', 'asc')->get())
@php
    $path = request()->path();
    $segments = explode('/', $path);
    $segment = $segments[0];
@endphp

<Header>
	<div class="header-top d-none d-lg-flex align-items-center mb-2">
		<div class="container">
			<div class="row align-items-center cs-justify-content-center">
				<div class="col-3">
					<div class="logo d-flex justify-content-center">
						<a href="{{url('/')}}">
							<img width="214" height="80" src="{{ Config::get('app.PATH_ADMIN').$setting->logo_header }}" alt="logo" style="width: 214px !important;"/>
						</a>
					</div>
				</div>
				<div class="col-9">
					<div class="row align-items-center">
						@foreach($headerSettings as $headerSetting)
							@if($headerSetting->type == 'search')
								<div class="col-{{ $headerSetting->col }}">
									<div class="header-search">
										<form class="form-inline" action="{{route('list.product')}}" method="GET">
											<div class="input-group">
												<input type="text" class="form-control" name="search" placeholder="{{ $headerSetting->content }}">
												<div class="input-group-append">
													<button class="btn" type="submit" aria-label="{{ $headerSetting->content }}"><i class="fa fa-search" aria-hidden="true"></i></button>
												</div>
											</div>
										</form>
									</div>
								</div>
								@break
							@endif
						@endforeach
							<div class="col col-contact">
								<div class="row align-items-center">
									@foreach($headerSettings as $headerSetting)
										@if($headerSetting->type == 'phone')
											<div class="col-{{ $headerSetting->col }}">
												<div class="phone-number d-flex align-items-center justify-content-center">
													<div class="icon">
														{!! $headerSetting->icon !!}
													</div>
													<div>
														<h3>{{ $headerSetting->name }}</h3>
														@if(!empty($headerSetting->content))
															<p>{{ $headerSetting->content }}</p>
														@endif
													</div>
												</div>
											</div>
										@endif
										@if($headerSetting->type == 'account')
											<div class="col-{{ $headerSetting->col }}">
											<div class="register">
											<span class="d-flex align-items-center justify-content-center">
												<div class="icon">
													{!! $headerSetting->icon !!}
												</div>
												@if(!empty(Auth::user()))
													<a href="{{ route('user.auth.detail') }}">
													<h3>Xin chào <br> {{ Auth::user()->login_name }}</h3>
												</a>
												@else
													<div>
														<h3>Tài Khoản</h3>
														<p>
															<button class="btn-dang-nhap btn-dang-nhap-user"><span>Đăng nhập</span></button>
															<button class="btn-dang-ky" onclick="javascript:window.location.href='{{ route('user.register') }}'"><span>Đăng ký</span></button>
														</p>
													</div>
												@endif
											</span>
											</div>
										</div>
										@endif
										@if($headerSetting->type == 'cart')
											<div class="col-{{ $headerSetting->col }}">
											<div class="header-card">
												<a href="{{url('gio-hang')}}" class="d-flex">
													<div class="icon">
														{!! $headerSetting->icon !!}
														@if(!empty(session()->all()['mini_cart']))
															@php($count = 0)
															@foreach(session()->all()['mini_cart'] as $item)
																@php($product = \App\Modules\Product\Models\Product::find($item['id']))
																@php($total += !empty($product->price_sale) ? $product->price_sale * $item['qty'] :
																$product->price_regular * $item['qty'])
																@php($count += $item['qty'])
															@endforeach
															<span class="count">{{$count}}</span>
														@else
															<span class="count">0</span>
														@endif
													</div>
													<div>
														<h3>Giỏ hàng</h3>
														<p>{{number_format($total, 0, '.', '.')}} <u>đ</u></p>
													</div>
												</a>
											</div>
										</div>
										@endif
										@if($headerSetting->type == 'email')
											<div class="col-{{ $headerSetting->col }}">
												<div class="phone-number d-flex align-items-center justify-content-center">
													<div class="icon">
														{!! $headerSetting->icon !!}
													</div>
													<div>
														<h3>{{ $headerSetting->name }}</h3>
														@if(!empty($headerSetting->content))
															<p>{{ $headerSetting->content }}</p>
														@endif
													</div>
												</div>
											</div>
										@endif
										@if($headerSetting->type == 'address')
											<div class="col-{{ $headerSetting->col }}">
												<div class="phone-number d-flex align-items-center justify-content-center">
													<div class="icon">
														{!! $headerSetting->icon !!}
													</div>
													<div>
														<h3>{{ $headerSetting->name }}</h3>
														@if(!empty($headerSetting->content))
															<p>{{ $headerSetting->content }}</p>
														@endif
													</div>
												</div>
											</div>
										@endif
										@if($headerSetting->type == 'link')
											<div class="col-{{ $headerSetting->col }}">
												<div class="phone-number d-flex align-items-center justify-content-center">
													<div class="icon">
														{!! $headerSetting->icon !!}
													</div>
													<div>
														<h3 class="d-flex"><a href="{{ !empty($headerSetting->content) ? $headerSetting->content : '#' }}">{{ $headerSetting->name }}</a></h3>
													</div>
												</div>
											</div>
										@endif
									@endforeach
								</div>
							</div>
						<div class="col-12">
							<ul class="navbar-nav cs-navbar-nav me-auto mb-2 mb-lg-0 justify-content-between mobile-align-items-start align-items-center">
								@if($menuVertical->count() > 0)
									<li class="nav-item dropdown d-flex align-items-center mobile-align-items-start category">
										<a class="nav-link" href="/" style="color: #FFFFFF"><i class="fa-solid fa-bars margin-right-10"></i> DANH MỤC SẢN PHẨM</a>
										<ul class="list-group list-group-flush dropdown-menu category-content" aria-labelledby="navbarDropdown">
											@foreach($menuVertical as $key => $item)
												@if($key < 17)
													<li class="list-group-item nav-item @if($item->children->count() > 0) dropdown @endif">
														@if(!empty($item->link))
															<a class="dropdown-item d-flex align-items-center @if($item->children->count() > 0) dropdown-toggle childMenu @endif" href="{{$item->link}}" style="white-space: normal">
														<span class="me-1">
                                                            {!! $item->menuIcon() !!}
                                                        </span>
																<span>
															{{ $item->name }}
														</span>
															</a>
														@else
															<a class="dropdown-item d-flex align-items-center @if($item->children->count() > 0) dropdown-toggle childMenu @endif" href="#" style="white-space: normal">
                                                        <span class="me-1">
                                                            {!! $item->menuIcon() !!}
                                                        </span>
																<span>{{ $item->name }}</span>
															</a>
														@endif
														@if($item->children->count() > 0)
															<ul class="row dropdown-menu submenu-level-2">
																<div class="row">
																	@foreach($item->children as $childMenu)
																		<li class="nav-item @if($childMenu->children->count() > 0) dropdown @endif ">
																			@if(!empty($childMenu->link))
																				<a class="dropdown-item @if($childMenu->children->count() > 0) dropdown-toggle @endif" href="{{$childMenu->link}}" style="font-weight: 600; white-space: normal">{{$childMenu->name}}</a>
																			@else
																				<a class="dropdown-item @if($childMenu->children->count() > 0) dropdown-toggle @endif" href="#" style="font-weight: 600; white-space: normal">{{$childMenu->name}}</a>
																			@endif
																			@if($childMenu->children->count() > 0)
																				<ul style="margin: 5px 0 0 15px">
																					@foreach($childMenu->children as $grandchildMenu)
																						<li>
																							<a href="{{ $grandchildMenu->link }}" class="text-decoration-none" style="white-space: normal">{{ $grandchildMenu->name }}</a>
																						</li>
																					@endforeach
																				</ul>
																			@endif
																		</li>
																	@endforeach
																</div>
															</ul>
														@endif
													</li>
												@else
													<li class="nav-item dropdown" style="padding: 4px 0 8px 0;">
														<a class="dropdown-item d-flex align-items-center justify-content-center dropdown-toggle childMenu " href="#" style="white-space: normal">
														<span class="me-1">
                                                        </span>
															<span>
															Xem thêm
														</span>
														</a>
														<ul class="row dropdown-menu submenu-level-2">
															<div class="row">
																@foreach($menuVertical as $k => $verticalItem)
																	@if($k >= 17)
																		<li class="nav-item @if($verticalItem->children->count() > 0) dropdown @endif ">
																			@if(!empty($verticalItem->link))
																				<a class="dropdown-item @if($verticalItem->children->count() > 0) dropdown-toggle @endif" href="{{$verticalItem->link}}" style="font-weight: 600; white-space: normal">{{$verticalItem->name}}</a>
																			@else
																				<a class="dropdown-item @if($verticalItem->children->count() > 0) dropdown-toggle @endif" href="#" style="font-weight: 600; white-space: normal">{{$verticalItem->name}}</a>
																			@endif
																			@if($verticalItem->children->count() > 0)
																				<ul style="margin: 5px 0 0 15px; list-style: none">
																					@foreach($verticalItem->children as $childMenu)
																						<li class="nav-item @if($childMenu->children->count() > 0) dropdown @endif">
																							<a href="{{ $childMenu->link }}" class="text-decoration-none @if($childMenu->children->count() > 0) dropdown-toggle @endif" style="white-space: normal"><i class="fa-solid fa-arrow-right"></i> {{ $childMenu->name }}</a>
																							@if($childMenu->children->count() > 0)
																								<ul style="margin: 5px 0 0 15px">
																									@foreach($childMenu->children as $grandchildMenu)
																										<li>
																											<a href="{{ $grandchildMenu->link }}" class="text-decoration-none" style="white-space: normal">{{ $grandchildMenu->name }}</a>
																										</li>
																									@endforeach
																								</ul>
																							@endif
																						</li>
																					@endforeach
																				</ul>
																			@endif
																		</li>
																	@endif
																@endforeach
															</div>
														</ul>
													</li>
													@break
												@endif
											@endforeach
										</ul>
									</li>
								@endif
								@foreach($menu as $item)
									@php($link = trim($item->link, '/'))
									<li class="nav-item @if($segment == $link) active @endif @if($item->children->count() > 0) dropdown @endif @if($item->link == 'app-api') dropdown @endif">
										@if(!empty($item->link))
											@if($item->link == 'app-api')
												<a class="nav-link dropdown-toggle d-flex justify-content-center align-items-center" href="#" style="color: {{ $setting->header_text_color }}">
													<span class="me-1">
                                                       	{!! $item->menuIcon() !!}
                                                    </span>
													<span>
														{{ $item->name }}
													</span>
												</a>
											@else
												<a class="nav-link d-flex justify-content-center align-items-center @if($item->children->count() > 0) dropdown-toggle @endif" href="{{$item->link}}" style="color: {{ $setting->header_text_color }}">
													<span class="me-1">
                                                       	{!! $item->menuIcon() !!}
                                                    </span>
													<span>
														{{ $item->name }}
													</span>
												</a>
											@endif
										@else
											<a class="nav-link d-flex justify-content-center align-items-center @if($item->children->count() > 0) dropdown-toggle @endif" href="#" style="color: {{ $setting->header_text_color }}">
												<span class="me-1">
                                                   	{!! $item->menuIcon() !!}
                                                </span>
												<span>
													{{ $item->name }}
												</span>
											</a>
										@endif
										@if(!empty($item->link == 'app-api'))
												<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
													@foreach($appMenu as $appItem)
														<li class="nav-item @if($appItem->children->count() > 0) dropdown @endif">
															<a class="dropdown-item @if($appItem->children->count() > 0) dropdown-toggle childMenu @endif" href="{{ '/' . $item->slug . '/' . $appItem->slug }}">{{$appItem->name}}</a>
															@if($appItem->children->count() > 0)
																<ul class="dropdown-menu submenu-level-2" aria-labelledby="navbarDropdown">
																	@foreach($appItem->children as $appChildMenu)
																		<li @if($appChildMenu->children->count() > 0) class="nav-item dropdown" @endif>
																			<a class="dropdown-item @if($appChildMenu->children->count() > 0) dropdown-toggle childMenu @endif" href="{{ '/' . $item->slug . '/' . $appChildMenu->slug }}">{{$appChildMenu->name}}</a>
																			@if($appChildMenu->children->count() > 0)
																				<ul class="dropdown-menu submenu-level-2" aria-labelledby="navbarDropdownSubmenu">
																					@foreach($appChildMenu->children as $appGrandchildMenu)
																						<li class="nav-item">
																							<a class="nav-link" href="{{ '/' . $item->slug . '/' . $appGrandchildMenu->slug }}">{{$appGrandchildMenu->name}}</a>
																						</li>
																					@endforeach
																				</ul>
																			@endif
																		</li>
																	@endforeach
																</ul>
															@endif
														</li>
													@endforeach
												</ul>
										@endif
										@if($item->children->count() > 0)
												<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
													@foreach($item->children as $childMenu)
														<li @if($childMenu->children->count() > 0) class="nav-item dropdown" @endif>
															@if(!empty($childMenu->link))
																<a class="dropdown-item @if($childMenu->children->count() > 0) dropdown-toggle childMenu @endif" href="{{$childMenu->link}}">
																	<span class="me-1">
																		{!! $childMenu->menuIcon() !!}
																	</span>
																	<span>{{ $childMenu->name }}</span>
																</a>
															@else
																<a class="dropdown-item @if($childMenu->children->count() > 0) dropdown-toggle childMenu @endif" href="#">
																	<span class="me-1">
																		{!! $childMenu->menuIcon() !!}
																	</span>
																	<span>{{ $childMenu->name }}</span>
																</a>
															@endif
															@if($childMenu->children->count() > 0)
																	<ul class="dropdown-menu submenu-level-2" aria-labelledby="navbarDropdownSubmenu">
																	@foreach($childMenu->children as $grandchildMenu)
																		<li class="nav-item">
																			@if(!empty($grandchildMenu->link))
																				<a class="dropdown-item" href="{{$grandchildMenu->link}}">
																					<span class="me-1">
																						{!! $grandchildMenu->menuIcon() !!}
																					</span>
																					<span>{{ $grandchildMenu->name }}</span>
																				</a>
																			@else
																				<a class="dropdown-item" href="#">
																					<span class="me-1">
																						{!! $grandchildMenu->menuIcon() !!}
																					</span>
																					<span>{{ $grandchildMenu->name }}</span>
																				</a>
																			@endif
																		</li>
																	@endforeach
																</ul>
															@endif
														</li>
													@endforeach
												</ul>
										@endif
									</li>
								@endforeach
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="div-header-hidden"></div>
	<div class="header-bottom header-background-text-color">
		<div class="container-fluid">
			<div class="row">
				<div class="col-3 col-header-left">
					<div class="div-header-left">
						<a href="{{url('/')}}">
							<img src="{{ Config::get('app.PATH_ADMIN').$setting->logo_header }}" alt="logo"/>
						</a>
					</div>
				</div>
				<div class="col-7 col-header-center">
					<nav class="navbar navbar-expand-lg navbar-light">
						<div class="container-fluid align-items-center p-0">
							<div class="col-lg-10 ml-auto lg-flex-1">
								<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
									<span class="navbar-toggler-icon"></span>
								</button>
								<div class="overlay"></div>
								<div class="mobile-menu">
									<div class="close-button">
										<button class="navbar-toggler" type="button" aria-label="Toggle navigation">
											<span class="navbar-toggler-icon"></span>
										</button>
									</div>
									<ul class="navbar-nav me-auto mb-2 mb-lg-0 justify-content-center mobile-align-items-start align-items-center gap-lg-3 height-lg-45">
										@if($menuVertical->count() > 0)
											<li class="nav-item dropdown d-flex align-items-center mobile-align-items-start category">
												<a class="nav-link" href="/" style="color: #FFFFFF"><i class="fa-solid fa-bars margin-right-10"></i> DANH MỤC SẢN PHẨM</a>
												<ul class="list-group list-group-flush dropdown-menu category-content category-main" aria-labelledby="navbarDropdown">
													@foreach($menuVertical as $key => $item)
														@if($key < 17)
															<li class="list-group-item nav-item @if($item->children->count() > 0) dropdown @endif">
																@if(!empty($item->link))
																	<a class="dropdown-item d-flex align-items-center @if($item->children->count() > 0) dropdown-toggle childMenu @endif" href="{{$item->link}}" style="white-space: normal">
																<span class="me-1">
																	{!! $item->menuIcon() !!}
																</span>
																		<span>
																	{{ $item->name }}
																</span>
																	</a>
																@else
																	<a class="dropdown-item d-flex align-items-center @if($item->children->count() > 0) dropdown-toggle childMenu @endif" href="#" style="white-space: normal">
																<span class="me-1">
																	{!! $item->menuIcon() !!}
																</span>
																		<span>{{ $item->name }}</span>
																	</a>
																@endif
																@if($item->children->count() > 0)
																	<ul class="row dropdown-menu submenu-level-2">
																		<div class="row">
																			@foreach($item->children as $childMenu)
																				<li class="nav-item @if($childMenu->children->count() > 0) dropdown @endif ">
																					@if(!empty($childMenu->link))
																						<a class="dropdown-item @if($childMenu->children->count() > 0) dropdown-toggle @endif" href="{{$childMenu->link}}" style="font-weight: 600; white-space: normal">{{$childMenu->name}}</a>
																					@else
																						<a class="dropdown-item @if($childMenu->children->count() > 0) dropdown-toggle @endif" href="#" style="font-weight: 600; white-space: normal">{{$childMenu->name}}</a>
																					@endif
																					@if($childMenu->children->count() > 0)
																						<ul style="margin: 5px 0 0 15px">
																							@foreach($childMenu->children as $grandchildMenu)
																								<li>
																									<a href="{{ $grandchildMenu->link }}" class="text-decoration-none" style="white-space: normal">{{ $grandchildMenu->name }}</a>
																								</li>
																							@endforeach
																						</ul>
																					@endif
																				</li>
																			@endforeach
																		</div>
																	</ul>
																@endif
															</li>
														@else
															<li class="nav-item dropdown" style="padding: 4px 0 8px 0;">
																<a class="dropdown-item d-flex align-items-center justify-content-center dropdown-toggle childMenu " href="#" style="white-space: normal">
																<span class="me-1">
																</span>
																	<span>
																	Xem thêm
																</span>
																</a>
																<ul class="row dropdown-menu submenu-level-2">
																	<div class="row">
																		@foreach($menuVertical as $k => $verticalItem)
																			@if($k >= 17)
																				<li class="nav-item @if($verticalItem->children->count() > 0) dropdown @endif ">
																					@if(!empty($verticalItem->link))
																						<a class="dropdown-item @if($verticalItem->children->count() > 0) dropdown-toggle @endif" href="{{$verticalItem->link}}" style="font-weight: 600; white-space: normal">{{$verticalItem->name}}</a>
																					@else
																						<a class="dropdown-item @if($verticalItem->children->count() > 0) dropdown-toggle @endif" href="#" style="font-weight: 600; white-space: normal">{{$verticalItem->name}}</a>
																					@endif
																					@if($verticalItem->children->count() > 0)
																						<ul style="margin: 5px 0 0 15px; list-style: none">
																							@foreach($verticalItem->children as $childMenu)
																								<li class="nav-item @if($childMenu->children->count() > 0) dropdown @endif">
																									<a href="{{ $childMenu->link }}" class="text-decoration-none @if($childMenu->children->count() > 0) dropdown-toggle @endif" style="white-space: normal"><i class="fa-solid fa-arrow-right"></i> {{ $childMenu->name }}</a>
																									@if($childMenu->children->count() > 0)
																										<ul style="margin: 5px 0 0 15px">
																											@foreach($childMenu->children as $grandchildMenu)
																												<li>
																													<a href="{{ $grandchildMenu->link }}" class="text-decoration-none" style="white-space: normal">{{ $grandchildMenu->name }}</a>
																												</li>
																											@endforeach
																										</ul>
																									@endif
																								</li>
																							@endforeach
																						</ul>
																					@endif
																				</li>
																			@endif
																		@endforeach
																	</div>
																</ul>
															</li>
															@break
														@endif
													@endforeach
												</ul>
											</li>
										@endif
										@foreach($menu as $item)
											@php($link = trim($item->link, '/'))
											<li class="nav-item @if($segment == $link) active @endif @if($item->children->count() > 0) dropdown @endif @if($item->link == 'app-api') dropdown @endif">
												@if(!empty($item->link))
													@if($item->link == 'app-api')
														<a class="nav-link dropdown-toggle d-flex justify-content-center align-items-center" href="#" style="color: {{ $setting->header_text_color }}">
															<span class="me-1">
																{!! $item->menuIcon() !!}
															</span>
															<span>
																{{ $item->name }}
															</span>
														</a>
													@else
														<a class="nav-link d-flex justify-content-center align-items-center @if($item->children->count() > 0) dropdown-toggle @endif" href="{{$item->link}}" style="color: {{ $setting->header_text_color }}">
															<span class="me-1">
																{!! $item->menuIcon() !!}
															</span>
															<span>
																{{ $item->name }}
															</span>
														</a>
													@endif
												@else
													<a class="nav-link d-flex justify-content-center align-items-center @if($item->children->count() > 0) dropdown-toggle @endif" href="#" style="color: {{ $setting->header_text_color }}">
														<span class="me-1">
															{!! $item->menuIcon() !!}
														</span>
														<span>
															{{ $item->name }}
														</span>
													</a>
												@endif
												@if(!empty($item->link == 'app-api'))
														<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
															@foreach($appMenu as $appItem)
																<li class="nav-item @if($appItem->children->count() > 0) dropdown @endif">
																	<a class="dropdown-item @if($appItem->children->count() > 0) dropdown-toggle childMenu @endif" href="{{ '/' . $item->slug . '/' . $appItem->slug }}">{{$appItem->name}}</a>
																	@if($appItem->children->count() > 0)
																		<ul class="dropdown-menu submenu-level-2" aria-labelledby="navbarDropdown">
																			@foreach($appItem->children as $appChildMenu)
																				<li @if($appChildMenu->children->count() > 0) class="nav-item dropdown" @endif>
																					<a class="dropdown-item @if($appChildMenu->children->count() > 0) dropdown-toggle childMenu @endif" href="{{ '/' . $item->slug . '/' . $appChildMenu->slug }}">{{$appChildMenu->name}}</a>
																					@if($appChildMenu->children->count() > 0)
																						<ul class="dropdown-menu submenu-level-2" aria-labelledby="navbarDropdownSubmenu">
																							@foreach($appChildMenu->children as $appGrandchildMenu)
																								<li class="nav-item">
																									<a class="nav-link" href="{{ '/' . $item->slug . '/' . $appGrandchildMenu->slug }}">{{$appGrandchildMenu->name}}</a>
																								</li>
																							@endforeach
																						</ul>
																					@endif
																				</li>
																			@endforeach
																		</ul>
																	@endif
																</li>
															@endforeach
														</ul>
												@endif
												@if($item->children->count() > 0)
														<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
															@foreach($item->children as $childMenu)
																<li @if($childMenu->children->count() > 0) class="nav-item dropdown" @endif>
																	@if(!empty($childMenu->link))
																		<a class="dropdown-item @if($childMenu->children->count() > 0) dropdown-toggle childMenu @endif" href="{{$childMenu->link}}">
																			<span class="me-1">
																				{!! $childMenu->menuIcon() !!}
																			</span>
																			<span>{{ $childMenu->name }}</span>
																		</a>
																	@else
																		<a class="dropdown-item @if($childMenu->children->count() > 0) dropdown-toggle childMenu @endif" href="#">
																			<span class="me-1">
																				{!! $childMenu->menuIcon() !!}
																			</span>
																			<span>{{ $childMenu->name }}</span>
																		</a>
																	@endif
																	@if($childMenu->children->count() > 0)
																			<ul class="dropdown-menu submenu-level-2" aria-labelledby="navbarDropdownSubmenu">
																			@foreach($childMenu->children as $grandchildMenu)
																				<li class="nav-item">
																					@if(!empty($grandchildMenu->link))
																						<a class="dropdown-item" href="{{$grandchildMenu->link}}">
																							<span class="me-1">
																								{!! $grandchildMenu->menuIcon() !!}
																							</span>
																							<span>{{ $grandchildMenu->name }}</span>
																						</a>
																					@else
																						<a class="dropdown-item" href="#">
																							<span class="me-1">
																								{!! $grandchildMenu->menuIcon() !!}
																							</span>
																							<span>{{ $grandchildMenu->name }}</span>
																						</a>
																					@endif
																				</li>
																			@endforeach
																		</ul>
																	@endif
																</li>
															@endforeach
														</ul>
												@endif
											</li>
										@endforeach
									</ul>
									<div class="language d-flex flex-column d-lg-none" style="margin: 0 20px">
										<a href="{{route('index.lang')}}/vi">
											<img src="{{asset('public/assets/images/vi.jpg')}}" alt="VI" width="38" height="25" style="width: 38px !important;">
										</a>
										<a href="{{route('index.lang')}}/en">
											<img src="{{asset('public/assets/images/en.jpg')}}" alt="EN" width="38" height="25" style="width: 38px !important; margin-top: 10px">
										</a>
										<a href="{{route('index.lang')}}/ja">
											<img src="{{asset('public/assets/images/ja.jpg')}}" alt="EN" width="38" height="25" style="width: 38px !important; margin-top: 10px">
										</a>
										<ul class="navbar-nav me-auto mb-2 mb-lg-0">
											@if(!empty(Auth::user()))
												<li class="nav-item d-lg-none">
													<a class="nav-link " href="{{ route('user.auth.detail') }}">Tài khoản của tôi</a>
												</li>
												<li class="nav-item d-lg-none">
													<a class="nav-link " href="{{ route('user.logout') }}">Đăng xuất</a>
												</li>
											@else
												<li class="nav-item d-lg-none">
													<a class="nav-link btn-dang-nhap-user" href="#"><span>Đăng nhập</span></a>
												</li>
												<li class="nav-item d-lg-none">
													<a class="nav-link" href="{{ route('user.register') }}"><span>Đăng ký</span></a>
												</li>
											@endif
										</ul>
									</div>
								</div>
							</div>
							<div class="div-language d-none d-lg-flex justify-content-end">
								<div class="language d-flex justify-content-end">
									<a href="{{route('index.lang')}}/vi">
										<img src="{{asset('public/assets/images/vi.jpg')}}" alt="VI" width="38" height="25" style="width: 38px !important; margin-right: 4px;">
									</a>
									<a href="{{route('index.lang')}}/en">
										<img src="{{asset('public/assets/images/en.jpg')}}" alt="EN" width="38" height="25" style="width: 38px !important; margin-right: 4px;">
									</a>
									<a href="{{route('index.lang')}}/ja">
										<img src="{{asset('public/assets/images/ja.jpg')}}" alt="EN" width="38" height="25" style="width: 38px !important;">
									</a>
								</div>
							</div>
							<div class="header-logo d-lg-none">
								<a href="{{url('/')}}">
									<img src="{{ Config::get('app.PATH_ADMIN').$setting->logo_header }}" alt="logo" style="width: 214px!important; max-height: unset"/>
								</a>
							</div>
							<div class="header-card d-lg-none">
								<a href="{{url('gio-hang')}}" class="d-flex">
									<div class="icon">
										<i class="fa fa-shopping-cart" aria-hidden="true"></i>
										@if(!empty(session()->all()['mini_cart']))
											@php($count = 0)
											@foreach(session()->all()['mini_cart'] as $item)
												@php($count += $item['qty'])
											@endforeach
											<span class="count">{{$count}}</span>
										@else
											<span class="count">0</span>
										@endif
									</div>
								</a>
							</div>
							<div class="header-search col-7 d-lg-none">
								<form class="form-inline" action="{{route('list.product')}}" method="GET">
									<div class="input-group">
										<input type="text" class="form-control" name="search" placeholder="Tìm sản phẩm?">
										<div class="input-group-append">
											<button class="btn" type="submit" aria-label="Tìm sản phẩm"><i class="fa fa-search" aria-hidden="true"></i></button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</nav>
				</div>
				<div class="col-2 col-header-right">
					<div class="div-header-right">
						@foreach($headerSettings as $headerSetting)
							@if($headerSetting->type == 'phone')
								{!! $headerSetting->icon !!}
								@if(!empty($headerSetting->content))
									{{ $headerSetting->content }}
								@endif
							@endif
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</Header>

@yield('main')

<div class="div-lien-he">
	@php
		use App\Modules\Home\Models\HomeSetting;
		$lienHe = HomeSetting::where('title', 'Liên hệ Hihaus')->first();
	@endphp
	<div class="container-fuild">
		<div class="row">
			<div class="col-md-3 col-md-3-1">
				<div class="div-lien-he-1">
					{!!$lienHe!=null?$lienHe->description:''!!}
				</div>
			</div>
			<div class="col-md-3 col-md-3-2">
				<div class="div-lien-he-2">
					<button data-bs-toggle="modal" data-bs-target="#modal-yeu-cau-bao-gia">Yêu cầu báo giá <i class="fa fa-chevron-right" aria-hidden="true"></i></button>
					<a href="{{url('/lien-he')}}">
						<button>Liên hệ Hihaus <i class="fa fa-chevron-right" aria-hidden="true"></i></button>
					</a>
					<button data-bs-toggle="modal" data-bs-target="#modal-dang-ky-nhan-tin">Đăng ký nhận tin <i class="fa fa-chevron-right" aria-hidden="true"></i></button>
				</div>
			</div>
			<div class="col-md-3 col-md-3-3">
				<div class="div-lien-he-3">
					{!!$lienHe!=null?$lienHe->content:''!!}
				</div>
			</div>
			<div class="col-md-3 col-md-3-4">
				<div class="div-lien-he-4">
					{!!$lienHe!=null?$lienHe->css:''!!}
				</div>
			</div>
		</div>
	</div>
</div>

<div class="scroll-top-btn" style="display: block;">
	<i class="fa fa-arrow-up"></i>
	<span class="hover-text">Top</span>
</div>
<div class="link_chat_social position-fixed">
	<!-- 
	<div class="link_chat_email">
		<a href="/lien-he" target="_blank">
			<div class="phone-vr-img-circle">
				<div class="phone-vr-circle-fill"></div>
				<img loading="lazy" src="{{ asset('public/assets/images/email.png') }}" alt="link_chat">
			</div>
		</a>
	</div>
	-->
	@if(!empty($setting->linkedin))
		<div class="link_chat_facebook">
			<a href="{{ $setting->linkedin }}" target="_blank">
				<div class="phone-vr-img-circle">
					<div class="phone-vr-circle-fill"></div>
					<img loading="lazy" src="{{ asset('public/assets/images/linkedin.png') }}" alt="link_chat">
				</div>
			</a>
		</div>
	@endif
	@if(!empty($setting->link_chat_facebook))
		<div class="link_chat_facebook">
			<a href="{{ $setting->link_chat_facebook }}" target="_blank">
				<div class="phone-vr-img-circle">
					<div class="phone-vr-circle-fill"></div>
					<img loading="lazy" src="{{ asset('public/assets/images/link_chat_facebook.png') }}" alt="link_chat">
				</div>
			</a>
		</div>
	@endif
	@if(!empty($setting->link_chat_zalo))
		<div class="link_chat_zalo">
			<a href="{{ $setting->link_chat_zalo }}" target="_blank">
				<div class="phone-vr-img-circle">
					<div class="phone-vr-circle-fill"></div>
					<img loading="lazy" src="{{ asset('public/assets/images/link_chat_zalo.png') }}" alt="link_chat">
				</div>
			</a>
		</div>
	@endif
	@if(!empty(json_decode($setting->phone)))
		<div class="link_call">
			<a href="tel:{{ json_decode($setting->phone)[0] }}" target="_blank">
				<div class="phone-vr-img-circle">
					<div class="phone-vr-circle-fill"></div>
					<img loading="lazy" src="{{ asset('public/assets/images/call.png') }}" alt="link_chat">
				</div>
			</a>
		</div>
	@endif
</div>
<div id="errorModal" class="modal" tabindex="-1" role="dialog">.header-bottom .mobile-menu>.navbar-nav>.nav-item
	<div class="modal-dialog" role="document">
		<div class="modal-content animated zoomIn faster">
			<div class="modal-header modal-header-error">
				<h4 class="modal-title" id="titleError"></h4>
			</div>
			<div class="modal-body">
				<p id="msgError" class="text-center"></p>
			</div>
			<div class="modal-footer" id="btnError">
				<button type='button' class='btn btn-success' data-bs-dismiss='modal'>OK</button>
			</div>
		</div>
	</div>
</div>
<div id="id_load_light" class="div_white_content">
	<div class="white_content">
		<i class="fa fa-refresh fa-spin" style="font-size:50px;color: #fff;"></i>
	</div>
</div>
<div id="id_load_fade" class="black_overlay"></div>
<script type="text/javascript">
	function popup_load_on(){
		document.getElementById('id_load_light').style.display='block';
		document.getElementById('id_load_fade').style.display='block';
	}
	function popup_load_off(){
		document.getElementById('id_load_light').style.display='none';
		document.getElementById('id_load_fade').style.display='none';
	}
</script>
<footer style="background-color: {{ $setting->footer_background_color }}; color: {{ $setting->footer_text_color }}">
	<div class="container">
		<div class="row">
			<div class="col-md-5">
				<div class="info">
					<h3 class="mb-3" style="border-bottom: 2px solid; color: var(--background-color-main)"><span style="font-size: 110%"><strong>{{$setting->company_name}}</strong></span></h3>
					<ul class="contact pt-1" style="font-family: arial, helvetica, sans-serif;">
						@if(json_decode($setting->phone))
							<li class="mt-3">
								<span><i class="fa fa-phone" aria-hidden="true"></i><strong>Điện thoại: </strong>{{ json_decode($setting->phone)[0] }}</span>
							</li>
						@endif
						@if(json_decode($setting->email))
								<li class="mt-3">
									<span><i class="fa fa-envelope" aria-hidden="true"></i><strong>Email: </strong>{{ json_decode($setting->email)[0] }}</span>
								</li>
						@endif
						@if($setting->tax_code)
								<li class="mt-3">
									<span><i class="fa-solid fa-id-card"></i><strong>Mã số thuế: </strong>{{ $setting->tax_code }}</span>
								</li>
						@endif
						@if(!empty(json_decode($setting->address)[0]->{'content'}))
							@foreach(json_decode($setting->address) as $address)
							<li class="mt-3">
								<span><i class="fa-solid fa-map-location-dot"></i><strong>{{ $address->{'name'} }} </strong>{{ $address->{'content'} }}</span>
							</li>
							@endforeach
						@endif
					</ul>
				</div>
			</div>
			<div class="col-md-7">
				<div class="row">
					<div class="col-md-7">
						<div class="row">
							<div class="col-md-6">
								<b class="d-flex">@if(!empty($setting->support_information_title)) {{ $setting->support_information_title }} @else THÔNG TIN HỖ TRỢ @endif</b>
								<div class="support-information">
									@php
										$content = $setting->support_information;
                                        $content = str_replace('images/blog', Config::get('app.PATH_ADMIN').'images/blog', $content);
                                        $content = str_replace('file/doc', Config::get('app.PATH_ADMIN').'file/doc', $content);
                                        $content = str_replace('file/excel', Config::get('app.PATH_ADMIN').'file/excel', $content);
                                        $content = str_replace('file/pdf', Config::get('app.PATH_ADMIN').'file/pdf', $content);
                                        echo $content;
									@endphp
								</div>
							</div>
							<div class="col-md-6">
								<b class="d-flex">@if(!empty($setting->tag_title)) {{ $setting->tag_title }} @else TỪ KHÓA NỔI BẬT @endif</b>
								<div class="tags">
									@php
										$content = $setting->tags;
                                        $content = str_replace('images/blog', Config::get('app.PATH_ADMIN').'images/blog', $content);
                                        $content = str_replace('file/doc', Config::get('app.PATH_ADMIN').'file/doc', $content);
                                        $content = str_replace('file/excel', Config::get('app.PATH_ADMIN').'file/excel', $content);
                                        $content = str_replace('file/pdf', Config::get('app.PATH_ADMIN').'file/pdf', $content);
                                        echo $content;
									@endphp
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-5">
						<div class="mb-3">
							<b>@if(!empty($setting->social_title)) {{ $setting->social_title }} @else Social Network @endif</b>
							<div class="info">
								<ul class="social flex-wrap">
									@if(!empty($setting->facebook))
										<li style="background-color: {{ $setting->icon_background_color }}">
											<a href="{{$setting->facebook}}" aria-label="facebook" style="color: {{ $setting->icon_color }}">
												<i class="fa-brands fa-facebook-f"></i>
											</a>
										</li>
									@endif
									@if(!empty($setting->twitter))
										<li style="background-color: {{ $setting->icon_background_color }}">
											<a href="{{$setting->twitter}}" aria-label="twitter" style="color: {{ $setting->icon_color }}">
												<i class="fa-brands fa-twitter"></i>
											</a>
										</li>
									@endif
									@if(!empty($setting->google))
										<li style="background-color: {{ $setting->icon_background_color }}">
											<a href="{{$setting->google}}" aria-label="google" style="color: {{ $setting->icon_color }}">
												<i class="fa-brands fa-google-plus-g"></i>
											</a>
										</li>
									@endif
									@if(!empty($setting->linkedin))
										<li style="background-color: {{ $setting->icon_background_color }}">
											<a href="{{$setting->linkedin}}" aria-label="linkedin" style="color: {{ $setting->icon_color }}">
												<i class="fa-brands fa-linkedin-in"></i>
											</a>
										</li>
									@endif
									@if(!empty($setting->youtube))
										<li style="background-color: {{ $setting->icon_background_color }}">
											<a href="{{$setting->youtube}}" aria-label="youtube" style="color: {{ $setting->icon_color }}">
												<i class="fa-brands fa-youtube"></i>
											</a>
										</li>
									@endif
									@if(!empty($setting->zalo))
										<li style="background-color: {{ $setting->icon_background_color }}">
											<a href="{{$setting->zalo}}" aria-label="zalo">
												<svg style="fill: {{ $setting->icon_color }}" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" viewBox="0 0 50 50"><path d="M 9 4 C 6.2504839 4 4 6.2504839 4 9 L 4 41 C 4 43.749516 6.2504839 46 9 46 L 41 46 C 43.749516 46 46 43.749516 46 41 L 46 9 C 46 6.2504839 43.749516 4 41 4 L 9 4 z M 9 6 L 15.580078 6 C 12.00899 9.7156859 10 14.518083 10 19.5 C 10 24.66 12.110156 29.599844 15.910156 33.339844 C 16.030156 33.549844 16.129922 34.579531 15.669922 35.769531 C 15.379922 36.519531 14.799687 37.499141 13.679688 37.869141 C 13.249688 38.009141 12.97 38.430859 13 38.880859 C 13.03 39.330859 13.360781 39.710781 13.800781 39.800781 C 16.670781 40.370781 18.529297 39.510078 20.029297 38.830078 C 21.379297 38.210078 22.270625 37.789609 23.640625 38.349609 C 26.440625 39.439609 29.42 40 32.5 40 C 36.593685 40 40.531459 39.000731 44 37.113281 L 44 41 C 44 42.668484 42.668484 44 41 44 L 9 44 C 7.3315161 44 6 42.668484 6 41 L 6 9 C 6 7.3315161 7.3315161 6 9 6 z M 33 15 C 33.55 15 34 15.45 34 16 L 34 25 C 34 25.55 33.55 26 33 26 C 32.45 26 32 25.55 32 25 L 32 16 C 32 15.45 32.45 15 33 15 z M 18 16 L 23 16 C 23.36 16 23.700859 16.199531 23.880859 16.519531 C 24.050859 16.829531 24.039609 17.219297 23.849609 17.529297 L 19.800781 24 L 23 24 C 23.55 24 24 24.45 24 25 C 24 25.55 23.55 26 23 26 L 18 26 C 17.64 26 17.299141 25.800469 17.119141 25.480469 C 16.949141 25.170469 16.960391 24.780703 17.150391 24.470703 L 21.199219 18 L 18 18 C 17.45 18 17 17.55 17 17 C 17 16.45 17.45 16 18 16 z M 27.5 19 C 28.11 19 28.679453 19.169219 29.189453 19.449219 C 29.369453 19.189219 29.65 19 30 19 C 30.55 19 31 19.45 31 20 L 31 25 C 31 25.55 30.55 26 30 26 C 29.65 26 29.369453 25.810781 29.189453 25.550781 C 28.679453 25.830781 28.11 26 27.5 26 C 25.57 26 24 24.43 24 22.5 C 24 20.57 25.57 19 27.5 19 z M 38.5 19 C 40.43 19 42 20.57 42 22.5 C 42 24.43 40.43 26 38.5 26 C 36.57 26 35 24.43 35 22.5 C 35 20.57 36.57 19 38.5 19 z M 27.5 21 C 27.39625 21 27.29502 21.011309 27.197266 21.03125 C 27.001758 21.071133 26.819727 21.148164 26.660156 21.255859 C 26.500586 21.363555 26.363555 21.500586 26.255859 21.660156 C 26.148164 21.819727 26.071133 22.001758 26.03125 22.197266 C 26.011309 22.29502 26 22.39625 26 22.5 C 26 22.60375 26.011309 22.70498 26.03125 22.802734 C 26.051191 22.900488 26.079297 22.994219 26.117188 23.083984 C 26.155078 23.17375 26.202012 23.260059 26.255859 23.339844 C 26.309707 23.419629 26.371641 23.492734 26.439453 23.560547 C 26.507266 23.628359 26.580371 23.690293 26.660156 23.744141 C 26.819727 23.851836 27.001758 23.928867 27.197266 23.96875 C 27.29502 23.988691 27.39625 24 27.5 24 C 27.60375 24 27.70498 23.988691 27.802734 23.96875 C 28.487012 23.82916 29 23.22625 29 22.5 C 29 21.67 28.33 21 27.5 21 z M 38.5 21 C 38.39625 21 38.29502 21.011309 38.197266 21.03125 C 38.099512 21.051191 38.005781 21.079297 37.916016 21.117188 C 37.82625 21.155078 37.739941 21.202012 37.660156 21.255859 C 37.580371 21.309707 37.507266 21.371641 37.439453 21.439453 C 37.303828 21.575078 37.192969 21.736484 37.117188 21.916016 C 37.079297 22.005781 37.051191 22.099512 37.03125 22.197266 C 37.011309 22.29502 37 22.39625 37 22.5 C 37 22.60375 37.011309 22.70498 37.03125 22.802734 C 37.051191 22.900488 37.079297 22.994219 37.117188 23.083984 C 37.155078 23.17375 37.202012 23.260059 37.255859 23.339844 C 37.309707 23.419629 37.371641 23.492734 37.439453 23.560547 C 37.507266 23.628359 37.580371 23.690293 37.660156 23.744141 C 37.739941 23.797988 37.82625 23.844922 37.916016 23.882812 C 38.005781 23.920703 38.099512 23.948809 38.197266 23.96875 C 38.29502 23.988691 38.39625 24 38.5 24 C 38.60375 24 38.70498 23.988691 38.802734 23.96875 C 39.487012 23.82916 40 23.22625 40 22.5 C 40 21.67 39.33 21 38.5 21 z"></path></svg>
											</a>
										</li>
									@endif
								</ul>
							</div>
						</div>
						<div class="mb-3">
							@if(!empty($setting->announced))
								<b>Thông báo</b>
								<div class="announced row align-items-center">
									<div class="col-7">
										<a href="{{ $setting->announced }}">
											<img loading="lazy" src="{{ asset('public/assets/images/da-thong-bao-bo-cong-thuong.png') }}" alt="announced">
										</a>
									</div>
								</div>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Đăng nhập</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
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
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl justify-content-center">
		<div class="modal-content" style="width: auto">
			<div class="modal-body">
				<img src="#" alt="Ảnh phóng to" id="modalImage" class="img-fluid">
			</div>
		</div>
	</div>
</div>

<!-- modal-yeu-cau-bao-gia -->
<div class="modal" id="modal-yeu-cau-bao-gia">
	<div class="modal-dialog modal-lg">
			<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">YÊU CẦU BÁO GIÁ</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>

			<!-- Modal body -->
			<div class="modal-body">
				<p>
					Bạn đang băn khoăn về việc lựa chọn mặt bằng và không gian cho văn phòng mới ? Hãy liên hệ với chúng tôi để được nhận tư vấn kịp thời.
				</p>
				<form id="form-yeu-cau-bao-gia" action="" name="" method="POST" enctype="multipart/form-data">
					{!! csrf_field() !!}
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<input type="text" class="form-control" name="fullname" placeholder="HỌ VÀ TÊN">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<input type="text" class="form-control" name="email" placeholder="EMAIL CỦA BẠN">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<input type="text" class="form-control" name="phone" placeholder="SỐ ĐIỆN THOẠI">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<input type="text" class="form-control" name="message" placeholder="LỜI NHẮN">
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<button type="button" class="btn-dang-ky" onclick="submitYeuCauBaoGia()">ĐĂNG KÝ</button>
							</div>
						</div>
					</div>
				</form>
			</div>

			<!-- Modal footer -->
			<div class="modal-footer">
			</div>

		</div>
	</div>
</div>

<!-- modal-dang-ky-nhan-tin -->
<div class="modal" id="modal-dang-ky-nhan-tin">
	<div class="modal-dialog modal-lg">
			<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">ĐĂNG KÝ NHẬN BẢN TIN</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>

			<!-- Modal body -->
			<div class="modal-body">
				<form id="form-dang-ky-nhan-tin" action="" name="" method="POST" enctype="multipart/form-data">
					{!! csrf_field() !!}
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<input type="text" class="form-control" name="email" placeholder="EMAIL CỦA BẠN">
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<button type="button" class="btn-dang-ky" onclick="submitDangKyNhanBanTin()">ĐĂNG KÝ</button>
							</div>
						</div>
					</div>
				</form>
			</div>

			<!-- Modal footer -->
			<div class="modal-footer">
			</div>

		</div>
	</div>
</div>

<!-- start js include path -->
<script src="{{asset('public/assets/js/jquery.min.js')}}"></script>
<script src="{{asset('public/assets/js/swiper-bundle.min.js')}}"></script>

<!-- bootstrap -->
<script src="{{asset('public/assets/js/bootstrap.min.js')}}"></script>

<!-- validate js -->
<script src="{{asset('public/assets/js/jquery.validate.min.js')}}"></script>
<script src="{{asset('public/assets/js/additional-methods.min.js')}}"></script>

<!--Owl Carousel  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<script>
	function submitYeuCauBaoGia(){
		popup_load_on();
		var form_data = new FormData($("#form-yeu-cau-bao-gia")[0]);
		$.ajax({
			url: "{{url('/submitYeuCauBaoGia')}}",
			data: form_data,
			type: 'POST',
			contentType: false,
			processData: false,
			success: function (result) {
				console.log(result);
				popup_load_off();
				if(result.status == 'true'){
					alert(result.message);
					window.location.reload();
				}else{
					alert(result.message);
					/* window.location.reload(); */
				}
			}
		});
	}
	function submitDangKyNhanBanTin(){
		popup_load_on();
		var form_data = new FormData($("#form-dang-ky-nhan-tin")[0]);
		$.ajax({
			url: "{{url('/submitDangKyNhanBanTin')}}",
			data: form_data,
			type: 'POST',
			contentType: false,
			processData: false,
			success: function (result) {
				console.log(result);
				popup_load_off();
				if(result.status == 'true'){
					alert(result.message);
					window.location.reload();
				}else{
					alert(result.message);
					/* window.location.reload(); */
				}
			}
		});
	}

	$(document).ready(function() {
		$('Header .menu ul li .toggle_child').on('click', function () {
			$(this).siblings('ul.sub-menu').toggle();
		});
		$('.bar_toggle').on('click', function () {
			$('Header .menu').toggle();
		});
		$('.search_toggle').on('click', function () {
			$('Header .search').toggle();
		});
		// Show or hide the scroll top button based on scroll position
		$(window).scroll(function() {
			if ($(this).scrollTop() > 100) {
				$('.scroll-top-btn').fadeIn();
			} else {
				$('.scroll-top-btn').fadeOut();
			}
		});

		// Scroll to the top when the button is clicked
		$('.scroll-top-btn').click(function() {
			$('html, body').animate({ scrollTop: 0 }, 100);
			return false;
		});

		$(".nav-item.dropdown").hover(
			function () {
				if ($(window).width() >= 991) {
					$(this).addClass("show");
					$(this).children(".dropdown-menu").addClass("show");
				}
			},
			function () {
				if ($(window).width() >= 991) {
					$(this).removeClass("show");
					$(this).children(".dropdown-menu").removeClass("show");
				}
			}
		);

		$(".navbar-toggler").on("click", function () {
			$(".overlay").toggleClass("active");
			$(".mobile-menu").toggleClass("active");
		});

		$(".overlay").on("click", function () {
			$(".overlay").removeClass("active");
			$(".mobile-menu").removeClass("active");
		});

		$(".dropdown .dropdown-menu").click(function(event) {
			event.stopPropagation();
		});

		$(".dropdown").click(function(event) {
			if ($(window).width() < 991) {
				event.preventDefault();
				$(this).siblings().removeClass("show");
				$(this).siblings().find(".dropdown-menu").removeClass("show");

				$(this).toggleClass("show");
				$(this).children(".dropdown-menu").toggleClass("show");
			}
		});

		$('.btn-dang-nhap-user').on('click', function() {
			$('#loginModal').modal('show');
		});

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
							var previousPage = window.location.href;
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

		$("#loginModal .close").on("click", function () {
			$('#loginModal').modal('hide');
		})

		$('.image-link').on('click', function() {
			var imageSrc = $(this).data('image-src');
			$('#modalImage').attr('src', imageSrc);
			$('#imageModal').modal('show');
		});

		//
		let header = $(".header-top");
		let headerHeight = header.outerHeight();
		let isFixed = false;

		$(window).scroll(function() {
			let currentScrollPos = $(window).scrollTop();
			if (currentScrollPos > 60 && currentScrollPos < headerHeight) {
				header.css('top', '-90px')
			}
			if (currentScrollPos > headerHeight && !isFixed) {
				header.removeClass('top').addClass('fixed');
				header.css('top', 0)
				isFixed = true;
			} else if (currentScrollPos <= headerHeight && isFixed) {
				header.removeClass('fixed').addClass('top');
				isFixed = false;
			}
		});
	});
</script>
<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<script type="text/javascript">
	function getCurrentDomain() {
		const currentUrl = window.location.href;
		const url = new URL(currentUrl);
		const parts = url.hostname.split('.');
		if (parts.length >= 2) {
			return parts[parts.length - 2] + '.' + parts[parts.length - 1];
		} else {
			return url.hostname;
		}
	}

	function setCookie(key, value, expiry, domain) {
		const expires = new Date();
		expires.setTime(expires.getTime() + (expiry * 24 * 60 * 60 * 1000));
		document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
		document.cookie = key + '=' + value + ';expires=' + expires.toUTCString() + ';domain=.' + domain;
	}

	function googleTranslateElementInit() {
		const currentDomain = getCurrentDomain();
		setCookie('googtrans', `/vi/{{ $lang }}`, 1, currentDomain);
		new google.translate.TranslateElement({
			pageLanguage: 'vi',
			layout: google.translate.TranslateElement.InlineLayout.VERTICAL
		}, 'google_translate_element');
	}

	window.onload = function() {
		googleTranslateElementInit();
	};
</script>
@yield('scripts')

<!-- seo script -->
{!! $seoSetting->footer_script !!}
</body>
</html>
