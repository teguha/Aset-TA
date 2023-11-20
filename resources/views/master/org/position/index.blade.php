@extends('layouts.lists')

@section('filters')
	<div class="row">
		<div class="ml-4 pb-2 mr-n2" style="width: 350px">
			<input type="text" class="form-control filter-control" data-post="name" placeholder="{{ __('Nama') }}">
		</div>
		<div class="ml-4 pb-2" style="width: 350px">
			<select class="form-control filter-control base-plugin--select2-ajax"
				data-url="{{ route('ajax.selectStruct', ['search' => 'position_with_req']) }}"
				data-post="location_id"
				data-placeholder="{{ __('Struktur Organisasi') }}">
			</select>
		</div>
	</div>
@endsection

@section('buttons')
	@if (auth()->user()->checkPerms($perms.'.create'))
		@include('layouts.forms.btnAdd')
	@endif
@endsection
