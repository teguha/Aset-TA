<?php

namespace App\Models\Master\Org;

use App\Imports\Master\OrgStructImport;
use App\Models\Globals\TempFiles;
use App\Models\Master\Aspect\Aspect;
use App\Models\Master\Geografis\City;
use App\Models\Master\Risk\LastAudit;
use App\Models\Master\Risk\RiskAssessment;
use App\Models\Model;
use App\Models\Rkia\Summary;

class OrgStruct extends Model
{
    protected $table = 'ref_org_structs';

    protected $fillable = [
        'parent_id',
        'level', //root, bod, department, branch
        'type', //1:presdir, 2:direktur, 3:ia department, 4:it department, 5:Bagian Perencanaan & Evaluasi Audit
        'name',
        'email',
        'website',
        'code',
        'code_manual',
        'phone',
        'address',
        'province_id',
        'city_id'
    ];

    /** MUTATOR **/

    /** ACCESSOR **/
    public function getShowLevelAttribute()
    {
        switch ($this->level) {
            case 'bod':
                return __('Direksi');
            case 'department':
                return __('Departemen');
            case 'subdepartment':
                return __('Sub Departemen');
            case 'subsection':
                return __('Sub Unit Departemen');
            case 'group':
                return __('Grup Lainnya');
            default:
                return ucfirst($this->level);
        }
    }

    /** RELATION **/
    public function parent()
    {
        return $this->belongsTo(OrgStruct::class, 'parent_id');
    }

    public function parents()
    {
        return $this->belongsTo(OrgStruct::class, 'parent_id')->with('parent');
    }

    public function child()
    {
        return $this->hasMany(OrgStruct::class, 'parent_id')->orderBy('level');
    }

    public function childs()
    {
        return $this->hasMany(OrgStruct::class, 'parent_id')->orderBy('level')->with('child');
    }

    public function childOfGroup()
    {
        return $this->belongsToMany(OrgStruct::class, 'ref_org_structs_groups', 'group_id', 'struct_id');
    }

    public function structGroup()
    {
        return $this->belongsToMany(OrgStruct::class, 'ref_org_structs_groups', 'struct_id', 'group_id');
    }

    public function positions()
    {
        return $this->hasMany(Position::class, 'location_id');
    }

    public function letterNo()
    {
        return $this->hasMany(LetterNo::class, 'department_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    /** SCOPE **/
    public function scopeFilters($query)
    {
        return $query->filterBy(['code', 'name', 'parent_id'])
                    ->when(
                        $parent_parent_id = request()->parent_parent_id,
                        function ($q) use ($parent_parent_id){
                            $q->whereHas('parent', function ($qq) use ($parent_parent_id){
                                $qq->where('parent_id', $parent_parent_id);
                            });
                        }
                    )
                    ->latest();
    }

    public function scopeRoot($query)
    {
        return $query->where('level', 'root')->orderByRaw("CASE WHEN updated_at > created_at THEN updated_at ELSE created_at END DESC");
    }

    public function scopeBod($query)
    {
        return $query->where('level', 'bod')->orderByRaw("CASE WHEN updated_at > created_at THEN updated_at ELSE created_at END DESC");
    }

    public function scopePresdir($query)
    {
        return $query->bod()->where('type', 1);
    }

    public function scopeDirector($query)
    {
        return $query->bod()->where('type', '!=', 1);
    }

    public function scopeDepartment($query)
    {
        return $query->where('level', 'department')->orderByRaw("CASE WHEN updated_at > created_at THEN updated_at ELSE created_at END DESC");
    }

    public function scopeSubDepartment($query)
    {
        return $query->where('level', 'subdepartment')->orderByRaw("CASE WHEN updated_at > created_at THEN updated_at ELSE created_at END DESC");
    }

    public function scopeSubSection($query)
    {
        return $query->where('level', 'subsection')->orderByRaw("CASE WHEN updated_at > created_at THEN updated_at ELSE created_at END DESC");
    }

    public function scopeInAudit($query)
    {
        $temp = OrgStruct::where(function ($q) {
            $q->where(function ($qq) {
                $qq->departmentIa();
            })->orWhere(function ($qq) {
                $qq->seksiIa();
            });
        })->get();
        $lists = [];
        foreach ($temp as $dd) {
            $lists = array_merge($lists, $dd->getIdsWithChild());
        }
        return $query->whereIn('id', $lists);
    }

    /** SAVE DATA **/
    public function handleStoreOrUpdate($request, $level)
    {
        $this->beginTransaction();
        try {
            if (in_array($level, ['boc', 'bod', 'department', 'subdepartment', 'subsection'])) {
                if ($root = static::root()->first()) {
                    $this->phone = $root->phone;
                    $this->address = $root->address;
                }
            }
            $this->fill($request->all());
            $this->updated_at = now();
            $this->level = $level;
            $this->code = $this->code ?: $this->getNewCode($level);
            $this->save();

            if ($level == 'group') {
                $this->childOfGroup()->sync($request->department);
            }
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
                return $this->rollback(__('base.error.related'));
            }
            $this->saveLogNotify();
            $this->delete();

            return $this->commitDeleted();
        } catch (\Exception $e) {
            return $this->rollbackDeleted($e);
        }
    }

    public function handleImport($request, $level)
    {
        $this->beginTransaction();
        try {
            $file = TempFiles::find($request->uploads['temp_files_ids'][0]);
            if (!$file || !\Storage::disk('public')->exists($file->file_path)) {
                $this->rollback('File tidak tersedia!');
            }

            $filePath = \Storage::disk('public')->path($file->file_path);
            \Excel::import(new OrgStructImport($level), $filePath);

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
            case $routes . '.importSave':
                auth()->user()->addLog('Import Data Master Struktur Organisasi');
                break;
        }
    }

    /** OTHER FUNCTIONS **/
    public function canDeleted()
    {
        if (in_array($this->type, [1, 2, 3, 4, 5])) return false;
        if (in_array($this->level, ['root', 'boc'])) return false;
        if ($this->child()->exists()) return false;
        if ($this->structGroup()->exists()) return false;
        if ($this->positions()->exists()) return false;

        return true;
    }

    public function getNewCode($level)
    {
        switch ($level) {
            case 'root':
                $max = static::root()->max('code');
                return $max ? $max + 1 : 1001;
            case 'boc':
                $max = static::bod()->max('code');
                return $max ? $max + 1 : 1101;
            case 'department':
                $max = static::department()->max('code');
                return $max ? $max + 1 : 2001;
            case 'subdepartment':
                $max = static::subdepartment()->max('code');
                return $max ? $max + 1 : 3001;
            case 'subsection':
                $max = static::subsection()->max('code');
                return $max ? $max + 1 : 4001;
        }
        return null;
    }

    public function getIdsWithChild()
    {
        $ids = [$this->id];
        foreach ($this->child as $child) {
            $ids = array_merge($ids, $child->getIdsWithChild());
        }
        return $ids;
    }
}
