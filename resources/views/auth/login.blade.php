{{-- {{ dd(session('remember_username'), $remember_username) }} --}}
@extends('layouts.auth')
@section('content')
    <div class="login-form login-signin">
        <form class="form" method="POST" action="{{ rut('login') }}">
            @csrf
            <div class="form-group">
                <label class="font-weight-bolder">{{ __('Username / Email') }}</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror @error('username') is-invalid @enderror"
                    value="{{ session('remember_username') ?? old('username') }}"
                    placeholder="{{ __('Masukkan Username / Email') }}" name="username" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label class="font-weight-bolder">{{ __('Password') }}</label>
                <div class="input-group">
                    <input class="form-control @error('password') is-invalid @enderror" id="pwCtrl" type="password"
                        placeholder="{{ __('Masukkan Password') }}" name="password" autocomplete="off" />
                    <button type="button" id="togglePassword" class="btn btn-outline-secondary" onclick="togglePasswordVisibility()" tabindex="-1">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label class="font-weight-bolder">Captcha</label>
                {{-- {!! captcha_img() !!} --}}
                {!! getCaptchaBox('captcha') !!}
                {{-- {{ $errors }} --}}
                {{-- {{ $errors->captcha }} --}}
                {{-- {{ $errors->get('captcha')[0]??'' }} --}}
                {{-- <input id="captcha" name="captcha" class="form-control @error('captcha') is-invalid @enderror"
                    placeholder="Captcha" autocomplete="off"> --}}
                @if ($errors->get('captcha')[0] ?? null)
                    {{-- @error('captcha') --}}
                    <span style="color: #F64E60; font-weight: 400; font-size: 10.8px">
                        <strong>{{ $errors->get('captcha')[0] ?? '' }}</strong>
                    </span>
                    {{-- @enderror --}}
                @endif
            </div>

            <div class="form-group">
                <label class="checkbox">
                    <input type="checkbox" name="remember"
                        {{ session('remember_username') != '' || old('remember') ? 'checked' : '' }}>
                    <span class="mr-2"></span>{{ \Base::trans('Remember Me') }}
                </label>
            </div>

            <div class="form-group d-flex flex-wrap justify-content-between align-items-center">
                <button type="submit" class="btn btn-info btn-block font-weight-bold my-3 py-3">
                    {{ \Base::trans('Masuk') }}
                </button>
                @if (Route::has('password.request'))
                    <a href="{{ rut('password.request') }}"
                        class="w-100 text-center text-dark-50 text-hover-danger my-3 mr-2">
                        {{ \Base::trans('Lupa Password?') }}
                    </a>
                @endif
            </div>
        </form>
    </div>
@endsection

@if (session('remember_username') != '')
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#pwCtrl').focus();
            });
        </script>
    @endpush
@endif

@push('scripts')
<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('pwCtrl');
        const togglePassword = document.getElementById('togglePassword');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            togglePassword.innerHTML = '<i class="fas fa-eye-slash"></i>';
        } else {
            passwordInput.type = 'password';
            togglePassword.innerHTML = '<i class="fas fa-eye"></i>';
        }
    }
</script>
@endpush



