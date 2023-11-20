@extends('layouts.modal')

@section('action', rut($routes.'.store'))

@section('modal-body')
	@method('POST')
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Provinsi') }} <span class="text-danger"> *</span> </label>
		<div class="col-sm-12 parent-group">
			<input type="text" name="name" class="form-control" required placeholder="{{ __('Provinsi') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Kode') }} <span class="text-danger"> *</span> </label>
		<div class="col-sm-12 parent-group">
			<input type="number" name="code" class="form-control" required placeholder="{{ __('Kode') }}">
		</div>
	</div>
@endsection
