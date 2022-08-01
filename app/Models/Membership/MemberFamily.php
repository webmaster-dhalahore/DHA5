<?php

namespace App\Models\Membership;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberFamily extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'memberfamily'; //MEMBERFAMILY
    protected $primaryKey = 'vno';
    // public $timestamps = false;
    protected $binaries = ['fmemberpic', 'fmembersign'];
    protected $guarded = [];
    // protected $casts = [
    //     'created_by' => 'integer',
    // ];
    

    public function getAgeAttribute()
    {
        return $this->dob->diffInYears(\Carbon\Carbon::now());
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function formIssuer()
    {
        return $this->belongsTo(User::class, 'form_issued_by', 'id');
    }

    public function modifier()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
