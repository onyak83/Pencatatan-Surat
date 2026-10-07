<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Suratmasuk extends Model
{
    protected $table = 'suratmasuks';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'instansi_id',
        'sifat_surat_id',
        'no_agenda',
        'no_surat',
        'tgl_surat',
        'tgl_diterima',
        'perihal',
        'lampiran',
        'file_surat',
        'keterangan',
        'created_by',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function instansi()
    {
        return $this->belongsTo(Instansi::class, 'instansi_id');
    }

    public function sifatSurat()
    {
        return $this->belongsTo(Sifatsurat::class, 'sifat_surat_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function disposisis()
    {
        return $this->hasMany(Disposisi::class, 'suratmasuk_id', 'id');
    }
}
