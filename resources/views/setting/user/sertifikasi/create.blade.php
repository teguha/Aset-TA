@extends('layouts.modal')

@section('action', rut($routes.'.sertifikasi.detailStore', $record->id))

@section('modal-body')
	@method('POST')

    <div class="form-group row">
		<label class="col-sm-3 col-form-label">{{ __('Nama Sertifikat') }}</label>
		<div class="col-sm-9 parent-group">
			<input type="text" name="nama_sertif" class="form-control" placeholder="{{ __('Nama Sertifikat') }}">
		</div>
	</div>
    <div class="form-group row">
		<label class="col-sm-3 col-form-label">{{ __('No Sertifikat') }}</label>
		<div class="col-sm-9 parent-group">
			<input type="text" name="no_sertif" class="form-control" placeholder="{{ __('No Sertifikat') }}">
		</div>
	</div>
    <div class="form-group row">
		<label class="col-sm-3 col-form-label">{{ __('Tgl Sertifikat') }}</label>
		<div class="col-sm-9 parent-group text-left">
			<input type="text" name="tgl_sertif" class="form-control base-plugin--datepicker width-200px mr-auto text-left" placeholder="{{ __('Tgl Sertifikat') }}">
		</div>
	</div>
    <div class="form-group row">
		<label class="col-sm-3 col-form-label">{{ __('Lembaga') }}</label>
		<div class="col-sm-9 parent-group">
			<input type="text" name="lembaga" class="form-control" placeholder="{{ __('Lembaga') }}">
		</div>
	</div>
    <div class="form-group row">
		<label class="col-md-3 col-form-label">{{ __('Keterangan') }}</label>
		<div class="col-md-9 parent-group">
			<textarea name="description" class="form-control" placeholder="{{ __('Keterangan') }}"></textarea>
		</div>
	</div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">{{ __('Lampiran') }}</label>
        <div class="col-sm-9 parent-group">
            <div class="custom-file">
                <input type="hidden" name="attachments[uploaded]" class="uploaded" value="0">
                <input type="file" multiple class="custom-file-input base-form--save-temp-files"
                    data-name="attachments" data-container="parent-group" data-max-size="20024"
                    data-max-file="100" accept="*">
                <label class="custom-file-label" for="file">Choose File</label>
            </div>
            <div class="form-text text-muted">*Maksimal 20MB</div>
        </div>
    </div>
@endsection



