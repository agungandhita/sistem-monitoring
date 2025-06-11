<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rombel extends Model
{
    use HasFactory;
    
    protected $table = 'rombels';
    protected $primaryKey = 'rombel_id';
    
    protected $fillable = [
        'kelas_id',
        'nama_rombel',
        'tahun_ajaran',
        'kapasitas_maksimal',
        'jumlah_siswa_saat_ini',
        'wali_kelas_id',
        'deskripsi',
        'status'
    ];
    
    protected $casts = [
        'kapasitas_maksimal' => 'integer',
        'jumlah_siswa_saat_ini' => 'integer'
    ];
    
    // Relationship with Kelas (Many-to-One)
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'kelas_id');
    }
    
    // Relationship with Guru as Wali Kelas (Many-to-One)
    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas_id', 'guru_id');
    }
    
    // Many-to-many relationship with Siswa
    public function siswas()
    {
        return $this->belongsToMany(Siswa::class, 'rombel_siswa', 'rombel_id', 'siswa_id')
                    ->withPivot('tahun_ajaran', 'tanggal_masuk', 'tanggal_keluar', 'status', 'keterangan')
                    ->withTimestamps();
    }
    
    // Get active students
    public function activeSiswas()
    {
        return $this->siswas()->wherePivot('status', 'aktif');
    }
    
    // Relationship with JadwalHarian (One-to-Many)
    public function jadwalHarian()
    {
        return $this->hasMany(JadwalHarian::class, 'rombel_id', 'rombel_id');
    }
    
    // Get schedule for specific day
    public function getScheduleByDay($hari)
    {
        return $this->jadwalHarian()
                    ->where('hari', $hari)
                    ->where('status', 'aktif')
                    ->orderBy('jam_ke')
                    ->with(['mapel', 'guru'])
                    ->get();
    }
    
    // Scope for active rombels
    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }
    
    // Scope for specific academic year
    public function scopeByTahunAjaran($query, $tahunAjaran)
    {
        return $query->where('tahun_ajaran', $tahunAjaran);
    }
    
    // Check if rombel has capacity for new students
    public function hasCapacity()
    {
        return $this->jumlah_siswa_saat_ini < $this->kapasitas_maksimal;
    }
    
    // Update student count
    public function updateStudentCount()
    {
        $count = $this->activeSiswas()->count();
        $this->update(['jumlah_siswa_saat_ini' => $count]);
        return $count;
    }
}
