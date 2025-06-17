<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiHarian extends Model
{
    use HasFactory;
    
    protected $table = 'nilai_harians';
    protected $primaryKey = 'nilai_id';
    
    protected $fillable = [
        'siswa_id',
        'guru_id',
        'mapel_id',
        'kelas_id',
        'tanggal',
        'nilai',
        'jenis_penilaian',
        'keterangan',
        'semester',
        'tahun_ajaran'
    ];
    
    protected $casts = [
        'tanggal' => 'date',
        'nilai' => 'decimal:2'
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
    
    // Relationship with Mapel
    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id', 'mapel_id');
    }
    
    // Relationship with Kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'kelas_id');
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
    
    // Scope untuk filter berdasarkan mapel
    public function scopeByMapel($query, $mapelId)
    {
        return $query->where('mapel_id', $mapelId);
    }
    
    // Scope untuk filter berdasarkan kelas
    public function scopeByKelas($query, $kelasId)
    {
        return $query->where('kelas_id', $kelasId);
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
    
    // Method untuk mendapatkan rata-rata nilai siswa per mapel
    public static function getRataRataNilai($siswaId, $mapelId, $semester = null, $tahunAjaran = null)
    {
        $query = self::where('siswa_id', $siswaId)
                    ->where('mapel_id', $mapelId);
                    
        if ($semester) {
            $query->where('semester', $semester);
        }
        
        if ($tahunAjaran) {
            $query->where('tahun_ajaran', $tahunAjaran);
        }
        
        return $query->avg('nilai');
    }
}