<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruMapel extends Model
{
    use HasFactory;
    
    protected $table = 'guru_mapel';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'guru_id',
        'mapel_id',
        'kurikulum_id',
        'kelas_id'
    ];
    
    // Relationship with Guru (Many-to-One)
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id', 'guru_id');
    }
    
    // Relationship with Mapel (Many-to-One)
    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id', 'mapel_id');
    }
    
    // Relationship with Kurikulum (Many-to-One)
    public function kurikulum()
    {
        return $this->belongsTo(Kurikulum::class, 'kurikulum_id', 'kurikulum_id');
    }
    
    // Relationship with Kelas (Many-to-One)
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'kelas_id');
    }
    
    // Scope for specific teacher
    public function scopeByGuru($query, $guruId)
    {
        return $query->where('guru_id', $guruId);
    }
    
    // Scope for specific subject
    public function scopeByMapel($query, $mapelId)
    {
        return $query->where('mapel_id', $mapelId);
    }
    
    // Scope for specific class
    public function scopeByKelas($query, $kelasId)
    {
        return $query->where('kelas_id', $kelasId);
    }
    
    // Scope for specific curriculum
    public function scopeByKurikulum($query, $kurikulumId)
    {
        return $query->where('kurikulum_id', $kurikulumId);
    }
}