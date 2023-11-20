@extends('layouts.modal')

@section('modal-body')
    <div class="form-group row">
        <label class="col-3 col-form-label">{{ __('Nama') }}</label>
        <div class="col-9 parent-group">
            <input name="name" class="form-control" disabled value="{{ $record->name }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-3 col-form-label">{{ __('Keterangan') }}</label>
        <div class="col-9 parent-group">
            <textarea name="description" class="form-control" disabled>{!! $record->description !!}</textarea>
        </div>
    </div>
@endsection

@section('buttons')
@endsection
