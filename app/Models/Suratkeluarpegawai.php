<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Suratkeluarpegawai extends Model
{
    use HasFactory;

    protected $table = 'suratkeluarpegawais';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'suratkeluar_id',
        'pegawaipu_id',
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

    public function suratKeluar()
    {
        return $this->belongsTo(Suratkeluar::class, 'suratkeluar_id');
    }

    public function pegawaiPu()
    {
        return $this->belongsTo(Pegawaipu::class, 'pegawaipu_id', 'id');
    }
}
