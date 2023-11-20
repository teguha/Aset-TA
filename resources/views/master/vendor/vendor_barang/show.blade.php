@extends('layouts.modal')

@section('modal-body')
@method('PATCH')
    <div class="row">
        <div class="col-sm-12 col-sm-12">
            <div class="form-group row">
                    <label class="col-sm-12 col-md-3 col-form-label">{{ __('ID Vendor') }}</label>
                    <div class=" col-sm-12 col-md-9 parent-group">
                        <input type="text" name="id_vendor" class="form-control" value="{{ $record->id_vendor }}" placeholder="{{ __('ID Vendor') }}" disabled>
                    </div>
            </div>
        </div>
        <div class="col-sm-12 col-sm-12">
            <div class="form-group row">
                <label class="col-sm-12 col-md-3 col-form-label">{{ __('Vendor') }}</label>
                <div class=" col-sm-12 col-md-9 parent-group">
                    <input type="text" name="name" class="form-control" value="{{ $record->name }}" readonly  placeholder="{{ __('Vendor') }}">
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-sm-12">
                         <div class="form-group row">
                <label class="col-sm-12 col-md-3 col-form-label">{{ __('Alamat') }}</label>
                <div class="col-sm-12 col-md-9 parent-group">
                    <textarea type="text" name="address" class="form-control"  placeholder="{{ __('Alamat') }}" disabled>{{ $record->address }}</textarea>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-sm-12">
            <div class="form-group row">
                <label class="col-sm-12 col-md-3 col-form-label">{{ __('Telepon') }}</label>
                <div class="col-sm-12 col-md-9 parent-group">
                    <input type="tel" name="telp" class="form-control" value="{{ $record->telp}}" readonly placeholder="{{ __('Telepon') }}"
                        pattern="[0-9]{4}[0-9]{4}-[0-9]{0,7}">
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-sm-12">
            <div class="form-group row">
                <label class="col-sm-12 col-md-3 col-form-label">{{ __('Email') }}</label>
                <div class="col-sm-12 col-md-9 parent-group">
                    <input type="email" name="email" class="form-control" value="{{ $record->email }}" readonly placeholder="{{ __('Email') }}">
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-sm-12">
            <div class="form-group row">
                <label class="col-sm-12 col-md-3 col-form-label">{{ __('Contact Person') }}</label>
                <div class="col-sm-12 col-md-9 parent-group">
                    <input type="text" name="contact_person" value="{{ $record->contact_person }}" class="form-control"  readonly
                        placeholder="{{ __('Contact Person') }}">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('buttons')
@endsection

@push('scripts')
    @include("master.vendor_barang.include.scripts")
@endpush
