@extends('layouts.lists')

@section('filters')
	<div class="row">
		<div class="col-12 col-sm-6 col-xl-3 pb-2 mr-n6">
			<input type="text" class="form-control filter-control" data-post="name" placeholder="{{ __('Kota / Kabupaten') }}">
		</div>
		<div class="ml-4" style="width: 250px">
            <select class="form-control filter-control base-plugin--select2-ajax"
				data-url="{{ rut('ajax.provinceOptionsBySearch', [
					'search'=>'all'
				]) }}" data-post="province_id" placeholder="{{ __('Provinsi') }}">
                <option value="">{{ __('Provinsi') }}</option>
            </select>
        </div>
	</div>
@endsection

@section('buttons')
	@if (auth()->user()->checkPerms($perms.'.create'))
		@include('layouts.forms.btnAdd')
	@endif
@endsection
