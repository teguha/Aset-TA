@extends('layouts.modal')

@section('action', rut($routes.'.pendidikan.detailStore', $record->id))

@section('modal-body')
	@method('POST')

    <div class="form-group row">
		<label class="col-sm-3 col-form-label">{{ __('Jenjang Pendidikan') }}</label>
		<div class="col-sm-9 parent-group">
			<select name="jenjang_pendidikan" class="form-control base-plugin--select2"
				placeholder="{{ __('Pilih Salah Satu') }}">
				<option value="SMA/SMK">SMA/SMK</option>
				<option value="D-1">D-1</option>
				<option value="D-2">D-2</option>
				<option value="D-3">D-3</option>
				<option value="S-1">S-1</option>
				<option value="S-2, Master">S-2, Master</option>
				<option value="S-3, Phd, Dr">S-3, Phd, Dr</option>
			</select>
		</div>
	</div>
    <div class="form-group row">
		<label class="col-sm-3 col-form-label">{{ __('Institusi Pendidikan') }}</label>
		<div class="col-sm-9 parent-group">
			<input type="text" name="institute" class="form-control" placeholder="{{ __('Institusi Pendidikan') }}">
		</div>
	</div>
    <div class="form-group row">
		<label class="col-sm-3 col-form-label">{{ __('Tahun Lulus') }}</label>
		<div class="col-sm-9 parent-group text-left">
			<input type="text" name="thn_lulus" class="form-control base-plugin--datepicker-3 width-200px mr-auto text-left" placeholder="{{ __('Tahun Lulus') }}">
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



