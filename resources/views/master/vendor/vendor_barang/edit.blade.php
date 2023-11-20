@extends('layouts.modal')

@section('action', route($routes . '.update', $record->id))

@section('modal-body')
    @method('PATCH')
    <div class="row">
        <div class="col-sm-12 col-sm-12">
            <div class="form-group row">
                <label class="col-sm-12 col-md-3 col-form-label">{{ __('ID Vendor') }}</label>
                <div class="col-sm-12 col-md-9 parent-group">
                    <input type="text" name="id_vendor" value="{{ $record->id_vendor }}" class="form-control"
                        placeholder="{{ __('ID Vendor') }}" readonly>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-sm-12">
            <div class="form-group row">
                <label class="col-sm-12 col-md-3 col-form-label">{{ __('Vendor') }}</label>
                <div class="col-sm-12 col-md-9 parent-group">
                    <input type="text" name="name" class="form-control" value="{{ $record->name }}"
                        @if ($record->status === '3' || $record->status === '2') readonly @endif placeholder="{{ __('Vendor') }}">
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-sm-12">
            <div class="form-group row">
                <label class="col-sm-12 col-md-3 col-form-label">{{ __('Alamat') }}</label>
                <div class="col-sm-12 col-md-9 parent-group">
                    <textarea type="text" name="address" class="form-control" placeholder="{{ __('Alamat') }}">{{ $record->address }}</textarea>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-sm-12">
            <div class="form-group row">
                <label class="col-sm-12 col-md-3 col-form-label">{{ __('Telepon') }}</label>
                <div class="col-sm-12 col-md-9 parent-group">
                    <input type="tel" name="telp" class="form-control" value="{{ $record->telp }}"
                        placeholder="{{ __('Telepon') }}" pattern="[0-9]{4}[0-9]{4}-[0-9]{0,7}">
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-sm-12">
            <div class="form-group row">
                <label class="col-sm-12 col-md-3 col-form-label">{{ __('Email') }}</label>
                <div class="col-sm-12 col-md-9 parent-group">
                    <input type="email" name="email" class="form-control" value="{{ $record->email }}"
                        placeholder="{{ __('Email') }}">
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-sm-12">
            <div class="form-group row">
                <label class="col-sm-12 col-md-3 col-form-label">{{ __('Contact Person') }}</label>
                <div class="col-sm-12 col-md-9 parent-group">
                    <input type="text" name="contact_person" value="{{ $record->contact_person }}" class="form-control"
                        placeholder="{{ __('Contact Person') }}">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('master.vendor_barang.include.scripts')
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.content-page').on('change', '.name', function() {
                let name = $(this).val()
                $('.nama_pemilik').val(name)
            })
        })
    </script>
@endpush
