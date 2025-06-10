<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Mapel extends Model
{
    protected $table = 'mapel';
    protected $primaryKey = 'mapel_id';

    protected $fillable = ['kode_mapel', 'nama_mapel', 'deskripsi'];

    /**
     * Relasi many-to-many dengan Guru melalui tabel pivot guru_mapel
     */
    public function gurus(): BelongsToMany
    {
        return $this->belongsToMany(Guru::class, 'guru_mapel', 'mapel_id', 'guru_id')
                    ->withPivot(['kelas', 'tahun_ajaran', 'status', 'catatan'])
                    ->withTimestamps();
    }

    /**
     * Mendapatkan guru aktif yang mengajar mapel ini
     */
    public function gurusAktif(): BelongsToMany
    {
        return $this->gurus()->wherePivot('status', 'aktif');
    }

    /**
     * Mendapatkan guru berdasarkan tahun ajaran
     */
    public function gurusByTahunAjaran($tahunAjaran): BelongsToMany
    {
        return $this->gurus()->wherePivot('tahun_ajaran', $tahunAjaran);
    }

    /**
     * Mendapatkan guru berdasarkan kelas
     */
    public function gurusByKelas($kelas): BelongsToMany
    {
        return $this->gurus()->wherePivot('kelas', $kelas);
    }
}