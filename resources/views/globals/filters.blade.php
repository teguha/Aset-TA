<div class="col-12 col-sm-6 col-md-1 mr-n6 pb-2">
    <input type="text" class="form-control filter-control base-plugin--datepicker-3" data-post="year"
        placeholder="{{ __('Tahun') }}">
</div>
<div class="col-12 col-sm-6 col-md-2 mr-n6 pb-2">
    <select class="form-control filter-control base-plugin--select2 filter-category" data-post="category"
        placeholder="{{ __('Jenis') }}">
        <option value="" selected>{{ __('Jenis') }}</option>
        <option value="operation">{{ __('PKPT') }}</option>
        <option value="ict">{{ __('TI') }}</option>
    </select>
</div>
<div class="col-12 col-sm-6 col-xl-3 mr-n6 pb-2">
    <select class="form-control filter-control base-plugin--select2-ajax filter-object" data-post="object"
        data-url="{{ rut('ajax.selectObject', ['category' => '']) }}" data-url-origin="{{ rut('ajax.selectObject') }}"
        placeholder="{{ __('Objek Audit') }}">
        <option value="">{{ __('Objek Audit') }}</option>
    </select>
</div>
<div class="col-12 col-sm-6 col-md-5 mr-n6 pb-2">
    <select class="form-control filter-control base-plugin--select2-ajax filter-auditor" data-post="auditor"
        data-url="{{ rut('ajax.selectUser', ['search' => 'auditor']) }}" placeholder="{{ __('Auditor') }}">
        <option value="">{{ __('Auditor') }}</option>
    </select>
</div>

@push('scripts')
    <script>
        $(function() {
            $('.content-page').on('change', 'select.filter-control.filter-category', function(e) {
                var me = $(this);
                if (me.val()) {
                    var objectId = $('select.filter-object');
                    var urlOrigin = objectId.data('url-origin');
                    var urlParam = $.param({
                        category: me.val()
                    });
                    objectId.data('url', decodeURIComponent(decodeURIComponent(urlOrigin + '?' +
                    urlParam)));
                    objectId.val(null).prop('disabled', false);
                }
                BasePlugin.initSelect2();
            });


            $('.content-page').on('click', '.reset-filter .reset.button', function(e) {
                var objectId = $('select.filter-object');
                var urlOrigin = objectId.data('url-origin');
                var urlParam = $.param({
                    category: ''
                });
                objectId.data('url', decodeURIComponent(decodeURIComponent(urlOrigin + '?' + urlParam)));
                objectId.val(null).prop('disabled', false);
                BasePlugin.initSelect2();
            });
        });
    </script>
@endpush
