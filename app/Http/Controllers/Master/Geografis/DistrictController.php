<?php

namespace App\Http\Controllers\Master\Geografis;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\Geografis\DistrictRequest;
use App\Models\Master\Geografis\District;
use App\Support\Base;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    protected $module = 'master_district';
    protected $routes = 'master.geografis.district';
    protected $views = 'master.geografis.kecamatan';
    protected $perms = 'master';

    public function __construct()
    {
        $this->prepare(
            [
                'module' => $this->module,
                'routes' => $this->routes,
                'views' => $this->views,
                'perms' => $this->perms,
                'permission' => $this->perms . '.view',
                'title' => 'Kecamatan',
                'breadcrumb' => [
                    'Data Master' => rut($this->routes . '.index'),
                    'Geografis' => rut($this->routes . '.index'),
                    'Kecamatan' => rut($this->routes . '.index'),
                ]
            ]
        );
    }

    public function index()
    {
        $this->prepare(
            [
                'tableStruct' => [
                    'datatable_1' => [
                        $this->makeColumn('name:num'),
                        $this->makeColumn('name:code|label:Kode|className:text-center'),
                        $this->makeColumn('name:name|label:Kecamatan|className:text-center'),
                        $this->makeColumn('name:city|label:Kota/Kabupaten|className:text-center'),
                        $this->makeColumn('name:province|label:Provinsi|className:text-center'),
                        $this->makeColumn('name:updated_by'),
                        $this->makeColumn('name:action'),
                    ],
                ],
            ]
        );
        return $this->render($this->views . '.index');
    }

    public function grid()
    {
        $user = auth()->user();
        $records = District::filters()->dtGet();

        return \DataTables::of($records)
            ->addColumn(
                'num',
                function ($record) {
                    return request()->start;
                }
            )
            ->editColumn(
                'code',
                function ($record) {
                    return $record->code;
                }
            )
            ->addColumn(
                'city',
                function ($record) {
                    return $record->city->name;
                }
            )
            ->addColumn(
                'province',
                function ($record) {
                    return $record->city->province->name;
                }
            )
            ->addColumn('name', function ($record) {
                return $record->name ?? null;
            })
            ->addColumn(
                'updated_by',
                function ($record) use ($user) {
                    return $record->createdByRaw();
                }
            )
            ->addColumn(
                'action',
                function ($record) use ($user) {
                    $actions = [
                        'type:show|id:' . $record->id,
                        'type:edit|id:' . $record->id,
                    ];
                    if ($record->canDeleted()) {
                        $actions[] = [
                            'type' => 'delete',
                            'id' => $record->id,
                            'attrs' => 'data-confirm-text="' . __('Hapus') . ' ' . $record->name . '?"',
                        ];
                    }
                    return $this->makeButtonDropdown($actions);
                }
            )
            ->rawColumns(['code', 'action', 'updated_by', 'location', 'name', 'province', 'city'])
            ->make(true);
    }
    public function create()
    {
        return $this->render($this->views . '.create');
    }

    public function store(DistrictRequest $request)
    {
        $record = new District;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(District $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function edit(District $record)
    {
        return $this->render($this->views . '.edit', compact('record'));
    }

    public function update(DistrictRequest $request, District $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(District $record)
    {
        return $record->handleDestroy();
    }
}
