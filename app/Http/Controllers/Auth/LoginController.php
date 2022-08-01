<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

    /** use this function to redirect to user's area's dashboard */
    public function authenticated($request, $user)
    {
        $today = Carbon::now();
        $client_ip = $request->getClientIp();
        $user->fill([
            'last_login' => $today,
            'last_login_ip' => $client_ip,
        ])->save();
        // $sql = "UPDATE users SET 
        //     users.\"last_login\" = TO_DATE('{$today}', 'YYYY-MM-DD HH24:MI:SS'),
        //     users.\"last_login_ip\" = '{$client_ip}'
        //     WHERE id = {$user->id}";
        // DB::statement($sql);
        // if($user->role=='super_admin'){
        //     return redirect()->route('admin.dashboard') ;
        // }elseif($user->role=='brand_manager'){
        //     return redirect()->route('brands.dashboard') ;
        // }
        // if ($user->id == 1) {
        //     return redirect()->route('member.index');
        // }
    }

    public function credentials($request)
    {
        return [
            'username'  => $request->username,
            'password'  => $request->password,
            'is_active' => '1'
        ];
    }
}
