<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\StaticFunction;
use Auth;
use App\Http\Requests\FrontUserRegister;
use DataTables;
use App\Models\UserPetInfo;
use Hash;
use App\Models\UserRole;
use DB;

class FrontUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userRegister()
    {
        $pageConfigs = ['blankPage' => true];
        $states = StaticFunction::states();
        $cities = StaticFunction::cities();
        $locations = User::select('id','business_name')->where('status',1)->with('pet_info')->whereHas('user_role', function ($query) {
            $query->where('role_id', 2);
        })->get();
        $pet_types = StaticFunction::pet_types();
        $gender = StaticFunction::gender();
        $cremation_type = StaticFunction::cremation_type();
        $frame_color_type = StaticFunction::frame_color_type();
        return view('/content/authentication/auth-register-multisteps', [
            'pageConfigs' => $pageConfigs, 
            'cities' => $cities, 
            'states' => $states, 
            'locations' => $locations,
            'pet_types' => $pet_types,
            'gender' => $gender,
            'cremation_type' => $cremation_type,
            'frame_color_type' => $frame_color_type
        ]);
    }

    public function index()
    {
        $breadcrumbs = [['link' => "admin/customers", 'name' => "Customer"], ['name' => "Customer List"]];
        if ($request->ajax()) {
            if(Auth::user()->user_role->role_id == 2){
                $users = User::with('created_user')->with('updated_user')->where('business_user_id', Auth::user()->id)->with('pet_info')->whereHas('user_role', function ($query) {
                    $query->where('role_id', 3);
                })->latest()->get();
            }elseif(Auth::user()->user_role->role_id == 1 || Auth::user()->user_role->role_id == 4){
                $users = User::with('created_user')->with('updated_user')->with('pet_info')->whereHas('user_role', function ($query) {
                    $query->where('role_id', 3);
                })->latest()->get();
            }
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('phone', function ($row) {
                    $phone = '';
                    if($row->phone != null){
                        $phone = $row->phone;
                    }
                    return $phone;
                })
                ->addColumn('created_by', function ($row) {
                    $created_by = '';
                    if($row->created_user != null){
                        $created_by = ucfirst($row->created_user->name);
                        $created_by .= ($row->created_user->lname != null) ? ' '.ucfirst($row->created_user->lname) : "";
                    }
                    return $created_by;
                })
                ->addColumn('updated_by', function ($row) {
                    $updated_by = '';
                    if($row->updated_user != null){
                        $updated_by = ucfirst($row->updated_user->name);
                        $updated_by .= ($row->updated_user->lname != null) ? ' '.ucfirst($row->updated_user->lname) : "";
                    }
                    return $updated_by;
                })
                ->addColumn('name', function ($row) {
                    $name = '';
                    $name = '<a href="' .url('/'). '/admin/customers/' .$row->id. '/edit">'.ucfirst($row->name);
                    $name .= ($row->lname != null) ? ' '.ucfirst($row->lname) : "".'</a>';
                    return $name;
                })
                ->addColumn('action', function ($row) {
                    $action = '';
                    $action .= '<a href="' . url()->current() . '/' . $row->id . '/edit" class="action-btn" data-toggle="tooltip" data-placement="bottom" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>';
                    if(Auth::user()->user_role->role_id == 1){
                        $action .= '<a onclick="deleteCustomer(' .$row->id. ')" class="action-btn" data-toggle="tooltip" data-placement="bottom" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>';
                    }
                    return $action;
                })
            ->rawColumns(['date_cremated','pet_name','pet_type','name','action','created_by','updated_by'])
            ->make(true);
        }
        return view('/content/apps/user/user-list', ['breadcrumbs' => $breadcrumbs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FrontUserRegister $request)
    {
        DB::beginTransaction();
        $user = new User();
        $user->name = $request->fname;
        $user->lname = $request->lname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->business_user_id = ($request->location != null) ? $request->location : null;
        $user->alternate_phone = $request->alternate_phone;
        $user->address = $request->address;
        $user->state = $request->state;
        $user->city = $request->city;
        $user->zipcode = $request->zipcode;
        $user->status = 1;
        $user->password = Hash::make($request->password);
        
        if($user->save()){
            $user_role = new UserRole();
            $user_role->user_id = $user->id;
            $user_role->role_id = 3;
            $user_role->save();

            // User pet information
            $pet_info = new UserPetInfo();
            $pet_info->user_id = $user->id;
            $pet_info->location = $request->location;
            $pet_info->pet_name = $request->pet_name;
            $pet_info->pet_type = $request->pet_type;
            $pet_info->gender = $request->gender;
            $pet_info->age = $request->age;
            $pet_info->weight = $request->weight;
            $pet_info->date_of_birth = $request->date_of_birth;
            $pet_info->breed_and_color = $request->breed_and_color;
            $pet_info->additional_pet_info = $request->additional_pet_info;
            $pet_info->cremation_type = $request->cremation_type;
            $pet_info->frame_color = $request->frame_color;
            $pet_info->special_info = $request->special_info;
            $pet_info->save();

            Auth::login($user);
            DB::commit();
            return redirect()->route('user-dashboard')->with('success', 'You\'re registered successfully.');
        }else{
            DB::rollback();
            return redirect()->route('user-register')->with('error', 'Something went wrong, try again later.');
        }
    }

    public function userDashboard()
    {
        $pageConfigs = ['pageHeader' => false];
        return view('/content/dashboard/dashboard-analytics', ['pageConfigs' => $pageConfigs]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
