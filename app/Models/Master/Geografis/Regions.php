<?php

namespace App\Models\Master\Geografis;

use App\Models\Auth\User;
use App\Models\Model;
use App\Models\Traits\HasFiles;
use Carbon\Carbon;

class Regions extends Model
{
    use HasFiles;
    protected $table = 'ref_regions';

    protected $fillable = [
        'id',
        'parent',
        'name',
        'created_by'
    ];

    public function scopeGrid($query)
    {
        return $query->latest();
    }

    public function scopeFilters($query)
    {
        return $query->filterBy(['name']);
    }

    public function handleStoreOrUpdate($request)
    {
        $this->beginTransaction();
        try {
            $this->fill($request->all());
            $this->save();
            $this->saveFiles($request);
            $this->saveLogNotify();

            return $this->commitSaved();
        } catch (\Exception $e) {
            return $this->rollbackSaved($e);
        }
    }

    public function saveFiles($request)
    {
        $this->saveFilesByTemp($request->attachments, $request->module, 'attachments');
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

    public function provinsi()
    {
        return $this->hasMany("App\Models\Master\Geografis\Regions", "parent", "id");
    }

    public function prov()
    {
        return $this->belongsTo(Regions::class, 'parent');
    }

    public function canDeleted()
    {
        if($this->provinsi()->exists()) return false;
    }
}
