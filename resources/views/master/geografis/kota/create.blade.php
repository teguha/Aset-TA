@extends('layouts.modal')
@section('action', rut($routes.'.store'))
@section('modal-body')
@method('POST')
<div class="form-group row">
	<label class="col-md-12 col-form-label">{{ __('Province') }}</label>
	<div class="col-md-12 parent-group">
		<select name="province_id" class="form-control base-plugin--select2-ajax"
			data-url="{{ rut('ajax.selectProvince', [
				'search'=>'all'
			]) }}"
			placeholder="{{ __('Pilih Salah Satu') }}">
			<option value="">{{ __('Pilih Salah Satu') }}</option>
			@if (isset($record) && ($province = $record->province))
				<option value="{{ $province->id }}" selected>{{ $province->name }}</option>
			@endif
		</select>
	</div>
</div>
<div class="form-group row">
	<label class="col-sm-12 col-form-label">{{ __('Kota / Kabupaten') }} <span class="text-danger"> *</span> </label>
	<div class="col-sm-12 parent-group">
		<input type="text" name="name" class="form-control" required placeholder="{{ __('Kota / Kabupaten') }}">
	</div>
</div>
<div class="form-group row">
	<label class="col-sm-12 col-form-label">{{ __('Kode') }} <span class="text-danger"> *</span> </label>
	<div class="col-sm-12 parent-group">
		<input type="number" name="code" class="form-control" required placeholder="{{ __('Kode') }}">
	</div>
</div>
@endsection
