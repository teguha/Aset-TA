@if (!request()->header('Base-Replace-Content'))
    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8" />
        <title>{{ !empty($title) ? $title . ' | ' . config('app.name') : config('app.name') }}</title>
        <meta name="debug" content="{{ config('app.debug') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="base-url" content="{{ yurl('/') }}">
        <meta name="replace" content="1">
        <meta name="author" content="PT Pragma Informatika" />
        <meta name="description" content="Aplication by PT Pragma Informatika" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <link rel="shortcut icon" href="{{ '/' . config('base.logo.favicon') }}" />
        <link rel="stylesheet" href="{{ '/assets/css/fonts/poppins/all.css' }}">
        <link rel="stylesheet" href="{{ '/assets/css/plugins.bundle.css' }}">
        <link rel="stylesheet" href="{{ '/assets/css/theme.bundle.css' }}">
        <link rel="stylesheet" href="{{ '/assets/css/theme.skins.bundle.css' }}">
        <link rel="stylesheet" href="{{ '/assets/css/base.bundle.css' }}">
        <link rel="stylesheet" href="{{ '/assets/css/modules.bundle.css' }}">

        <script src="{{ '/assets/js/plugins.bundle.js' }}"></script>
    </head>

    <body id="kt_body"
        class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable {{ !empty($sidebarMini) ? 'aside-minimize' : '' }} page-loading">

        <div class="no-body-clear page-loader page-loader-default fade-out">
            <div class="blockui">
                <span>Please wait...</span>
                <span>
                    <div class="spinner spinner-primary"></div>
                </span>
            </div>
        </div>

        <div id="kt_header_mobile" class="no-body-clear header-mobile align-items-center header-mobile-fixed">
            <a href="index.html">
                <img src="{{ '/' . config('base.logo.aside') }}" height="30px" alt="logo">
            </a>
            <div class="d-flex align-items-center">
                <button class="btn burger-icon burger-icon-left p-0" id="kt_aside_mobile_toggle">
                    <span></span>
                </button>
                @if (auth()->check())
                    <button class="btn btn-hover-text-primary ml-2 p-0" id="kt_header_mobile_topbar_toggle">
                        <img src="{{ '/' . auth()->user()->image_path }}" class="img-circle" height="30px">
                    </button>
                @endif
            </div>
        </div>

        <div class="no-body-clear d-flex flex-column flex-root">
            <div class="d-flex flex-column-fluid flex-row">
                @include('layouts.base.aside')

                <div id="wrapper" class="d-flex flex-column flex-row-fluid wrapper">
                    @include('layouts.base.header')
                    <div id="content" class="content d-flex flex-column flex-column-fluid">
                        <div id="content-page" class="content-page" data-sidebar-mini="{{ $sidebarMini ?? 0 }}"
                            data-module="{{ $module ?? '' }}">
                            @stack('styles')
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="kt_scrolltop" class="no-body-clear scrolltop">
            {!! Base::getSVG('assets/media/svg/icons/Navigation/Up-2.svg') !!}
        </div>
        <div id="base_script" class="no-body-clear">
            <script>
                BaseAppLang = {!! json_encode(__('base'), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!};
            </script>
            <script src="{{ '/assets/js/theme.bundle.js' }}"></script>
            <script src="{{ '/assets/js/base.bundle.js' }}"></script>
            <script src="{{ '/assets/js/modules.bundle.js' }}"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
            <script>
                $(function() {
                    $('body').removeClass('content-loading');
                });
            </script>
        </div>
        @stack('scripts')
    </body>

    </html>
@else
    <div id="content-page" class="content-page" data-sidebar-mini="{{ $sidebarMini ?? 0 }}"
        data-module="{{ $module ?? '' }}">
        @stack('styles')
        @yield('content')
        <div class="base-content--state"
            data-title="{{ !empty($title) ? $title . ' | ' . config('app.name') : config('app.name') }}"
            data-url="{{ in_array(env('APP_ENV'), ['production', 'staging']) ? str_replace('10.11.12.219', 'audit.spi.tirtapatriot.net', ) : url()->full() }}"
            data-csrf-token="{{ csrf_token() }}"
            data-last-user-notification="{{ auth()->user()->getLastNotificationId() }}">
            <script>
                if (!document.getElementById('kt_body')) {
                    document.getElementById("content-page").style.display = "none";
                    window.location.reload();
                }
            </script>
        </div>
        @stack('scripts')
    </div>
@endif
