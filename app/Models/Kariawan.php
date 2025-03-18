<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kariawan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nomor_identifikasi',
        'umur',
        'alamat',
        'pekerjaan',
        'tempat_lahir',
        'tanggal_lahir',
    ];
}
