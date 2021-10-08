<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nasabah extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id';

    protected $fillable = [
        'nama',
        'no_hp',
        'no_ktp',
        'ktp_terbit',
        'ktp_berlaku_sampai',
        'jenis_kelamin',
        'status_pernikahan',
        'gelar_nasabah',
        'nama_gadis_ibu_kandung',
        'no_npwp',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat_ktp',
        'provinsi',
        'kota',
        'kecamatan',
        'kelurahan',
        'rw',
        'rt',
        'kode_pos',
        'nama_pasangan',
        'hubungan',
        'ktp_pasangan',
        'tanggal_lahir_pasangan',
        'no_hp_pasangan',
        'card_id',
    ];

    public function card()
    {
        return $this->belongsTo(Card::class, 'card_id', 'id');
    }
    public function dokumen()
    {
        return $this->hasMany(DokumenNasabah::class);
    }
}
