@extends('layouts.modal')

@section('modal-body')
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Struktur') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" value="{{ $record->location->name ?? '' }}" class="form-control" placeholder="{{ __('Struktur') }}"  disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Level Jabatan') }}</label>
		<div class="col-sm-12 parent-group">
			<select name="level_id" class="form-control base-plugin--select2-ajax"
				data-url="{{ route('ajax.selectLevelPosition', ['search' => 'all']) }}"
                data-url-origin="{{ route('ajax.selectLevelPosition', ['search' => 'all']) }}"
				data-placeholder="{{ __('Pilih Salah Satu') }}" disabled>
				@if($record->level)
				<option value="{{ $record->level->id }}" selected>{{ $record->level->name }}</option>
				@endif
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Nama') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" value="{{ $record->name }}" class="form-control" placeholder="{{ __('Nama') }}" disabled>
		</div>
	</div>
@endsection

@section('buttons')
@endsection