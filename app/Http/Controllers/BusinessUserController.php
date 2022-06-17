<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserRole;
use DataTables;
use App\Helpers\StaticFunction;
use App\Http\Requests\BusinessUser;
use Hash;
use Auth;

class BusinessUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $users = User::with('created_user')->with('updated_user')->whereHas('user_role', function ($query) {
                $query->where('role_id', 2);
            })->latest()->get();
        $breadcrumbs = [['link' => "admin/businesses", 'name' => "Business"], ['name' => "Business List"]];
        if ($request->ajax()) {
            $users = User::with('created_user')->with('updated_user')->whereHas('user_role', function ($query) {
                $query->where('role_id', 2);
            })->latest()->get();
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    $date = '';
                    $date = isset($row->created_at) ? \Carbon\Carbon::parse($row->created_at)->format('jS F, Y') : '-';
                    return $date;
                })
                ->addColumn('status', function ($row) {
                    $status = '';
                    if($row->status == 0){
                        $status = '<span class="badge bg-danger">Inactive</span>';
                    }elseif($row->status == 1) {
                        $status = '<span class="badge bg-success">Active</span>';
                    }
                    return $status;
                })
                ->addColumn('name', function ($row) {
                    $name = '';
                    $name = '<a href="' .url('/'). '/admin/businesses/' .$row->id. '/edit">'.ucfirst($row->name) .' '. ucfirst($row->lname).'</a>';
                    return $name;
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
                ->addColumn('action', function ($row) {
                    $action = '';
                    $action .= '<a href="' . url()->current() . '/' . $row->id . '" class="action-btn" data-toggle="tooltip" data-placement="bottom" title="View"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>';
                    $action .= '<a href="' . url()->current() . '/' . $row->id . '/edit" class="action-btn" data-toggle="tooltip" data-placement="bottom" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>';
                    if(Auth::user()->user_role->role_id == 1){
                      $action .= '<a onclick="deleteBusinessUser(' .$row->id. ')" class="action-btn" data-toggle="tooltip" data-placement="bottom" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>';
                    }
                    return $action;
                })
            ->rawColumns(['created_at','action','status','name','created_by','updated_by'])
            ->make(true);
        }
        return view('/content/apps/business-user/business-user-list', ['breadcrumbs' => $breadcrumbs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $states = StaticFunction::states();
        $cities = StaticFunction::cities();
        $breadcrumbs = [['link' => "admin/businesses", 'name' => "Business"], ['name' => "Create"]];
        return view('/content/apps/business-user/business-user-add', ['breadcrumbs' => $breadcrumbs, 'cities' => $cities, 'states' => $states]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BusinessUser $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->lname = $request->lname;
        $user->business_name = $request->business_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->alternate_phone = $request->alternate_phone;
        $user->address = $request->street;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->zipcode = $request->zipcode;
        $user->status = $request->status;
        $user->created_by = Auth::user()->id;
        $imageName = '';
        if ($request->file('profile_image')) {
          $imageName = $request->profile_image->getClientOriginalName();
          $request->profile_image->move(public_path('/images/user_profiles/'), $imageName);
          $user->profile_image = $imageName;
        }
        if($user->save()){
            $role_user = new UserRole();
            $role_user->user_id = $user->id;
            $role_user->role_id = 2;
            $role_user->save();

            return redirect()->route('businesses.index')->with('success', 'Business user added successfully.');
        }else{
            return redirect()->route('businesses.index')->with('error', 'Something went wrong, try again later.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $breadcrumbs = [['link' => "admin/businesses", 'name' => "Business"], ['name' => "View"]];
        if (!$user) {
            return redirect()->route('businesses.index')->with('error', 'Business User Not Found.');
        }
        $states = StaticFunction::states();
        $state = '';
        if(count($states) > 0)
        foreach ($states as $key => $value) {
            if($key == $user->state){
                $state = $value;
            }
        }
        $cities = StaticFunction::cities($user->city);
        $city = '';
        if(count($cities) > 0)
        foreach ($cities as $key => $value) {
            if($key == $user->city){
                $city = $value;
            }
        }
        return view('/content/apps/business-user/business-user-view', ['breadcrumbs' => $breadcrumbs, 'city' => $city, 'state' => $state, 'user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        if (!$user) {
            return redirect()->route('businesses.index')->with('error', 'User Not Found.');
        }
        $states = StaticFunction::states();
        $cities = StaticFunction::cities();
        $breadcrumbs = [['link' => "admin/businesses", 'name' => "Business"], ['name' => "Edit"]];
        return view('/content/apps/business-user/business-user-edit', ['breadcrumbs' => $breadcrumbs, 'cities' => $cities, 'states' => $states, 'user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BusinessUser $request, $id)
    {
        $user = User::findOrFail($id);
        if(!$user){
            return redirect()->route('businesses.index')->with('error', 'User Not Found.');
        }
        $user->name = $request->name;
        $user->lname = $request->lname;
        $user->business_name = $request->business_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->alternate_phone = $request->alternate_phone;
        $user->address = $request->street;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->zipcode = $request->zipcode;
        $user->status = $request->status;
        $user->updated_by = Auth::user()->id;
        $imageName = '';
        if ($request->file('profile_image')) {
          $imageName = $request->profile_image->getClientOriginalName();
          $request->profile_image->move(public_path('/images/user_profiles/'), $imageName);
          $user->profile_image = $imageName;
        }
        if($user->save()){
            return redirect()->route('businesses.index')->with('success', 'Business user updated successfully.');
        }else{
            return redirect()->route('businesses.index')->with('error', 'Something went wrong, try again later.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $user = User::findOrFail($id);
      if(!$user){
          return response()->json(['data' => 'error', 'error' => 'User Not Found.', 'status' => 0], 400);
      }
      $user->delete();
      return response()->json(['data' => 'success', 'success' => 'Busines User Deleted Successfully.', 'status' => 1], 200);
    }
}
