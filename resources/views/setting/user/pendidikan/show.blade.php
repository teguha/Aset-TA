@extends('layouts.modal')

@section('modal-body')
	@method('POST')
	
    <div class="form-group row">
		<label class="col-sm-3 col-form-label">{{ __('Jenjang Pendidikan') }}</label>
		<div class="col-sm-9 parent-group">
			<select name="jenjang_pendidikan" class="form-control base-plugin--select2"
				placeholder="{{ __('Pilih Salah Satu') }}" disabled>
				<option @if($detail->jenjang_pendidikan == "SMA/SMK") selected @endif value="SMA/SMK">SMA/SMK</option>
				<option @if($detail->jenjang_pendidikan == "D-1") selected @endif value="D-1">D-1</option>
				<option @if($detail->jenjang_pendidikan == "D-2") selected @endif value="D-2">D-2</option>
				<option @if($detail->jenjang_pendidikan == "D-3") selected @endif value="D-3">D-3</option>
				<option @if($detail->jenjang_pendidikan == "S-1") selected @endif value="S-1">S-1</option>
				<option @if($detail->jenjang_pendidikan == "S-2, Master") selected @endif value="S-2, Master">S-2, Master</option>
				<option @if($detail->jenjang_pendidikan == "S-3, Phd, Dr") selected @endif value="S-3, Phd, Dr">S-3, Phd, Dr</option>
			</select>
		</div>
	</div>
    <div class="form-group row">
		<label class="col-sm-3 col-form-label">{{ __('Institusi Pendidikan') }}</label>
		<div class="col-sm-9 parent-group">
			<input type="text" name="institute" class="form-control" placeholder="{{ __('Institusi Pendidikan') }}" value="{{$detail->institute}}" disabled>
		</div>
	</div>
    <div class="form-group row">
		<label class="col-sm-3 col-form-label">{{ __('Tahun Lulus') }}</label>
		<div class="col-sm-9 parent-group text-left">
			<input type="text" name="thn_lulus" class="form-control base-plugin--datepicker-3 width-200px mr-auto text-left" placeholder="{{ __('Tahun Lulus') }}" value="{{$detail->thn_lulus}}" disabled>
		</div>
	</div>
    <div class="form-group row">
		<label class="col-md-3 col-form-label">{{ __('Keterangan') }}</label>
		<div class="col-md-9 parent-group">
			<textarea name="description" class="form-control" placeholder="{{ __('Keterangan') }}" disabled>{{$detail->description}}</textarea>
		</div>
	</div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">{{ __('Lampiran') }}</label>
        <div class="col-sm-9 parent-group">
			@foreach ($detail->files($module)->where('flag', 'lampiran_pendidikan')->get() as $file)
				<div class="progress-container w-100" data-uid="{{ $file->id }}">
					<div class="alert alert-custom alert-light fade show py-2 px-4 mb-0 mt-2 success-uploaded" role="alert">
						<div class="alert-icon">
							<i class="{{ $file->file_icon }}"></i>
						</div>
						<div class="alert-text text-left">
							<input type="hidden"
								name="attachments[files_ids][]"
								value="{{ $file->id }}">
							<div>Uploaded File:</div>
							<a href="{{ $file->file_url }}" target="_blank" class="text-primary">
								{{ $file->file_name }}
							</a>
						</div>
						<div class="alert-close">
							<button type="button"
								class="close base-form--remove-temp-files"
								data-toggle="tooltip"
								data-original-title="Remove">
								<span aria-hidden="true">
									<i class="ki ki-close"></i>
								</span>
							</button>
						</div>
					</div>
				</div>
			@endforeach
        </div>
    </div>
@endsection

@section('buttons')
@endsection



