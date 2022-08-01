<?php

namespace App\Models\Membership;

use App\Models\Billings\BillMst;
use App\Models\Club;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Member extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'memberinfo';
    protected $primaryKey = 'membersr';
    // public $timestamps = false;
    protected $binaries = ['memberpic', 'membersign'];
    protected $guarded = [];
    protected $casts = [
        'dob'  => 'date:Y-m-d',
        'membershipdate'  => 'date:Y-m-d',
    ];

    protected static $recordEvents = ['deleted', 'updated'];

    public function getAgeAttribute()
    {
        // return $this->dob->diffInYears(\Carbon\Carbon::now());
        $age_array = [];

        $age_str = Carbon::createFromDate($this->dob)->diff(Carbon::now())->format('%y-years, %m-months, %d-days');
        $age = explode(',', $age_str);
        for ($i = 0; $i < count($age); $i++) {
            $key_value = explode('-', $age[$i]);
            $age_array[$key_value[1]] = $key_value[0];
        }
        return $age_array;
        // return Carbon::createFromDate($this->dob)->diff(Carbon::now())->format('%y-years, %m-months, %d-days');
    }


    public function bills()
    {
        return $this->hasMany(BillMst::class, 'fkmembersr', 'membersr');
    }

    public function family()
    {
        return $this->hasMany(MemberFamily::class, 'fkmembersr', 'membersr');
    }

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function category()
    {
        return $this->belongsTo(MemberCategory::class, 'categoryid', 'code');
    }

    public function type()
    {
        return $this->belongsTo(MemberType::class, 'typeid', 'code');
    }

    public function occupation()
    {
        return $this->belongsTo(MemberOccupation::class, 'occupationid', 'code');
    }

    public static function getMemberByClubID($memberid, $club_id)
    {
        try {
            $member = self::getMember($memberid, $club_id);
            if (!$member) {
                throw new \Exception();
            }
            return $member;
        } catch (\Exception $e) {
            $validator = Validator::make([], []);
            $validator->errors()->add('memberid', 'The selected Member ID is invalid.');
            throw new ValidationException($validator);
        }
    }

    public static function getMember($memberid, $club_id)
    {
        $user = auth()->user();
        $member = null;
        if ($user->hasRole(getSU())) {
            $member = Member::where('memberid', strtoupper($memberid))
                ->with('family')->first();
        } else {
            $member = Member::where('memberid', strtoupper($memberid))
                ->where('club_id', $club_id)
                ->with('family')->first();
        }

        return $member;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status', 'memberid', 'membername', 'categoryid', 'typeid', 'club_id', 'cnic', 'department', 'organisation', 'otherinfo', 'dob', 'married', 'mailingaddress', 'workingaddress', 'phoneoffice', 'blockstatus', 'remarks', 'fromdate', 'todate', 'mobileno', 'mobileno2', 'phoneresidence', 'email', 'cardissuedate', 'cardexpirydate', 'picture', 'signature'])
            // ->dontLogIfAttributesChangedOnly(['memberpic', 'membersign','updated_at'])
            ->logOnlyDirty()
            ->useLogName('Memberinfo')
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }
}
