<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Guru extends Model
{
    protected $table = 'guru';
    protected $primaryKey = 'guru_id';
    protected $fillable = ['nuptk', 'nip', 'nama', 'jabatan', 'foto', 'email', 'password', 'jenis_kelamin', 'alamat', 'telepon'];

    protected $hidden = ['password'];

    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     * Relasi many-to-many dengan Mapel melalui tabel pivot guru_mapel
     */
    public function mapels(): BelongsToMany
    {
        return $this->belongsToMany(Mapel::class, 'guru_mapel', 'guru_id', 'mapel_id')
                    ->withPivot(['kelas', 'tahun_ajaran', 'status', 'catatan'])
                    ->withTimestamps();
    }

    /**
     * Mendapatkan mapel aktif yang diajar guru
     */
    public function mapelsAktif(): BelongsToMany
    {
        return $this->mapels()->wherePivot('status', 'aktif');
    }

    /**
     * Mendapatkan mapel berdasarkan tahun ajaran
     */
    public function mapelsByTahunAjaran($tahunAjaran): BelongsToMany
    {
        return $this->mapels()->wherePivot('tahun_ajaran', $tahunAjaran);
    }
}