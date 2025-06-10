<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Guru extends Model
{
    protected $table = 'guru';
    protected $primaryKey = 'guru_id';
    protected $fillable = ['nuptk', 'nip', 'nama', 'jabatan', 'foto', 'email', 'password', 'jenis_kelamin', 'alamat', 'telepon', 'mapel_id'];

    protected $hidden = ['password'];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function mapel(): BelongsTo
    {
        return $this->belongsTo(Mapel::class, 'mapel_id', 'mapel_id');
    }
}