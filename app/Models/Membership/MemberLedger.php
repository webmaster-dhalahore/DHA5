<?php

namespace App\Models\Membership;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MemberLedger extends Model
{
    use HasFactory;
    protected $table = 'memberledger';
    protected $casts = [
        'docdate'  => 'date:Y-m-d',
    ];

    public static function getOpeningBal($memberid, $begining_date, $from_date)
    {
        $openingBalanceArr = MemberLedger::select(DB::raw('NVL(SUM(DR),0) - NVL(SUM(CR),0) AS opening_balance'))
            ->where('memberid', $memberid)
            ->whereRaw("DOCDATE >= TO_DATE('" . $begining_date . "', 'YYYY-MM-DD')")
            ->whereRaw("docdate < TO_DATE('" . $from_date . "', 'YYYY-MM-DD')")
            ->get();
        return floor((float) $openingBalanceArr[0]->opening_balance);
    }

    public static function getMemberTransactions($memberid, $from_date, $to_date)
    {
        return MemberLedger::where('memberid', strtoupper($memberid))
            ->whereBetween('docdate', [$from_date, $to_date])
            // ->whereRaw("docdate BETWEEN TO_DATE('" . $from_date . "', 'YYYY-MM-DD') AND TO_DATE('" . $to_date . "', 'YYYY-MM-DD')")
            ->orderBy('docdate')
            ->get(['docno', 'docdate', 'area_desc', 'memberid', 'membername', 'dr', 'cr']);
    }
}
