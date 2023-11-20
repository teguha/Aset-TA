<?php

namespace App\Models\Globals;

use App\Models\Model;
use App\Models\Rkia\Summary;

class RevisiFiles extends Model
{
    protected $table = 'sys_revisi';

    protected $fillable = [
        'target_id',
        'target_type',
        'module',
        'version',
        'file_name',
        'file_path',
        'file_size',
        'summary_id',
        'flag', //Tambahkan flag jika ada kondisi tertentu
    ];

    protected $appends = [
        'file_url',
    ];

    public function target()
    {
        return $this->morphTo();
    }

    public function summary()
    {
        return $this->belongsTo(Summary::class, 'summary_id');
    }

    public function getFileUrlAttribute()
    {
        if ($this->file_path) {
            // Handle jika ada yg menyimpan full url
            $file_path = explode('/storage/', $this->file_path);
            $file_path = end($file_path);
            return yurl('storage/' . $file_path);
        }
        return null;
    }

    public function getFileTypeAttribute()
    {
        if ($this->file_path) {
            $extension = explode('.', trim($this->file_path));
            return strtolower(end($extension));
        }
        return null;
    }

    public function getFileIconAttribute()
    {
        $icon = 'far fa-file-alt';
        $type = $this->file_type;
        if ($type == 'pdf') {
            $icon = 'text-danger far fa-file-pdf';
        } else if ($type == 'xlsx') {
            $icon = 'text-success far fa-file-excel';
        } else if ($type == 'jpg' || $type == 'png') {
            $icon = 'text-warning far fa-file-image';
        } else if ($type == 'ppt') {
            $icon = 'text-danger far fa-file-powerpoint';
        } else if ($type == 'docx') {
            $icon = 'text-primary far fa-file-word';
        }
        return $icon . ' ' . $type;
    }
}
