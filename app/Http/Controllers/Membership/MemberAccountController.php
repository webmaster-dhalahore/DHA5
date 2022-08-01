<?php

namespace App\Http\Controllers\Membership;

use App\Models\Membership\MemberLedger;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberAccountController extends MembershipBaseController
{
    public function memberLedger(Request $request)
    {
        $memberid = null;
        $opening_balance = null;
        $memberTransactions = null;
        $transactions_count = 0;
        $sessionMsg = null;
        $membername = '';
        if ($request->isMethod('post')) {
            // dump($request->all());
            $begining_date = '2019-07-01'; // timestamp 1561939200 /pk ts 1562007599
            $bd_ts = strtotime($begining_date);
            $request->validate([
                'memberid' => 'required|max:20|exists:memberinfo,memberid',
                'from_date' => 'required|date_format:Y-m-d',
                'to_date' => 'required|date_format:Y-m-d',
            ]);

            $from_date = $request->from_date;
            $to_date = $request->to_date;
            $memberid = $request->memberid;  // R-1698
            $fd_ts = strtotime($from_date);
            if ($fd_ts < $bd_ts) $from_date = $begining_date;
            $opening_balance = MemberLedger::getOpeningBal($memberid, $begining_date, $from_date);
            $memberTransactions = MemberLedger::getMemberTransactions($memberid, $from_date, $to_date);
            // dd($opening_balance);
            if(!count($memberTransactions)){
                $sessionMsg = [
                    'type' => 'error',
                    'message' => "No entries between this period!",
                ];
            } else {
                $membername = $memberTransactions[0]->membername;
            }
        }
        return view('members.reports.member_ledger', [
            'memberid' => $memberid,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'opening_balance' => $opening_balance,
            'transactions' => $memberTransactions,
            'transactions_count' => $transactions_count,
            'sessionMsg' => $sessionMsg,
            'membername' => $membername,
        ]);
    }

    public function memberLedgerDownloadPDF(Request $request)
    {
        $begining_date = '2019-07-01';
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $memberid = $request->memberid;
        
        $opening_balance = MemberLedger::getOpeningBal($memberid, $begining_date, $from_date);
        $memberTransactions = MemberLedger::getMemberTransactions($memberid, $from_date, $to_date);
        $membername = $memberTransactions[0]->membername;

        $pdf = PDF::loadView('members.reports.pdfs.ledger', [
            'memberid' => $memberid,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'opening_balance' => $opening_balance,
            'transactions' => $memberTransactions,
            'membername' => $membername,
        ]);
        return $pdf->download('member_ledger.pdf');
    }
}
