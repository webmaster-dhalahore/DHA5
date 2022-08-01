<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class BaseController extends Controller
{
    public function logError($e, $user_id, $method = __METHOD__, $line_no = __LINE__)
    {
        $error = sprintf("[Method => %s,line_no => %d, USER_ID => %s], ERROR:[%s]", $method, $line_no, json_encode($user_id), json_encode($e->getMessage(), true));
        Log::info($error);
        Log::error($e);
    }

}
