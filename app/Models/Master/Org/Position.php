<?php

namespace App\Models\Master\Org;

use App\Imports\Master\PositionImport;
use App\Models\Auth\User;
use App\Models\Globals\TempFiles;
use App\Models\Master\Org\OrgStruct;
use App\Models\Model;

class Position extends Model
{
    protected $table = 'ref_positions';

    protected $fillable = [
        'location_id',
        'level_id',
        'name',
        'code',
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
    public function location()
    {
        return $this->belongsTo(OrgStruct::class, 'location_id');
    }

    public function level()
    {
        return $this->belongsTo(LevelPosition::class, 'level_id');
    }

    public function struct()
    {
        return $this->belongsTo(OrgStruct::class, 'location_id');
    }
    
    public function users()
    {
        return $this->hasMany(User::class, 'position_id');
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
        return $query->filterBy(['name'])
            ->when(
                $location_id = request()->post('location_id'),
                function ($q) use ($location_id) {
                    $q->where('location_id', $location_id);
                }
            );
    }

    /*******************************
     ** SAVING
     *******************************/
    public function handleStoreOrUpdate($request)
    {
        $this->beginTransaction();
        try {
            $this->fill($request->all());
            $this->code = $this->code ?: $this->getNewCode();
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
            if (!$this->canDeleted()) {
                throw new \Exception('#' . __('base.error.related'));
            }
            $this->saveLogNotify();
            $this->delete();

            return $this->commitDeleted();
        } catch (\Exception $e) {
            return $this->rollbackDeleted($e);
        }
    }

    public function handleImport($request)
    {
        $this->beginTransaction();
        try {
            $file = TempFiles::find($request->uploads['temp_files_ids'][0]);
            if (!$file || !\Storage::disk('public')->exists($file->file_path)) {
                $this->rollback('File tidak tersedia!');
            }

            $filePath = \Storage::disk('public')->path($file->file_path);
            \Excel::import(new PositionImport(), $filePath);

            $this->saveLogNotify();

            return $this->commitSaved();
        } catch (\Exception $e) {
            return $this->rollbackSaved($e);
        }
    }

    public function saveLogNotify()
    {
        $data = $this->name;
        $routes = request()->get('routes');
        switch (request()->route()->getName()) {
            case $routes . '.store':
                $this->addLog('Membuat Data ' . $data);
                break;
            case $routes . '.update':
                $this->addLog('Mengubah Data ' . $data);
                break;
            case $routes . '.destroy':
                $this->addLog('Menghapus Data ' . $data);
                break;
        }
    }

    /*******************************
     ** OTHER FUNCTIONS
     *******************************/
    public function canDeleted()
    {
        if ($this->users()->exists()) return false;

        return true;
    }

    public function getNewCode()
    {
        $max = static::max('code');
        return $max ? $max + 1 : 1001;
    }

    public function imAuditor()
    {
        return $this->location->code == 3001 || (isset($this->location->parent->code) && $this->location->parent->code == 3001);
    }

    public function imAuditorBranchEvaluasi()
    {
        $temp = OrgStruct::where(function ($q) {
            $q->where(function ($qq) {
                $qq->seksiEvaluasi();
            });
        })->get();
        $lists = [];
        foreach($temp as $dd){
            $lists = array_merge($lists, $dd->getIdsWithChild());
        }
        return in_array($this->location_id , $lists);
    }

    public function imLevelManajerSPI()
    {
        $temp = Position::whereHas('level', function ($q) {
            $q->where('name', 'LIKE', '%' . 'Manajer SPI');
        })->pluck('id')->toArray();
        return in_array($this->id, $temp);
    }

    public function isAuditor($request)
    {
        if ($this->where([['name', 'like', '%Audit%'], ['id', '=', $request]])->exists()) return true;

        return false;
    }
}
