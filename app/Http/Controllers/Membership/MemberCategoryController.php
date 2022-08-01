<?php

namespace App\Http\Controllers\Membership;

use App\Models\Membership\MemberCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class MemberCategoryController extends MembershipBaseController
{
    public function index()
    {
        $categories = MemberCategory::all(['code', 'des', 'abbr']);
        return view('members.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $member_category = $request->member_category;

        $request->validate([
            'member_category' => 'required|string|max:100|unique:membercategory,des',
            'member_abbr' => 'required|string|max:5',
        ], [
            'unique' => 'Duplicate entry for Member Category : ' . $member_category
        ]);

        $user = auth()->user();
        $clean_des = strtoupper(cleanStr($request->member_category));
        $abbr = strtoupper(trim($request->member_abbr));
        try {
            $category_code = DB::select('SELECT MAX(NVL(code, 0)) + 1 next_category_code FROM membercategory');
            $next_category_code = $category_code[0]->next_category_code;
            MemberCategory::create([
                'code' => $next_category_code,
                'des' => $clean_des,
                'abbr' => $abbr,
                'created_by' => $user->id,
            ]);
            $sessionMsg = [
                'type' => 'success',
                'message' => "Member Category Created Successfully!",
            ];
            return response()->json([
                'success' => true,
                'sessionMsg' => $sessionMsg,
            ]);
        } catch (\Exception $e) {
            $this->logError($e, $user->id, __METHOD__, __LINE__);
            return response()->json([
                'success' => false,
                'sessionMsg' => [
                    'type' => 'error',
                    'message' => "Sorry Server Error! Member Category not saved.",
                ],
            ], 500);
        }

    }

    public function update(Request $request)
    {
        $request->validate([
            'code' => 'required|integer|exists:membercategory,code',
            'member_category_edit' => 'required|string|max:100',
            'member_abbr_edit' => 'required|string|max:5',
        ], [
            'member_category_edit.required' => 'Member Category is required.',
            'member_category_edit.max' => 'The Member Category must not be greater than 100 characters.',
            'member_abbr_edit.required' => 'Member Abbreviation is required.',
            'member_abbr_edit.max' => 'The Abbreviation must not be greater than 5 characters.',
        ]);

        $clean_des = strtoupper(cleanStr($request->member_category_edit));
        $abbr = strtoupper(trim($request->member_abbr_edit));
        $code = $request->code;
        $user = auth()->user();
        // VALIDATE if category is already taken
        try {
            $category_exists = MemberCategory::where('code', '!=', $code)
                ->where("des", $clean_des)
                ->first();
            if ($category_exists) {
                throw new \Exception();
            }
        } catch (\Exception $e) {
            $this->logError($e, $user->id, __METHOD__, __LINE__);
            $validator = Validator::make([], []);
            $validator->errors()->add('member_category_edit', 'Category is already taken.');
            throw new ValidationException($validator);
        }

        
        try {
            MemberCategory::find($code)
            ->update([
                'des' => $clean_des,
                'abbr' => $abbr
            ]);

            $sessionMsg = [
                'type' => 'success',
                'message' => "Member Category Updated Successfully!",
            ];
            return response()->json([
                'success' => true,
                'sessionMsg' => $sessionMsg,
            ]);
        } catch (\Exception $e) {
            $this->logError($e, $user->id, __METHOD__, __LINE__);
            return response()->json([
                'success' => false,
                'sessionMsg' => [
                    'type' => 'error',
                    'message' => "Sorry Server Error! Member Category not saved.",
                ],
            ], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            MemberCategory::find($request->code)->update([
                'deleted_at' => now(),
                'deleted_by' => auth()->user()->id,
            ]);
        } catch (\Exception $e) {
            
        }
    }
}
