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
        'catatan',
        'kategori',
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
}