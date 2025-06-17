<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Guru extends Authenticatable
{
    use HasFactory, Notifiable;
    
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
        'tanggal_lahir' => 'date',
        'password' => 'hashed'
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
    
    // Relationship with NilaiHarian (One-to-Many)
    public function nilaiHarian()
    {
        return $this->hasMany(NilaiHarian::class, 'guru_id', 'guru_id');
    }
    
    // Relationship with CatatanPerkembangan (One-to-Many)
    public function catatanPerkembangan()
    {
        return $this->hasMany(CatatanPerkembangan::class, 'guru_id', 'guru_id');
    }
    
    // Relationship with Jadwal (One-to-Many)
    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'guru_id', 'guru_id');
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
