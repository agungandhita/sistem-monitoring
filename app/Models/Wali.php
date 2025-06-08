<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wali extends Model
{
    use HasFactory;

    protected $table = "walis";
    protected $primaryKey = "wali_id";


    protected $guarded =[
        'wali_id'
    ];

    // public function santri()
    // {
    //     return $this->hasMany(Santri::class,'santri_id', 'wali_id');
    // }
}
