<div class="row">
    <div class="col-sm-6">
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">{{ __('Tahun') }}</label>
            <div class="col-sm-8 col-form-label">
                {!! $summary->labelYear() !!}
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">{{ __('Jenis Audit') }}</label>
            <div class="col-sm-8 col-form-label">
                {!! $summary->labelCategory() !!}
            </div>
        </div>
        {{-- <div class="form-group row">
            <label class="col-sm-4 col-form-label">{{ __('Tipe Objek') }}</label>
            <div class="col-sm-8 col-form-label">
                {!! $summary->labelObjectType() !!}
            </div>
        </div> --}}
    </div>
    <div class="col-sm-6">
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">{{ __('Objek Audit') }}</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" value="{{ $summary->getObjectName() }}" disabled>
            </div>
        </div>
        @if (isset($summary->assignment->status) && $summary->assignment->status === 'completed')
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">{{ __('Surat Penugasan') }}</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" value="{!! $summary->assignment->getMonthPlan() !!}" disabled>
                </div>
            </div>
        @else
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">{{ __('Rencana Pelaksanaan') }}</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" value="{!! $summary->getMonthPlan() !!}" disabled>
                </div>
            </div>
        @endif
    </div>
</div>
