<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;
    
    protected $table = 'mapels';
    protected $primaryKey = 'mapel_id';
    
    protected $fillable = [
        'kode_mapel',
        'mapel',
        'deskripsi'
    ];
    
    // Many-to-many relationship with Guru through guru_mapel pivot table
    public function gurus()
    {
        return $this->belongsToMany(Guru::class, 'guru_mapel', 'mapel_id', 'guru_id')
                    ->withPivot('kurikulum_id', 'kelas')
                    ->withTimestamps();
    }
    
    // Relationship through pivot table to get curriculum
    public function kurikulums()
    {
        return $this->belongsToMany(Kurikulum::class, 'guru_mapel', 'mapel_id', 'kurikulum_id')
                    ->withPivot('guru_id', 'kelas')
                    ->withTimestamps();
    }
}
