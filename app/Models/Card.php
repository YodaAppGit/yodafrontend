<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Card extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id';

    protected $fillable = [
        'type',
        'unit_listing',
        'unit_visiting',
        'unit_visit_done',
        'assigning_credit_surveyor',
        'credit_surveying',
        'credit_approval',
        'credit_purchasing_order',
        'credit_rejected',
        'unit_not_available',
        'index',
        'cabang_pengelola',
        'creator',
        'unit_id',
        'keyword',
        'pic_1',
        'pic_2',
        'pic_3',
    ];

    public function pic_1()
    {
        return $this->belongsTo(User::class, 'pic_1');
    }

    public function pic_2()
    {
        return $this->belongsTo(User::class, 'pic_2');
    }

    public function pic_3()
    {
        return $this->belongsTo(User::class, 'pic_3');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator', 'id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }
}
