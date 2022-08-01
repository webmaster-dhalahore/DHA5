<?php

namespace App\Models\Membership;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberOccupation extends Model
{
    use HasFactory;
    protected $table = 'memberoccupation';
    protected $primaryKey = 'code';
    public $timestamps = false;
    protected $guarded = [];

    public function members()
    {
        return $this->hasMany(Member::class, 'occupationid', 'code');
    }
}
