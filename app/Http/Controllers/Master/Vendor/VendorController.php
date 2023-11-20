<?php

namespace App\Http\Controllers\Master\Vendor;

use App\Exports\GenerateExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\Vendor\VendorRequest;
use App\Models\Master\Vendor\Vendor;
use App\Models\Master\Geo\City;
use App\Models\Master\Geo\Province;
use App\Support\Base;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VendorController extends Controller
{
    protected $module = 'master.vendor';
    protected $routes = 'master.vendor';
    protected $views  = 'master.vendor.vendor_barang';
    protected $perms = 'master';
    private $datas;

    public function __construct()
    {
        $this->prepare(
            [
                'module' => $this->module,
                'routes' => $this->routes,
                'views' => $this->views,
                'perms' => $this->perms,
                'permission' => $this->perms . '.view',
                'title' => 'Vendor',
                'breadcrumb' => [
                    'Konsol Admin' => route($this->routes . '.index'),
                    'Parameter' => route($this->routes . '.index'),
                    'Vendor' => route($this->routes . '.index'),
                ]
            ]
        );
    }

    public function index()
    {
        $this->prepare([
            'tableStruct' => [
                'datatable_1' => [
                    $this->makeColumn('name:num'),
                    $this->makeColumn('name:name|label:Vendor|className:text-left'),
                    // $this->makeColumn('name:address|label:Alamat|className:text-left'),
                    // $this->makeColumn('name:province|label:Provinsi|className:text-left'),
                    // $this->makeColumn('name:city|label:Kota|className:text-left'),
                    // $this->makeColumn('name:telp|label:Telepon|className:text-left'),
                    // $this->makeColumn('name:email|label:Email|className:text-left'),
                    $this->makeColumn('name:contact_person|label:Contact Person|className:text-center'),
                    $this->makeColumn('name:updated_by'),
                    $this->makeColumn('name:action'),
                ],
            ],
        ]);
        return $this->render($this->views . '.index');
    }

    public function grid()
    {
        $user = auth()->user();
        $records = Vendor::grid()->filters()->dtGet();

        return DataTables::of($records)
            ->addColumn(
                'num',
                function ($record) {
                    return request()->start;
                }
            )
            ->addColumn(
                'name',
                function ($record) {
                    return Base::makeLabel($record->name, 'danger');
                }
            )
            ->addColumn(
                'contact_person',
                function ($record) {
                    return  Base::makeLabel($record->contact_person, 'primary');
                }
            )
            ->addColumn(
                'telp',
                function ($record) {
                    return Base::makeLabel($record->telp, 'success');
                }
            )
            ->addColumn(
                'address',
                function ($record) {
                    return  $record->address;
                }
            )
            ->addColumn(
                'email',
                function ($record) {
                    return  $record->email;
                }
            )
            ->addColumn(
                'updated_by',
                function ($record) {
                    return $record->createdByRaw();
                }
            )
            ->addColumn(
                'action',
                function ($record) use ($user) {
                    $actions = [];

                    if ($record->checkAction('show', $this->perms)) {
                        $actions[] = 'type:show|id:' . $record->id;
                    }
                    if ($record->checkAction('edit', $this->perms)) {
                        $actions[] = 'type:edit|id:' . $record->id;
                    }
                    if ($record->checkAction('delete', $this->perms)) {
                        $actions[] = [
                            'type' => 'delete',
                            'id' => $record->id,
                            'attrs' => 'data-confirm-text="' . __('Hapus Parameter Vendor') . ' ' . $record->name . '?"',
                        ];
                    }
                    return $this->makeButtonDropdown($actions);
                }
            )
            ->addColumn(

                'status',
                function ($record) {
                    return $record->status;
                }
            )
            ->rawColumns(['contact_person', 'status', 'email', 'telp', 'address', 'name', 'action', 'updated_by'])
            ->make(true);
    }

    public function create()
    {
        $data = $this->datas;
        $page_action = "create";
        $provinces = Province::select("id", "name")->get();
        $record = new Vendor();
        $this->pushBreadcrumb(['Tambah' => route($this->routes . '.create', $record)]);
        return $this->render($this->views . '.create', compact('page_action', 'data', 'provinces'));
    }

    public function store(VendorRequest $request)
    {
        $record = new Vendor;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(Vendor $record)
    {
        $page_action = "show";
        return $this->render($this->views . '.show', compact('record', 'page_action'));
    }

    public function edit(Vendor $record)
    {

        $this->pushBreadcrumb(['Detil' => route($this->routes . '.edit', $record)]);
        $province = Province::where('id', $record->ref_province_id)->first();
        $city = City::where('id', $record->ref_city_id)->first();
        $page_action = "edit";
        return $this->render($this->views . '.edit', compact('record', 'province', 'city', 'page_action'));
    }

    public function update(VendorRequest $request, Vendor $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(Vendor $record)
    {
        return $record->handleDestroy();
    }

    public function import()
    {
        if (request()->get('download') === 'template') {
            return $this->template();
        }
        return $this->render($this->views . '.import');
    }

    public function template()
    {
        $fileName = date('Y-m-d') . ' Template Import Data ' . $this->prepared('title') . '.xlsx';
        $view = $this->views . '.template';
        $data = [];
        return \Excel::download(new GenerateExport($view, $data), $fileName);
    }

    public function importSave(Request $request)
    {
        $request->validate([
            'uploads.uploaded' => 'required',
            'uploads.temp_files_ids.*' => 'required',
        ], [], [
            'uploads.uploaded' => 'File',
            'uploads.temp_files_ids.*' => 'File',
        ]);

        $record = new Vendor;
        return $record->handleImport($request);
    }
}
