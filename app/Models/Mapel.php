<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mapel extends Model
{
    protected $table = 'mapel';
    protected $primaryKey = 'mapel_id';

    protected $fillable = ['kode_mapel', 'nama_mapel', 'deskripsi'];

    public function guru(): HasMany
    {
        return $this->hasMany(Guru::class, 'mapel_id', 'mapel_id');
    }
}