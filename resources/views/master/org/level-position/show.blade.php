@extends('layouts.modal')

@section('modal-body')
	<div class="form-group row">
		<label class="col-md-12 col-form-label">{{ __('Nama') }}</label>
		<div class="col-md-12 parent-group">
			<input type="text" value="{{ $record->name }}" class="form-control" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-12 col-form-label">{{ __('Deskripsi') }}</label>
		<div class="col-md-12 parent-group">
			<textarea name="description" class="form-control" disabled>{!! $record->description !!}</textarea>
		</div>
	</div>
@endsection

@section('buttons')
@endsection
