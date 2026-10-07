<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenissuratkeluar extends Model
{
    use HasFactory;

    protected $table = 'jenissuratkeluars';

    protected $fillable = [
        'jenis_suratkeluar',
    ];

    public function Suratkeluar()
    {
        return $this->hasMany(Suratkeluar::class, 'jenis_suratkeluar_id');
    }
}
