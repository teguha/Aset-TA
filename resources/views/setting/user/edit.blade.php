@extends('layouts.modal')

@section('action', rut($routes.'.update', $record->id))

@section('modal-body')
@method('PATCH')
<div class="form-group row">
	<label class="col-md-4 col-form-label">{{ __('Nama') }}</label>
	<div class="col-md-8 parent-group">
		<input type="text" name="name" value="{{ $record->name }}" class="form-control" placeholder="{{ __('Nama') }}">
	</div>
</div>
<div class="form-group row">
	<label class="col-sm-4 col-form-label">{{ __('NPP') }}</label>
	<div class="col-sm-8 parent-group">
		<input type="number" name="npp" value="{{ $record->npp }}" class="form-control" placeholder="{{ __('NPP') }}" maxlength="16">
	</div>
</div>
<div class="form-group row">
	<label class="col-sm-4 col-form-label">{{ __('Username') }}</label>
	<div class="col-sm-8 parent-group">
		<input type="text" class="form-control" value="{{ $record->username }}" disabled>
	</div>
</div>
<div class="form-group row">
	<label class="col-sm-4 col-form-label">{{ __('Email') }}</label>
	<div class="col-sm-8 parent-group">
		<input type="email" name="email" value="{{ $record->email }}" class="form-control" placeholder="{{ __('Email') }}"
			readonly>
	</div>
</div>
<div class="form-group row">
	<label class="col-sm-4 col-form-label">{{ __('Struktur') }}</label>
	<div class="col-sm-8 parent-group">
		<select name="location_id" class="form-control base-plugin--select2-ajax" id="strukturCtrl"
			data-url="{{ route('ajax.selectStruct', ['search' => 'position_with_req']) }}"
			data-url-origin="{{ route('ajax.selectStruct', ['search' => 'position_with_req']) }}" placeholder="{{ __('Pilih Salah Satu') }}"
			@if($record->position_id == NULL) disabled @endif>
			<option value="">{{ __('Pilih Salah Satu') }}</option>
			<option value="{{ $record->position->location->id }}" selected>{{ $record->position->location->name }}</option>
		</select>
	</div>
</div>

<div class="form-group row">
	<label class="col-sm-4 col-form-label">{{ __('Jabatan') }}</label>
	<div class="col-sm-8 parent-group">
		@if ($record->id ==1)
		<select id="jabatanCtrl" name="position_id" class="form-control base-plugin--select2-ajax"
			data-url="{{ rut('ajax.selectPosition', 'all') }}" data-placeholder="{{ __('Pilih Salah Satu') }}" disabled>
			<option value="">{{ __('Pilih Salah Satu') }}</option>
			@if ($record->position)
			<option value="{{ $record->position->id }}" selected>{{ $record->position->name }}</option>
			@endif
		</select>
		@else
		<select id="jabatanCtrl" name="position_id" class="form-control base-plugin--select2-ajax"
			data-url="{{ rut('ajax.selectPosition', ['search' => 'by_location', 'id' => $record->position->location->id]) }}"
			data-placeholder="{{ __('Pilih Salah Satu') }}">
			<option value="">{{ __('Pilih Salah Satu') }}</option>
			@if ($record->position)
			<option value="{{ $record->position->id }}" selected>{{ $record->position->name }}</option>
			@endif
		</select>
		@endif
	</div>
</div>
<div class="form-group row">
	<label class="col-sm-4 col-form-label">{{ __('Role') }}</label>
	<div class="col-sm-8 parent-group">
		@if($record->id == 1)
		@foreach ($record->roles as $role)
		<input class="d-none" name="roles[]" value="{{ $role->id }}">
		@endforeach
		<select class="form-control base-plugin--select2" data-url="{{ rut('ajax.selectRole', 'all') }}"
			data-placeholder="{{ __('Pilih Salah Satu') }}" @if($record->id == 1) disabled @endif>
			<option value="">{{ __('Pilih Salah Satu') }}</option>
			@foreach ($record->roles as $val)
			<option value="{{ $val->id }}" selected>{{ $val->name }}</option>
			@endforeach
		</select>
		@else
		<select name="roles[]" class="form-control base-plugin--select2-ajax"
			data-url="{{ rut('ajax.selectRole', 'all') }}" data-placeholder="{{ __('Pilih Salah Satu') }}">
			<option value="">{{ __('Pilih Salah Satu') }}</option>
			@foreach ($record->roles as $val)
			<option value="{{ $val->id }}" selected>{{ $val->name }}</option>
			@endforeach
		</select>
		@endif
	</div>
</div>
@if ($record->id == 1)
<input type="hidden" name="status" value="active">
@else
<div class="form-group row">
	<label class="col-sm-4 col-form-label">{{ __('Status') }}</label>
	<div class="col-sm-8 parent-group">
		<select name="status" class="form-control base-plugin--select2" placeholder="{{ __('Pilih Salah Satu') }}">
			<option value="active" {{ $record->status == 'nonactive' ? '' : 'selected' }}>Active</option>
			<option value="nonactive" {{ $record->status == 'nonactive' ? 'selected' : '' }}>Non Active</option>
		</select>
	</div>
</div>
@endif
@endsection

@push('scripts')
<script>
	$(function () {
			$('.content-page')
			.on('change', '#strukturCtrl', function(){
                $.ajax({
                    method: 'GET',
                    url: '{{ yurl('/ajax/jabatan-options') }}',
                    data: {
                        location_id: $(this).val()
                    },
                    success: function(response, state, xhr) {
                        // let options = `<option value='' selected disabled></option>`;
                        let options = `<option disabled selected value=''>Pilih Salah Satu</option>`;
                        for (let item of response) {
                            options += `<option value='${item.id}'>${item.name}</option>`;
                        }
                        $('#jabatanCtrl').select2('destroy');
                        $('#jabatanCtrl').html(options);
                        $('#jabatanCtrl').select2();
                        console.log(54, response, options);
                    },
                    error: function(a, b, c) {
                        console.log(a, b, c);
                    }
                });
            });
		});
</script>
@endpush
