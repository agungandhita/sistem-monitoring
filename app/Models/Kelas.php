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
        'kapasitas_maksimal',
        'deskripsi',
        'status'
    ];
    
    protected $casts = [
        'tingkat' => 'integer',
        'kapasitas_maksimal' => 'integer'
    ];
    
    // Relationship with Rombel (One-to-Many)
    public function rombels()
    {
        return $this->hasMany(Rombel::class, 'kelas_id', 'kelas_id');
    }
    
    // Get active rombels for this class
    public function activeRombels()
    {
        return $this->rombels()->where('status', 'aktif');
    }
    
    // Get students through rombels
    public function students()
    {
        return $this->hasManyThrough(
            Siswa::class,
            Rombel::class,
            'kelas_id', // Foreign key on rombels table
            'siswa_id', // Foreign key on rombel_siswa table
            'kelas_id', // Local key on kelas table
            'rombel_id' // Local key on rombels table
        )->wherePivot('status', 'aktif');
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
}
