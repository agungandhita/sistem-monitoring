<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    use HasFactory;
    
    protected $table = 'kurikulums';
    protected $primaryKey = 'kurikulum_id';
    
    protected $fillable = [
        'nama_kurikulum',
        'tahun_ajaran'
    ];
    
    // Direct relationship with Mapel
    public function mapels()
    {
        return $this->hasMany(Mapel::class, 'kurikulum_id', 'kurikulum_id');
    }
    
    // Relationship through pivot table to get gurus
    public function gurus()
    {
        return $this->belongsToMany(Guru::class, 'guru_mapel', 'kurikulum_id', 'guru_id')
                    ->withPivot('mapel_id', 'kelas')
                    ->withTimestamps();
    }
    
    // Relationship through pivot table to get mapels (for backward compatibility)
    public function mapelsPivot()
    {
        return $this->belongsToMany(Mapel::class, 'guru_mapel', 'kurikulum_id', 'mapel_id')
                    ->withPivot('guru_id', 'kelas')
                    ->withTimestamps();
    }
}
