<?php

namespace App\Http\Controllers\Master\Geografis;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\Geografis\RegionsRequest;
use App\Models\Master\Geografis\Regions;
use Illuminate\Http\Request;

class KotaController extends Controller
{
    protected $module = 'master_kota';
    protected $routes = 'master.geografis.kota';
    protected $views = 'master.geografis.kota';
    protected $perms = 'master';

    public function __construct()
    {
        $this->prepare([
            'module' => $this->module,
            'routes' => $this->routes,
            'views' => $this->views,
            'perms' => $this->perms,
            'permission' => $this->perms.'.view',
            'title' => 'Kota / Kabupaten',
            'breadcrumb' => [
                'Data Master' => rut($this->routes . '.index'),
                'Geografis' => rut($this->routes . '.index'),
                'Kota / Kabupaten' => rut($this->routes.'.index'),
            ]
        ]);
    }

    public function index()
    {
        $this->prepare([
            'tableStruct' => [
                'datatable_1' => [
                    $this->makeColumn('name:num'),
                    $this->makeColumn('name:provinsi|label:Provinsi|className:text-left'),
                    $this->makeColumn('name:name|label:Kota / Kabupaten|className:text-left'),
                    $this->makeColumn('name:updated_by'),
                    $this->makeColumn('name:action'),
                ],
            ],
        ]);
        return $this->render($this->views.'.index');
    }

    public function grid()
    {
        $user = auth()->user();
        $records = Regions::filters()->where("parent", "!=", "0")->dtGet();

        return \DataTables::of($records)
            ->addColumn('num', function ($record) {
                return request()->start;
            })
            ->addColumn('provinsi', function ($record) {
                if (isset($record->prov->name)) {
                    return $record->prov->name;
                }else{
                    return null;
                }
            })
            ->addColumn('name', function ($record) {
                return $record->name;
            })
            ->addColumn('updated_by', function ($record) use ($user) {
                return $user->name;
            })
            ->addColumn('action', function ($record) use ($user) {
                $actions = [
                    'type:show|id:'.$record->id,
                    'type:edit|id:'.$record->id,
                ];
                if ($record->canDeleted()) {
                    $actions[] = [
                        'type' => 'delete',
                        'id' => $record->id,
                        'attrs' => 'data-confirm-text="'.__('Hapus').' '.$record->name.'?"',
                    ];
                }
                return $this->makeButtonDropdown($actions);
            })
            ->rawColumns(['action','updated_by','location'])
            ->make(true);
    }
    public function create()
    {
        $provinsi = Regions::where("parent", "0")->get();

        return $this->render($this->views.'.create', compact('provinsi'));
    }

    public function store(RegionsRequest $request)
    {
        $record = new Regions;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(Regions $record)
    {
        $provinsi = Regions::where("parent", "0")->get();

        return $this->render($this->views.'.show', compact('record', 'provinsi'));
    }

    public function edit(Regions $record)
    {
        $provinsi = Regions::where("parent", "0")->get();

        return $this->render($this->views.'.edit', compact('record', 'provinsi'));
    }

    public function update(RegionsRequest $request, Regions $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(Regions $record)
    {
        return $record->handleDestroy();
    }
}
