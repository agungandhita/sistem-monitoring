<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    
    protected $table = 'siswas';
    protected $primaryKey = 'siswa_id';
    
    protected $fillable = [
        'nis',
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'tempat_lahir',
        'alamat',
        'telepon',
        'kelas',
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
    
    // Many-to-many relationship with Rombel through rombel_siswa pivot table
    public function rombels()
    {
        return $this->belongsToMany(Rombel::class, 'rombel_siswa', 'siswa_id', 'rombel_id')
                    ->withPivot('tahun_ajaran', 'tanggal_masuk', 'tanggal_keluar', 'status', 'keterangan')
                    ->withTimestamps();
    }
    
    // Get current active rombel
    public function currentRombel($tahunAjaran = null)
    {
        $query = $this->rombels()->wherePivot('status', 'aktif');
        
        if ($tahunAjaran) {
            $query->wherePivot('tahun_ajaran', $tahunAjaran);
        }
        
        return $query->first();
    }
    
    // Get schedule for current rombel
    public function getSchedule($tahunAjaran = null)
    {
        $rombel = $this->currentRombel($tahunAjaran);
        
        if (!$rombel) {
            return collect();
        }
        
        return $rombel->weeklySchedule()->get();
    }
    
    // Check if student is assigned to any rombel for academic year
    public function hasRombelForYear($tahunAjaran)
    {
        return $this->rombels()
                    ->wherePivot('tahun_ajaran', $tahunAjaran)
                    ->wherePivot('status', 'aktif')
                    ->exists();
    }
    
    // Scope for students without rombel assignment
    public function scopeWithoutRombel($query, $tahunAjaran)
    {
        return $query->whereDoesntHave('rombels', function ($q) use ($tahunAjaran) {
            $q->where('tahun_ajaran', $tahunAjaran)
              ->where('status', 'aktif');
        });
    }
    
    // Scope for students in specific grade
    public function scopeInGrade($query, $tingkat)
    {
        return $query->where('kelas', 'like', $tingkat . '%');
    }
}
