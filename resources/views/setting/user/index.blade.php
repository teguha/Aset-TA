@extends('layouts.lists')

@section('filters')
	<div class="row">
        <div class="col-12 col-sm-6 col-xl-2 px-1 pl-3">
			<input class="form-control filter-control" data-post="name" placeholder="{{ __('Name / Email') }}">
		</div>
        <div class="col-12 col-sm-6 col-xl-3 px-1">
			<select class="form-control filter-control base-plugin--select2-ajax"
				data-url="{{ route('ajax.selectStruct', ['search' => 'position_with_req']) }}"
				data-post="location_id"
				data-placeholder="{{ __('Struktur Organisasi') }}">
			</select>
		</div>
		<div class="col-12 col-sm-6 col-xl-3 px-1">
			<select class="form-control base-plugin--select2-ajax filter-control"
				data-post="role_id"
				data-url="{{ rut('ajax.selectRole', 'all') }}"
				data-placeholder="{{ __('Hak Akses') }}">
				<option value="" selected>{{ __('Hak Akses') }}</option>
			</select>
		</div>
		<div class="col-12 col-sm-6 col-xl-2 px-1">
			<select class="form-control base-plugin--select2-ajax filter-control"
				data-post="status"
				data-placeholder="{{ __('Status') }}">
				<option value="" selected>{{ __('Status') }}</option>
				<option value="active">Active</option>
				<option value="nonactive">Nonactive</option>
			</select>
		</div>
	</div>
@endsection

@section('buttons')
	@if (auth()->user()->checkPerms($perms.'.create'))
		@include('layouts.forms.btnAdd')
	@endif
@endsection
