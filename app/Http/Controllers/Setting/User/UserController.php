<?php

namespace App\Http\Controllers\Setting\User;

use App\Exports\Setting\UserTemplateExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\User\PendidikanUserRequest;
use App\Http\Requests\Setting\User\SertifikasiUserRequest;
use App\Http\Requests\Setting\User\UserRequest;
use App\Models\Auth\Pendidikan;
use App\Models\Auth\Sertifikasi;
use App\Models\Auth\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $module = 'setting_user';
    protected $routes = 'setting.user';
    protected $views = 'setting.user';
    protected $perms = 'setting';

    public function __construct()
    {
        $this->prepare(
            [
                'module' => $this->module,
                'routes' => $this->routes,
                'views' => $this->views,
                'perms' => $this->perms,
                'permission' => $this->perms . '.view',
                'title' => 'Manajemen User',
                'breadcrumb' => [
                    'Pengaturan Umum' => rut($this->routes . '.index'),
                    'Manajemen User' => rut($this->routes . '.index'),
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
                        $this->makeColumn('name:name|label:Nama|className:text-center'),
                        $this->makeColumn('name:username|label:Username|className:text-center'),
                        $this->makeColumn('name:email|label:Struktur|className:text-center'),
                        // $this->makeColumn('name:nik|label:NIK|className:text-center'),
                        $this->makeColumn('name:position|label:Jabatan|className:text-center'),
                        $this->makeColumn('name:role|label:Hak Akses|className:text-center width-10px'),
                        $this->makeColumn('name:status|className:width-10px'),
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
        $records = User::grid()
            ->filters()
            ->dtGet()
            ->orderBy('updated_at', 'DESC');

        return \DataTables::of($records)
            ->addColumn(
                'num',
                function ($record) {
                    return request()->start;
                }
            )
            ->addColumn(
                'name',
                function ($record) {
                    return $record->name;
                }
            )
            ->addColumn(
                'username',
                function ($record) {
                    return $record->username;
                }
            )
            ->addColumn(
                'email',
                function ($record) {
                    if ($record->position) {
                        return $record->position->location->name ;
                    } else {
                        return '-' ;
                    }

                }
            )
            ->addColumn(
                'position',
                function ($record) {
                    if (isset($record->position)) {
                        return $record->position->name ?? '-';
                    }
                    return '-';
                }
            )
            ->addColumn(
                'role',
                function ($record) {
                    if ($record->roles()->exists()) {
                        $x = '';
                        foreach ($record->roles as $role) {
                            $x .=  $role->name;
                            $x .= '<br>';
                        }
                        return $x;
                    }
                    return '-';
                }
            )
            ->editColumn(
                'status',
                function ($record) {
                    return $record->labelStatus();
                }
            )
            ->editColumn(
                'updated_by',
                function ($record) {
                    return $record->createdByRaw();
                }
            )
            ->addColumn(
                'action',
                function ($record) use ($user) {
                    $actions = [];
                    $actions[] = [
                        'type' => 'show',
                        'id' => $record->id
                    ];
                    $actions[] = [
                        'type' => 'edit',
                        'id' => $record->id,
                    ];

                    $actions[] = [
                        'type' => 'custom',
                        'icon' => 'fas fa-file-contract text-primary',
                        'page' => true,
                        'label' => '&nbsp;Sertifikasi',
                        'url' => rut($this->routes . '.sertifikasi', $record->id),
                    ];

                    $actions[] = [
                        'type' => 'custom',
                        'icon' => 'fas fa-file-contract text-info',
                        'page' => true,
                        'label' => '&nbsp;Pendidikan',
                        'url' => rut($this->routes . '.pendidikan', $record->id),
                    ];

                    if ($user->id == 1) {
                        $actions[] = [
                            'label' => 'Reset Password',
                            'icon' => 'fa fa-retweet text-warning',
                            'class' => 'base-form--postByUrl',
                            'attrs' => 'data-swal-text="Reset password akan mengubah password menjadi: qwerty123456"',
                            'id' => $record->id,
                            'url' => rut($this->routes . '.resetPassword', $record->id)
                        ];
                    }

                    if ($record->position_id != null) {
                        if ($record->canDeleted()) {
                            $actions[] = [
                                'type' => 'delete',
                                'id' => $record->id,
                                'attrs' => 'data-confirm-text="' . __('Hapus') . ' User ' . $record->name . '?"',
                            ];
                        }
                    }
                    return $this->makeButtonDropdown($actions);
                }
            )
            ->rawColumns(['action', 'email', 'updated_by', 'status', 'position', 'role', 'username', 'name'])
            ->make(true);
    }

    public function create()
    {
        return $this->render($this->views . '.create');
    }

    public function store(UserRequest $request)
    {
        $record = new User;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(User $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function pendidikan(User $record)
    {
        $grid = [
            $this->makeColumn('name:num|label:#|sortable:false|width:20px'),
            $this->makeColumn('name:jenjang|label:Jenjang Pendidikan|sortable:false|className:text-center'),
            $this->makeColumn('name:institusi|label:Institusi Pendidikan|sortable:false|className:text-center'),
            $this->makeColumn('name:tahun_lulus|label:Tahun Kelulusan|sortable:false|className:text-center'),
            $this->makeColumn('name:lampiran|label:Lampiran|sortable:false|className:text-center'),
            $this->makeColumn('name:action|label:#|sortable:false'),
        ];

        $this->prepare(
            [
                'tableStruct' => [
                    'url' => rut($this->routes . '.pendidikan.grid', $record->id),
                    'datatable_1' => $grid
                ],
            ]
        );
        return $this->render($this->views . '.pendidikan.index', compact('record'));
    }

    public function pendidikanGrid(User $record)
    {
        $user = auth()->user();
        $records = Pendidikan::whereHas(
                'user',
                function ($q) use ($record) {
                    $q->where('user_id', $record->id);
                }
            )
            ->dtGet();

        return \DataTables::of($records)
            ->addColumn(
                'num',
                function ($detail) {
                    return request()->start;
                }
            )
            ->addColumn(
                'jenjang',
                function ($detail) {
                    return $detail->jenjang_pendidikan;
                }
            )
            ->addColumn(
                'institusi',
                function ($detail) {
                    return $detail->institute;
                }
            )
            ->addColumn(
                'tahun_lulus',
                function ($detail) {
                    return $detail->thn_lulus;
                }
            )
            ->addColumn(
                'lampiran',
                function ($detail) {
                    $str = "<span class='badge badge-info'>" . $detail->files()->where('flag', 'lampiran_pendidikan')->count() . " Files</span>";
                    return $str;
                }
            )
            ->addColumn(
                'action',
                function ($detail) {
                    $actions = [];
                    $actions[] = [
                        'type' => 'show',
                        'url' => rut($this->routes . '.pendidikan.detailShow', $detail->id),
                    ];
                    $actions[] = [
                        'type' => 'edit',
                        'url' => rut($this->routes.'.pendidikan.detailEdit', $detail->id),
                    ];
                    $actions[] = [
                        'type' => 'delete',
                        'url' => rut($this->routes . '.pendidikan.detailDestroy', $detail->id),
                        'text' => $detail->name ?? $detail->item->name ?? '',
                    ];
                    return $this->makeButtonDropdown($actions, $detail->id);
                }
            )
            ->rawColumns(['action', 'updated_by', 'lampiran'])
            ->make(true);
    }

    public function pendidikanDetailCreate(User $record)
    {
        return $this->render($this->views . '.pendidikan.create', compact('record'));
    }

    public function pendidikanDetailEdit($id)
    {
        $detail = Pendidikan::find($id);
        return $this->render($this->views . '.pendidikan.edit', compact('detail'));
    }

    public function pendidikanDetailShow($id)
    {
        $detail = Pendidikan::find($id);
        return $this->render($this->views . '.pendidikan.show', compact('detail'));
    }

    public function pendidikanDetailUpdate(PendidikanUserRequest $request, $id)
    {
        $detail = Pendidikan::find($id);
        $record = User::find($detail->user_id);
        return $record->handleStoreOrUpdatePendidikan($request);

    }

    public function pendidikanDetailDestroy($id)
    {
        $detail = Pendidikan::find($id);
        $record = User::find($detail->user_id);
        return $record->handleDestroyPendidikan($id);

    }

    public function pendidikanDetailStore(PendidikanUserRequest $request, $id)
    {
        $record = User::find($id);
        return $record->handleStoreOrUpdatePendidikan($request);
    }

    public function sertifikasi(User $record)
    {
        $grid = [
            $this->makeColumn('name:num|label:#|sortable:false|width:20px'),
            $this->makeColumn('name:nama_sertif|label:Nama Sertifikat|sortable:false|className:text-center'),
            $this->makeColumn('name:no_sertif|label:Nomor Sertifikat|sortable:false|className:text-center'),
            $this->makeColumn('name:tgl_sertif|label:Tgl Sertifikat|sortable:false|className:text-center'),
            $this->makeColumn('name:lembaga|label:Lembaga|sortable:false|className:text-center'),
            $this->makeColumn('name:lampiran|label:Lampiran|sortable:false|className:text-center'),
            $this->makeColumn('name:action|label:#|sortable:false'),
        ];

        $this->prepare(
            [
                'tableStruct' => [
                    'url' => rut($this->routes . '.sertifikasi.grid', $record->id),
                    'datatable_1' => $grid
                ],
            ]
        );
        return $this->render($this->views . '.sertifikasi.index', compact('record'));
    }

    public function sertifikasiGrid(User $record)
    {
        $user = auth()->user();
        $records = Sertifikasi::whereHas(
                'user',
                function ($q) use ($record) {
                    $q->where('user_id', $record->id);
                }
            )
            ->dtGet();

        return \DataTables::of($records)
            ->addColumn(
                'num',
                function ($detail) {
                    return request()->start;
                }
            )
            ->addColumn(
                'nama_sertif',
                function ($detail) {
                    return $detail->nama_sertif;
                }
            )
            ->addColumn(
                'no_sertif',
                function ($detail) {
                    return $detail->no_sertif;
                }
            )
            ->addColumn(
                'tgl_sertif',
                function ($detail) {
                    return $detail->tgl_sertif->translatedFormat('d F Y');
                }
            )
            ->addColumn(
                'lembaga',
                function ($detail) {
                    return $detail->lembaga;
                }
            )
            ->addColumn(
                'lampiran',
                function ($detail) {
                    $str = "<span class='badge badge-info'>" . $detail->files()->where('flag', 'lampiran_sertifikasi')->count() . " Files</span>";
                    return $str;
                }
            )
            ->addColumn(
                'action',
                function ($detail) {
                    $actions = [];
                    $actions[] = [
                        'type' => 'show',
                        'url' => rut($this->routes . '.sertifikasi.detailShow', $detail->id),
                    ];
                    $actions[] = [
                        'type' => 'edit',
                        'url' => rut($this->routes.'.sertifikasi.detailEdit', $detail->id),
                    ];
                    $actions[] = [
                        'type' => 'delete',
                        'url' => rut($this->routes . '.sertifikasi.detailDestroy', $detail->id),
                        'text' => $detail->name ?? $detail->item->name ?? '',
                    ];
                    return $this->makeButtonDropdown($actions, $detail->id);
                }
            )
            ->rawColumns(['action', 'updated_by', 'lampiran'])
            ->make(true);
    }

    public function sertifikasiDetailCreate(User $record)
    {
        return $this->render($this->views . '.sertifikasi.create', compact('record'));
    }

    public function sertifikasiDetailEdit($id)
    {
        $detail = Sertifikasi::find($id);
        return $this->render($this->views . '.sertifikasi.edit', compact('detail'));
    }

    public function sertifikasiDetailShow($id)
    {
        $detail = Sertifikasi::find($id);
        return $this->render($this->views . '.sertifikasi.show', compact('detail'));
    }

    public function sertifikasiDetailUpdate(SertifikasiUserRequest $request, $id)
    {
        $detail = Sertifikasi::find($id);
        $record = User::find($detail->user_id);
        return $record->handleStoreOrUpdateSertifikasi($request);

    }

    public function sertifikasiDetailDestroy($id)
    {
        $detail = Sertifikasi::find($id);
        $record = User::find($detail->user_id);
        return $record->handleDestroySertifikasi($id);

    }

    public function sertifikasiDetailStore(SertifikasiUserRequest $request, $id)
    {
        $record = User::find($id);
        return $record->handleStoreOrUpdateSertifikasi($request);
    }

    public function detail(User $record)
    {
        $record->position = $record->position;
        $record->struct = $record->position->location;
        return $record;
    }


    public function edit(User $record)
    {
        return $this->render($this->views . '.edit', compact('record'));
    }

    public function update(UserRequest $request, User $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(User $record)
    {
        return $record->handleDestroy();
    }

    public function resetPassword(User $record)
    {
        return $record->handleResetPassword();
    }

    public function import()
    {
        if (request()->get('download') == 'template') {
            return $this->template();
        }
        return $this->render($this->views . '.import');
    }

    public function template()
    {
        $fileName = date('Y-m-d') . ' Template Import Data ' . $this->prepared('title') . '.xlsx';
        return \Excel::download(new UserTemplateExport, $fileName);
    }

    public function importSave(Request $request)
    {
        $request->validate(
            [
                'uploads.uploaded' => 'required'
            ],
            [],
            [
                'uploads.uploaded' => 'Lampiran'
            ]
        );

        $record = new User;
        return $record->handleImport($request);
    }
}
