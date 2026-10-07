<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pangkat extends Model
{
    use HasFactory;

    protected $table = 'pangkats';
    protected $fillable = ['nm_pangkat', 'nm_gol'];

    public function pegawaipu()
    {
        return $this->hasMany(Pegawaipu::class, 'pangkat_id');
    }
}
