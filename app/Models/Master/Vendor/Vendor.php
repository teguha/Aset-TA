<?php

namespace App\Models\Master\Vendor;

use App\Imports\Master\ExampleImport;
use App\Models\Globals\TempFiles;
use App\Models\Master\Geo\City;
use App\Models\Master\Geo\Province;
use App\Models\Model;
use App\Models\Traits\RaidModel;
use App\Models\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Vendor extends Model
{
    use RaidModel, ResponseTrait;
    // use HasUuids;
    // protected $primaryKey = 'uuid';

    public $table = 'ref_vendor';

    protected $fillable = [
        "name", "address", "ref_province_id", "ref_city_id", "id_vendor",
        "telp", "email", "contact_person", "status",
    ];

    public function provinsi() {
        return $this->belongsTo(Province::class, 'ref_province_id');
    }

    public function kota() {
        return $this->belongsTo(City::class, "ref_city_id");
    }

    public function getProvinceName() {
        return $this->provinsi->name;
    }

    public function getCityName() {
        return $this->kota->name;
    }

    /*******************************
     ** MUTATOR
     *******************************/

    /*******************************
     ** ACCESSOR
     *******************************/

    /*******************************
     ** RELATION
     *******************************/
    public function barang()
    {
        return $this->hasMany(Barang::class, 'vendor_id', 'uuid');
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
        ->filterBy(['status']);
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

    public function handleImport($request)
    {
        $this->beginTransaction();
        try {
            $file = TempFiles::find($request->uploads['temp_files_ids'][0]);
            if (!$file || !\Storage::disk('public')->exists($file->file_path)) {
                $this->rollback('File tidak tersedia!');
            }

            $filePath = \Storage::disk('public')->path($file->file_path);
            \Excel::import(new ExampleImport(), $filePath);

            $this->saveLogNotify();

            return $this->commitSaved();
        } catch (\Exception $e) {
            return $this->rollbackSaved($e);
        }
    }

    public function checkAction($action, $perms)
    {
        $user = auth()->user();
        switch ($action) {
            case 'create':
                return $user->checkPerms($perms . '.create');

            case 'edit':
                return $user->checkPerms($perms . '.edit');

            case 'show':
                return true;

            case 'delete':
                return $this->canDeleted() && $user->checkPerms($perms . '.delete');
        }

        return false;
    }

    /*******************************
     ** OTHER FUNCTIONS
     *******************************/
    public function canDeleted()
    {
        // if($this->barang->count() || $this->pembelian->count()) return false;

        return true;
    }
}
