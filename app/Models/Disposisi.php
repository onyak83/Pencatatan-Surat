<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Disposisi extends Model
{
    protected $table = 'disposisis';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'suratmasuk_id',
        'no_disposisi',
        'dari_user_id',
        'dari_pegawai_id',
        'kepada_pegawai_id',
        'instruksi',
        'batas_waktu',
        'status',
        'tgl_dikirim',
        'tgl_diterima',
    ];

    protected $casts = [
        'batas_waktu'   => 'date',
        'tgl_dikirim'   => 'datetime',
        'tgl_diterima'  => 'datetime',
    ];

    /**
     * Generate UUID ketika membuat data disposisi.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    /**
     * Relasi ke Surat Masuk.
     */
    public function suratMasuk()
    {
        return $this->belongsTo(SuratMasuk::class, 'suratmasuk_id', 'id');
    }

    /**
     * User pengirim.
     *
     * Digunakan terutama untuk disposisi pertama:
     * Operator → Sekretaris
     */
    public function dariUser()
    {
        return $this->belongsTo(User::class, 'dari_user_id', 'id');
    }

    /**
     * Pegawai yang mengirim disposisi.
     *
     * Digunakan setelah disposisi berada pada
     * Sekretaris / Kepala Dinas.
     */
    public function dariPegawai()
    {
        return $this->belongsTo(Pegawaipu::class, 'dari_pegawai_id', 'id');
    }

    /**
     * Pegawai penerima disposisi.
     */
    public function kepadaPegawai()
    {
        return $this->belongsTo(Pegawaipu::class, 'kepada_pegawai_id', 'id');
    }
}
