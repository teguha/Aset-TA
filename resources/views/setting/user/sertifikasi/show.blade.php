@extends('layouts.modal')
@section('modal-body')
	@method('POST')
	
    <div class="form-group row">
		<label class="col-sm-3 col-form-label">{{ __('Nama Sertifikat') }}</label>
		<div class="col-sm-9 parent-group">
			<input type="text" name="nama_sertif" class="form-control" placeholder="{{ __('Nama Sertifikat') }}" value="{{$detail->nama_sertif}}" disabled>
		</div>
	</div>
    <div class="form-group row">
		<label class="col-sm-3 col-form-label">{{ __('No Sertifikat') }}</label>
		<div class="col-sm-9 parent-group">
			<input type="text" name="no_sertif" class="form-control" placeholder="{{ __('No Sertifikat') }}" value="{{$detail->no_sertif}}" disabled>
		</div>
	</div>
    <div class="form-group row">
		<label class="col-sm-3 col-form-label">{{ __('Tgl Sertifikat') }}</label>
		<div class="col-sm-9 parent-group text-left">
			<input type="text" name="tgl_sertif" class="form-control base-plugin--datepicker width-200px mr-auto text-left" placeholder="{{ __('Tgl Sertifikat') }}" value="{{$detail->tgl_sertif->format('d/m/Y')}}" disabled>
		</div>
	</div>
    <div class="form-group row">
		<label class="col-sm-3 col-form-label">{{ __('Lembaga') }}</label>
		<div class="col-sm-9 parent-group">
			<input type="text" name="lembaga" class="form-control" placeholder="{{ __('Lembaga') }}" value="{{$detail->lembaga}}" disabled>
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
            @foreach ($detail->files($module)->where('flag', 'lampiran_sertifikasi')->get() as $file)
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


