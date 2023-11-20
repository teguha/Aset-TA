@extends('layouts.modal')

@section('action', rut($routes.'.store'))

@section('modal-body')
	@method('POST')
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Nama') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="text" name="name" class="form-control" placeholder="{{ __('Nama') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('NPP') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="number" name="npp" class="form-control" placeholder="{{ __('NPP') }}" maxlength="16">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Username') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="text" name="username" class="form-control" placeholder="{{ __('Username') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Email') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="email" name="email" class="form-control" placeholder="{{ __('Email') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Struktur') }}</label>
		<div class="col-sm-8 parent-group">
			<select name="location_id" class="form-control base-plugin--select2-ajax"
				id="strukturCtrl"
				data-url="{{ route('ajax.selectStruct', ['search' => 'position_with_req']) }}"
                data-url-origin="{{ route('ajax.selectStruct', ['search' => 'position_with_req']) }}"
				placeholder="{{ __('Pilih Salah Satu') }}">
				<option value="">{{ __('Pilih Salah Satu') }}</option>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Jabatan') }}</label>
		<div class="col-sm-8 parent-group">
			<select name="position_id" id="jabatanCtrl" class="form-control base-plugin--select2-ajax"
				placeholder="{{ __('Pilih Salah Satu') }}">
				<option value="">{{ __('Pilih Salah Satu') }}</option>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Hak Akses') }}</label>
		<div class="col-sm-8 parent-group">
			<select name="roles[]" class="form-control base-plugin--select2-ajax"
				data-url="{{ rut('ajax.selectRole', 'all') }}"
				placeholder="{{ __('Pilih Salah Satu') }}">
				<option value="">{{ __('Pilih Salah Satu') }}</option>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Password') }}</label>
		<div class="col-sm-8 parent-group">
			<div class="input-group">
				<input type="password" name="password" class="form-control" id="pwCtrl" placeholder="{{ __('Password') }}">
				<button type="button" id="togglePassword" class="btn btn-outline-secondary" onclick="togglePasswordVisibility()" tabindex="-1">
					<i class="fas fa-eye"></i>
				</button>
			</div>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Konfirmasi Password') }}</label>
		<div class="col-sm-8 parent-group">
			<div class="input-group">
				<input type="password" name="password_confirmation" id="pwCtrlConfirmation" class="form-control" placeholder="{{ __('Konfirmasi Password') }}">
				<button type="button" id="togglePasswordConfirmation" class="btn btn-outline-secondary" onclick="togglePasswordVisibilityConfirmation()" tabindex="-1">
					<i class="fas fa-eye"></i>
				</button>
			</div>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Status') }}</label>
		<div class="col-sm-8 parent-group">
			<select name="status" class="form-control base-plugin--select2"
				placeholder="{{ __('Pilih Salah Satu') }}">
				<option value="active" selected>Active</option>
				<option value="nonactive">Non Active</option>
			</select>
		</div>
	</div>
@endsection

@push('scripts')
	<script>
		$(function () {
			$('.content-page')
			.on('change', '#strukturCtrl', function(){
                $.ajax({
                    method: 'GET',
                    url: '{{ yurl('/ajax/jabatan-options') }}',
                    data: {
                        location_id: $(this).val()
                    },
                    success: function(response, state, xhr) {
                        // let options = `<option value='' selected disabled></option>`;
                        let options = `<option disabled selected value=''>Pilih Salah Satu</option>`;
                        for (let item of response) {
                            options += `<option value='${item.id}'>${item.name}</option>`;
                        }
                        $('#jabatanCtrl').select2('destroy');
                        $('#jabatanCtrl').html(options);
                        $('#jabatanCtrl').select2();
                        console.log(54, response, options);
                    },
                    error: function(a, b, c) {
                        console.log(a, b, c);
                    }
                });
            });
		});
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

