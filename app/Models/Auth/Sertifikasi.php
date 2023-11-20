<?php

namespace App\Models\Auth;

use App\Models\Auth\User;
use App\Models\Model;
use App\Models\Traits\HasFiles;
use Carbon\Carbon;

class Sertifikasi extends Model
{
    use HasFiles;
    
    protected $table = 'ref_sertifikasi_user';

    protected $fillable = [
        'user_id',
        'nama_sertif',
        'no_sertif',
        'tgl_sertif',
        'lembaga',
        'description',
    ];

    protected $dates = [
        'tgl_sertif',

    ];
    /*******************************
     ** MUTATOR
     *******************************/

    /*******************************
     ** ACCESSOR
     *******************************/

    /*******************************
     ** RELATION
     *******************************/
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function setTglSertifAttribute($value)
    {
        $this->attributes['tgl_sertif'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    /*******************************
     ** SCOPE
     *******************************/
    public function scopeGrid($query)
    {
        return $query->latest();
    }

    public function scopeFilters($query)
    {
        return $query;
    }

    /*******************************
     ** SAVING
     *******************************/
    public function handleStoreOrUpdate($request)
    {
        $this->beginTransaction();
        try {
            $this->fill($request->all());
            $this->save();
            $this->saveLogNotify();

            return $this->commitSaved();
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

    public function saveLogNotify()
    {
        $data = $this->name;
        $routes = request()->get('routes');
        switch (request()->route()->getName()) {
            case $routes.'.store':
                $this->addLog('Membuat Data '.$data);
                break;
            case $routes.'.update':
                $this->addLog('Mengubah Data '.$data);
                break;
            case $routes.'.destroy':
                $this->addLog('Menghapus Data '.$data);
                break;
        }
    }

    /*******************************
     ** OTHER FUNCTIONS
     *******************************/
    public function canDeleted()
    {
        return true;
    }
}
