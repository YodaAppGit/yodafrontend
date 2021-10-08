<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisUnit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'jenis_unit'
    ];
}
