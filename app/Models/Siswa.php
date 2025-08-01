<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    
    protected $table = 'siswas';
    protected $primaryKey = 'siswa_id';
    
    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'siswa_id';
    }
    
    protected $fillable = [
        'nis',
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'tempat_lahir',
        'alamat',
        'telepon',
        'kelas_id',
        'tahun_masuk',
        'status',
        'catatan'
    ];
    
    protected $casts = [
        'tanggal_lahir' => 'date'
    ];
    
    // Many-to-many relationship with Wali
    public function walis()
    {
        return $this->belongsToMany(Wali::class, 'wali_siswa', 'siswa_id', 'wali_id')
                    ->withPivot('hubungan')
                    ->withTimestamps();
    }
    
    // Relationship with Kelas (Many-to-One)
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'kelas_id');
    }
    
    // Get jadwals for this student's class
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'kelas_id', 'kelas_id');
    }
    
    // Relationship with NilaiHarian (One-to-Many)
    public function nilaiHarian()
    {
        return $this->hasMany(NilaiHarian::class, 'siswa_id', 'siswa_id');
    }
    
    // Relationship with CatatanPerkembangan (One-to-Many)
    public function catatanPerkembangan()
    {
        return $this->hasMany(CatatanPerkembangan::class, 'siswa_id', 'siswa_id');
    }
    
    // Scope for students in specific grade
    public function scopeInGrade($query, $tingkat)
    {
        return $query->where('kelas', $tingkat);
    }
    
    // Scope for students without class assignment
    public function scopeWithoutClass($query)
    {
        return $query->whereNull('nama_kelas');
    }
    
    // Scope for active students
    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }
}
