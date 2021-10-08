<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardRefinancing extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'slik_checking',
        'assigning_credit_surveyor',
        'credit_surveying',
        'credit_approval',
        'credit_purchasing_order',
        'credit_rejected',
        'slik_rejected',
        'cabang_pengelola',
        'index',
        'creator',
        'unit_id',
        'keyword',
        'pic_1',
        'pic_2',
        'pic_3',
    ];
}
