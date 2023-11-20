<?php

namespace App\Exports\Monitoring;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MonitoringExport implements FromView, ShouldAutoSize
{
    public function __construct(
        public $record
    ) {
    }
    public function view(): View
    {
        $record = $this->record;
        return view('monitoring.excel', compact('record'));
    }
}
