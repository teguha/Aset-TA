<html>
    <head>
        <title>{{ $title }}</title>
        <style>
            * {
                box-sizing: border-box;
            }
            /** Define the margins of your page **/
            @page { margin: 1cm 1.5cm 1cm 1.5cm;}

            header {
                position: fixed;
                top: 0px;
                left: 0;
                right: 0;
                /*margin-left: 10mm;*/
                /*margin-right: 5mm;*/
                /*line-height: 35px;*/
            }

            footer {
                position: fixed;
                bottom: -5px;
                left: 0px;
                right: 0;
                height: 50px;
                /* line-height: 35px; */
            }

            body {
                margin-top: 2cm;
                font-size: 12pt;
            }

            .pagenum:before {
                content: counter(page);
                content: counter(page, decimal);
            }

            table {
                width: 100%;
                border: 1pt solid black;
                border-collapse: collapse;
            }

            tr th,
            tr td {
              border-bottom:1pt solid black;
              border:1pt solid black;
              border-right:1pt solid black;
            }

            ul {
                margin: 0;
                padding-left: 20px;
            }

            .table-data {
                height: 44px;
                background-repeat: no-repeat;
                /*background-position: center center;*/
                border: 1px solid;
                /*text-align: justify;*/
                /*background-color: #ffffff;*/
                font-weight: normal;
                /*color: #555555;*/
                /*padding: 11px 5px 11px 5px;*/
                vertical-align: middle;
            }

            .table-data tr th,
            .table-data tr td {
                padding: 5px 8px;
            }

            .table-data tr td {
                vertical-align: top;
            }

            .page-break: {
                page-break-inside: always;
            }
            .nowrap {
                white-space: nowrap;
            }
        </style>
    </head>
    <body class="page">
        <header>
            <table style="border:none; width: 100%;">
                <tr>
                    <td style="border:none;" width="140px" >
                        <img src="{{ config('base.logo.print') }}" style="max-width: 140px; max-height: 60px">
                    </td>
                    <td style="border:none;  text-align: center; font-size: 14pt;" width="auto">
                        <b>{{ __('SURAT TUGAS') }}</b>
                        <div><b>{{ strtoupper(getRoot()->name) }}</b></div>
                    </td>
                    <td style="border:none; text-align: right; font-size: 12px;" width="150px">
                        <b></b>
                    </td>
                </tr>
            </table>
            <hr>
        </header>
        <footer>
            <table table width="100%" border="0" style="border: none;">
                <tr>
                    <td style="border: none;">
                        <small>
                            <i>***Dokumen ini sudah ditandatangani secara elektronik dan dinyatakan sah oleh {{ getRoot()->name }}.</i>
                            <br><i>Tanggal Cetak: {{now()->translatedFormat('d F Y H:i:s')}}</i>
                        </small>
                    </td>
                </tr>
            </table>
        </footer>
        <main>
            <table style="border:none;">
                <tr>
                    <td style="border:none; text-align:center;">
                        <div>Nomor: {{ $record->show_letter_no }}</div>
                    </td>
                </tr>
                <tr>
                    <td style="border:none;">
                        <div>Kepada:</div>
                        @foreach ($record->users as $user)
                            <div>{{ $user->name }}</div>
                        @endforeach
                        <div>{{ getRoot()->name }}</div>
                        <div style="white-space: pre-wrap;">{{ $record->to_address }}</div>
                    </td>
                </tr>
            </table>
            <br>
            <div style="white-space: pre-wrap; text-indent: 50px; text-align: justify;">{!! $record->description !!}</div>
            <div style="margin-top: 10px; margin-left: 30px">
                <table style="border:none; width: 100%;">
                    <tr>
                        <td style="border: none; vertical-align:top; width: 20px;">1.</td>
                        <td style="border: none; vertical-align:top; width: 300px;">Penanggungjawab merangkap Pengawas</td>
                        <td style="border: none; vertical-align:top; width: 10px;">:</td>
                        <td style="border: none; vertical-align:top;">{{ $record->pic->name }}</td>
                    </tr>
                    <tr>
                        <td style="border: none; vertical-align:top; width: 20px;">2.</td>
                        <td style="border: none; vertical-align:top; width: 300px;">Ketua Tim merangkap Anggota</td>
                        <td style="border: none; vertical-align:top; width: 10px;">:</td>
                        <td style="border: none; vertical-align:top;">{{ $record->leader->name }}</td>
                    </tr>
                    <tr>
                        <td style="border: none; vertical-align:top; width: 20px;">3.</td>
                        <td style="border: none; vertical-align:top; width: 300px;">Anggota</td>
                        <td style="border: none; vertical-align:top; width: 10px;">:</td>
                        <td style="border: none; vertical-align:top;">
                            <ol style="margin: 0; padding-left: 20px;">
                                @foreach ($record->members as $user)
                                    <li>{{ $user->name }}</li>
                                @endforeach
                            </ol>
                        </td>
                    </tr>
                </table>
            </div>
            <br>
            <div style="white-space: pre-wrap; text-indent: 50px; text-align: justify;">{!! $record->note !!} {{ $record->date_start->translatedFormat('d F Y').' '.$record->date_end->translatedFormat('d F Y') }}</div>
            <br>
            <br>

            @if ($record->approval($module)->exists())
                <div style="page-break-inside: avoid;">
                    <div  style="text-align: center;">{{ getCompanyCity() }}, {{ $record->letter_date->translatedFormat('d F Y') }}</div>
                    <table style="border:none;">
                        <tbody>
                            @php
                                $ids = $record->approval($module)->pluck('id')->toArray();
                                $length = count($ids);
                            @endphp
                            @for ($i = 0; $i < $length; $i += 3)
                                <tr>
                                    @if (!empty($ids[$i]))
                                        <td style="border: none; text-align: center; width: 33%; vertical-align: bottom;">
                                            @if ($approval = $record->approval($module)->find($ids[$i]))
                                                @if ($approval->status == 'approved')
                                                    <div style="height: 110px; padding-top: 15px;">
                                                        {!! \Base::getQrcode('Approved by: '.$approval->user->name.', '.$approval->approved_at) !!}
                                                    </div>

                                                    <div><b><u>{{ $approval->user->name }}</u></b></div>
                                                    <div>{{ $approval->position->name }}</div>
                                                @else
                                                    <div style="height: 110px; padding-top: 15px;; color: #ffffff;">#</div>
                                                    <div><b><u>(............................)</u></b></div>
                                                    <div>{{ $approval->role->name }}</div>
                                                @endif
                                            @endif
                                        </td>
                                    @endif
                                    @if (!empty($ids[$i+1]))
                                        <td style="border: none; text-align: center; width: 33%; vertical-align: bottom;">
                                            @if ($approval = $record->approval($module)->find($ids[$i+1]))
                                                @if ($approval->status == 'approved')
                                                    <div style="height: 110px; padding-top: 15px;">
                                                        {!! \Base::getQrcode('Approved by: '.$approval->user->name.', '.$approval->approved_at) !!}
                                                    </div>

                                                    <div><b><u>{{ $approval->user->name }}</u></b></div>
                                                    <div>{{ $approval->position->name }}</div>
                                                @else
                                                    <div style="height: 110px; padding-top: 15px;; color: #ffffff;">#</div>
                                                    <div><b><u>(............................)</u></b></div>
                                                    <div>{{ $approval->role->name }}</div>
                                                @endif
                                            @endif
                                        </td>
                                    @endif
                                    @if (!empty($ids[$i+2]))
                                        <td style="border: none; text-align: center; width: 33%; vertical-align: bottom;">
                                            @if ($approval = $record->approval($module)->find($ids[$i+2]))
                                                @if ($approval->status == 'approved')
                                                    <div style="height: 110px; padding-top: 15px;">
                                                        {!! \Base::getQrcode('Approved by: '.$approval->user->name.', '.$approval->approved_at) !!}
                                                    </div>

                                                    <div><b><u>{{ $approval->user->name }}</u></b></div>
                                                    <div>{{ $approval->position->name }}</div>
                                                @else
                                                    <div style="height: 110px; padding-top: 15px;; color: #ffffff;">#</div>
                                                    <div><b><u>(............................)</u></b></div>
                                                    <div>{{ $approval->role->name }}</div>
                                                @endif
                                            @endif
                                        </td>
                                    @endif
                                </tr>

                            @endfor
                        </tbody>
                    </table>
                </div>
            @endif

            @if ($record->cc()->exists())
                <div style="page-break-inside: avoid;">
                    <div style="text-align: left;">{{ __('Tembusan') }}:</div>
                    <ul>
                        @foreach ($record->cc()->get() as $cc)
                             <li>{{ $cc->name }}</li>
                         @endforeach
                    </ul>
                </div>
            @endif
        </main>
    </body>
</html>
