<?php

namespace App\Models\Membership;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class MemberCategory extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 'membercategory';
    protected $primaryKey = 'code';
    // public $timestamps = false;
    protected static $recordEvents = ['deleted', 'updated'];

    protected $guarded = [];

    public function members()
    {
        return $this->hasMany(Member::class, 'categoryid', 'code');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['code', 'des', 'abbr', 'deleted_at', 'deleted_by'])
            // ->dontLogIfAttributesChangedOnly(['memberpic', 'membersign','updated_at'])
            ->logOnlyDirty()
            ->useLogName('MemberCategory')
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }
}
