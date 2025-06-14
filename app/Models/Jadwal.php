<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;
    
    protected $table = 'jadwals';
    protected $primaryKey = 'jadwal_id';
    
    protected $fillable = [
        'hari',
        'jam_ke',
        'jam_mulai',
        'jam_selesai',
        'mapel_id',
        'guru_id',
        'kelas_id',
        'kurikulum_id',
        'tahun_ajaran',
        'status',
        'catatan'
    ];
    
    protected $casts = [
        'jam_mulai' => 'string',
        'jam_selesai' => 'string'
    ];
    
    // Relationship with Mapel (Many-to-One)
    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id', 'mapel_id');
    }
    
    // Relationship with Guru (Many-to-One)
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id', 'guru_id');
    }
    
    // Relationship with Kelas (Many-to-One)
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'kelas_id');
    }
    
    // Relationship with Kurikulum (Many-to-One)
    public function kurikulum()
    {
        return $this->belongsTo(Kurikulum::class, 'kurikulum_id', 'kurikulum_id');
    }
    
    // Scope for active schedules
    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }
    
    // Scope for specific day
    public function scopeByHari($query, $hari)
    {
        return $query->where('hari', $hari);
    }
    
    // Scope for specific class
    public function scopeByKelas($query, $kelasId)
    {
        return $query->where('kelas_id', $kelasId);
    }
    
    // Scope for specific teacher
    public function scopeByGuru($query, $guruId)
    {
        return $query->where('guru_id', $guruId);
    }
    
    // Scope for specific academic year
    public function scopeByTahunAjaran($query, $tahunAjaran)
    {
        return $query->where('tahun_ajaran', $tahunAjaran);
    }
    
    // Scope for specific time slot
    public function scopeByJamKe($query, $jamKe)
    {
        return $query->where('jam_ke', $jamKe);
    }
    
    // Get schedule for a specific day and class
    public function scopeJadwalHarian($query, $hari, $kelasId, $tahunAjaran)
    {
        return $query->where('hari', $hari)
                    ->where('kelas_id', $kelasId)
                    ->where('tahun_ajaran', $tahunAjaran)
                    ->where('status', 'aktif')
                    ->orderBy('jam_ke');
    }
    
    // Get teacher's schedule for a specific day
    public function scopeJadwalGuru($query, $hari, $guruId, $tahunAjaran)
    {
        return $query->where('hari', $hari)
                    ->where('guru_id', $guruId)
                    ->where('tahun_ajaran', $tahunAjaran)
                    ->where('status', 'aktif')
                    ->orderBy('jam_ke');
    }
    
    // Check if there's a schedule conflict
    public static function hasConflict($hari, $jamKe, $kelasId, $guruId, $tahunAjaran, $excludeId = null)
    {
        $query = self::where('hari', $hari)
                    ->where('jam_ke', $jamKe)
                    ->where('tahun_ajaran', $tahunAjaran)
                    ->where('status', 'aktif')
                    ->where(function($q) use ($kelasId, $guruId) {
                        $q->where('kelas_id', $kelasId)
                          ->orWhere('guru_id', $guruId);
                    });
        
        if ($excludeId) {
            $query->where('jadwal_id', '!=', $excludeId);
        }
        
        return $query->exists();
    }
}