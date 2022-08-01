<?php

namespace App\Models\Accounts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class MemberSubscription extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'membersubscription';
    protected $primaryKey = 'code';
    // public $timestamps = false;
    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty()
            ->useLogName('Items')
            ->dontSubmitEmptyLogs();
    }
}
