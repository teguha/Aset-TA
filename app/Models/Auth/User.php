<?php

namespace App\Models\Auth;

use App\Imports\Setting\UserImport;
use App\Models\Auth\Pendidikan;
use App\Models\Auth\Sertifikasi;
use App\Models\Globals\Activity;
use App\Models\Globals\Approval;
use App\Models\Globals\Notification;
use App\Models\Globals\TempFiles;
use App\Models\Master\Fee\BankAccount;
use App\Models\Master\Org\OrgStruct;
use App\Models\Master\Org\Position;
use App\Models\Rkia\Rkia;
use App\Models\Rkia\Summary;
use App\Models\Survey\SurveyRegUser;
use App\Models\Traits\RaidModel;
use App\Models\Traits\ResponseTrait;
use App\Models\Traits\Utilities;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasRoles;
    use RaidModel, Utilities, ResponseTrait;

    protected $table = 'sys_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'nik',
        'npp',
        'image',
        'phone',
        'position_id',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /** MUTATOR **/
    /** ACCESSOR **/
    public function getImagePathAttribute()
    {
        if ($this->image) {
            if (\Storage::disk('public')->exists($this->image)) {
                return 'storage/' . $this->image;
            }
            $this->update(['image' => null]);
        }
        return 'assets/media/users/default.jpg';
    }

    public function getRolesImplodedAttribute()
    {
        return implode(', ', $this->roles->pluck('name')->toArray());
    }

    /** RELATION **/
    public function notifications()
    {
        return $this->belongsToMany(
            Notification::class,
            'sys_notifications_users',
            'user_id',
            'notification_id'
        )
            ->withPivot('readed_at');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'user_id');
    }

    public function pendidikans()
    {
        return $this->hasMany(Pendidikan::class, 'user_id');
    }

    public function sertifikasis()
    {
        return $this->hasMany(Sertifikasi::class, 'user_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    /** SCOPE **/
    public function scopeGrid($query)
    {
        return $query->orderByRaw("CASE WHEN updated_at > created_at THEN updated_at ELSE created_at END DESC");
    }

    public function scopeFilters($query)
    {
        return $query
            // ->filterBy('status', '=')
            // ->filterBy('position_id', '=')
            ->when(
                $name = request()->post('name'),
                function ($q) use ($name) {
                    $q->where('name', 'LIKE', '%' . $name . '%')->orWhere('email', 'LIKE', '%' . $name . '%');
                }
            )
            ->when(
                $location_id = request()->post('location_id'),
                function ($q) use ($location_id) {
                    $cleanedLocationId = str_replace(['struct--', 'nonpkpt--'], '', $location_id);
                    if (Str::startsWith($location_id, 'struct--')) {
                        $q->whereHas(
                            'position',
                            function ($qq) use ($cleanedLocationId) {
                                $qq->where('location_id', $cleanedLocationId);
                            }
                        );
                    } elseif (Str::startsWith($location_id, 'nonpkpt--')) {
                        $q->whereHas(
                            'position',
                            function ($qq) use ($cleanedLocationId) {
                                $qq->where('nonpkpt_id', $cleanedLocationId);
                            }
                        );
                    }
                }
            )
            ->when(
                $role_id = request()->post('role_id'),
                function ($q) use ($role_id) {
                    $q->whereHas(
                        'roles',
                        function ($qq) use ($role_id) {
                            $qq->where('id', $role_id);
                        }
                    );
                }
            );
    }

    public function scopeWhereHasLocationId($query, $location_id = 0)
    {
        return $query->whereHas(
            'position',
            function ($q) use ($location_id) {
                $q
                    // ->where('location_id', $location_id)
                    ->whereHas(
                        'struct',
                        function ($q) use ($location_id) {
                            $q->where('id', $location_id)
                                ->orWhere('parent_id', $location_id)
                                ->orWhereHas(
                                    'parent',
                                    function ($q) use ($location_id) {
                                        $q->where('parent_id', $location_id);
                                    }
                                );
                        }
                    );
            }
        );
    }

    /** SAVE DATA */
    public function handleStoreOrUpdate($request)
    {
        $this->beginTransaction();
        try {
            $this->fill($request->all());
            if ($request->password) {
                $this->password = bcrypt($request->password);
            }
            $this->save();
            $this->roles()->sync(array_filter($request->roles ?? []));
            $this->saveLogNotify();
            // Clear Perms Cache
            app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

            return $this->commitSaved();
        } catch (\Exception $e) {
            return $this->rollbackSaved($e);
        }
    }

    public function handleDestroy()
    {
        $this->beginTransaction();
        try {
            // if (!$this->canDeleted()) {
            //     return $this->rollback(__('base.error.related'));
            // }
            $this->saveLogNotify();
            $this->delete();

            return $this->commitDeleted();
        } catch (\Exception $e) {
            return $this->rollbackDeleted($e);
        }
    }

    public function handleDestroyPendidikan($id)
    {
        $this->beginTransaction();
        try {
            $temp = Pendidikan::find($id);
            $temp->delete();
            $this->save();

            return $this->commitDeleted();
        } catch (\Exception $e) {
            return $this->rollbackDeleted($e);
        }
    }

    public function handleDestroySertifikasi($id)
    {
        $this->beginTransaction();
        try {
            $temp = Sertifikasi::find($id);
            $temp->delete();
            $this->save();

            return $this->commitDeleted();
        } catch (\Exception $e) {
            return $this->rollbackDeleted($e);
        }
    }

    public function handleResetPassword()
    {
        $this->beginTransaction();
        try {
            $this->password = bcrypt('qwerty123456');
            $this->save();
            $this->saveLogNotify();

            return $this->commitSaved(['redirect' => rut(request()->get('routes') . '.index')]);
        } catch (\Exception $e) {
            return $this->rollbackSaved($e);
        }
    }

    public function handleStoreOrUpdatePendidikan($request)
    {
        $this->beginTransaction();
        try {
            $pendidikan = $this->pendidikans()
                ->firstOrNew(
                    [
                        'jenjang_pendidikan' => $request->jenjang_pendidikan
                    ]
                );
            $pendidikan->fill($request->all());
            $this->pendidikans()->save($pendidikan);
            $pendidikan->saveFilesByTemp($request->attachments, $request->module, 'lampiran_pendidikan');

            $this->save();
            $this->saveLogNotify();

            return $this->commitSaved();
        } catch (\Exception $e) {
            return $this->rollbackSaved($e);
        }
    }

    public function handleStoreOrUpdateSertifikasi($request)
    {
        $this->beginTransaction();
        try {
            $sertifikasi = $this->sertifikasis()
                ->firstOrNew(
                    [
                        'nama_sertif' => $request->nama_sertif
                    ]
                );
            $sertifikasi->fill($request->all());
            $this->sertifikasis()->save($sertifikasi);
            $sertifikasi->saveFilesByTemp($request->attachments, $request->module, 'lampiran_sertifikasi');

            $this->save();
            $this->saveLogNotify();

            return $this->commitSaved();
        } catch (\Exception $e) {
            return $this->rollbackSaved($e);
        }
    }

    public function handleUpdateProfile($request)
    {
        $this->beginTransaction();
        try {
            if ($request->image) {
                $oldImage = $this->image;
                $this->image = $request->image->store('users', 'public');
            }
            $this->phone  = $request->phone;
            $this->email  = $request->email;
            $this->save();
            $this->saveLogNotify();

            // Hapus file image yg lama
            if (!empty($oldImage) && \Storage::disk('public')->exists($oldImage)) {
                \Storage::disk('public')->delete($oldImage);
            }
            return $this->commitSaved(['redirectTo' => rut($request->routes . '.index')]);
        } catch (\Exception $e) {
            return $this->rollbackSaved($e);
        }
    }

    public function handleUpdatePassword($request)
    {
        $this->beginTransaction();
        try {
            $this->password  = bcrypt($request->new_password);
            $this->save();
            $request->merge(['module' => 'profile']);
            $this->saveLogNotify();
            return $this->commitSaved(['redirectTo' => rut($request->routes . '.index')]);
        } catch (\Exception $e) {
            return $this->rollbackSaved($e);
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

            \Excel::import(new UserImport, \Storage::disk('public')->path($file->file_path));

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
            case $routes . '.resetPassword':
                $this->addLog('Reset Password ' . $data);
                break;
            case $routes . '.updateProfile':
                $this->addLog('Mengubah Profil ' . $data);
                break;
            case $routes . '.updatePassword':
                $this->addLog('Mengubah Password ' . $data);
                break;
            case $routes . '.importSave':
                auth()->user()->addLog('Import Data User');
                break;
        }
    }

    /** OTHER FUNCTION **/
    public function canDeleted()
    {
        if (in_array($this->id, [1])) return false;
        if ($this->id == auth()->id()) return false;
        if (BankAccount::where('user_id', $this->id)->exists()) return false;
        if (Approval::where('user_id', $this->id)->exists()) return false;
        if (SurveyRegUser::where('user_id', $this->id)->exists()) return false;

        $check = Summary::where('pic_id', $this->id)
            ->orWhere('leader_id', $this->id)
            ->orWhereHas(
                'members',
                function ($q) {
                    $q->where('user_id', $this->id);
                }
            )
            ->orWhereHas(
                'rkia',
                function ($r) {
                    $r->orWhereHas(
                        'cc',
                        function ($q) {
                            $q->where('user_id', $this->id);
                        }
                    );
                }
            )
            ->orWhereHas(
                'assignment',
                function ($a) {
                    $a->where('pic_id', $this->id)
                        ->orWhere('leader_id', $this->id)
                        ->orWhereHas(
                            'members',
                            function ($q) {
                                $q->where('user_id', $this->id);
                            }
                        );
                }
            )
            ->exists();
        if ($check) return false;

        return true;
    }

    public function checkPerms($permission)
    {
        return $this->hasPermissionTo($permission);
    }

    public function hasAllObjects()
    {
        // Role Administrator
        if ($this->hasRole(1)) {
            return true;
        }

        if ($this->position && ($location = $this->position->location)) {
            // boc, bod, ia division
            if (in_array($location->level, ['boc', 'bod'])) {
                return true;
            }
            if (in_array($location->type, [3])) {
                return true;
            }
            if ($location->parent) {
                if (in_array($location->parent->type, [3])) {
                    return true;
                }
            }
        }

        return false;
    }


    public function hasBodAndEvaluasi()
    {
        // Role Administrator
        if ($this->hasRole(1)) {
            return true;
        }

        if ($this->position && ($location = $this->position->location)) {
            // boc, bod, ia division
            if (in_array($location->level, ['boc', 'bod'])) {
                return true;
            }
            if ($this->position->imAuditorBranchEvaluasi()) {
                return true;
            }
        }

        return false;
    }

    public function approvalType()
    {
        $flag = $this->position->location->flag ?? 0;
        $parent_flag = $this->position->location->parent->flag ?? 0;
        if ($flag == 2) {
            return '01'; // Korwil Utama
        };
        if ($flag == 3) {
            return '02'; // Korwil Barat
        };
        if ($flag == 4) {
            return '03'; // Korwil Timur
        };
        if ($flag == 1 || $parent_flag == 1) {
            return '00'; // SPI
        };
    }

    public function getLastNotificationId()
    {
        $last = $this->notifications()->latest()->first();
        return $last->id ?? 0;
    }

    public function getRoleIds()
    {
        return $this->roles()->pluck('id')->toArray();
    }
}
