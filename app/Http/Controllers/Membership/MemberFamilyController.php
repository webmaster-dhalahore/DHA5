<?php

namespace App\Http\Controllers\Membership;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule as ValidationRule;

use App\Models\Membership\MemberFamily;
use App\Models\Membership\Consts as MembershipConsts;
use App\Models\Membership\Member;
use Illuminate\Database\Eloquent\Collection;

class MemberFamilyController extends MembershipBaseController
{
    private $imagesPath = MembershipConsts::IMAGES_PATH;

    public function familyByVNO($vno)
    {
        $member = null;
        $fmemberpic = null;
        $fmembersign = null;

        $member = MemberFamily::query();
        if (is_numeric($vno)) {
            $member = $member->where('vno', $vno);
        } else {
            $member = $member->where('memberid', $vno);
        }

        $member = $member->with('modifier:id,name')
            ->with('formIssuer:id,name')
            ->first();

        if (!$member) {
            return response()->json([
                'success' => false,
                'data' => null,
                'sessionMsg' => [
                    'type' => 'error',
                    'message' => "Invalid Member",
                ],
            ], 404);
        }

        if (!$member->picture) {
            $fmemberpic = $member->fmemberpic ? 'data:image/bmp;base64,' . base64_encode($member->fmemberpic) : null;
        }

        if (!$member->signature) {
            $fmembersign = $member->fmembersign ? 'data:image/bmp;base64,' . base64_encode($member->fmembersign) : null;
        }

        $credit_allowed = MembershipConsts::CREDIT_ALLOWED;
        $relations = MembershipConsts::RELATIONS;

        return response()->json([
            'success' =>  true,
            'data' => [
                'fkmembersr' => $member->fkmembersr,
                'memberid' => $member->memberid,
                'membername' => $member->membername,
                'dob' => $member->dob,
                'relation' => $member->relation,
                'creditallow' => $member->creditallow,
                'edate' => $member->edate,
                'tsr' => $member->tsr,
                'euser' => $member->euser,
                'srno' => $member->srno,
                'enb' => $member->enb,
                'vno' => $member->vno,
                'cardissuedate' => $member->cardissuedate,
                'cardexpirydate' => $member->cardexpirydate,
                'other' => $member->other,
                'vnomemberfamily' => $member->vnomemberfamily,
                'memberidnew' => $member->memberidnew,
                'memberidnew1' => $member->memberidnew1,
                'fmemberpic' => $fmemberpic,
                'fmembersign' => $fmembersign,
                'picture' => $member->picture,
                'signature' => $member->signature,
                'membership_form' => $member->membership_form,
                'form_issued_by' => $member->form_issued_by,
                'formIssuer' => $member->formIssuer,
                'modifier' => $member->modifier,
                'updated_by' => $member->updated_by,
                'updated_at' => $member->updated_at,
            ],
            'credit_allowed' => $credit_allowed,
            'relations' => $relations,
        ]);
    }

    public function getMemberFamilyAll(Request $request)
    {
        $membersr = $request->membersr;
        $members = MemberFamily::where('fkmembersr', $membersr)->get(['fkmembersr', 'memberid', 'membername', 'creditallow', 'picture', 'relation', 'signature', 'fmemberpic', 'fmembersign']);
        $member_family =  new Collection();

        foreach ($members as $member) {
            $fmemberpic = asset('dist/img/profile_pic01.jpg');
            $fmembersign = asset('dist/img/sign-placeholder.png');

            if (!$member->picture && $member->fmemberpic) {
                $fmemberpic = 'data:image/bmp;base64,' . base64_encode($member->fmemberpic);
            }
    
            if (!$member->signature && $member->fmembersign) {
                $fmembersign = 'data:image/bmp;base64,' . base64_encode($member->fmembersign);
            }

            $member_family->push((object)[
                'fkmembersr'=> $member->fkmembersr,
                'memberid' => $member->memberid,
                'membername' => $member->membername,
                'creditallow' => $member->creditallow,
                'picture' => $member->picture,
                'signature' => $member->signature,
                'relation' => $member->relation,
                'fmemberpic' => $fmemberpic,
                'fmembersign' => $fmembersign,
            ]);
        }

        return response()->json($member_family);

    }

    public function store(Request $request)
    {
        $family_vno = $request->family_vno;
        if ($family_vno) {
            return $this->updateMemberFamily($request);
        }
        return $this->createMemberFamily($request);
    }

    public function updateMemberFamily($request)
    {
        // Validate the fields
        $this->validateData(true);

        // fields validated find the family member FKMEMBERSR
        $vno = $request->family_vno ? $request->family_vno : $request->member_family_id;
        $fieldVno = is_numeric($vno) ? 'vno' : 'memberid';
        $member = MemberFamily::where($fieldVno, $vno)->first();

        // check if member family belongs to what it is the database
        if ($member->fkmembersr != $request->member_sr_fk) {
            return response()->json([
                'sessionMsg' => [
                    'type' => 'error',
                    'message' => "Invalid Member",
                ],
            ], 400);
        }

        try {
            // select * from memberfamily t where t.memberid = 'R-869-D1' and t.vno != 3108
            $memberid_exists = MemberFamily::where('memberid', $request->member_family_id)
                ->where($fieldVno, '!=', $vno)
                ->first();
            if ($memberid_exists) {
                throw new \Exception('Tried Member ID already on update that is already taken vno : ' . $fieldVno);
            }
        } catch (\Exception $e) {
            $this->logError($e, $request->user()->id, __METHOD__, __LINE__);
            $validator = Validator::make([], []);
            $validator->errors()->add('member_family_id', 'Member ID already taken.');
            throw new ValidationException($validator);
        }

        DB::beginTransaction();
        try {
            $user_id = auth()->user()->id;
            $member->membername = $request->member_family_name;
            $member->creditallow = $request->credit_allowed;
            $member->dob = $request->member_family_dob;
            $member->relation = $request->member_relation;
            $member->cardissuedate = $request->member_family_card_issue_date;
            $member->cardexpirydate = $request->member_family_card_expiry_date;
            $member->updated_by = $user_id;
            $memberid = $request->member_family_id;
            $member_sr_fk = request()->member_sr_fk;
            $fmemberpic_filename = null;
            $fmembersign_filename = null;

            if ($request->membership_form == '1') {
                $member->membership_form = now();
                $member->form_issued_by = $user_id;
            } else {
                $member->membership_form = null;
            }

            if ($request->hasFile('member_family_pic')) {
                $extension = $request->file('member_family_pic')->extension();
                $fmemberpic_filename = $memberid . '-p-' . $member_sr_fk . '-vno-' . $vno . '.' . $extension;
                $request->member_family_pic->storeAs($this->imagesPath, $fmemberpic_filename, 'public');

                // add image to database
                $procedureName = 'family_img';
                $bindings = [
                    'imgname' => $fmemberpic_filename,
                    'fkmsr' => $member_sr_fk,
                    'mid'  => $memberid
                ];
                DB::executeProcedure($procedureName, $bindings);
            }
            if ($request->hasFile('member_family_sign')) {
                $extension = $request->file('member_family_sign')->extension();
                $fmembersign_filename = $memberid . '-s-' . $member_sr_fk . '-vno-' . $vno . '.' . $extension;
                $request->member_family_sign->storeAs($this->imagesPath, $fmembersign_filename, 'public');

                $procedureName = 'family_sign';
                $bindings = [
                    'imgname' => $fmembersign_filename,
                    'fkmsr' => $member_sr_fk,
                    'mid'  => $memberid
                ];
                DB::executeProcedure($procedureName, $bindings);
            }

            $member->picture = $fmemberpic_filename;
            $member->signature = $fmembersign_filename;

            $member->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'fkmembersr' => $member->fkmembersr,
                'memberid' => $member->memberid,
                'membername' => $member->membername,
                'vno' => $member->vno,
                'sessionMsg' => [
                    'type' => 'success',
                    'message' => "Record Updated Succesfully.",
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->logError($e, $request->user()->id, __METHOD__, __LINE__);
            return response()->json([
                'success' => false,
                'sessionMsg' => [
                    'type' => 'error',
                    'message' => "Sorry! member  not saved, error occured.",
                    'err' => $e->getMessage(),
                ],
            ], 500);
        }
    }

    public function createMemberFamily($request)
    {
        $user = auth()->user();
        $member_sr_fk = request()->member_sr_fk;
        $club_code = $user->club->code;
        $created_by = $user->id;
        $this->validateData();

        $msr = DB::select("SELECT MAX(NVL(vno, 0)) + 1 next_vno FROM memberfamily");
        $next_vno = $msr[0]->next_vno;

        $memberid = $request['member_family_id'];
        $imagesPath = MembershipConsts::IMAGES_PATH;
        $fmemberpic_filename = null;
        $fmembersign_filename = null;
        if ($request->hasFile('member_family_pic')) {
            $extension = $request->file('member_family_pic')->extension();
            $fmemberpic_filename = $memberid . '-p-' . $member_sr_fk . '-vno-' . $next_vno . '.' . $extension;
            $request->member_family_pic->storeAs($imagesPath, $fmemberpic_filename, 'public');
        }
        if ($request->hasFile('member_family_sign')) {
            $extension = $request->file('member_family_sign')->extension();
            $fmembersign_filename = $memberid . '-s-' . $member_sr_fk . '-vno-' . $next_vno . '.' . $extension;
            $request->member_family_sign->storeAs($imagesPath, $fmembersign_filename, 'public');
        }

        // save family
        $familyData = [
            'fkmembersr' => $member_sr_fk,
            'memberid' => $memberid,
            'membername' => $request->member_family_name,
            'dob' => $request->member_family_dob,
            'relation' => $request->member_relation,
            'creditallow' => $request->credit_allowed,
            'edate' => null,
            'tsr' => null,
            'euser' => null,
            'srno' => null,
            'enb' => $club_code,
            'vno' => $next_vno,
            'cardissuedate' => $request->member_family_card_issue_date,
            'cardexpirydate' => $request->member_family_card_expiry_date,
            'other' => null,
            'vnomemberfamily' => null,
            'memberidnew' => $memberid,
            'memberidnew1' => $memberid,
            // 'fmemberpic' => null,
            // 'fmembersign' => null,
            'picture' => $fmemberpic_filename,
            'signature' => $fmembersign_filename,
            // 'created_at' => $today,
            // 'updated_at' => $today,
            'created_by' => $created_by,
            'updated_by' => $created_by,
        ];

        if ($request->membership_form == '1') {
            $familyData['membership_form'] = now();
            $familyData['form_issued_by'] = $created_by;
        }

        DB::beginTransaction();
        try {
            $family = MemberFamily::create($familyData);
            DB::commit();

            if ($family) {
                if ($request->hasFile('member_family_pic')) {
                    $procedureName = 'family_img';
                    $bindings = [
                        'imgname' => $fmemberpic_filename,
                        'fkmsr' => $member_sr_fk,
                        'mid'  => $memberid
                    ];
                    DB::executeProcedure($procedureName, $bindings);
                }

                if ($request->hasFile('member_family_sign')) {
                    $procedureName = 'family_sign';
                    $bindings = [
                        'imgname' => $fmembersign_filename,
                        'fkmsr' => $member_sr_fk,
                        'mid'  => $memberid
                    ];
                    DB::executeProcedure($procedureName, $bindings);
                }
            }
            $sessionMsg = [
                'type' => 'success',
                'message' => "Record Created Successfully!",
            ];
            return response()->json([
                'success' => true,
                'sessionMsg' => $sessionMsg,
            ]);
        } catch (\Exception $e) {

            DB::rollBack();
            // $user = [
            //     'user_id' => 1,
            //     'username' => 'Muhammad Usman Sharif',
            //     'date' => $today->format('d-m-Y h:i:s'),
            // ];
            // $error = sprintf("[%s],[%d], USER:[%s], ERROR:[%s]", __METHOD__, __LINE__, json_encode($user, true), json_encode($e->getMessage(), true));
            // Log::error($error);
            $this->logError($e, $request->user()->id, __METHOD__, __LINE__);
            return response()->json([
                'success' => false,
                'sessionMsg' => [
                    'type' => 'error',
                    'message' => "Sorry! member $memberid not saved, error occured.",
                ],
            ], 500);
        }
    }

    private function validateData($an_update = false)
    {
        $rules = [
            "member_family_name" => "required|max:100",
            "credit_allowed" => "required|in:0,1",
            "member_family_dob" => "required|date_format:Y-m-d",
            "member_relation" => ['required', ValidationRule::in(MembershipConsts::RELATION)],
            'member_family_pic' => 'nullable|image|mimes:jpeg,jpg,png,bmp|max:1024', // MEMBERPIC
            'member_family_sign' => 'nullable|image|mimes:jpeg,jpg,png,bmp|max:1024',
            'member_family_sign' => 'nullable|image|mimes:jpeg,jpg,png,bmp|max:1024',
            'member_family_card_issue_date' => 'nullable|date_format:Y-m-d',
            'member_family_card_expiry_date' => 'nullable|date_format:Y-m-d',
            'membership_form' => ['nullable', ValidationRule::in(['1', '0'])],
        ];

        if (!$an_update) {
            $rules["member_family_id"] = 'required|unique:memberfamily,memberid';
        }

        return request()->validate($rules, [
            'member_family_id.required' => 'Member ID is required.',
            'member_family_name.required' => 'Member Name is required.',
            'credit_allowed.required' => 'Credit Allowed is required.',
            'member_family_dob.required' => 'Date of birth is required.',
            'member_relation.required' => 'Relation is required.',
            '*.date_format' => 'Invalid Date.',
            'member_relation.in' => 'Invalid Relation.',
            '*.image' => 'The Image must be a file of type: jpeg, jpg, png, bmp.',
            '*.mimes' => 'The Image must be a file of type: jpeg, jpg, png, bmp.',
            '*.max' => 'The Image must not be greater than 1-MB or (1024 kilobytes).',
        ]);
    }
}
