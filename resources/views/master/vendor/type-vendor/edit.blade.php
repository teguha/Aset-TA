@extends('layouts.modal')

@section('action', route($routes.'.update', $record->id))

@section('modal-body')
	@method('PATCH')
    <div class="form-group row">
		<label class="col-3 col-form-label">{{ __('Nama') }}</label>
		<div class="col-9 parent-group">
			<input name="name" class="form-control" placeholder="{{ __('Nama') }}" value="{{ $record->name }}">
		</div>
	</div>
    <div class="form-group row">
		<label class="col-3 col-form-label">{{ __('Keterangan') }}</label>
		<div class="col-9 parent-group">
			<textarea name="description" class="form-control" placeholder="{{ __('Keterangan') }}">{!! $record->description !!}</textarea>
		</div>
	</div>
@endsection
