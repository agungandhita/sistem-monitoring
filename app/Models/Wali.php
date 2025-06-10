<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wali extends Model
{
    use HasFactory;

    protected $table = "walis";
    protected $primaryKey = "wali_id";


    protected $fillable = [
        'user_id',
        'nama',
        'alamat',
        'telepon',
        'pekerjaan',
        'jenis_kelamin'
    ];
    
    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    
    // Many-to-many relationship with Siswa
    public function siswas()
    {
        return $this->belongsToMany(Siswa::class, 'wali_siswa', 'wali_id', 'siswa_id')
                    ->withPivot('hubungan')
                    ->withTimestamps();
    }
}
