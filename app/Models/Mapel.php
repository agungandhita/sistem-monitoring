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
        'deskripsi',
        'kurikulum_id'
    ];
    
    // Many-to-many relationship with Guru through guru_mapel pivot table
    public function gurus()
    {
        return $this->belongsToMany(Guru::class, 'guru_mapel', 'mapel_id', 'guru_id')
                    ->withPivot('kurikulum_id', 'kelas_id')
                    ->withTimestamps();
    }
    
    // Direct relationship with Kurikulum
    public function kurikulum()
    {
        return $this->belongsTo(Kurikulum::class, 'kurikulum_id', 'kurikulum_id');
    }
    
    // Relationship through pivot table to get curriculum (for backward compatibility)
    public function kurikulums()
    {
        return $this->belongsToMany(Kurikulum::class, 'guru_mapel', 'mapel_id', 'kurikulum_id')
                    ->withPivot('guru_id', 'kelas_id')
                    ->withTimestamps();
    }
    
    // Relationship with Kelas through guru_mapel pivot table
    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'guru_mapel', 'mapel_id', 'kelas_id')
                    ->withPivot('guru_id', 'kurikulum_id')
                    ->withTimestamps();
    }
    
    // Relationship with Jadwal (One-to-Many)
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'mapel_id', 'mapel_id');
    }
}
