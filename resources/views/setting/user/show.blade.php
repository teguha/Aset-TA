@extends('layouts.modal')

@section('action', rut($routes.'.update', $record->id))

@section('modal-body')
	@method('PATCH')
	<div class="form-group row">
		<label class="col-md-4 col-form-label">{{ __('Nama') }}</label>
		<div class="col-md-8 parent-group">
			<input type="text" value="{{ $record->name }}" class="form-control" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('NPP') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="number" name="npp" value="{{ $record->npp }}" class="form-control" placeholder="{{ __('NPP') }}" maxlength="16" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Username') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="text" value="{{ $record->username }}" class="form-control" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Email') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="email" value="{{ $record->email }}" class="form-control" disabled>
		</div>
	</div>
    <div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Struktur') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="text" value="{{ $record->position->location->name ?? '' }}" class="form-control" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Jabatan') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="text" value="{{ $record->position->name ?? '' }}" class="form-control" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Hak Akses') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="text" value="{{ implode(', ', $record->roles()->pluck('name')->toArray()) }}" class="form-control" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Status') }}</label>
		<div class="col-sm-8 col-form-label">
			{!! $record->labelStatus() !!}
		</div>
	</div>
@endsection

@section('buttons')
@endsection
