@extends('layouts.modal')

@section('action', rut($routes.'.update', $record->id))

@section('modal-body')
	@method('PATCH')
	<div class="form-group row">
		<label class="col-md-12 col-form-label">{{ __('Nama') }}</label>
		<div class="col-md-12 parent-group">
			<input type="text" name="name" class="form-control" maxlength="50" placeholder="{{ __('Nama') }}" value="{{ $record->name }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-12 col-form-label">{{ __('Deskripsi') }}</label>
		<div class="col-md-12 parent-group">
			<textarea name="description"
				class="form-control"
				placeholder="{{ __('Deskripsi') }}">{!! $record->description !!}</textarea>
		</div>
	</div>
@endsection
