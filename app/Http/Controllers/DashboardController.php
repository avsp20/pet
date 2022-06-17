<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Auth;
use App\Models\User;
use App\Helpers\StaticFunction;
use Hash;
use App\Models\UserPetInfo;

class DashboardController extends Controller
{
  public function dashboardAnalytics(Request $request)
  {
    $pageConfigs = ['pageHeader' => false];
    return view('/content/dashboard/dashboard-analytics', ['pageConfigs' => $pageConfigs]);
  }

  public function customerList(Request $request)
  {
    // $users = UserPetInfo::with('created_user')->with('updated_user')->latest()->get();
    $pet_types = StaticFunction::pet_types();
    $processing_status = StaticFunction::processing_status();
    if ($request->ajax()) {
        if(Auth::user()->user_role->role_id == 2){
          $users = UserPetInfo::whereHas('customer', function($query) {
            $query->where('business_user_id',Auth::user()->id);
          })->with('created_user')->with('updated_user')->latest()->get();
        }elseif(Auth::user()->user_role->role_id == 1 || Auth::user()->user_role->role_id == 4){
          $users = UserPetInfo::with('customer')->with('created_user')->with('updated_user')->latest()->get();
        }
        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('created_at', function ($row) {
              $date = '-';
              $date = isset($row->created_at) ? \Carbon\Carbon::parse($row->created_at)->format('jS F, Y') : '-';
              return $date;
            })
            ->addColumn('customer_name', function ($row) {
              $customer_name = '-';
              if($row->customer != null){
                $customer_name = ucfirst($row->customer->name);
                $customer_name .= ($row->customer->lname != null) ? ' '.ucfirst($row->customer->lname) : "";
              }
              return $customer_name;
            })
            ->addColumn('pet_name', function ($row) {
              $pet_name = '-';
              if(Auth::user()->user_role->role_id != 3){
                $pet_name = '<a href="' .url('/'). '/admin/customers/edit-pet/' .$row->id. '">'.ucfirst($row->pet_name).'</a>';
              }else{
                $pet_name = '<a href="' .url('/'). '/user/customers/edit-pet/' .$row->id. '">'.ucfirst($row->pet_name).'</a>';
              }
              return $pet_name;
            })
            ->addColumn('pet_type', function ($row) use ($pet_types) {
              $pet_type = '';
              if(count($pet_types) > 0){
                  foreach ($pet_types as $key => $type) {
                      if($key == $row->pet_type){
                          $pet_type = $type;
                      }
                  }
              }
              return $pet_type;
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
            ->addColumn('pet_status', function ($row) use ($processing_status) {
              $status = '';
              if(count($processing_status) > 0){
                foreach ($processing_status as $key => $type) {
                  if($key == $row->pet_status){
                    // $status = $type;
                    if($row->pet_status != null){
                      if($row->pet_status == 0){
                          $status = '<span class="badge bg-secondary">' .$type. '</span>';
                      }elseif($row->pet_status == 1){
                          $status = '<span class="badge bg-warning">' .$type. '</span>';
                      }elseif($row->pet_status == 2){
                          $status = '<span class="badge bg-primary">' .$type. '</span>';
                      }elseif($row->pet_status == 3){
                          $status = '<span class="badge bg-info">' .$type. '</span>';
                      }elseif($row->pet_status == 4){
                          $status = '<span class="badge bg-success">' .$type. '</span>';
                      }
                    }
                  }
                }
              }
              return $status;
            })
            ->addColumn('action', function ($row) {
              $action = '';
              $action .= '<a href="' . url('/') . '/admin/customers/edit-pet/' . $row->id . '" class="action-btn" data-toggle="tooltip" data-placement="bottom" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>';
              $action .= '<a onclick="deleteCustomerPet(' .$row->id. ')" class="action-btn" data-toggle="tooltip" data-placement="bottom" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>';
              return $action;
            })
        ->rawColumns(['pet_name','pet_type','action','pet_status'])
        ->make(true);
    }
  }

  public function profile()
  {
    $states = StaticFunction::states();
    $cities = StaticFunction::cities();
    $user = Auth::user();
    $breadcrumbs = [['link' => "admin/dashboard", 'name' => "Home"], ['name' => "Profile"]];
    return view('/content/pages/profile', ['breadcrumbs' => $breadcrumbs, 'states' => $states, 'cities' => $cities, 'user' => $user]);
  }

  public function changePassword()
  {
    $breadcrumbs = [['link' => "admin/dashboard", 'name' => "Home"], ['name' => "Change Password"]];
    return view('/content/pages/change-password', ['breadcrumbs' => $breadcrumbs]);
  }

  public function userChangePassword(Request $request)
  {
    $this->validate($request, [
      'current_password' => 'required',
      'new_password' => 'required|string|min:8|different:current_password',
      'confirm_new_password' => 'required|required_with:new_password|same:new_password'
    ],[
      'current_password' => 'The current password field is required.',
      'confirm_new_password.required' => 'The confirm password field is required.',
      'confirm_new_password.same' => 'The confirm password and new password must match.'
    ]);
    $user = User::where('id',Auth::user()->id)->first();
    if(!$user){
      return redirect()->route('change-password')->with('error', 'User not found!');
    }
    // dd(Hash::check($request->current_password, $user->password));
    if (!Hash::check($request->current_password, $user->password)) {
      return redirect()->route('change-password')->with('error', 'Entered current password is wrong! Please enter your current password.');
    }
    $user->password = Hash::make($request->new_password);
    $user->save();
    return redirect()->route('change-password')->with('success', 'Your current password changed successfully.');
  }
  
  public function editProfile(Request $request)
  {
    $this->validate($request, [
      'name' => 'required',
      'lname' => 'required',
      'email' => 'required',
      'phone' => 'required|numeric'
    ],[
      'name' => 'The first name field is required.',
      'lname' => 'The last name field is required.'
    ]);
    $user = Auth::user();
    $user->name = $request->name;
    $user->lname = $request->lname;
    $user->email = $request->email;
    $user->phone = $request->phone;
    $user->alternate_phone = $request->alternate_phone;
    $user->address = $request->street;
    $user->city = $request->city;
    $user->state = $request->state;
    $user->zipcode = $request->zipcode;
    $imageName = '';
    if ($request->file('profile_image')) {
      $imageName = $request->profile_image->getClientOriginalName();
      $request->profile_image->move(public_path('/images/user_profiles/'), $imageName);
      $user->profile_image = $imageName;
    }
    if($user->save()){
      return redirect()->route('profile')->with('success', 'Your profile updated successfully.');
    }else{
      return redirect()->route('profile')->with('error', 'Something went wrong, try again later.');
    }
  }
}
