<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    
    protected $table = 'kelas';
    protected $primaryKey = 'kelas_id';
    
    protected $fillable = [
        'nama_kelas',
        'tingkat',
        'tahun_ajaran',
        'kurikulum_id',
        'kapasitas',
        'status'
    ];
    public function getRouteKeyName()
    {
        return 'kelas_id'; // Sesuaikan dengan primary key Anda
    }
    // Relationship with Kurikulum (Many-to-One)
    public function kurikulum()
    {
        return $this->belongsTo(Kurikulum::class, 'kurikulum_id', 'kurikulum_id');
    }
    
    // Relationship with Siswa (One-to-Many)
    public function siswas()
    {
        return $this->hasMany(Siswa::class, 'kelas_id', 'kelas_id');
    }
    
    // Relationship with GuruMapel (One-to-Many)
    public function guruMapels()
    {
        return $this->hasMany(GuruMapel::class, 'kelas_id', 'kelas_id');
    }
    
    // Relationship with Jadwal (One-to-Many)
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'kelas_id', 'kelas_id');
    }
    
    // Get gurus that teach in this class
    public function gurus()
    {
        return $this->belongsToMany(Guru::class, 'guru_mapel', 'kelas_id', 'guru_id')
                    ->withPivot('mapel_id', 'kurikulum_id')
                    ->withTimestamps();
    }
    
    // Get mapels taught in this class
    public function mapels()
    {
        return $this->belongsToMany(Mapel::class, 'guru_mapel', 'kelas_id', 'mapel_id')
                    ->withPivot('guru_id', 'kurikulum_id')
                    ->withTimestamps();
    }
    
    // Scope for active classes
    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }
    
    // Scope for specific grade level
    public function scopeByTingkat($query, $tingkat)
    {
        return $query->where('tingkat', $tingkat);
    }
    
    // Scope for specific academic year
    public function scopeByTahunAjaran($query, $tahunAjaran)
    {
        return $query->where('tahun_ajaran', $tahunAjaran);
    }
    
    // Get total students in this class
    public function getTotalSiswaAttribute()
    {
        return $this->siswas()->count();
    }
    
    // Check if class is full
    public function getIsFullAttribute()
    {
        return $this->total_siswa >= $this->kapasitas;
    }
}