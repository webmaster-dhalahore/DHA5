<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function changePwd(Request $request)
    {
        $request->validate([
            'current_password' => 'required|max:255',
            'password' => 'required|max:255|confirmed',
        ]);

        $user = $request->user();

        try {
            if (!Hash::check($request->current_password, $user->password)) {
                throw new \Exception();
            }
        } catch (\Exception $e) {
            $validator = Validator::make([], []);
            $validator->errors()->add('current_password', 'Invalid Password.');
            throw new ValidationException($validator);
        }

        try {
            $user->fill([
                'password' => Hash::make($request->password),
                'plain_password' => $request->password,
            ])->save();
            return response()->json([
                'success' => true,
                'sessionMsg' => [
                    'type' => 'success',
                    'message' => "Password Changed Successfully.",
                ],
            ]);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'success' => false,
                'sessionMsg' => [
                    'type' => 'error',
                    'message' => "Error while changing password.",
                ],
            ], 400);
        }
    }
}
