<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPeserta extends Model
{
    use HasFactory;
    protected $table = 'data_pesertas';
    protected $fillable = [
        'user_id',
        'nim',
        'jurusan',
        'angkatan',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
