<?php

namespace App\Http\Controllers\Membership;

use App\Models\Club;
use Carbon\Carbon;
// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule as ValidationRule;
use Illuminate\Validation\ValidationException;
use Spatie\QueryBuilder\QueryBuilder;

use App\Models\Membership\Member;
use App\Models\Membership\MemberCategory;
use App\Models\Membership\Consts as MembershipConsts;
use App\Models\Membership\MemberType;
use Error;
use Exception;
use Yajra\DataTables\DataTables;

class MemberController extends MembershipBaseController
{
    private $imagesPath = MembershipConsts::IMAGES_PATH;


    public function index()
    {
        return view('members.index');
    }

    public function home()
    {
        return view('members.dashboard');
    }

    public function getMembers()
    {
        $club_id = auth()->user()->club_id;
        $data =  Member::select(
            'membersr',
            'memberid',
            'membername',
            'status',
            'blockstatus',
            'mailingaddress',
            'mobileno',
            'cnic',
            'categoryid',
            'typeid',
            'memberfname',
            'email',
            'dob',
            'phoneresidence',
            'occupationid',
        )
            ->where('club_id', $club_id)
            ->whereNotNull('memberid')
            ->orWhere('memberid', '<>', '')
            ->with('type:code,des')
            ->with('category:code,des')
            ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('memberid', function ($data) {
                $memberid = $data->memberid;
                $edit_route = route('member.edit', ['memberid' => $memberid]);
                // $info_form_id = 'info-form-' . $memberid;
                // $info_form = $this->createPostForm($memberid, $edit_route, $info_form_id);
                // $html = $info_form;
                // $html .= "<a href='#' onclick='submitForm(event, `" . $info_form_id . "`)'>" . $data->membername . "</a>";
                // return $html;
                // $url = baseURL() . 'members/' . $memberid . '/edit';
                return '<a href="' . $edit_route  . '">' . $memberid . "</a>";
            })
            ->editColumn('membername', function ($data) {
                $memberid = $data->memberid;
                $info_route = route('member.reports.member-infoPost');
                $info_form_id = 'info-form-' . $memberid;
                $info_form = $this->createPostForm($memberid, $info_route, $info_form_id);
                $html = $info_form;
                $html .= "<a href='#' onclick='submitForm(event, `" . $info_form_id . "`)'>" . $data->membername . "</a>";
                return $html;
            })
            ->editColumn('typeid', function ($m) {
                return $m->type ? $m->type->des : '';
            })
            ->editColumn('categoryid', function ($m) {
                return $m->category ? $m->category->des : '';
            })
            // ->addColumn('action', function ($data) {
            //     $memberid = $data->memberid;
            //     $edit_route = route('member.edit', ['memberid' => $memberid]);

            //     $info_route = route('member.reports.member-infoPost');
            //     $info_form_id = 'info-form-' . $memberid;
            //     $info_form = $this->createPostForm($memberid, $info_route, $info_form_id);

            //     $profile_route = route('member.reports.member-profilePost');
            //     $profile_form_id = 'profile-form-' . $memberid;
            //     $profile_form = $this->createPostForm($memberid, $profile_route, $profile_form_id);


            //     $html  = '<div class="dropdown"><button role="button" type="button" class="btn" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>';
            //     $html .= '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">';
            //     $html .= $info_form;
            //     $html .= $profile_form;
            //     $html .= '<a class="dropdown-item text-primary" href="' . $edit_route . '"><i class="fas fa-edit"></i> Edit</a>';
            //     $html .= '<button type="button" class="dropdown-item text-primary" onclick="submitForm(event, `' . $profile_form_id . '`)"><i class="fas fa-address-card"></i> Profile Report</button>';
            //     $html .= '<div class="dropdown-divider"></div>';
            //     $html .= '<button type="button" class="dropdown-item text-success" onclick="submitForm(event, `' . $info_form_id . '`)"><i class="fas fa-info-circle"></i> Member Info Report</button>';
            //     $html .= '</div></div>';
            //     return $html;
            // })
            ->rawColumns(['memberid', 'membername'])
            ->make(true);
    }

    private function createPostForm($memberid, $route, $form_id = 'form')
    {
        $csrf_token = csrf_token();
        $csrf_input = '<input type="hidden" name="_token" value="' . $csrf_token . '" />';
        $memberid_input = '<input type="hidden" name="memberid" value="' . $memberid . '" />';

        $form = '<form id="' . $form_id . '" action="' . $route . '" method="POST" class="d-none">';
        $form .= $csrf_input;
        $form .= $memberid_input;
        $form .= '</form>';
        return $form;
    }

    public function show($memberid)
    {
        $club_id = auth()->user()->club_id;
        $member = Member::where('memberid', strtoupper($memberid))
            ->where('club_id', $club_id)
            ->with('family')->first();

        if (!$member) {
            return redirect()
                ->back()
                ->with('memberid', $memberid)
                ->with('error', "Sorry! Member Not Found, Invalid Member ID.");
        }

        return view('members.show', compact('member'));
    }

    public function create(Request $request)
    {
        $statuses = MembershipConsts::STATUSES;
        $block_statuses = MembershipConsts::BLOCK_STATUSES;
        $other_types = MembershipConsts::TYPES;
        $member_type_subs = MembershipConsts::MEMBER_TYPE_SUBS;
        $categories = MemberCategory::all('code', 'des');

        return view('members.create', [
            'categories' => $categories,
            'statuses' => $statuses,
            'block_statuses' => $block_statuses,
            'other_types' => $other_types,
            'member_type_subs' => $member_type_subs,
        ]);
    }

    public function store(Request $request)
    {
        $club_id = auth()->user()->club_id; // $request->user()->club_id;

        if (!$club_id) {
            return redirect()->back()->with('error', 'invalid club');
        }

        // validate request
        $request->club_id = $club_id;
        $validatedData = $this->validateData();

        // get next member serial
        $msr = DB::select('SELECT MAX(NVL(membersr, 0)) + 1 next_member_sr FROM memberinfo');
        $next_member_sr = $msr[0]->next_member_sr;
        $memberid = str_replace(' ', '', $request->memberid);
        $created_by = auth()->user()->id;
        $today = Carbon::now();
        $memberpic_filename = null;
        $membersign_filename = null;

        $validatedData['blockstatus'] = 'ACTIVE';
        $validatedData['memberpic'] = '';
        $validatedData['membersign'] = '';
        $validatedData['married'] = in_array($request['married'], ['Y', 'N']) ? $request['married'] : 'Y';
        $validatedData['club_id'] = $club_id;
        $validatedData['membersr'] = $next_member_sr;
        $validatedData['enb'] = auth()->user()->club->code;

        if ($request->hasFile('memberpic')) {
            $extension = $request->file('memberpic')->extension();
            $memberpic_filename = $memberid . '-p-' . $next_member_sr . '.' . $extension;
            $request->memberpic->storeAs($this->imagesPath, $memberpic_filename, 'public');
        }

        if ($request->hasFile('membersign')) {
            $extension = $request->file('membersign')->extension();
            $membersign_filename = $memberid . '-s-' . $next_member_sr . '.' . $extension;
            $request->membersign->storeAs($this->imagesPath, $membersign_filename, 'public');
        }

        Log::info('memberpic_filename : => ' . $memberpic_filename);
        Log::info('membersign_filename : => ' . $membersign_filename);

        $validatedData['picture'] = $memberpic_filename;
        $validatedData['signature'] = $membersign_filename;
        // $validatedData['created_at'] = $today;
        // $validatedData['updated_at'] = $today;
        $validatedData['created_by'] = $created_by;
        $validatedData['updated_by'] = $created_by;
        $validatedData['memberid'] = $memberid;

        DB::beginTransaction();
        try {
            $member = Member::create($validatedData);
            if ($member) {
                if ($request->hasFile('memberpic')) {
                    $procedureName = 'member_img_upload';
                    // $procedureName = 'img_upload';
                    $bindings = ['imgname'  => $memberpic_filename, 'id'  => $next_member_sr];
                    DB::executeProcedure($procedureName, $bindings);
                }

                if ($request->hasFile('membersign')) {
                    $procedureName = 'member_sign_upload';
                    // $procedureName = 'sign_upload';
                    $bindings = ['imgname'  => $membersign_filename, 'id'  => $next_member_sr];
                    DB::executeProcedure($procedureName, $bindings);
                }

                // $procedureName = 'member_img_upload';
                // $bindings = ['imgname'  => 'R-11115.bmp', 'membersr'  => $next_member_sr];
                // $result = DB::executeProcedure($procedureName, $bindings);
            }

            DB::commit();

            return redirect()
                ->route('member.edit', ['memberid' => $member->memberid, 'tab' => 'family'])
                ->with('success', 'Member created successfully!');
        } catch (\Exception $e) {
            // $user = [
            //     'user_id' => auth()->user()->id,
            //     'username' => 'Muhammad Usman Sharif',
            //     'date' => $today->format('d-m-Y h:i:s'),
            // ];
            // $error = sprintf("[%s],[%d], USER:[%s], ERROR:[%s]", __METHOD__, __LINE__, json_encode($user, true), json_encode($e->getMessage(), true));
            // Log::error($error);
            $this->logError($e, $request->user()->id, __METHOD__, __LINE__);
            return redirect()->back()->with('error', 'Invalid Error');
        }
    }

    public function updateStatus(Request $request)
    {
        $member = null;
        $memberid = null;
        $statuses = MembershipConsts::STATUSES;
        $block_statuses = MembershipConsts::BLOCK_STATUSES;
        $sessionMsg = null;
        $sessionMsgSA = null;

        if ($request->post()) {
            $request->validate([
                'memberid' => 'required|exists:memberinfo,memberid',
                'blockstatus' => ['required', ValidationRule::in(MembershipConsts::BLOCK_STATUS)],
                'remarks' => 'nullable|max:500',
                'fromdate' => 'nullable|date_format:Y-m-d',
                'todate' => 'nullable|date_format:Y-m-d',
            ]);

            $membersr = $request->membersr;
            $memberid = $request->memberid;

            $user = auth()->user();
            $user_id = $user->id;

            try {
                // throw new Exception('random exce');
                $member = Member::select('membersr', 'memberid', 'fromdate', 'todate', 'remarks', 'blockstatus', 'status', 'membername', 'typeid')
                    ->where('membersr', $membersr)
                    ->where('club_id', $user->club_id)
                    ->first();

                if ($member) {

                    $member->blockstatus = strtoupper($request->blockstatus);
                    $member->remarks = strtoupper($request->remarks);
                    $member->todate = $request->todate;
                    $member->fromdate = $request->fromdate;
                    $member->updated_by = $user_id;
                    $member->save();
                    $sessionMsgSA = [
                        'expression' => 'Success!',
                        'type' => 'success',
                        'message' => "Member status updated successfully!",
                    ];
                } else {
                    $sessionMsgSA = [
                        'expression' => 'Opps!',
                        'type' => 'error',
                        'message' => "Member Not Found!",
                    ];
                }
            } catch (\Exception $e) {
                $this->logError($e, $user_id, __METHOD__, __LINE__);
                $sessionMsgSA = [
                    'expression' => 'Opps!',
                    'type' => 'error',
                    'message' => "Server Error, Please try again!",
                ];
            }
        }

        return view('members.update_status', [
            'member' => $member,
            'memberid' => $memberid,
            'statuses' => $statuses,
            'block_statuses' => $block_statuses,
            'member' => $member,
            'sessionMsg' => null,
            'sessionMsgSA' => $sessionMsgSA,
        ]);
    }

    public function edit($memberid, Request $request)
    {
        $club_id = auth()->user()->club_id;
        $member = Member::getMember($memberid, $club_id);
        // $member = Member::where('memberid', strtoupper($memberid))
        //     ->where('club_id', $club_id)
        //     ->with('family')->first();

        $statuses = MembershipConsts::STATUSES;
        $block_statuses = MembershipConsts::BLOCK_STATUSES;
        $other_types = MembershipConsts::TYPES;
        $member_type_subs = MembershipConsts::MEMBER_TYPE_SUBS;
        $categories = MemberCategory::all('code', 'des');

        $credit_allowed = MembershipConsts::CREDIT_ALLOWED;
        $relations = MembershipConsts::RELATIONS;

        $sessionMsg = null;
        if (!$member) {
            return redirect()
                ->route('member.create')
                ->with('memberid', $memberid)
                ->with('error', "Sorry! Member <strong>$memberid</strong> Not Found");
        }

        return view('members.edit', [
            'categories' => $categories,
            'statuses' => $statuses,
            'block_statuses' => $block_statuses,
            'other_types' => $other_types,
            'member_type_subs' => $member_type_subs,
            'member' => $member,
            'memberid' => $memberid,
            'credit_allowed' => $credit_allowed,
            'relations' => $relations,
            'sessionMsg' => $sessionMsg,
        ]);
    }

    public function update($membersr, Request $request)
    {

        $this->validateData(true);

        // VALIDATE if memberid already taken
        // try {
        //     $memberid_exists = Member::where('memberid', $request->memberid)
        //         ->where('membersr', '!=', $membersr)
        //         ->first();
        //     if ($memberid_exists) {
        //         throw new \Exception();
        //     }
        // } catch (\Exception $e) {
        //     $this->logError($e, $request->user()->id, __METHOD__, __LINE__);
        //     $validator = Validator::make([], []);
        //     $validator->errors()->add('memberid', 'Member ID already taken.');
        //     throw new ValidationException($validator);
        // }


        DB::beginTransaction();
        try {
            $member = Member::find($membersr);

            if (!$member) {
                return redirect()->back()->with('error', 'Invalid Member');
            }

            $today = Carbon::now();
            $updated_by = auth()->user()->id;
            $memberid = str_replace(' ', '', $request->memberid); //$request->memberid;
            $memberpic_filename = $member->picture;
            $membersign_filename = $member->signature;


            if ($request->hasFile('memberpic')) {
                $extension = $request->file('memberpic')->extension();
                $memberpic_filename = $memberid . '-p-' . $membersr . '.' . $extension;
                $request->memberpic->storeAs($this->imagesPath, $memberpic_filename, 'public');

                // update picture blob field
                $procedureName = 'member_img_upload';
                $bindings = ['imgname'  => $memberpic_filename, 'id'  => $membersr];
                DB::executeProcedure($procedureName, $bindings);
            }

            if ($request->hasFile('membersign')) {
                $extension = $request->file('membersign')->extension();
                $membersign_filename = $memberid . '-s-' . $membersr . '.' . $extension;
                $request->membersign->storeAs($this->imagesPath, $membersign_filename, 'public');

                // update signature blob field
                $procedureName = 'member_sign_upload';
                $bindings = ['imgname'  => $membersign_filename, 'id'  => $membersr];
                DB::executeProcedure($procedureName, $bindings);
            }


            Member::find($membersr)->update([
                // 'memberid' => $memberid,
                'categoryid' => $request->categoryid,
                'typeid' => $request->typeid,
                'membername' => $request->membername,
                'memberfname' => $request->memberfname,
                'cnic' => $request->cnic,
                'pano' => $request->pano,
                'occupationid' => $request->occupationid,
                'rank' => $request->rank,
                'department' => $request->department,
                'organisation' => $request->organisation,
                'dob' => $request->dob,
                'married' => $request->married,
                'otherinfo' => $request->otherinfo,
                'membertype' => $request->membertype,
                'status' => $request->status,
                'membershipdate' => $request->membershipdate,
                'cardissuedate' => $request->cardissuedate,
                'cardexpirydate' => $request->cardexpirydate,
                'phoneoffice' => $request->phoneoffice,
                'phoneresidence' => $request->phoneresidence,
                'mailingaddress' => $request->mailingaddress,
                'workingaddress' => $request->workingaddress,
                'mobileno' => $request->mobileno,
                'mobileno2' => $request->mobileno2,
                'fax' => $request->fax,
                'email' => $request->email,
                'picture' => $memberpic_filename,
                'signature' => $membersign_filename,
                'updated_by' => $updated_by,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Member Updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            // $user = [
            //     'user_id' => auth()->user()->id,
            //     'username' => 'Muhammad Usman Sharif',
            //     'date' => $today->format('d-m-Y h:i:s'),
            // ];
            // $error = sprintf("[%s],[%d], USER:[%s], ERROR:[%s]", __METHOD__, __LINE__, json_encode($user, true), json_encode($e->getMessage(), true));
            // Log::error($error);
            $this->logError($e, $request->user()->id, __METHOD__, __LINE__);
            return redirect()
                ->back()
                ->with('error', "Sorry! member $memberid not saved, error occured.");
        }
    }

    private function validateData($an_update = false)
    {
        $rules = [
            // 'memberid' => 'required|unique:memberinfo,memberid|max:20', // MEMBERID,
            // 'club_id' => 'required|exists:clubs,club_id', // club_id
            'club_id' => 'required|exists:clubs,id', // club_id
            'categoryid' => 'required|exists:membercategory,code', // CATEGORYID
            'typeid' => 'required|exists:membertypes,code', // TYPEID
            'membername' => 'required|max:100', // MEMBERNAME
            'memberfname' => 'nullable|max:100', // MEMBERFNAME
            'cnic' => 'required|max:20', // CNIC
            'pano' => 'nullable|max:8', // PANO
            'occupationid' => 'nullable|exists:memberoccupation,code', // OCCUPATIONID (profession)
            'rank' => 'nullable|max:255', // RANK
            'department' => 'nullable|max:200', // DEPARTMENT
            'organisation' => 'nullable|max:100', // ORGANISATION
            'dob' => 'required|date_format:Y-m-d', // DOB
            'married' => 'nullable', // 'nullable', // MARRIED
            'otherinfo' => 'nullable|max:100', // OTHERINFO
            'membertype' => ['nullable', ValidationRule::in(MembershipConsts::TYPE)], // OTHERINFO
            // 'memberpic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=500,height=500', // MEMBERPIC
            'memberpic' => 'nullable|image|mimes:jpeg,jpg,png,bmp|max:1024', // MEMBERPIC
            'membersign' => 'nullable|image|mimes:jpeg,jpg,png,bmp|max:1024', // MEMBERSIGN
            'status' => ['nullable', ValidationRule::in(MembershipConsts::STATUS)], // STATUS
            // 'blockstatus' => ['nullable', ValidationRule::in(MembershipConsts::BLOCK_STATUS)], // BLOCKSTATUS
            'membershipdate' => 'nullable|date_format:Y-m-d', // MEMBERSHIPDATE
            'cardissuedate' => 'nullable|date_format:Y-m-d', // CARDISSUEDATE
            'cardexpirydate' => 'nullable|date_format:Y-m-d', // CARDEXPIRYDATE
            'phoneoffice' => 'nullable|max:60', // PHONEOFFICE
            'phoneresidence' => 'nullable|max:60', // PHONERESIDENCE
            'mailingaddress' => 'nullable|max:500', // MAILINGADDRESS
            'workingaddress' => 'nullable|max:500', // WORKINGADDRESS
            'mobileno' => 'nullable|max:20', // MOBILENO
            'mobileno2' => 'nullable|max:100', // MOBILENO
            'fax' => 'nullable|max:20', // FAX
            'email' => 'nullable|email|max:50', // EMAIL
        ];

        if (!$an_update) {
            $rules['memberid'] = 'unique:memberinfo,memberid|max:20';
        }

        return request()->validate($rules, [
            'memberid.required' => 'Member ID is required.',
            'memberid.unique' => 'Member ID already taken.',
            'club_id.exists' => 'Invalid Club',
            'typeid.required' => 'Required',
            'typeid.exists' => 'Invalid Type',
            'categoryid.required' => 'Cattegory is required',
            'categoryid.exists' => 'Invalid Cattegory',
            'membername.required' => 'Member name is required',
            'cnic.required' => 'CNIC is required',
            'occupationid.exists' => 'Invalid Profession',
            'dob.required' => 'Date of birth is required',
            'membertype.in' => 'Invalid Type',
            'status.in' => 'Invalid Status',
            '*.date_format' => 'Invalid Date',
        ]);
    }

    public function search()
    {
        $statuses = MembershipConsts::STATUSES;
        $block_statuses = MembershipConsts::BLOCK_STATUSES;
        $other_types = MembershipConsts::TYPES;
        $member_type_subs = MembershipConsts::MEMBER_TYPE_SUBS;
        $categories = MemberCategory::all('code', 'des');
        $clubs = Club::all('id', 'name', 'code');

        return view('members.search', [
            'categories' => $categories,
            'statuses' => $statuses,
            'block_statuses' => $block_statuses,
            'other_types' => $other_types,
            'member_type_subs' => $member_type_subs,
            'clubs' => $clubs,
        ]);
        // return view('members.search');
    }


    public function submitSearch(Request $request)
    {
        // sleep(3);
        $admin = false;
        $club_id = auth()->user()->club_id;
        $is_super_admin = $request->user()->hasRole(getSU());

        $rules = [
            'dob' => 'nullable|date_format:Y-m-d',
            'block_from_from_date' => 'nullable|date_format:Y-m-d',
            'block_from_to_date' => 'nullable|date_format:Y-m-d',
            'block_to_from_date' => 'nullable|date_format:Y-m-d',
            'block_to_to_date' => 'nullable|date_format:Y-m-d',
            'membershipfromdate' => 'nullable|date_format:Y-m-d',
            'membershiptodate' => 'nullable|date_format:Y-m-d',
            'card_issue_from_date' => 'nullable|date_format:Y-m-d',
            'card_issue_to_date' => 'nullable|date_format:Y-m-d',
            'card_expiry_from_date' => 'nullable|date_format:Y-m-d',
            'card_expiry_to_date' => 'nullable|date_format:Y-m-d',
            'typeid' => 'nullable|exists:membertypes,code',
            'occupationid' => 'nullable|exists:memberoccupation,code',
            'married' => ['nullable', ValidationRule::in(['Y', 'N'])],
            'membertype' => ['nullable', ValidationRule::in(MembershipConsts::TYPE)],
            'status' => ['nullable', ValidationRule::in(MembershipConsts::STATUS)],
            'blockstatus' => ['nullable', ValidationRule::in(MembershipConsts::BLOCK_STATUS)],
        ];

        if ($is_super_admin) {
            $rules['club_id'] = 'nullable|exists:clubs,id';
            $club_id = $request->club_id;
        }

        $request->validate($rules);

        $today = Carbon::now();
        $memberid = $request->memberid;
        $categoryid = $request->categoryid;
        $typeid = $request->typeid;
        $membername = $request->membername;
        $memberfname = $request->memberfname;
        $memberfname_blank = $request->memberfname_blank;
        $cnic = $request->cnic;
        $cnic_blank = $request->cnic_blank;
        $pano = $request->pano;
        $pano_blank = $request->pano_blank;
        $occupationid = $request->occupationid;
        $occupationid_blank = $request->occupationid_blank;
        $department = $request->department;
        $department_blank = $request->department_blank;
        $organisation = $request->organisation;
        $organisation_blank = $request->organisation_blank;
        $dob = $request->dob;
        $dob_blank = $request->dob_blank;
        $married = $request->married;
        $otherinfo = $request->otherinfo;
        $membertype = $request->membertype;
        $status = $request->status;
        $blockstatus = $request->blockstatus;
        $block_from_from_date = $request->block_from_from_date;
        $block_from_to_date = $request->block_from_to_date;
        $block_to_from_date = $request->block_to_from_date;
        $block_to_to_date = $request->block_to_to_date;
        $remarks = $request->remarks;
        $membershipfromdate = $request->membershipfromdate;
        $membershiptodate = $request->membershiptodate;
        $card_issue_from_date = $request->card_issue_from_date;
        $card_issue_to_date = $request->card_issue_to_date;
        $card_expiry_from_date = $request->card_expiry_from_date;
        $card_expiry_to_date = $request->card_expiry_to_date;
        $phoneoffice = $request->phoneoffice;
        $phoneresidence = $request->phoneresidence;
        $mailingaddress = $request->mailingaddress;
        $mailingaddress_blank = $request->mailingaddress_blank;
        $workingaddress = $request->workingaddress;
        $workingaddress_blank = $request->workingaddress_blank;
        $mobileno = $request->mobileno;
        $mobileno_blank = $request->mobileno_blank;
        $fax = $request->fax;
        $fax_blank = $request->fax_blank;
        $email = $request->email;
        $email_blank = $request->email_blank;

        // validate if at least one field is filled or checked 
        // if not throw an error wit status code 400
        try {
            $filledKeys = [];
            foreach ($request->all() as $k => $val) {
                if ($k == "_token") continue;

                if ($val) $filledKeys[$k] =  $val;
            }
            $filledKeysCount = count($filledKeys);
            if (!$filledKeysCount) {
                throw new Exception("Atleast one field is Required");
            }
        } catch (\Exception $e) {
            $this->logError($e, $request->user()->id, __METHOD__, __LINE__);
            return response()->json([
                'success' => false,
                'sessionMsg' => [
                    'type' => 'error',
                    // 'message' => "Atleast Two fields are Required.",
                    'message' => $e->getMessage(),
                ],
            ], 400);
        }


        try {
            $members = Member::select('membersr', 'memberid', 'categoryid', 'membername', 'memberfname', 'cnic', 'department', 'organisation', 'otherinfo', 'dob', 'married', 'mailingaddress', 'workingaddress', 'phoneoffice', 'phoneresidence', 'mobileno', 'fax', 'email', 'status', 'cardissuedate', 'cardexpirydate', 'membershipdate', 'edate', 'euser', 'eterm', 'occupationid', 'typeid', 'pano', 'remarks', 'discperc', 'membertype', 'blockstatus', 'fromdate', 'todate', 'blockremarks', 'club_id', 'picture', 'signature')
                ->with('type:code,des')
                ->with('category:code,des')
                ->with('occupation:code,des');

            if ($memberid) {
                $memberid = strtoupper($memberid);
                $column = 'memberid';
                $members = $members->whereRaw("UPPER($column) LIKE '%{$memberid}%'");
            }

            if ($categoryid) {
                $members = $members->where('categoryid', $categoryid);
            }

            if ($typeid) {
                $members = $members->where('typeid', $typeid);
            }

            if ($membername) {
                $membername = strtoupper($membername);
                $column = 'membername';
                $members = $members->whereRaw("UPPER($column) LIKE '%{$membername}%'");
            }

            if ($memberfname_blank) {
                $members = $members->whereNull('memberfname');
            } else if ($memberfname) {
                $memberfname = strtoupper($memberfname);
                $column = 'memberfname';
                $members = $members->whereRaw("UPPER($column) LIKE '%{$memberfname}%'");
            }

            if ($cnic_blank) {
                $members = $members->whereNull('cnic');
            } else if ($cnic) {
                $cnic = rtrim(str_replace("_", "", $cnic), '-');
                $members = $members->where('cnic', 'LIKE', "%{$cnic}%");
            }

            if ($pano_blank) {
                $members = $members->whereNull('pano');
            } else if ($pano) {
                $members = $members->where('pano', 'LIKE', "%{$pano}%");
            }

            if ($occupationid_blank) {
                $members = $members->whereNull('occupationid');
            } else if ($occupationid) {
                $members = $members->where('occupationid', $occupationid);
            }

            if ($department_blank) {
                $members = $members->whereNull('department');
            } else if ($department) {
                $department = strtoupper($department);
                $column = 'department';
                $members = $members->whereRaw("UPPER($column) LIKE '%{$department}%'");
            }

            if ($organisation_blank) {
                $members = $members->whereNull('organisation');
            } else if ($organisation) {
                $organisation = strtoupper($organisation);
                $column = 'organisation';
                $members = $members->whereRaw("UPPER($column) LIKE '%{$organisation}%'");
            }

            if ($dob_blank) {
                $members = $members->whereNull('dob');
            } else if ($dob) {
                $members = $members->where('dob', $dob);
            }

            if ($married) {
                $married = strtoupper($married);
                $column = 'married';
                $members = $members->whereRaw("UPPER($column) = '$married'");
            }

            if ($otherinfo) {
                $otherinfo = strtoupper($otherinfo);
                $column = 'otherinfo';
                $members = $members->whereRaw("UPPER($column) LIKE '%{$otherinfo}%'");
            }

            if ($membertype) {
                $membertype = strtoupper($membertype);
                $column = 'membertype';
                $members = $members->whereRaw("UPPER($column) = '$membertype'");
            }

            if ($membertype) {
                $membertype = strtoupper($membertype);
                $column = 'membertype';
                $members = $members->whereRaw("UPPER($column) = '$membertype'");
            }

            if ($blockstatus) {
                $blockstatus = strtoupper($blockstatus);
                $column = 'blockstatus';
                $members = $members->whereRaw("UPPER($column) = '$blockstatus'");
            }

            if ($status) {
                $status = strtoupper($status);
                $column = 'status';
                $members = $members->whereRaw("UPPER($column) = '$status'");
            }

            if ($block_from_from_date && $block_from_to_date) {
                $members = $members->whereBetween('fromdate', [$block_from_from_date, $block_from_to_date]);
            } else if ($block_from_from_date) {
                $members = $members->whereBetween('fromdate', [$block_from_from_date, $$today]);
            } else if ($block_from_to_date) {
                $members = $members->where('fromdate', $block_from_to_date);
            }

            if ($block_to_from_date && $block_to_to_date) {
                $members = $members->whereBetween('todate', [$block_to_from_date, $block_to_to_date]);
            } else if ($block_to_from_date) {
                $members = $members->whereBetween('todate', [$block_to_from_date, $$today]);
            } else if ($block_to_to_date) {
                $members = $members->where('todate', $block_to_to_date);
            }

            if ($remarks) {
                $remarks = strtoupper($remarks);
                $column = 'remarks';
                $members = $members->whereRaw("UPPER($column) LIKE '%$remarks%'");
            }

            if ($membershipfromdate && $membershiptodate) {
                $members = $members->whereBetween('membershipdate', [$membershipfromdate, $membershiptodate]);
            } else if ($membershipfromdate) {
                $members = $members->whereBetween('membershipdate', [$membershipfromdate, $today]);
            } else if ($membershiptodate) {
                $members = $members->where('membershipdate', $membershiptodate);
            }

            if ($card_issue_from_date && $card_issue_to_date) {
                $members = $members->whereBetween('cardissuedate', [$card_issue_from_date, $card_issue_to_date]);
            } else if ($card_issue_from_date) {
                $members = $members->whereBetween('cardissuedate', [$card_issue_from_date, $$today]);
            } else if ($card_issue_to_date) {
                $members = $members->where('cardissuedate', $card_issue_to_date);
            }

            if ($card_expiry_from_date && $card_expiry_to_date) {
                $members = $members->whereBetween('cardexpirydate', [$card_expiry_from_date, $card_expiry_to_date]);
            } else if ($card_expiry_from_date) {
                $members = $members->whereBetween('cardexpirydate', [$card_expiry_from_date, $$today]);
            } else if ($card_expiry_to_date) {
                $members = $members->where('cardexpirydate', $card_expiry_to_date);
            }

            if ($phoneoffice) {
                $members = $members->where('phoneoffice', 'LIKE', "%{$phoneoffice}%");
            }

            if ($phoneresidence) {
                $members = $members->where('phoneresidence', 'LIKE', "%{$phoneresidence}%");
            }

            if ($mailingaddress_blank) {
                $members = $members->whereNull('mailingaddress');
            } else if ($mailingaddress) {
                $mailingaddress = strtoupper($mailingaddress);
                $column = 'mailingaddress';
                $members = $members->whereRaw("UPPER($column) LIKE '%{$mailingaddress}%'");
            }

            if ($workingaddress_blank) {
                $members = $members->whereNull('workingaddress');
            } else if ($workingaddress) {
                $workingaddress = strtoupper($workingaddress);
                $column = 'workingaddress';
                $members = $members->whereRaw("UPPER($column) LIKE '%{$workingaddress}%'");
            }

            if ($mobileno_blank) {
                $members = $members->whereNull('mobileno');
            } else if ($mobileno) {
                $members = $members->where('mobileno', 'LIKE', "%{$mobileno}%")
                    ->orWhere('mobileno2', 'LIKE', "%{$mobileno}%");
            }

            if ($fax_blank) {
                $members = $members->whereNull('fax');
            } else if ($fax) {
                $members = $members->where('fax', 'LIKE', "%{$fax}%");
            }

            if ($email_blank) {
                $members = $members->whereNull('email');
            } else if ($email) {
                $email = strtoupper($email);
                $column = 'email';
                $members = $members->whereRaw("UPPER($column) LIKE '%{$email}%'");
            }

            if (!$is_super_admin) {
                $members = $members->where('club_id', $club_id);
            }


            $members = $members->get();

            return response()->json([
                'members' => $members,
                'count' => count($members),
            ]);
        } catch (\Exception $e) {
            $this->logError($e, $request->user()->id, __METHOD__, __LINE__);
            return response()->json([
                'members' => [],
                'count' => 0,
                'query_params' => [],
                'sessionMsg' => [
                    'type' => 'error',
                    'message' => "Atleast one field is Required.",
                ],
            ], 400);
        }
    }

    public function memberSearch(Request $request)
    {
        dd($request->all());
    }

    public function getMember(Request $request)
    {
        $memberid = $request->memberid;
        $member = Member::select('membersr', 'memberid', 'categoryid', 'membername', 'memberfname', 'cnic', 'department', 'organisation', 'otherinfo', 'dob', 'married', 'mailingaddress', 'workingaddress', 'phoneoffice', 'phoneresidence', 'mobileno', 'fax', 'email', 'status', 'cardissuedate', 'cardexpirydate', 'membershipdate', 'edate', 'euser', 'eterm', 'occupationid', 'typeid', 'pano', 'remarks', 'discperc', 'membertype', 'blockstatus', 'fromdate', 'todate', 'blockremarks', 'club_id', 'picture', 'signature')
            ->where('memberid', strtoupper($memberid))
            ->where('club_id', auth()->user()->club_id)
            ->with('type')
            ->first();
        $sessionMsg = null;
        if (!$member) {
            $sessionMsg = [
                'type' => 'error',
                'message' => "Atleast one field is Required.",
            ];
        }

        return response()->json([
            'data' => $member,
            'sessionMsg' => $sessionMsg,
        ]);
    }

    public function getMemberBySR(Request $request)
    {
        $sessionMsg = [];
        $sessionMsg['type'] = 'error'; 
        $sessionMsg['message'] = 'Member Serial is required'; 

        if (!$request->filled('membersr')) {
            return response()->json([
                'member' => [],
                'sessionMsg' => $sessionMsg,
            ]);
        }

        $member = Member::select('membersr', 'memberid', 'membername', 'status', 'typeid', 'discperc', 'blockstatus', 'memberpic', 'membersign', 'picture', 'signature')
            ->where('membersr', $request->input('membersr'))
            ->with('type', function ($q) {
                $q->select('code')->with('subscription:code,typeid,dhadiscount');
            })
            ->first();
        
        if(!$member){
            $sessionMsg['message'] = 'Member Not Found';
            return response()->json([
                'member' => [],
                'sessionMsg' => $sessionMsg,
            ]);
        }

        $memberpic = null;
        $membersign = null;
        
        if (!$member->picture) {
            $memberpic = $member->memberpic ? 'data:image/bmp;base64,' . base64_encode($member->memberpic) : null;
        }

        if (!$member->signature) {
            $membersign = $member->membersign ? 'data:image/bmp;base64,' . base64_encode($member->membersign) : null;
        }

        return response()->json([
            'member' => [
                'membersr' => $member->membersr,
                'memberid' => $member->memberid,
                'membername' => $member->membername,
                'status' => $member->status,
                'discperc' => $member->discperc,
                'blockstatus' => $member->blockstatus,
                'picture' => $member->picture,
                'signature' => $member->signature,
                'memberpic' => $memberpic,
                'membersign' => $membersign,
                'typeid' => $member->typeid,
                'type' => $member->type,
            ],
            'sessionMsg' => null,
        ]);
    }

    public function getMemberByID(Request $request)
    {
        $sessionMsg = [];
        $sessionMsg['type'] = 'error'; 
        $sessionMsg['message'] = 'Member Serial is required'; 
        $member_id_is_num = is_numeric($request->input('memberid'));

        $memberid = $request->input('memberid');

        if($member_id_is_num && !str_starts_with($request->input('memberid'), '1')){
            $memberid = 'R-'.$memberid;
        }

        if (!$request->filled('memberid')) {
            return response()->json([
                'member' => null,
                'sessionMsg' => $sessionMsg,
            ]);
        }

        $member = Member::select('membersr', 'memberid', 'membername', 'typeid', 'status', 'discperc', 'blockstatus', 'memberpic', 'membersign', 'picture', 'signature')
            ->where('memberid', strtoupper($memberid))
            ->with('type', function ($q) {
                $q->select('code')->with('subscription:code,typeid,dhadiscount');
            })
            ->first();
        
        if(!$member){
            $sessionMsg['message'] = 'Member Not Found';
            return response()->json([
                'member' => null,
                'sessionMsg' => $sessionMsg,
            ]);
        }

        $memberpic = null;
        $membersign = null;
        
        if (!$member->picture) {
            $memberpic = $member->memberpic ? 'data:image/bmp;base64,' . base64_encode($member->memberpic) : null;
        }

        if (!$member->signature) {
            $membersign = $member->membersign ? 'data:image/bmp;base64,' . base64_encode($member->membersign) : null;
        }

        return response()->json([
            'member' => [
                'membersr' => $member->membersr,
                'memberid' => $member->memberid,
                'membername' => $member->membername,
                'status' => $member->status,
                'discperc' => $member->discperc,
                'blockstatus' => $member->blockstatus,
                'picture' => $member->picture,
                'signature' => $member->signature,
                'memberpic' => $memberpic,
                'membersign' => $membersign,
                'typeid' => $member->typeid,
                'type' => $member->type,
            ],
            'sessionMsg' => null,
        ]);
    }


    public function membersForLov(Request $request)
    {
        $members = Member::select('membersr', 'memberid', 'membername', 'mailingaddress', 'discperc')
            ->orderBy('membersr', 'desc')
            ->whereNotNull('memberid');

        if ($request->filled('query')) {
            $query = strtoupper($request->input('query'));
            $members = $members->whereRaw("UPPER(memberid) LIKE '%{$query}%'")
                ->orWhereRaw("UPPER(membername) LIKE '%{$query}%'");
                // ->take(50);
        // } else {
        //     $members = $members;
        }

        $members = $members->take(50)->get();

        return $members;
    }
}
