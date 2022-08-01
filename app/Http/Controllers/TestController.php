<?php

namespace App\Http\Controllers;

use App\Models\Membership\Member;
use App\Models\Membership\MemberCategory;
use App\Models\UMUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index()
    {
        // $classes = DB::select('select * from item_class');
        // $member = DB::select("select membersr, memberid from memberinfo t where t.memberid='R-1731'");
        $member = MemberCategory::all(); //('user_id', 30)->get()->first();
        // var_dump($classes);
        return response()->json(['Name' => 'Usman SHarif', 'member' => $member]);
    }
}
