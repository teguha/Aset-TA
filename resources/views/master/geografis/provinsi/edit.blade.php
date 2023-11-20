@extends('layouts.modal')

@section('action', rut($routes.'.update', $record->id))

@section('modal-body')
	@method('PUT')
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Provinsi') }} <span class="text-danger"> *</span> </label>
		<div class="col-sm-12 parent-group">
			<input type="text" name="name" value="{{ $record->name }}" class="form-control" placeholder="{{ __('Provinsi') }}" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Kode') }} <span class="text-danger"> *</span> </label>
		<div class="col-sm-12 parent-group">
			<input type="number" name="code" value="{{ $record->code }}" class="form-control" required placeholder="{{ __('Kode') }}">
		</div>
	</div>
@endsection
