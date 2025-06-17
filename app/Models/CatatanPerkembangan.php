<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanPerkembangan extends Model
{
    use HasFactory;
    
    protected $table = 'catatan_perkembangans';
    protected $primaryKey = 'catatan_id';
    
    protected $fillable = [
        'siswa_id',
        'guru_id',
        'tanggal',
        'jenis_catatan',
        'catatan',
        'semester',
        'tahun_ajaran'
    ];
    
    protected $casts = [
        'tanggal' => 'date'
    ];
    
    // Relationship with Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'siswa_id');
    }
    
    // Relationship with Guru
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id', 'guru_id');
    }
    
    // Scope untuk filter berdasarkan guru
    public function scopeByGuru($query, $guruId)
    {
        return $query->where('guru_id', $guruId);
    }
    
    // Scope untuk filter berdasarkan siswa
    public function scopeBySiswa($query, $siswaId)
    {
        return $query->where('siswa_id', $siswaId);
    }
    
    // Scope untuk filter berdasarkan jenis catatan
    public function scopeByJenis($query, $jenisCatatan)
    {
        return $query->where('jenis_catatan', $jenisCatatan);
    }
    
    // Scope untuk filter berdasarkan tanggal
    public function scopeByTanggal($query, $tanggal)
    {
        return $query->whereDate('tanggal', $tanggal);
    }
    
    // Scope untuk filter berdasarkan periode
    public function scopeByPeriode($query, $startDate, $endDate)
    {
        return $query->whereBetween('tanggal', [$startDate, $endDate]);
    }
}