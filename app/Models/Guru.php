<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;
    
    protected $table = 'gurus';
    protected $primaryKey = 'guru_id';
    
    protected $fillable = [
        'nuptk',
        'nip',
        'nama',
        'foto',
        'alamat',
        'tanggal_lahir',
        'nomor_hp',
        'email',
        'password',
        'jabatan',
        'tahun_masuk'
    ];
    
    protected $casts = [
        'tanggal_lahir' => 'date'
    ];
    
    protected $hidden = [
        'password'
    ];
    
    // Many-to-many relationship with Mapel through guru_mapel pivot table
    public function mapels()
    {
        return $this->belongsToMany(Mapel::class, 'guru_mapel', 'guru_id', 'mapel_id')
                    ->withPivot('kurikulum_id', 'kelas_id')
                    ->withTimestamps();
    }
    
    // Relationship through pivot table to get curriculum
    public function kurikulums()
    {
        return $this->belongsToMany(Kurikulum::class, 'guru_mapel', 'guru_id', 'kurikulum_id')
                    ->withPivot('mapel_id', 'kelas_id')
                    ->withTimestamps();
    }
    
    // Relationship with Kelas through guru_mapel pivot table
    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'guru_mapel', 'guru_id', 'kelas_id')
                    ->withPivot('mapel_id', 'kurikulum_id')
                    ->withTimestamps();
    }
    
    // Relationship with Jadwal (One-to-Many)
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'guru_id', 'guru_id');
    }
}
