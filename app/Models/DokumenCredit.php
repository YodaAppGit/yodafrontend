<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenCredit extends Model
{
    use HasFactory;

    protected $fillable = [
        'credit_id',
        'keterangan'
    ];

    public function credit()
    {
        return $this->belongsTo(Credit::class, 'credit_id', 'id');
    }
}
