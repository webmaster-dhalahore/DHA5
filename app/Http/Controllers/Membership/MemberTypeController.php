<?php

namespace App\Http\Controllers\Membership;

use App\Http\Controllers\Controller;
use App\Models\Membership\MemberType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class MemberTypeController extends MembershipBaseController
{
    public function membertypes_all(Request $request)
    {
        return MemberType::all('code', 'des');
    }

    public function index()
    {
        $types = MemberType::all(['code', 'des']);
        return view('members.types.index', compact('types'));
    }

    public function store(Request $request)
    {
        $member_type = $request->member_type;
        $request->validate([
            'member_type' => 'required|string|max:100|unique:membertypes,des'
        ], [
            'unique' => 'Duplicate entry for Member Type : ' . $member_type
        ]);

        $user = auth()->user();
        try {
            $mt_code = DB::select('SELECT MAX(NVL(code, 0)) + 1 next_type_code FROM membertypes');
            $next_type_code = $mt_code[0]->next_type_code;
            MemberType::create([
                'code' => $next_type_code,
                'des' => strtoupper(cleanStr($member_type)),
                'created_by' => $user->id,
            ]);

            return response()->json([
                'success' => true,
                'sessionMsg' => [
                    'type' => 'success',
                    'message' => "Member Type Created Successfully!",
                ],
            ]);
        } catch (\Exception $e) {
            $this->logError($e, $user->id, __METHOD__, __LINE__);
            return response()->json([
                'success' => false,
                'sessionMsg' => [
                    'type' => 'error',
                    'message' => "Sorry Server Error! Member Type not saved.",
                ],
            ], 500);
        }
    }

    public function update(Request $request)
    {
        $member_type = $request->member_type_edit;

        $request->validate([
            'code' => 'required|integer|exists:membertypes,code',
            'member_type_edit' => 'required|string|max:100',
        ], [
            'member_type_edit.required' => 'Member Type is required.',
            'member_type_edit.max' => 'The Member Type must not be greater than 100 characters.',
        ]);

        $member_type = strtoupper(cleanStr($request->member_type_edit));
        $code = $request->code;
        $user = auth()->user();

        try {
            $type_exists = MemberType::where('code', '!=', $code)
                ->where("des", $member_type)
                ->first();
            if ($type_exists) {
                throw new \Exception();
            }
        } catch (\Exception $e) {
            $this->logError($e, $user->id, __METHOD__, __LINE__);
            $validator = Validator::make([], []);
            $validator->errors()->add('member_type_edit', 'Category is already taken.');
            throw new ValidationException($validator);
        }

        try {
            MemberType::find($code)->update(['des' => $member_type]);

            return response()->json([
                'success' => true,
                'sessionMsg' => [
                    'type' => 'success',
                    'message' => "Member Type Updated Successfully!",
                ],
            ]);
        } catch (\Exception $e) {
            $this->logError($e, $user->id, __METHOD__, __LINE__);
            return response()->json([
                'success' => false,
                'sessionMsg' => [
                    'type' => 'error',
                    'message' => "Sorry Server Error! Member Type not saved.",
                ],
            ], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            MemberType::find($request->code)->update([
                'deleted_at' => now(),
                'deleted_by' => auth()->user()->id,
            ]);
        } catch (\Exception $e) {
            
        }
    }
}
