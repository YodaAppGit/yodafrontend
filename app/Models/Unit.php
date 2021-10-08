<?php

namespace App\Models;

use App\Http\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Unit extends Model
{
    use HasFactory, SoftDeletes, ImageTrait;

    protected $primaryKey = 'id';

    protected $fillable = [
        'plat_nomor',
        'merek',
        'model',
        'varian',
        'tahun',
        'jarak_tempuh',
        'bahan_bakar',
        'warna',
        'catatan',
        'cover',
        'penjual_id',
        'latitude',
        'longitude',
        'alamat',
        'harga',
        'keyword'
    ];

    public function penjual()
    {
        return $this->belongsTo(Penjual::class, 'penjual_id', 'id');
    }

    public function getImageLinksAttribute()
    {
        $links = $this->getImageList($this->attributes['id'], 'units');

        return $links;
    }

    public function card()
    {
        return $this->belongsToMany(Card::class);
    }
}
