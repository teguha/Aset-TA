<?php

namespace App\Http\Controllers\Master\Geografis;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\Geografis\CityRequest;
use App\Models\Master\Geografis\City;
use App\Support\Base;
use Illuminate\Http\Request;

class CityController extends Controller
{
    protected $module = 'master_city';
    protected $routes = 'master.geografis.city';
    protected $views = 'master.geografis.kota';
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
                'title' => 'Kota / Kabupaten',
                'breadcrumb' => [
                    'Data Master' => rut($this->routes . '.index'),
                    'Geografis' => rut($this->routes . '.index'),
                    'Kota / Kabupaten' => rut($this->routes . '.index'),
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
                        $this->makeColumn('name:name|label:Kota/Kabupaten|className:text-center'),
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
        $records = City::filters()->dtGet();

        return \DataTables::of($records)
            ->addColumn(
                'num',
                function ($record) {
                    return request()->start;
                }
            )
            ->addColumn('name', function ($record) {
                return $record->name ?? null;
            })
            ->editColumn(
                'code',
                function ($record) {
                    return $record->code;
                }
            )
            ->addColumn(
                'province',
                function ($record) {
                    return $record->province->name;
                }
            )
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
            ->rawColumns(['code', 'action', 'updated_by', 'location', 'name', 'province'])
            ->make(true);
    }

    public function create()
    {
        return $this->render($this->views . '.create');
    }

    public function store(CityRequest $request)
    {
        $record = new City;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(City $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function edit(City $record)
    {
        return $this->render($this->views . '.edit', compact('record'));
    }

    public function update(CityRequest $request, City $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(City $record)
    {
        return $record->handleDestroy();
    }
}
