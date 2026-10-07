<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Suratkeluar extends Model
{
    use HasFactory;

    protected $table = 'suratkeluars';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'jenis_suratkeluar_id',
        'instansi_id',
        'sifat_surat_id',
        'no_agenda',
        'no_surat',
        'tgl_surat',
        'perihal',
        'lampiran',

        //field untuk surat tugas
        'jumlah_hari_tugas',
        'ikut_dlm_tugas',
        'tujuan_tugas',
        'maksud_tujuan_tugas',
        'mulai_tugas',
        'selesai_tugas',

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

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function jenisSuratKeluar()
    {
        return $this->belongsTo(Jenissuratkeluar::class, 'jenis_suratkeluar_id', 'id');
    }

    public function pegawai()
    {
        return $this->hasMany(Suratkeluarpegawai::class, 'suratkeluar_id', 'id');
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
}
