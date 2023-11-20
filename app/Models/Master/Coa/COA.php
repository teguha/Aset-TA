<?php

namespace App\Models\Master\Coa;

use App\Models\Auth\User;
use App\Models\Master\Org\OrgStruct;
use App\Models\Model;
use App\Models\Traits\HasApprovals;
use App\Models\Traits\HasFiles;
use App\Models\Traits\RaidModel;
use App\Models\Traits\ResponseTrait;
use App\Models\Traits\Utilities;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class COA extends Model
{
    use HasFiles,  RaidModel, ResponseTrait, Utilities, HasApprovals;
    // use HasUuids;
    // protected $primaryKey = 'uuid';
    protected $table = 'ref_coa';

    protected $fillable = [
        'kode_akun',
        'nama_akun',
        'tipe_akun',
        'deskripsi',
        'status',
    ];


     /*******************************
     ** MUTATOR
     *******************************/


    /*******************************
     ** ACCESSOR
     *******************************/

    public function checkAction($action, $perms)
    {
        $user = auth()->user();
        switch ($action) {
            case 'create':
                return $user->checkPerms($perms.'.create');

            case 'edit':
                return $user->checkPerms($perms.'.edit');

            case 'show':
                return true;

            case 'delete':
                return $user->checkPerms($perms.'.delete');
        }

        return false;
    }



    /*******************************
     ** RELATION
     *******************************/


    /*******************************
     ** SCOPE
     *******************************/
    public function scopeGrid($query)
    {
        return $query->latest();
    }

    public function scopeFilters($query)
    {
        return $query
        ->filterBy(['tipe_akun'])
        ->filterBy(['nama_akun']);
    }

    /*******************************
     ** SAVING
     *******************************/
    public function handleStoreOrUpdate($request)
    {
        $this->beginTransaction();
        try {
            $data = $request->all();
            // $data['module'] = $request->module;
            $this->fill($data);
            $this->save();
            $this->saveLogNotify();

            // if ($request->is_submit) {
            //     return $this->commitSaved(['redirectToModal' => route($request->routes.'.submit', $this->id)]);
            // }


            $redirect = route(request()->get('routes') . '.index');
            return $this->commitSaved(compact('redirect'));
        } catch (\Exception $e) {
            return $this->rollbackSaved($e);
        }
    }

    public function handleDestroy()
    {
        $this->beginTransaction();
        try {
            $this->saveLogNotify();
            $this->delete();

            return $this->commitDeleted();
        } catch (\Exception $e) {
            return $this->rollbackDeleted($e);
        }
    }
}
