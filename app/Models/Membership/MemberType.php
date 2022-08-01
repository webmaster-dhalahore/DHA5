<?php

namespace App\Models\Membership;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;

use App\Models\Accounts\MemberSubscription;

class MemberType extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 'membertypes';
    protected $primaryKey = 'code';
    // public $timestamps = false;
    protected $guarded = [];

    protected static $recordEvents = ['deleted', 'updated'];
    

    public function members()
    {
        return $this->hasMany(Member::class, 'typeid', 'code');
    }

    public function subscription()
    {
        return $this->belongsTo(MemberSubscription::class, 'code', 'typeid');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['code', 'des', 'deleted_at', 'deleted_by'])
            // ->dontLogIfAttributesChangedOnly(['memberpic', 'membersign','updated_at'])
            ->logOnlyDirty()
            ->useLogName('MemberType')
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

}
