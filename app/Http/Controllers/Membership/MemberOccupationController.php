<?php

namespace App\Http\Controllers\Membership;

use App\Http\Controllers\Controller;
use App\Models\Membership\MemberOccupation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberOccupationController extends MembershipBaseController
{
    public function professions_all(Request $request)
    {
        // return MemberOccupation::all('code', 'des');
        // return MemberOccupation::orderBy('code')->get('code', 'des');
        $abc = DB::select('select code, des from memberoccupation order by code');
        return $abc;
    }
}
