<?php

namespace App\Http\Controllers\Membership;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Membership\Consts;
use App\Models\Membership\Member;
use App\Models\Membership\MemberCategory;
use App\Models\Membership\MemberType;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class MemberReportsController extends BaseController
{
    private $on_error_route = 'member.index';

    public function memberInfo(Request $request)
    {
        $member = null;
        $memberid = null;

        if ($request->isMethod('post')) {
            $request->validate([
                'memberid' => 'required|max:20|exists:memberinfo,memberid',
            ], [
                'exists' => 'The selected Member ID is invalid.',
            ]);
            $club_id = auth()->user()->club_id;
            $memberid = $request->memberid;
            $member = Member::getMemberByClubID($memberid, $club_id);
        }

        return view('members.reports.info', [
            'memberid' => $memberid,
            'member' => $member,
        ]);
    }

    public function memberProfile(Request $request)
    {
        $member = null;
        $memberid = null;

        if ($request->isMethod('post')) {
            $request->validate([
                'memberid' => 'required|max:20|exists:memberinfo,memberid',
            ]);
            $club_id = auth()->user()->club_id;
            $memberid = $request->memberid;
            $member = Member::getMemberByClubID($memberid, $club_id);
        }

        return view('members.reports.profile', [
            'memberid' => $memberid,
            'member' => $member,
        ]);
    }

    public function ageWise(Request $request)
    {
        if ($request->post() && $request->ajax()) {
            return $this->ageWisePost($request);
        }
        return view('members.reports.member_age_wise');
    }

    public function ageWisePost(Request $request)
    {
        $club_id = auth()->user()->club_id;
        $request->validate([
            'from_age' => 'required|numeric',
            'to_age' => 'required|numeric',
        ]);

        $from_age = intval($request->from_age);
        $to_age = intval($request->to_age);

        $sql = "SELECT
                A.MEMBERNAME,
                A.MEMBERID,
                A.MEMBERSHIPDATE,
                A.DOB,
                trunc(months_between(sysdate, dob) / 12) years,
                mod(trunc(months_between(sysdate, dob)), 12) months,
                trunc(sysdate - add_months(dob, trunc(months_between(sysdate, dob)))) days,
                A.MAILINGADDRESS
            FROM
                MEMBERINFO A
            WHERE
                club_id = $club_id
                AND trunc(months_between(sysdate, dob) / 12) BETWEEN $from_age AND $to_age";

        $result = DB::select($sql);
        return response()->json($result);
    }

    public function memberDependents(Request $request)
    {
        $club_id = auth()->user()->club_id;
        if ($request->post() && $request->ajax()) {
            $request->validate([
                'from_age' => 'required|numeric',
                'to_age' => 'required|numeric',
                'relation' => ['nullable',  Rule::in(Consts::RELATION)],
                'status' => ['nullable',  Rule::in(Consts::STATUS)],
                'block_status' => ['nullable',  Rule::in(Consts::BLOCK_STATUS)],
            ]);

            $from_age = $request->from_age;
            $to_age = $request->to_age;
            $relation = $request->relation;
            $member_status = $request->status;
            $block_status = $request->block_status;

            $sql = "SELECT
                A.MEMBERID,
                A.MEMBERNAME,
                B.MEMBERID family_memberid,
                B.MEMBERNAME family_membername,
                B.DOB,
                B.RELATION,
                trunc (months_between(sysdate, B.DOB) / 12) years,
                mod(trunc(months_between(sysdate, B.DOB)), 12) months,
                trunc(sysdate - add_months(B.DOB, trunc(months_between(sysdate, B.DOB)))) days
            FROM
                MEMBERINFO A,
                MEMBERFAMILY B
            WHERE
                (B.FKMEMBERSR = A.MEMBERSR)
                AND B.RELATION = '$relation'
                AND trunc (months_between(sysdate, B.DOB) / 12) >= $from_age
                AND trunc (months_between(sysdate, B.DOB) / 12) < $to_age
                AND A.STATUS = '$member_status'
                AND A.blockstatus = '$block_status'
                AND A.club_id = $club_id
            ORDER BY
                A.MEMBERID";

            $members = DB::select($sql);
            return response()->json($members);
        }

        return view('members.reports.dependents');
    }

    public function memberSummary(Request $request)
    {
        $club_id = auth()->user()->club_id;
        try {
            $categories = MemberCategory::all();
            $members = Member::select(DB::raw('memberinfo.categoryid, COUNT(*) AS count'))
                ->where('memberinfo.membertype', 'MEMBER')
                ->where('memberinfo.status', 'ACTIVE')
                ->where('memberinfo.club_id', $club_id)
                ->groupBy('memberinfo.categoryid')
                ->orderBy('memberinfo.categoryid')
                ->get();
            $member_summary =  new Collection();
            foreach ($members as $member) {
                $category_name = null;
                $abbr = 'W';
                $categoryid = -1;
                foreach ($categories as $category) {
                    if ($category->code == intval($member->categoryid)) {
                        $category_name = $category->des;
                        $abbr = $category->abbr;
                        $categoryid = $category->code;
                    }
                }
                if (!$category_name) {
                    $category_name = 'W'; //MEMBERTYPE;
                }
                $member_summary->push((object)[
                    'memberabbr' => $abbr,
                    'membertype' => $category_name,
                    'countmembers' => $member->count,
                    'categoryid' => $member->categoryid,
                ]);
            }

            return view('members.reports.summary', compact('member_summary', 'categories'));
        } catch (\Exception $e) {
            $this->logError($e, $request->user()->id, __METHOD__, __LINE__);
            return redirect()->route($this->on_error_route)->with('error', 'Error Occured!, please try again later.');
        }
    }

    public function summaryAPI()
    {
        $club_id = auth()->user()->club_id;
        $categories = MemberCategory::all();
        $members = Member::select(DB::raw('memberinfo.categoryid, COUNT(*) AS count'))
            ->where('memberinfo.membertype', 'MEMBER')
            ->where('memberinfo.status', 'ACTIVE')
            ->where('memberinfo.club_id', $club_id)
            ->groupBy('memberinfo.categoryid')
            ->orderBy('memberinfo.categoryid')
            ->get();

        $member_summary =  new Collection();
        foreach ($members as $member) {
            $category_name = null;
            $abbr = 'W';
            foreach ($categories as $category) {
                if ($category->code == intval($member->categoryid)) {
                    $category_name = $category->des;
                    $abbr = $category->abbr;
                }
            }
            if (!$category_name) {
                $category_name = 'W'; //MEMBERTYPE;
            }
            $member_summary->push((object)[
                'memberabbr' => $abbr,
                'membertype' => $category_name,
                'countmembers' => $member->count,
                'categoryid' => $member->categoryid,
            ]);
        }
        return ['member_summary' => $member_summary, 'categories' => $categories];
    }

    public function memberSummaryType($categoryid, Request $request)
    {
        $club_id = auth()->user()->club_id;
        try {
            $categoryid = intval($categoryid);
            $members = Member::select(DB::raw('memberinfo.typeid, COUNT(*) AS count'))
                ->where('memberinfo.membertype', 'MEMBER')
                ->where('memberinfo.status', 'ACTIVE')
                ->where('memberinfo.club_id', $club_id)
                ->where('memberinfo.categoryid', $categoryid)
                ->groupBy('memberinfo.typeid')
                ->get();

            $memberTypes = MemberType::all();
            $category = MemberCategory::find($categoryid);
            $result =  new Collection();
            foreach ($members as $member) {
                $type_name = null;
                foreach ($memberTypes as $type) {
                    if ($type->code == intval($member->typeid)) {
                        $type_name = $type->des;
                    }
                }
                if (!$type_name) {
                    $type_name = 'No Category'; //MEMBERTYPE;
                }
                $result->push((object)[
                    'memberabbr' => $category ? $category->abbr : 'W',
                    'des' => $type_name,
                    'countmembers' => $member->count,
                ]);
            }

            return view('members.reports.summaryType', compact('result', 'category'));
        } catch (\Exception $e) {
            $this->logError($e, $request->user()->id, __METHOD__, __LINE__);
            return redirect()->back()->with('error', 'Error Occured!, please try again later.');
        }
    }
}
