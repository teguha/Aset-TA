@extends('layouts.modal')

@section('modal-body')
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Provinsi') }} <span class="text-danger"> *</span> </label>
		<div class="col-sm-12 parent-group">
			<input type="text" name="name" value="{{ $record->name }}" class="form-control" placeholder="{{ __('Provinsi') }}" disabled required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Kode') }} <span class="text-danger"> *</span> </label>
		<div class="col-sm-12 parent-group">
			<input type="number" name="code" value="{{ $record->code }}" class="form-control" required placeholder="{{ __('Kode') }}" disabled>
		</div>
	</div>
@endsection

@section('buttons')

@endsection