<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kantor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_cabang',
        'kode_cabang',
        'no_telepon',
        'alamat',
        'pic',
        'tanggal_registrasi',
    ];

    protected $casts = [
        'tanggal_registrasi' => 'date:F j, Y',
    ];

    public function pic()
    {
        return $this->belongsTo(User::class);
    }
}
