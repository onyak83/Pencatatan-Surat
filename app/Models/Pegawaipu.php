<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pegawaipu extends Model
{
    use HasFactory;

    protected $table = 'pegawaipus';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable =
        [
            'nama',
            'nip',
            'pangkat_id',
            'jabatan',
            'no_hp',
            'email',
            'alamat',
            'urut_hirarki',
        ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function pangkat()
    {
        return $this->belongsTo(Pangkat::class, 'pangkat_id', 'id');
    }
}
