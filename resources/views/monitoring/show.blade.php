@extends('layouts.page', ['container' => 'container'])

@section('card-body')
    @include('globals.header')
    <hr>
    <div class="col-md-12 parent-group">
        <div class="table-responsive">
            <table class="table-bordered mb-1 table">
                <thead>
                    <tr>
                        <th class="width-40px text-center">#</th>
                        <th class="text-center">{{ __('Nama Module') }}</th>
                        <th class="text-center">{{ __('Status') }}</th>
                        <th class="text-center">{{ __('Tanggal Pembuatan') }}</th>
                        <th class="text-center">{{ __('Tanggal Pembaharuan') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $iteration = 1;
                    @endphp
                    @if ($assignment = $summary->assignment()->first())
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Surat Penugasan
                            </td>
                            <td class="parent-group text-center">
                                {!! \Base::getStatus($assignment->status) !!}
                            </td>
                            <td class="text-center">
                                {{ $assignment->created_at ? \Base::dateFormat($assignment->created_at) : '-' }}
                            </td>
                            <td class="parent-group text-center">
                                {{ $assignment->updated_at ? \Base::dateFormat($assignment->updated_at) : '-' }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Surat Penugasan
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                            <td class="text-center">
                                -
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                        </tr>
                    @endif
                    @if ($instruction = $summary->instruction()->first())
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Instruksi Audit
                            </td>
                            <td class="parent-group text-center">
                                {!! \Base::getStatus($instruction->status) !!}
                            </td>
                            <td class="text-center">
                                {{ $instruction->created_at ? \Base::dateFormat($instruction->created_at) : '-' }}
                            </td>
                            <td class="parent-group text-center">
                                {{ $instruction->updated_at ? \Base::dateFormat($instruction->updated_at) : '-' }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Instruksi Audit
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                            <td class="text-center">
                                -
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                        </tr>
                    @endif
                    @if ($langkahKerja = $summary->langkahKerja()->first())
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Langkah Kerja
                            </td>
                            <td class="parent-group text-center">
                                {!! \Base::getStatus($langkahKerja->status) !!}
                            </td>
                            <td class="text-center">
                                {{ $langkahKerja->created_at ? \Base::dateFormat($langkahKerja->created_at) : '-' }}
                            </td>
                            <td class="parent-group text-center">
                                {{ $langkahKerja->updated_at ? \Base::dateFormat($langkahKerja->updated_at) : '-' }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Program Audit
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                            <td class="text-center">
                                -
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                        </tr>
                    @endif
                    @if ($program = $summary->apm()->first())
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Program Audit
                            </td>
                            <td class="parent-group text-center">
                                {!! \Base::getStatus($program->status) !!}
                            </td>
                            <td class="text-center">
                                {{ $program->created_at ? \Base::dateFormat($program->created_at) : '-' }}
                            </td>
                            <td class="parent-group text-center">
                                {{ $program->updated_at ? \Base::dateFormat($program->updated_at) : '-' }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Program Audit
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                            <td class="text-center">
                                -
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                        </tr>
                    @endif
                    @if ($fee = $summary->fee()->first())
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Biaya Penugasan
                            </td>
                            <td class="parent-group text-center">
                                {!! \Base::getStatus($fee->status) !!}
                            </td>
                            <td class="text-center">
                                {{ $fee->created_at ? \Base::dateFormat($fee->created_at) : '-' }}
                            </td>
                            <td class="parent-group text-center">
                                {{ $fee->updated_at ? \Base::dateFormat($fee->updated_at) : '-' }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Biaya Penugasan
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                            <td class="text-center">
                                -
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                        </tr>
                    @endif
                    @if ($memoOpening = $summary->memoOpening()->first())
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Memo Opening
                            </td>
                            <td class="parent-group text-center">
                                {!! \Base::getStatus($memoOpening->status) !!}
                            </td>
                            <td class="text-center">
                                {{ $memoOpening->created_at ? \Base::dateFormat($memoOpening->created_at) : '-' }}
                            </td>
                            <td class="parent-group text-center">
                                {{ $memoOpening->updated_at ? \Base::dateFormat($memoOpening->updated_at) : '-' }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Memo Opening
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                            <td class="text-center">
                                -
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                        </tr>
                    @endif
                    @if ($opening = $summary->opening()->first())
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Opening Meeting
                            </td>
                            <td class="parent-group text-center">
                                {!! \Base::getStatus($opening->status) !!}
                            </td>
                            <td class="text-center">
                                {{ $opening->created_at ? \Base::dateFormat($opening->created_at) : '-' }}
                            </td>
                            <td class="parent-group text-center">
                                {{ $opening->updated_at ? \Base::dateFormat($opening->updated_at) : '-' }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Opening Meeting
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                            <td class="text-center">
                                -
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                        </tr>
                    @endif
                    @if ($document = $summary->document()->first())
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Permintaan Dokumen
                            </td>
                            <td class="parent-group text-center">
                                {!! \Base::getStatus($document->status) !!}
                            </td>
                            <td class="text-center">
                                {{ $document->created_at ? \Base::dateFormat($document->created_at) : '-' }}
                            </td>
                            <td class="parent-group text-center">
                                {{ $document->updated_at ? \Base::dateFormat($document->updated_at) : '-' }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Permintaan Dokumen
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                            <td class="text-center">
                                -
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                        </tr>
                    @endif
                    @if ($doc_full = $summary->document?->docFull()->first())
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Pemenuhan Dokumen
                            </td>
                            <td class="parent-group text-center">
                                {!! \Base::getStatus($summary->document->docFull->status ?? 'new') !!}
                            </td>
                            <td class="text-center">
                                {{ $doc_full->created_at ? \Base::dateFormat($doc_full->created_at) : '-' }}
                            </td>
                            <td class="parent-group text-center">
                                {{ $doc_full->updated_at ? \Base::dateFormat($doc_full->updated_at) : '-' }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Pemenuhan Dokumen
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                            <td class="text-center">
                                -
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                        </tr>
                    @endif
                    @if ($sample = $summary->sample()->first())
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Kertas Kerja
                            </td>
                            <td class="parent-group text-center">
                                {!! \Base::getStatus($sample->status) !!}
                            </td>
                            <td class="text-center">
                                {{ $sample->created_at ? \Base::dateFormat($sample->created_at) : '-' }}
                            </td>
                            <td class="parent-group text-center">
                                {{ $sample->updated_at ? \Base::dateFormat($sample->updated_at) : '-' }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Kertas Kerja
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                            <td class="text-center">
                                -
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                        </tr>
                    @endif
                    @if ($feedback = $summary->feedback()->first())
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Tanggapan
                            </td>
                            <td class="parent-group text-center">
                                {!! \Base::getStatus($feedback->status) !!}
                            </td>
                            <td class="text-center">
                                {{ $feedback->created_at ? \Base::dateFormat($feedback->created_at) : '-' }}
                            </td>
                            <td class="parent-group text-center">
                                {{ $feedback->updated_at ? \Base::dateFormat($feedback->updated_at) : '-' }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Tanggapan
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                            <td class="text-center">
                                -
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                        </tr>
                    @endif
                    @if ($worksheet = $summary->worksheet()->first())
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Temuan Sementara
                            </td>
                            <td class="parent-group text-center">
                                {!! \Base::getStatus($worksheet->status) !!}
                            </td>
                            <td class="text-center">
                                {{ $worksheet->created_at ? \Base::dateFormat($worksheet->created_at) : '-' }}
                            </td>
                            <td class="parent-group text-center">
                                {{ $worksheet->updated_at ? \Base::dateFormat($worksheet->updated_at) : '-' }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Temuan Sementara
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                            <td class="text-center">
                                -
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                        </tr>
                    @endif
                    @if ($memoClosing = $summary->memoClosing()->first())
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Memo Closing
                            </td>
                            <td class="parent-group text-center">
                                {!! \Base::getStatus($memoClosing->status) !!}
                            </td>
                            <td class="text-center">
                                {{ $memoClosing->created_at ? \Base::dateFormat($memoClosing->created_at) : '-' }}
                            </td>
                            <td class="parent-group text-center">
                                {{ $memoClosing->updated_at ? \Base::dateFormat($memoClosing->updated_at) : '-' }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Memo Closing
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                            <td class="text-center">
                                -
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                        </tr>
                    @endif
                    @if ($closing = $summary->closing()->first())
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Closing Meeting
                            </td>
                            <td class="parent-group text-center">
                                {!! \Base::getStatus($closing->status) !!}
                            </td>
                            <td class="text-center">
                                {{ $closing->created_at ? \Base::dateFormat($closing->created_at) : '-' }}
                            </td>
                            <td class="parent-group text-center">
                                {{ $closing->updated_at ? \Base::dateFormat($closing->updated_at) : '-' }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Closing Meeting
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                            <td class="text-center">
                                -
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                        </tr>
                    @endif
                    @if ($memoExiting = $summary->memoExiting()->first())
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Memo Exit
                            </td>
                            <td class="parent-group text-center">
                                {!! \Base::getStatus($memoExiting->status) !!}
                            </td>
                            <td class="text-center">
                                {{ $memoExiting->created_at ? \Base::dateFormat($memoExiting->created_at) : '-' }}
                            </td>
                            <td class="parent-group text-center">
                                {{ $memoExiting->updated_at ? \Base::dateFormat($memoExiting->updated_at) : '-' }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Memo Exit
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                            <td class="text-center">
                                -
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                        </tr>
                    @endif
                    @if ($exiting = $summary->exiting()->first())
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Exit Meeting
                            </td>
                            <td class="parent-group text-center">
                                {!! \Base::getStatus($exiting->status) !!}
                            </td>
                            <td class="text-center">
                                {{ $exiting->created_at ? \Base::dateFormat($exiting->created_at) : '-' }}
                            </td>
                            <td class="parent-group text-center">
                                {{ $exiting->updated_at ? \Base::dateFormat($exiting->updated_at) : '-' }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Exit Meeting
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                            <td class="text-center">
                                -
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                        </tr>
                    @endif
                    @if ($memoLhp = $summary->memoLhp()->first())
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Memo LHP
                            </td>
                            <td class="parent-group text-center">
                                {!! \Base::getStatus($memoLhp->status) !!}
                            </td>
                            <td class="text-center">
                                {{ $memoLhp->created_at ? \Base::dateFormat($memoLhp->created_at) : '-' }}
                            </td>
                            <td class="parent-group text-center">
                                {{ $memoLhp->updated_at ? \Base::dateFormat($memoLhp->updated_at) : '-' }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Memo LHP
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                            <td class="text-center">
                                -
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                        </tr>
                    @endif
                    @if ($lha = $summary->lha()->first())
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                LHP
                            </td>
                            <td class="parent-group text-center">
                                {!! \Base::getStatus($lha->status) !!}
                            </td>
                            <td class="text-center">
                                {{ $lha->created_at ? \Base::dateFormat($lha->created_at) : '-' }}
                            </td>
                            <td class="parent-group text-center">
                                {{ $lha->updated_at ? \Base::dateFormat($lha->updated_at) : '-' }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                LHP
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                            <td class="text-center">
                                -
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                        </tr>
                    @endif
                    @if ($dirNote = $summary->dirNote()->first())
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Catatan Direksi
                            </td>
                            <td class="parent-group text-center">
                                {!! \Base::getStatus($dirNote->status) !!}
                            </td>
                            <td class="text-center">
                                {{ $dirNote->created_at ? \Base::dateFormat($dirNote->created_at) : '-' }}
                            </td>
                            <td class="parent-group text-center">
                                {{ $dirNote->updated_at ? \Base::dateFormat($dirNote->updated_at) : '-' }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Catatan Direksi
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                            <td class="text-center">
                                -
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                        </tr>
                    @endif
                    @if ($followupMemoTindakLanjut = $summary->followupMemoTindakLanjut()->first())
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Memo Tindak Lanjut
                            </td>
                            <td class="parent-group text-center">
                                {!! \Base::getStatus($followupMemoTindakLanjut->status) !!}
                            </td>
                            <td class="text-center">
                                {{ $followupMemoTindakLanjut->created_at ? \Base::dateFormat($followupMemoTindakLanjut->created_at) : '-' }}
                            </td>
                            <td class="parent-group text-center">
                                {{ $followupMemoTindakLanjut->updated_at ? \Base::dateFormat($followupMemoTindakLanjut->updated_at) : '-' }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Memo Tindak Lanjut
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                            <td class="text-center">
                                -
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                        </tr>
                    @endif
                    @if ($reschedule = $summary->followupReg->reschedule ?? null)
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Jadwal Ulang
                            </td>
                            <td class="parent-group text-center">
                                {!! \Base::getStatus($reschedule->status) !!}
                            </td>
                            <td class="text-center">
                                {{ $reschedule->created_at ? \Base::dateFormat($reschedule->created_at) : '-' }}
                            </td>
                            <td class="parent-group text-center">
                                {{ $reschedule->updated_at ? \Base::dateFormat($reschedule->updated_at) : '-' }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Jadwal Ulang
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                            <td class="text-center">
                                -
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                        </tr>
                    @endif
                    @if ($followupMonitor = $summary->followupMonitor()->first())
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Monitoring
                            </td>
                            <td class="parent-group text-center">
                                {!! \Base::getStatus($followupMonitor->status) !!}
                            </td>
                            <td class="text-center">
                                {{ $followupMonitor->created_at ? \Base::dateFormat($followupMonitor->created_at) : '-' }}
                            </td>
                            <td class="parent-group text-center">
                                {{ $followupMonitor->updated_at ? \Base::dateFormat($followupMonitor->updated_at) : '-' }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td class="width-40px text-center">{{ $iteration++ }}</td>
                            <td class="parent-group text-left">
                                Monitoring
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                            <td class="text-center">
                                -
                            </td>
                            <td class="parent-group text-center">
                                -
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('buttons')
@endsection
