@extends('layouts.modal')

@section('action', rut($routes.'.update', $record->id))

@section('modal-body')
	@method('PATCH')
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Struktur') }}</label>
		<div class="col-sm-12 parent-group">
			<select name="location_id" class="form-control base-plugin--select2-ajax"
				data-url="{{ route('ajax.selectStruct', ['search' => 'position_with_req']) }}"
                data-url-origin="{{ route('ajax.selectStruct', ['search' => 'position_with_req']) }}"
				data-placeholder="{{ __('Pilih Salah Satu') }}">
				<option value="{{ $record->location->id }}" selected>{{ $record->location->name }}</option>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Level Jabatan') }}</label>
		<div class="col-sm-12 parent-group">
			<select name="level_id" class="form-control base-plugin--select2-ajax"
				data-url="{{ route('ajax.selectLevelPosition', ['search' => 'all']) }}"
                data-url-origin="{{ route('ajax.selectLevelPosition', ['search' => 'all']) }}"
				data-placeholder="{{ __('Pilih Salah Satu') }}">
				@if($record->level)
				<option value="{{ $record->level->id }}" selected>{{ $record->level->name }}</option>
				@endif
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Nama') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" name="name" value="{{ $record->name }}" class="form-control" placeholder="{{ __('Nama') }}">
		</div>
	</div>
@endsection
