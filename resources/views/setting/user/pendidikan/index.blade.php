@extends('layouts.form3', ['container' => 'container'])

@section('card-body')
    @method('POST')
    <div class="card card-custom mb-5">
        <div class="card-header">
            <div class="card-title">
                <span class="card-icon">
                    <i class="fas fa-user text-primary"></i>
                </span>
                <h4 class="card-label">Informasi User</h4>
            </div>
            <div class="card-toolbar">
                @section('card-toolbar')
                    @include('layouts.forms.btnBackTop')
                @show
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered w-100">
                <tr>
                    <td><b>Nama</b></td>
                    <td style="width: 20px">:</td>
                    <td>{{ $record->name }}</td>
                    <td><b>Username</b></td>
                    <td style="width: 20px">:</td>
                    <td>{{ $record->username }}</td>
                </tr>
                <tr>
                    <td><b>Email</b></td>
                    <td style="width: 20px">:</td>
                    <td>{{ $record->email }}</td>
                    <td><b>Struktur</b></td>
                    <td style="width: 20px">:</td>
                    <td>{{ $record->position->location->name ?? '' }}</td>
                    <tr>
                </tr>
                    <td><b>Jabatan</b></td>
                    <td style="width: 20px">:</td>
                    <td>
                    {{ $record->position->name ?? '' }}
                    </td>
                    <td><b>Hak Akses</b></td>
                    <td style="width: 20px">:</td>
                    <td>{{ implode(', ', $record->roles()->pluck('name')->toArray()) }}</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="card card-custom mb-5">
        <div class="card-header">
            <div class="card-title">
                <span class="card-icon">
                    <i class="fas fa-file-contract text-primary"></i>
                </span>
                <h4 class="card-label">Detail Pendidikan<small>({{ $record->name }})</small></h4>
            </div>
            <div class="card-toolbar">
                <a href="{{ rut($routes . '.pendidikan.detailCreate', $record->id) }}"  data-placement="bottom" class="btn btn-primary base-modal--render" data-modal-backdrop="false" data-modal-v-middle="false" data-modal-size="modal-md"><i class="fas fa-plus"></i>
                    Tambah Pendidikan</a>
            </div>
        </div>
        <div class="card-body">
            @if (isset($tableStruct['datatable_1']))
                <table id="datatable_1" class="table table-bordered table-hover is-datatable hide" style="width: 100%;"
                    data-url="{{ isset($tableStruct['url']) ? $tableStruct['url'] : rut($route . '.grid') }}"
                    data-paging="{{ $paging ?? true }}" data-info="{{ $info ?? true }}">
                    <thead>
                        <tr>
                            @foreach ($tableStruct['datatable_1'] as $struct)
                                <th class="text-center v-middle" data-columns-name="{{ $struct['name'] ?? '' }}"
                                    data-columns-data="{{ $struct['data'] ?? '' }}"
                                    data-columns-label="{{ $struct['label'] ?? '' }}"
                                    data-columns-sortable="{{ $struct['sortable'] === true ? 'true' : 'false' }}"
                                    data-columns-width="{{ $struct['width'] ?? '' }}"
                                    data-columns-class-name="{{ $struct['className'] ?? '' }}"
                                    style="{{ isset($struct['width']) ? 'width: ' . $struct['width'] . '; ' : '' }}">
                                    {{ $struct['label'] }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @yield('tableBody')
                    </tbody>
                </table>
            @endif
        </div>
    </div>


@endsection

@section('card-footer')
@endsection
