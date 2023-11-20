@if (request()->header('Base-Replace-Content'))
	<script>
		window.location.reload();
	</script>
@else
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="utf-8" />
        <title>{{ !empty($title) ? $title.' | '.config('app.name') : config('app.name') }}</title>
        <meta name="debug" content="{{ config('app.debug') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="base-url" content="{{ yurl('/') }}">
        <meta name="replace" content="1">
        <meta name="author" content="PT Pragma Informatika" />
        <meta name="description" content="Aplication by PT Pragma Informatika" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <link rel="shortcut icon" href="{{ '/'.(('base.logo.favicon')) }}" />
        <link rel="stylesheet" href="{{ ('/assets/css/fonts/poppins/all.css') }}">
        <link rel="stylesheet" href="{{ (('/assets/css/plugins.bundle.css')) }}">
        <link rel="stylesheet" href="{{ (('/assets/css/theme.bundle.css')) }}">
        <link rel="stylesheet" href="{{ (('/assets/css/theme.skins.bundle.css')) }}">
        <link rel="stylesheet" href="{{ (('/assets/css/base.bundle.css')) }}">
        <link rel="stylesheet" href="{{ (('/assets/css/modules.bundle.css')) }}">
        <style>
            body {
                background-color: white;
            }
        </style>
	</head>
	<body id="kt_body" class="header-fixed header-mobile-fixed page-loading">
		<div class="no-body-clear page-loader page-loader-default fade-out">
            <div class="blockui">
                <span>Please wait...</span>
                <span><div class="spinner spinner-primary"></div></span>
            </div>
        </div>

		<div class="d-flex flex-column flex-root align-items-center justify-content-center">
		    <div class="login login-1 login-signin-on d-flex flex-column flex-lg-row" id="kt_login">
		        <div class="d-flex flex-column flex-row-fluid position-relative p-7 overflow-hidden">
					<div class="d-flex flex-column align-items p-5">
						<div class="text-center">
							<img src="{{ '/'.(config('base.logo.auth')) }}" alt="Image" style="max-width: 500px; max-height: 90px">
						</div>
						<div class="text-center">
							<h1 class="font-size-h1 font-weight-boldest"  style="color:#6f55d0;"><b>E-AUDIT SPI</b></h1>
							<h1 class="font-size-h3 font-weight-boldest"  style="color:#6f55d0;">
								<b>
									APLIKASI SISTEM INFORMASI MANAJEMEN AUDIT<br>
									SATUAN PENGAWAS INTERN - PERUMDA TIRTA PATRIOT
								</b>
							</h1>
						</div>
					</div>
		            <div class="d-flex flex-column-fluid flex-center mt-10 mt-lg-0">
		                <div class="card rounded-xl shadow">
		                    <div class="card-body p-0">
		                        <div class="d-flex">
		                            <div class="p-10">
		                                @yield('content')
		                            </div>
		                        </div>
		                    </div>
		                </div>
		            </div>

		            <div class="d-flex flex-column align-items-center p-5">
		                <div class="order-2 order-sm-1 my-2" style="color:#6f55d0;font-weight:600;">
							© SPI {{ config('base.app.name') }} 2023
		                </div>
		                <div class="d-flex order-1 order-sm-2 my-2" style="color:#6f55d0;font-weight:600;">
		                    {{ config('base.app.copyright') }}
		                </div>
		            </div>

		        </div>
		    </div>
		</div>

		<script src="{{ (('/assets/js/plugins.bundle.js')) }}"></script>
        {{-- <script src="{{ ('/assets/js/theme.config.js')) }}"></script> --}}
        <script src="{{ (('/assets/js/theme.bundle.js')) }}"></script>
        <script src="{{ (('/assets/js/base.bundle.js')) }}"></script>
        <script src="{{ (('/assets/js/modules.bundle.js')) }}"></script>
		@stack('scripts')
	</body>
	</html>
@endif
