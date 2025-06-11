<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalHarian extends Model
{
    use HasFactory;
    
    protected $table = 'jadwal_harian';
    protected $primaryKey = 'jadwal_id';
    
    protected $fillable = [
        'rombel_id',
        'mapel_id',
        'guru_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'jam_ke',
        'tahun_ajaran',
        'semester',
        'keterangan',
        'status'
    ];
    
    protected $casts = [
        'jam_mulai' => 'datetime:H:i',
        'jam_selesai' => 'datetime:H:i',
        'jam_ke' => 'integer'
    ];
    
    // Relationship with Rombel (Many-to-One)
    public function rombel()
    {
        return $this->belongsTo(Rombel::class, 'rombel_id', 'rombel_id');
    }
    
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
    
    // Scope for specific academic year
    public function scopeByTahunAjaran($query, $tahunAjaran)
    {
        return $query->where('tahun_ajaran', $tahunAjaran);
    }
    
    // Scope for specific semester
    public function scopeBySemester($query, $semester)
    {
        return $query->where('semester', $semester);
    }
    
    // Scope for specific rombel
    public function scopeByRombel($query, $rombelId)
    {
        return $query->where('rombel_id', $rombelId);
    }
    
    // Scope for specific teacher
    public function scopeByGuru($query, $guruId)
    {
        return $query->where('guru_id', $guruId);
    }
    
    // Get weekly schedule for a rombel
    public static function getWeeklySchedule($rombelId, $tahunAjaran, $semester)
    {
        return self::with(['mapel', 'guru'])
                   ->where('rombel_id', $rombelId)
                   ->where('tahun_ajaran', $tahunAjaran)
                   ->where('semester', $semester)
                   ->where('status', 'aktif')
                   ->orderBy('hari')
                   ->orderBy('jam_ke')
                   ->get()
                   ->groupBy('hari');
    }
    
    // Check for schedule conflicts
    public function hasConflict()
    {
        return self::where('guru_id', $this->guru_id)
                   ->where('hari', $this->hari)
                   ->where('tahun_ajaran', $this->tahun_ajaran)
                   ->where('semester', $this->semester)
                   ->where('status', 'aktif')
                   ->where('jadwal_id', '!=', $this->jadwal_id ?? 0)
                   ->where(function($query) {
                       $query->whereBetween('jam_mulai', [$this->jam_mulai, $this->jam_selesai])
                             ->orWhereBetween('jam_selesai', [$this->jam_mulai, $this->jam_selesai])
                             ->orWhere(function($q) {
                                 $q->where('jam_mulai', '<=', $this->jam_mulai)
                                   ->where('jam_selesai', '>=', $this->jam_selesai);
                             });
                   })
                   ->exists();
    }
}
