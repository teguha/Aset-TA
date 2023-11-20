<table>
    <tr>
        <td colspan="2" rowspan="2">
            <img src="{{ config('base.logo.print') }}" style="width: 100% !important;">
        </td>
        <td colspan="9">{{ getRoot()->name }}</td>
    </tr>
    <tr>
        <td colspan="9">SATUAN PENGAWASAN INTERN</td>
    </tr>
    <tr>
        <td colspan="10" style="text-align: center">
            <b>TIME FRAME PEMERIKSAAN</b>
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td colspan="3">No. S T P</td>
        <td>: </td>
    </tr>
    <tr>
        <td colspan="3">Nama Obyek Audit</td>
        <td>: {{ $record->summary->getObjectName() }}</td>
    </tr>
    <tr>
        <td colspan="3">Sasaran Audit</td>
        <td>: </td>
    </tr>
    <tr>
        <td colspan="3">T u j u a n</td>
        <td>: {{ $record->objective }}</td>
    </tr>
    <tr>
        <td colspan="3">Periode Pemeriksaan</td>
        <td>: {{ $record->summary->getMonthPlan() }}</td>
    </tr>
    <tr>
        <td colspan="3">Anggaran Waktu</td>
        <td>: {{ $record->date_start->format('d F Y') }} s/d {{ $record->date_end->format('d F Y') }}</td>
    </tr>
    <tr></tr>
    @php
        $summary    = $record->summary;
        $start_date = $summary->created_at;
        $end_date   = $summary->updated_at;
        if ($record->updated_at) {
            $end_date   = $summary->updated_at;
        }
        if (isset($summary->apm->updated_at)) {
            $end_date   = $summary->apm->updated_at;
        }
        if (isset($summary->fee->updated_at)) {
            $end_date   = $summary->fee->updated_at;
        }
        if (isset($summary->opening->updated_at)) {
            $end_date   = $summary->opening->updated_at;
        }
        if (isset($summary->document->updated_at)) {
            $end_date   = $summary->document->updated_at;
        }
        if (isset($summary->sample->updated_at)) {
            $end_date   = $summary->sample->updated_at;
        }
        if (isset($summary->feedback->updated_at)) {
            $end_date   = $summary->feedback->updated_at;
        }
        if (isset($summary->worksheet->updated_at)) {
            $end_date   = $summary->worksheet->updated_at;
        }
        if (isset($summary->closing->updated_at)) {
            $end_date   = $summary->closing->updated_at;
        }
        if (isset($summary->exiting->updated_at)) {
            $end_date   = $summary->exiting->updated_at;
        }
        if (isset($summary->lha->updated_at)) {
            $end_date   = $summary->lha->updated_at;
        }
        if (isset($summary->opening->updated_at)) {
            $end_date   = $summary->opening->updated_at;
        }
        if (isset($summary->dirNote->updated_at)) {
            $end_date   = $summary->dirNote->updated_at;
        }
        if (isset($summary->followupReg->updated_at)) {
            $end_date   = $summary->followupReg->updated_at;
        }
        if (isset($summary->followupReschedule->updated_at)) {
            $end_date   = $summary->followupReschedule->updated_at;
        }
        if (isset($summary->followupMonitor->updated_at)) {
            $end_date   = $summary->followupMonitor->updated_at;
        }
        // $end_date       = now()->addMonths(2);
        $date_period    = \Carbon\CarbonPeriod::create($start_date->format('Y-m-d'), $end_date->format('Y-m-d'));
    @endphp
    <tr>
        <td rowspan="2" style="background-color: #F2F2F2; border: 1px solid black; width: 3em; text-align: center">No</td>
        <td rowspan="2" colspan="3" style="background-color: #F2F2F2; border: 1px solid black; text-align: center">Uraian Kegiatan</td>
        <td colspan="4" style="background-color: #F2F2F2; border: 1px solid black; text-align: center">Pelaksana Tugas</td>
        <td colspan="{{ $date_period->count() }}" style="background-color: #F2F2F2; border: 1px solid black; text-align: center">Tanggal</td>
    </tr>
    <tr>
        <td style="background-color: #F2F2F2; border: 1px solid black; text-align: center">Pen. Jwb.</td>
        <td style="background-color: #F2F2F2; border: 1px solid black; text-align: center">Pengawas</td>
        <td style="background-color: #F2F2F2; border: 1px solid black; text-align: center">Ka. Tim</td>
        <td style="background-color: #F2F2F2; border: 1px solid black; text-align: center">Anggota</td>
        @foreach ($date_period as $date)
            <td style="background-color: #F2F2F2; border: 1px solid black; text-align: center">{{ $date->format('d') }}</td>
        @endforeach
    </tr>
    <tr>
        <td style="width: 3em; text-align: center"><b>I</b></td>
        <td colspan="3" style="border: 1px solid black; "><b>Persiapan Pemeriksaan</b></td>
    </tr>
    <tr>
        <td style="width: 3em; text-align: center"></td>
        <td style="border: 1px solid black; width: 3em; text-align: center">1</td>
        <td colspan="2" style="border: 1px solid black; ">Opening Meeting</td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
    </tr>
    <tr>
        <td style="width: 3em; text-align: center"><b>II</b></td>
        <td colspan="3" style="border: 1px solid black; "><b>Pelaksanaan Pemeriksaan</b></td>
    </tr>
    <tr>
        <td style="width: 3em; text-align: center"></td>
        <td style="border: 1px solid black; width: 3em; text-align: center">1</td>
        <td colspan="2" style="border: 1px solid black; ">Pengambilan dokumen</td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
    </tr>
    <tr>
        <td style="width: 3em; text-align: center"></td>
        <td style="border: 1px solid black; width: 3em; text-align: center">2</td>
        <td colspan="2" style="border: 1px solid black; ">Memeriksa dokumen</td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
    </tr>
    <tr>
        <td style="width: 3em; text-align: center"></td>
        <td style="border: 1px solid black; width: 3em; text-align: center">3</td>
        <td colspan="2" style="border: 1px solid black; ">Cek Fisik Lapangan</td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
    </tr>
    <tr>
        <td style="width: 3em; text-align: center"></td>
        <td style="border: 1px solid black; width: 3em; text-align: center">4</td>
        <td colspan="2" style="border: 1px solid black; ">Menganalisa hasil pemeriksaan</td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
    </tr>
    <tr>
        <td style="width: 3em; text-align: center"></td>
        <td style="border: 1px solid black; width: 3em; text-align: center">5</td>
        <td colspan="2" style="border: 1px solid black; ">Mencatat hasil pemeriksaan dalam KKP </td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
    </tr>
    <tr>
        <td style="width: 3em; text-align: center"><b>III</b></td>
        <td colspan="3" style="border: 1px solid black; "><b>Pelaporan</b></td>
    </tr>
    <tr>
        <td style="width: 3em; text-align: center"></td>
        <td style="border: 1px solid black; width: 3em; text-align: center">1</td>
        <td colspan="2" style="border: 1px solid black; ">Membuat Draft Laporan Hasil Pemeriksaan</td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
    </tr>
    <tr>
        <td style="width: 3em; text-align: center"></td>
        <td style="border: 1px solid black; width: 3em; text-align: center">2</td>
        <td colspan="2" style="border: 1px solid black; ">Review Draft LP</td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
    </tr>
    <tr>
        <td style="width: 3em; text-align: center"></td>
        <td style="border: 1px solid black; width: 3em; text-align: center">3</td>
        <td colspan="2" style="border: 1px solid black; ">Menerbitkan Laporan Hasil Pemeriksaan</td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
    </tr>
    <tr></tr>
    <tr>
        <td></td>
        <td colspan="3">
            {{ getCompanyCity() }}, {{ now()->translatedFormat('F Y') }}
        </td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2">
            Menyetujui,
        </td>
        <td></td>
        <td>Tim Auditor</td>
    </tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr>
        <td></td>
        <td colspan="2" style="text-align: center">
            <b style="text-decoration: underline">{{ $record->pic->name }}</b>
        </td>
        <td colspan="1" style="text-align: center">
            <b style="text-decoration: underline">{{ $record->supervisor->name }}</b>
        </td>
        <td colspan="2" style="text-align: center">
            <b style="text-decoration: underline">{{ $record->leader->name }}</b>
        </td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        @foreach ($record->members as $member)
            <td colspan="6" style="text-align: center">
                <b style="text-decoration: underline">{{ $member->name }}</b>
            </td>
        @endforeach
    </tr>
    <tr>
        <td></td>
        <td colspan="2" style="text-align: center">Penanggung Jawab</td>
        <td colspan="1" style="text-align: center">Pengawas</td>
        <td colspan="2" style="text-align: center">Ketua Tim</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        @foreach ($record->members as $member)
            <td colspan="6" style="text-align: center">
                <b style="text-decoration: underline">Anggota</b>
            </td>
        @endforeach
    </tr>
</table>
