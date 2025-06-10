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
}
