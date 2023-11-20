<div class="row">
    <div class="col-sm-6">
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">{{ __('Tahun') }}</label>
            <div class="col-sm-8 col-form-label">
                {!! $summary->labelYear() !!}
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">{{ __('Jenis') }}</label>
            <div class="col-sm-8 col-form-label">
                {!! $summary->labelCategory() !!}
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">{{ __('Tipe Objek') }}</label>
            <div class="col-sm-8 col-form-label">
                {!! $summary->labelObjectType() !!}
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">{{ __('Objek Audit') }}</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" value="{{ $summary->getObjectName() }}" disabled>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">{{ __('Rencana Pelaksanaan') }}</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" value="{!! $summary->getMonthPlan() !!}" disabled>
            </div>
        </div>
    </div>
</div>
