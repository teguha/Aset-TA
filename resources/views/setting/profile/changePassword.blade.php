@extends('layouts.page')

@section('page')
    <div class="d-flex flex-row">
        @include($views.'.includes.profile-aside', ['tab' => 'changePassword'])

        <div class="flex-row-fluid ml-lg-8">
            <div class="card card-custom gutter-b">

                <div class="card-header py-3">
                    <div class="card-title align-items-start flex-column">
                        <h3 class="card-label font-weight-bolder text-dark">{{ __($title) }}</h3>
                        <span class="text-muted font-weight-bold font-size-sm mt-1">{{ __('Informasi Pribadi') }}</span>
                    </div>
                </div>

                <form action="{{ rut($routes.'.updatePassword') }}" method="post" autocomplete="off">
                    @csrf
                    @method('POST')

                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label text-right">{{ __('Password Lama') }}</label>
                            <div class="col-lg-9 col-xl-6 parent-group">
                                <div class="input-group input-group-lg input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="la la-key"></i>
                                        </span>
                                    </div>
                                    <input type="password" class="form-control" id="pwCtrlOld" name="old_password" placeholder="{{ __('Password Lama') }}">
                                    <button type="button" id="togglePasswordOld" class="btn btn-outline-secondary" onclick="togglePasswordVisibilityOld()" tabindex="-1">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label text-right">{{ __('Password Baru') }}</label>
                            <div class="col-lg-9 col-xl-6 parent-group">
                                <div class="input-group input-group-lg input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="la la-key"></i>
                                        </span>
                                    </div>
                                    <input type="password" class="form-control" id="pwCtrl" name="new_password" placeholder="{{ __('Password Baru') }}">
                                    <button type="button" id="togglePassword" class="btn btn-outline-secondary" onclick="togglePasswordVisibility()" tabindex="-1">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label text-right">{{ __('Konfirmasi Password Baru') }}</label>
                            <div class="col-lg-9 col-xl-6 parent-group">
                                <div class="input-group input-group-lg input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="la la-key"></i>
                                        </span>
                                    </div>
                                    <input type="password" class="form-control" id="pwCtrlConfirmation" name="new_password_confirmation" placeholder="{{ __('Konfirmasi Password Baru') }}">
                                    <button type="button" id="togglePasswordConfirmation" class="btn btn-outline-secondary" onclick="togglePasswordVisibilityConfirmation()" tabindex="-1">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        @include('layouts.forms.btnSubmitPage')
                    </div>
                </form>

            </div>
        </div>

    </div>
@endsection



@push('scripts')
	<script>
		function togglePasswordVisibilityOld() {
			const passwordInputOld = document.getElementById('pwCtrlOld');
			const togglePasswordOld = document.getElementById('togglePasswordOld');

			if (passwordInputOld.type === 'password') {
				passwordInputOld.type = 'text';
				togglePasswordOld.innerHTML = '<i class="fas fa-eye-slash"></i>';
			} else {
				passwordInputOld.type = 'password';
				togglePasswordOld.innerHTML = '<i class="fas fa-eye"></i>';
			}
		}
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
		function togglePasswordVisibilityConfirmation() {
			const passwordInputConfirmation = document.getElementById('pwCtrlConfirmation');
			const togglePasswordConfirmation = document.getElementById('togglePasswordConfirmation');

			if (passwordInputConfirmation.type === 'password') {
				passwordInputConfirmation.type = 'text';
				togglePasswordConfirmation.innerHTML = '<i class="fas fa-eye-slash"></i>';
			} else {
				passwordInputConfirmation.type = 'password';
				togglePasswordConfirmation.innerHTML = '<i class="fas fa-eye"></i>';
			}
		}
	</script>
@endpush
