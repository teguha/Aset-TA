<?php

namespace App\Http\Controllers\Setting\Reset;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResetController extends Controller
{
    protected $module = 'setting_reset';
    protected $routes = 'setting.reset';
    protected $views = 'setting.reset';
    protected $perms = 'setting';

    public function __construct()
    {
        $this->prepare(
            [
                'module' => $this->module,
                'routes' => $this->routes,
                'views' => $this->views,
                'permission' => $this->perms . '.view',
                'title' => 'Reset Data',
                'breadcrumb' => [
                    'Pengaturan Umum' => rut($this->routes),
                    'Reset Data' => rut($this->routes),
                ]
            ]
        );
    }

    public function index()
    {
        $data = array();
        return $this->render($this->views . '.index', compact('data'));
    }

    public function reset(Request $request)
    {
        $type = $request->post('type');

        $validator = Validator::make(
            ['type' => $type],
            array(
                'type' => 'required|string|in:reset_transaction,migrate_fresh'
            )
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'code' => 500,
                    'message' => 'Data yang anda masukkan tidak valid'
                ]
            );
        }

        if ($type == 'reset_transaction') {
            try {
                Artisan::call('transaction:truncate');

                return response()->json(
                    [
                        'code' => 200,
                        'message' => 'Berhasil melakukan reset data transaksi'
                    ]
                );
            } catch (\Throwable $th) {
                return response()->json(
                    [
                        'code' => 500,
                        'message' => 'Gagal melakukan reset data transaksi : ' . $th->getMessage()
                    ]
                );
            }
        } else {
            try {
                Artisan::call('migrate:fresh --seed');

                return response()->json(
                    [
                        'code' => 200,
                        'message' => 'Berhasil melakukan fresh install'
                    ]
                );
            } catch (\Throwable $th) {
                return response()->json(
                    [
                        'code' => 500,
                        'message' => 'Gagal melakukan fresh install : ' . $th->getMessage()
                    ]
                );
            }
        }
    }
}
