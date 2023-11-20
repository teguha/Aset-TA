@extends('layouts.lists')

@section('filters')
	<div class="row">
		<div class="col-12 col-sm-6 col-xl-3 pb-2">
			<input type="text" class="form-control filter-control" data-post="name" placeholder="{{ __('Kecamatan') }}">
		</div>
		<div class="ml-4" style="width: 250px">
            <select id="provinceCtrl" class="form-control filter-control base-plugin--select2-ajax"
				data-url="{{ rut('ajax.provinceOptionsBySearch', [
					'search'=>'all'
				]) }}" data-post="province_id" placeholder="{{ __('Provinsi') }}">
                <option value="">{{ __('Provinsi') }}</option>
            </select>
        </div>
		<div class="ml-4" style="width: 250px">
            <select id="cityCtrl"  class="form-control filter-control base-plugin--select2-ajax" 	data-post="city_id" placeholder="{{ __('Kota') }}">
                <option value="">{{ __('Kota') }}</option>
            </select>
        </div>
	</div>
@endsection

@section('buttons')
	@if (auth()->user()->checkPerms($perms.'.create'))
		@include('layouts.forms.btnAdd')
	@endif
@endsection

@push('scripts')
<script>
	$(function () {
        $('.content-page')
            .on('change', '#provinceCtrl', function(){
                $.ajax({
                    method: 'GET',
                    url: '{{ yurl('/ajax/city-options') }}',
                    data: {
                        province_id: $(this).val()
                    },
                    success: function(response, state, xhr) {
                        // let options = `<option value='' selected disabled></option>`;
                        let options = `<option disabled selected value=''>Pilih Salah Satu</option>`;
                        for (let item of response) {
                            options += `<option value='${item.id}'>${item.name}</option>`;
                        }
                        $('#cityCtrl').select2('destroy');
                        $('#cityCtrl').html(options);
                        $('#cityCtrl').select2();
                        console.log(54, response, options);
                    },
                    error: function(a, b, c) {
                        console.log(a, b, c);
                    }
                });
            })
	});
</script>

@endpush
