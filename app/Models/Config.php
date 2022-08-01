<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class config extends Model
{
    use HasFactory;

    protected $table = 'config';
    protected $primaryKey = null;
    public $incrementing = false;

    protected $guarded = [];
    protected $casts = [
        'fk_bill_date'  => 'date:Y-m-d',
    ];
}
