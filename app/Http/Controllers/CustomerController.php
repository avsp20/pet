<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DataTables;
use App\Helpers\StaticFunction;
use App\Http\Requests\CustomerRequest;
use App\Http\Requests\CustomerPetRequest;
use App\Models\UserRole;
use App\Models\UrnDisplay;
use App\Models\UserPetInfo;
use DB;
use Auth;
use PDF;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewCertificate()
    {
        $id = 5;
        $data = array();
        $pet_info = User::with('pet_info')->where('id',$id)->first();
        if(!$pet_info){
            return redirect()->route('customers.index')->with('error', 'Customer Not Found.');
        }
        $pet_types = StaticFunction::pet_types();
        if(count($pet_types) > 0){
            foreach ($pet_types as $key => $value) {
                if($pet_info->pet_info != null){
                    if($key == $pet_info->pet_info->pet_type){
                        $data['pet_type'] = $value;
                    }
                }
            }
        }
        $data['order_no'] = ($pet_info->pet_info != null) ? $pet_info->pet_info->id : "";
        $data['pet_name'] = ($pet_info->pet_info != null) ? $pet_info->pet_info->pet_name : "";
        $data['name'] = $pet_info->name . ' '.$pet_info->lname;
        $data['date_cremated'] = ($pet_info->pet_info != null && $pet_info->pet_info->date_cremated != null) ? \Carbon\Carbon::parse($pet_info->pet_info->date_cremated)->format('jS \o\f F, Y') : "";
        $data['age'] = ($pet_info->pet_info != null) ? $pet_info->pet_info->age : "";
        $data['tag'] = ($pet_info->pet_info != null) ? $pet_info->pet_info->tag : "";
        $data['date_of_birth'] = ($pet_info->pet_info != null && $pet_info->pet_info->date_of_birth != null) ? \Carbon\Carbon::parse($pet_info->pet_info->date_of_birth)->format('d/m/Y') : "";
        return view('content.apps.user.certificate',['data' => $data]);
    }

    public function index(Request $request)
    {
        // User List Page
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
        $states = StaticFunction::states();
        $cities = StaticFunction::cities();
        $processing_status = StaticFunction::processing_status();
        // $customer_status = StaticFunction::customer_status();
        $payment_status = StaticFunction::payment_status();
        $pet_types = StaticFunction::pet_types();
        $gender = StaticFunction::gender();
        $processing_checklist = StaticFunction::processing_checklist();
        $cremation_type = StaticFunction::cremation_type();
        $frame_color_type = StaticFunction::frame_color_type();
        $urn_details = StaticFunction::urn_details();
        $pet_additional_items = StaticFunction::pet_additional_items();
        $urn_display = UrnDisplay::where('status',1)->get();
        if(Auth::user()->user_role->role_id == 2){
            $locations = User::select('id','business_name')->where('id',Auth::user()->id)->where('status',1)->with('pet_info')->whereHas('user_role', function ($query) {
                        $query->where('role_id', 2);
                    })->get();
        }elseif(Auth::user()->user_role->role_id == 1 || Auth::user()->user_role->role_id == 4){
            $locations = User::select('id','business_name')->where('status',1)->with('pet_info')->whereHas('user_role', function ($query) {
                        $query->where('role_id', 2);
                    })->get();
        }
        $breadcrumbs = [['link' => "admin/customers", 'name' => "Customer"], ['name' => "Create"]];
        return view('/content/apps/user/user-add', [
            'breadcrumbs' => $breadcrumbs,
            'states' => $states,
            'cities' => $cities,
            'processing_status' => $processing_status,
            // 'customer_status' => $customer_status,
            'payment_status' => $payment_status,
            'pet_types' => $pet_types,
            'gender' => $gender,
            'processing_checklist' => $processing_checklist,
            'cremation_type' => $cremation_type,
            'frame_color_type' => $frame_color_type,
            'urn_details' => $urn_details,
            'pet_additional_items' => $pet_additional_items,
            'locations' => $locations,
            'urn_display' => $urn_display
        ]);
    }

    public function customerPetDetails(Request $request, $id)
    {
        $users = UserPetInfo::with('created_user')->with('updated_user')->where('user_id',$id)/*->where('pet_status','!=',3)*/->latest()->get();
        $pet_types = StaticFunction::pet_types();
        $processing_status = StaticFunction::processing_status();
        if ($request->ajax()) {
            $users = UserPetInfo::with('created_user')->with('updated_user')->where('user_id',$id)/*->where('pet_status','!=',3)*/->latest()->get();
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    $date = '-';
                    $date = isset($row->created_at) ? \Carbon\Carbon::parse($row->created_at)->format('jS F, Y') : '-';
                    return $date;
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
                ->addColumn('action', function ($row) {
                    $action = '';
                    $action .= '<a href="' . url('/') . '/admin/customers/edit-pet/' . $row->id . '" class="action-btn" data-toggle="tooltip" data-placement="bottom" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>';
                    $action .= '<a onclick="deleteCustomerPet(' .$row->id. ')" class="action-btn" data-toggle="tooltip" data-placement="bottom" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>';
                    return $action;
                })
            ->rawColumns(['pet_name','pet_type','action','created_by','updated_by'])
            ->make(true);
        }
    }

    public function petProcessingChecklist(Request $request)
    {
        $breadcrumbs = [['link' => "admin/pet-processing", 'name' => "Pet Processing"], ['name' => "Pet Processing List"]];
        $pet_types = StaticFunction::pet_types();
        $processing_status = StaticFunction::processing_status();
        if ($request->ajax()) {
            $users = UserPetInfo::where('pet_status','!=',3)->latest()->get();
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('date_cremated', function ($row) {
                    $date = '-';
                    $date = isset($row->date_cremated) ? \Carbon\Carbon::parse($row->date_cremated)->format('jS F, Y') : '-';
                    return $date;
                })
                ->addColumn('created_at', function ($row) {
                    $date = '-';
                    $date = isset($row->created_at) ? \Carbon\Carbon::parse($row->created_at)->format('jS F, Y') : '-';
                    return $date;
                })
                ->addColumn('pet_name', function ($row) {
                    $pet_name = '-';
                    $pet_name = '<a href="' .url('/'). '/admin/pet-processing/' .$row->id. '">'.ucfirst($row->pet_name).'</a>';
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
                ->addColumn('pet_status', function ($row) use ($processing_status) {
                    $status = '';
                    if(count($processing_status) > 0){
                        foreach ($processing_status as $key => $type) {
                            if($key == $row->pet_status){
                                $status = $type;
                                if($row->pet_status == 0){
                                    $status = '<span class="badge bg-secondary">' .$type. '</span>';
                                }elseif($row->pet_status == 1){
                                    $status = '<span class="badge bg-warning">' .$type. '</span>';
                                }elseif($row->pet_status == 2){
                                    $status = '<span class="badge bg-primary">' .$type. '</span>';
                                }elseif($row->pet_status == 3){
                                    $status = '<span class="badge bg-info">' .$type. '</span>';
                                }else{
                                    $status = '<span class="badge bg-success">' .$type. '</span>';
                                }
                            }
                        }
                    }
                    return $status;
                })
                ->addColumn('action', function ($row) {
                    $action = '';
                    $action .= '<a href="' . url('/') . '/admin/pet-processing/' . $row->id . '" class="btn btn-primary waves-effect waves-float waves-light btn-sm">Edit/Process</a>';
                    return $action;
                })
            ->rawColumns(['date_cremated','pet_name','pet_type','action','pet_status'])
            ->make(true);
        }
        return view('/content/apps/user/user-pet-processing-checklist', ['breadcrumbs' => $breadcrumbs]);
    }

    public function businessLocations()
    {
        $locations = array();
        $loc = '';
        $business_locations = User::select('id','address','city','state','zipcode')->with(['user_role' => function($query){
            $query->where('role_id',2);
        }])->get();
        $states = StaticFunction::states();
        $cities = StaticFunction::cities();
        $i = 0;
        if(count($business_locations) > 0){
            foreach ($business_locations as $key => $value) {
                $loc = $value->address;
                if(count($cities) > 0){
                    foreach ($cities as $key => $ct) {
                        if($value->city != null){
                            if($key == $value->city){
                                $loc .= ', '.$ct;
                            }
                        }
                    }
                }
                if(count($states) > 0){
                    foreach ($states as $key => $st) {
                        if($value->state != null){
                            if($key == $value->state){
                                $loc .= ', '.$st;
                            }
                        }
                    }
                }
                $loc .= ($value->zipcode != null) ? ', '.$value->zipcode : "";
                if($value->user_role != null){
                    $locations[$i]['id'] = $value->id;
                    $locations[$i]['location'] = $loc;
                }
                $i++;
            }
        }
        $locations = array_values(array_filter($locations));
        return $locations;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        $processing_checklist = array();
        DB::beginTransaction();
        $user = new User();
        $user->name = $request->fname;
        $user->lname = $request->lname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->business_user_id = Auth::user()->id;
        $user->alternate_phone = $request->alternate_phone;
        $user->address = $request->address;
        $user->state = $request->state;
        $user->city = $request->city;
        $user->zipcode = $request->zipcode;
        $user->status = 1;
        $user->password = '';
        $user->created_by = Auth::user()->id;
        $imageName = '';
        if ($request->file('profile_image')) {
            $imageName = $request->profile_image->getClientOriginalName();
            $request->profile_image->move(public_path('/images/user_profiles/'), $imageName);
            $user->profile_image = $imageName;
        }
        if($user->save()){
            $user_role = new UserRole();
            $user_role->user_id = $user->id;
            $user_role->role_id = 3;
            $user_role->save();

            if($request->processing_checklist != null){
                // $processing_checklist = implode(", ", $request->processing_checklist);
                foreach($request->processing_checklist as $key => $checklist){
                    $processing_checklist[]['id'] = $checklist;
                    $processing_checklist[$key]['date'] = date('Y-m-d');
                    $processing_checklist[$key]['status'] = 1;
                }
                $processing_checklist = json_encode($processing_checklist);
            }
            $urn_details = '';
            if($request->urn_details != null){
                $urn_details = implode(", ", $request->urn_details);
            }
            $additional_items = '';
            if($request->additional_items != null){
                $additional_items = implode(", ", $request->additional_items);
            }
            // User pet information
            $pet_info = new UserPetInfo();
            $pet_info->user_id = $user->id;
            $pet_info->location = $request->location;
            $pet_info->invoice_no = $request->invoice_no;
            $pet_info->tag = $request->tag;
            $pet_info->pet_name = $request->pet_name;
            $pet_info->pet_type = $request->pet_type;
            $pet_info->pet_status = $request->pet_status;
            // $pet_info->customer_status = $request->customer_status;
            $pet_info->payment_status = $request->payment_status;
            $pet_info->gender = $request->gender;
            $pet_info->age = $request->age;
            $pet_info->weight = $request->weight;
            $pet_info->date_of_birth = $request->date_of_birth;
            $pet_info->breed_and_color = $request->breed_and_color;
            $pet_info->additional_pet_info = $request->additional_pet_info;
            $pet_info->date_received = $request->date_received;
            $pet_info->date_cremated = $request->date_cremated;
            $pet_info->date_delivered = $request->date_delivered;
            $pet_info->processing_checklist = $processing_checklist;
            $pet_info->cremation_type = $request->cremation_type;
            $pet_info->frame_color = $request->frame_color;
            $pet_info->urn_details = $urn_details;
            $pet_info->special_info = $request->special_info;
            $pet_info->additional_items = $additional_items;
            $pet_info->save();

            DB::commit();
            return redirect()->route('customers.index')->with('success', 'Customer added successfully.');
        }else{
            DB::rollback();
            return redirect()->route('customers.index')->with('error', 'Something went wrong, try again later.');
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
        $user = User::with('pet_info')->findOrFail($id);
        if (!$user) {
            return redirect()->route('customers.index')->with('error', 'Customer Not Found.');
        }
        $states = StaticFunction::states();
        $cities = StaticFunction::cities();
        $processing_status = StaticFunction::processing_status();
        $payment_status = StaticFunction::payment_status();
        // $customer_status = StaticFunction::customer_status();
        $pet_types = StaticFunction::pet_types();
        $gender = StaticFunction::gender();
        $processing_checklist = StaticFunction::processing_checklist();
        $cremation_type = StaticFunction::cremation_type();
        $frame_color_type = StaticFunction::frame_color_type();
        $urn_details = StaticFunction::urn_details();
        $pet_additional_items = StaticFunction::pet_additional_items();
        $urn_display = UrnDisplay::where('status',1)->get();
        $locations = array();
        $breadcrumbs = [['link' => "admin/customers", 'name' => "Customer"], ['name' => "Edit"]];
        if(Auth::user()->user_role->role_id == 2){
            $locations = User::select('id','business_name')->where('id',Auth::user()->id)->where('status',1)->with('pet_info')->whereHas('user_role', function ($query) {
                        $query->where('role_id', 2);
                    })->get();
        }elseif(Auth::user()->user_role->role_id == 1 || Auth::user()->user_role->role_id == 4){
            $locations = User::select('id','business_name')->where('status',1)->with('pet_info')->whereHas('user_role', function ($query) {
                        $query->where('role_id', 2);
                    })->get();
        }else{
            $breadcrumbs = [['link' => "user/customers/" .Auth::user()->id. "/edit", 'name' => "Customer"], ['name' => "Edit"]];
        }
        return view('/content/apps/user/user-edit', [
            'breadcrumbs' => $breadcrumbs,
            'states' => $states,
            'cities' => $cities,
            'processing_status' => $processing_status,
            // 'customer_status' => $customer_status,
            'payment_status' => $payment_status,
            'pet_types' => $pet_types,
            'gender' => $gender,
            'processing_checklist' => $processing_checklist,
            'cremation_type' => $cremation_type,
            'frame_color_type' => $frame_color_type,
            'urn_details' => $urn_details,
            'pet_additional_items' => $pet_additional_items,
            'locations' => $locations,
            'user' => $user,
            'urn_display' => $urn_display
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, $id)
    {
        $user = User::findOrFail($id);
        if(!$user){
            return redirect()->route('customers.index')->with('error', 'User Not Found.');
        }
        $user->name = $request->fname;
        $user->lname = $request->lname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->alternate_phone = $request->alternate_phone;
        $user->address = $request->address;
        $user->state = $request->state;
        $user->city = $request->city;
        $user->zipcode = $request->zipcode;
        $user->password = '';
        $user->updated_by = Auth::user()->id;
        $imageName = '';
        if ($request->file('profile_image')) {
            $imageName = $request->profile_image->getClientOriginalName();
            $request->profile_image->move(public_path('/images/user_profiles/'), $imageName);
            $user->profile_image = $imageName;
        }
        if($user->save()){
            if(Auth::user()->user_role->role_id == 3){
                return redirect()->route('customers.front-edit',[Auth::user()->id])->with('success', 'Your details updated successfully.');
            }else{
                return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
            }
        }else{
            return redirect()->route('customers.index')->with('error', 'Something went wrong, try again later.');
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
            return response()->json(['data' => 'error', 'error' => 'Customer Not Found.', 'status' => 0], 400);
        }
        $user->delete();
        return response()->json(['data' => 'success', 'success' => 'Customer Deleted Successfully.', 'status' => 1], 200);
    }

    public function editPetProcessing($id)
    {
        if(!$id){
            return redirect()->route('customers.index')->with('error', 'Something went wrong, try again later.');
        }
        $pet_processing = UserPetInfo::with('customer')->findOrFail($id);
        if(!$pet_processing){
            return redirect()->route('customers.index')->with('error', 'Customer Not Found.');
        }
        $processing_checklist = StaticFunction::processing_checklist();
        $pet_processing_status = StaticFunction::petProcessingStatus();
        $processing_status = StaticFunction::processing_status();

        $process_list = array();
        if(!empty($pet_processing->processing_checklist)){
            $process_list = json_decode($pet_processing->processing_checklist);
        }
        $breadcrumbs = [['link' => "admin/pet-processing", 'name' => "Pet Processing"], ['name' => "Processing Checklist"]];
        return view('/content/apps/user/user-pet-processing-checklist-form', [
            'breadcrumbs' => $breadcrumbs,
            'processing_checklist' => $processing_checklist,
            'process_list' => $process_list,
            'pet_processing' => $pet_processing,
            'pet_processing_status' => $pet_processing_status,
            'processing_status' => $processing_status
        ]);
    }

    public function updatePetProcessing(Request $request, $id)
    {
        $processing_checklist = array();
        $list_ids = array();
        $new_arr = array();
        $process_arr = array();
        $pet_processing = UserPetInfo::findOrFail($id);
        if(!$pet_processing){
            return response()->json(['data' => null, 'error' => 'Customer Not Found.', 'status' => 0], 400);
        }
        if($request->processing_checklist != null){
            $db_checklist = json_decode($pet_processing->processing_checklist, true);
            if(!empty($db_checklist)){
                foreach ($db_checklist as $key => $value) {
                    $list_ids[] = $value['id'];
                }
            }
            if($pet_processing->processing_checklist != null){
                if(!empty(array_diff($request->processing_checklist, $list_ids))){
                    $diff_arr = array_values(array_diff($request->processing_checklist, $list_ids));
                    foreach ($diff_arr as $keys => $value) {
                        $new_arr[]['id'] = $value;
                        $new_arr[$keys]['date'] = date('Y-m-d');
                        $new_arr[$keys]['status'] = 1;
                    }
                    $processing_checklist = array_merge($db_checklist, $new_arr);
                }else{
                    $diff_arr = array_intersect($request->processing_checklist,$list_ids);
                    if(count($diff_arr) > 0){
                        foreach ($diff_arr as $keys => $value) {
                            $key = array_search($value, array_column($db_checklist, 'id'));
                            $process_arr[]['id'] = $db_checklist[$key]['id'];
                            $process_arr[$keys]['date'] = $db_checklist[$key]['date'];
                            $process_arr[$keys]['status'] = $db_checklist[$key]['status']; 
                        }
                    }
                    $processing_checklist = $process_arr;
                }
            }else{
                foreach($request->processing_checklist as $key => $checklist){
                    $processing_checklist[]['id'] = $checklist;
                    $processing_checklist[$key]['date'] = date('Y-m-d');
                    $processing_checklist[$key]['status'] = 1;
                }
                $processing_checklist = json_encode($processing_checklist);
            }
        }
        $pet_processing->processing_checklist = $processing_checklist;
        $pet_processing->pet_status = $request->processing_status;
        $pet_processing->save();

        $processing_checklist = StaticFunction::processing_checklist();
        $pet_processing_status = StaticFunction::petProcessingStatus();
        $processing_status = StaticFunction::processing_status();
        // return response()->json(['data' => $pet_processing, 'success' => 'Pet Processing updated successfully.', 'status' => 1], 200);
        $process_list = array();
        if(!empty($pet_processing->processing_checklist)){
            $process_list = $pet_processing->processing_checklist;
        }
        $returnHTML = view('/content/apps/user/user-pet-processing-checklist-form-content', [
            'processing_checklist' => $processing_checklist,
            'pet_processing' => $pet_processing,
            'process_list' => $process_list,
            'pet_processing_status' => $pet_processing_status,
            'processing_status' => $processing_status
        ])->render();
        return response()->json(['data' => $returnHTML, 'success' => 'Pet Processing updated successfully.', 'status' => 1], 200);
    }

    public function generatePetCremationCertificate($id)
    {
        $data = array();
        if(!$id){
            return redirect()->route('customers.index')->with('error', 'Something went wrong, try again later.');
        }
        // $pet_info = User::with('pet_info')->where('id',$id)->first();
        $pet_info = UserPetInfo::with('customer')->where('id',$id)->first();
        if(!$pet_info){
            return redirect()->route('customers.index')->with('error', 'Customer Not Found.');
        }
        $pet_types = StaticFunction::pet_types();
        if(count($pet_types) > 0){
            foreach ($pet_types as $key => $value) {
                if($key == $pet_info->pet_type){
                    $data['pet_type'] = $value;
                }
                // if($pet_info->pet_info != null){
                // }                                                                          
            }
        }
        $data['order_no'] = ($pet_info != null) ? $pet_info->id : "";
        $data['pet_name'] = ($pet_info != null) ? ucfirst($pet_info->pet_name) : "";
        $data['name'] = ($pet_info->customer != null) ? ucfirst($pet_info->customer->name) . ' '.ucfirst($pet_info->customer->lname) : "";
        $data['date_cremated'] = ($pet_info != null && $pet_info->date_cremated != null) ? \Carbon\Carbon::parse($pet_info->date_cremated)->format('jS \o\f F, Y') : "";
        $data['age'] = ($pet_info != null) ? $pet_info->age : "";
        $data['tag'] = ($pet_info != null) ? $pet_info->tag : "";
        $data['date_of_birth'] = ($pet_info != null && $pet_info->date_of_birth != null) ? \Carbon\Carbon::parse($pet_info->date_of_birth)->format('d/m/Y') : "";
        $pdf = PDF::loadView('content.apps.user.certificate',['data' => $data])->setPaper('a4', 'landscape');
        return $pdf->download('certificate.pdf');
    }

    public function editCustomerPetDetails($id)
    {
        $pet_info = UserPetInfo::findOrFail($id);
        if (!$pet_info) {
            return redirect()->back()->with('error', 'Pet Not Found.');
        }
        $states = StaticFunction::states();
        $cities = StaticFunction::cities();
        $processing_status = StaticFunction::processing_status();
        $payment_status = StaticFunction::payment_status();
        // $customer_status = StaticFunction::customer_status();
        $pet_types = StaticFunction::pet_types();
        $gender = StaticFunction::gender();
        $processing_checklist = StaticFunction::processing_checklist();
        $cremation_type = StaticFunction::cremation_type();
        $frame_color_type = StaticFunction::frame_color_type();
        $urn_details = StaticFunction::urn_details();
        $pet_additional_items = StaticFunction::pet_additional_items();
        $urn_display = UrnDisplay::where('status',1)->get();
        $locations = array();
        $breadcrumbs = [['link' => "admin/customers/" .$pet_info->user_id. "/edit", 'name' => "Customer"], ['name' => "Edit"]];
        if(Auth::user()->user_role->role_id == 2){
            $locations = User::select('id','business_name')->with('created_user')->with('updated_user')->where('id',Auth::user()->id)->where('status',1)->with('pet_info')->whereHas('user_role', function ($query) {
                        $query->where('role_id', 2);
                    })->get();
        }elseif(Auth::user()->user_role->role_id == 1 || Auth::user()->user_role->role_id == 4){
            $locations = User::select('id','business_name')->with('created_user')->with('updated_user')->where('status',1)->with('pet_info')->whereHas('user_role', function ($query) {
                        $query->where('role_id', 2);
                    })->get();
        }else{
            $breadcrumbs = [['link' => "user/customers/" .$pet_info->user_id. "/edit", 'name' => "Customer"], ['name' => "Edit"]];
        }
        return view('/content/apps/user/user-pet-edit', [
            'breadcrumbs' => $breadcrumbs,
            'states' => $states,
            'cities' => $cities,
            'processing_status' => $processing_status,
            'payment_status' => $payment_status,
            'pet_types' => $pet_types,
            'gender' => $gender,
            'processing_checklist' => $processing_checklist,
            'cremation_type' => $cremation_type,
            'frame_color_type' => $frame_color_type,
            'urn_details' => $urn_details,
            'pet_additional_items' => $pet_additional_items,
            'locations' => $locations,
            'pet_info' => $pet_info,
            'urn_display' => $urn_display
        ]);
    }

    public function createCustomerPets($id)
    {
        $states = StaticFunction::states();
        $cities = StaticFunction::cities();
        $processing_status = StaticFunction::processing_status();
        // $customer_status = StaticFunction::customer_status();
        $payment_status = StaticFunction::payment_status();
        $pet_types = StaticFunction::pet_types();
        $gender = StaticFunction::gender();
        $processing_checklist = StaticFunction::processing_checklist();
        $cremation_type = StaticFunction::cremation_type();
        $frame_color_type = StaticFunction::frame_color_type();
        $urn_details = StaticFunction::urn_details();
        $pet_additional_items = StaticFunction::pet_additional_items();
        $urn_display = UrnDisplay::where('status',1)->get();
        $locations = array();
        $breadcrumbs = [['link' => "admin/customers/" .$id. "/edit", 'name' => "Customer"], ['name' => "Create"]];
        if(Auth::user()->user_role->role_id == 2){
            $locations = User::select('id','business_name')->with('created_user')->with('updated_user')->where('id',Auth::user()->id)->where('status',1)->with('pet_info')->whereHas('user_role', function ($query) {
                        $query->where('role_id', 2);
                    })->get();
        }elseif(Auth::user()->user_role->role_id == 1 || Auth::user()->user_role->role_id == 4){
            $locations = User::select('id','business_name')->with('created_user')->with('updated_user')->where('status',1)->with('pet_info')->whereHas('user_role', function ($query) {
                        $query->where('role_id', 2);
                    })->get();
        }else{
            $breadcrumbs = [['link' => "user/customers/" .$id. "/edit", 'name' => "Customer"], ['name' => "Create"]];
        }
        return view('/content/apps/user/user-pet-add', [
            'breadcrumbs' => $breadcrumbs,
            'states' => $states,
            'cities' => $cities,
            'processing_status' => $processing_status,
            // 'customer_status' => $customer_status,
            'payment_status' => $payment_status,
            'pet_types' => $pet_types,
            'gender' => $gender,
            'processing_checklist' => $processing_checklist,
            'cremation_type' => $cremation_type,
            'frame_color_type' => $frame_color_type,
            'urn_details' => $urn_details,
            'pet_additional_items' => $pet_additional_items,
            'locations' => $locations,
            'urn_display' => $urn_display
        ]);
    }

    public function storeCustomerPets(CustomerPetRequest $request, $id)
    {
        $processing_checklist = array();
        if(!$id){
            return redirect()->route('customers.edit',[$id])->with('error', 'User Not Found.');
        }
        
        $urn_details = '';
        $additional_items = '';
        $pet_info = new UserPetInfo();
        $pet_info->user_id = $id;
        $pet_info->location = $request->location;
        $pet_info->invoice_no = $request->invoice_no;
        $pet_info->tag = $request->tag;
        $pet_info->pet_name = $request->pet_name;
        $pet_info->pet_type = $request->pet_type;
        $pet_info->pet_status = $request->pet_status;
        // $pet_info->customer_status = $request->customer_status;
        $pet_info->payment_status = $request->payment_status;
        $pet_info->gender = $request->gender;
        $pet_info->age = $request->age;
        $pet_info->weight = $request->weight;
        $pet_info->date_of_birth = $request->date_of_birth;
        $pet_info->breed_and_color = $request->breed_and_color;
        $pet_info->additional_pet_info = $request->additional_pet_info;
        $pet_info->date_received = $request->date_received;
        $pet_info->date_cremated = $request->date_cremated;
        $pet_info->date_delivered = $request->date_delivered;
        if($request->processing_checklist != null){
            if(count($request->processing_checklist) > 0){
                foreach($request->processing_checklist as $key => $checklist){
                    $processing_checklist[]['id'] = $checklist;
                    $processing_checklist[$key]['date'] = date('Y-m-d');
                    $processing_checklist[$key]['status'] = 1;
                }
                $processing_checklist = json_encode($processing_checklist);
                $pet_info->processing_checklist = $processing_checklist;
            }
        }
        $pet_info->cremation_type = $request->cremation_type;
        $pet_info->frame_color = $request->frame_color;
        if($request->urn_details != null){
            if(count($request->urn_details) > 0){
                $urn_details = implode(", ", $request->urn_details);
                $pet_info->urn_details = $urn_details;
            }
        }
        $pet_info->special_info = $request->special_info;
        if($request->additional_items != null){ 
            if(count($request->additional_items) > 0){
                $additional_items = implode(", ", $request->additional_items);
                $pet_info->additional_items = $additional_items;
            }
        }
        $pet_info->created_by = Auth::user()->id;
        $pet_info->save();
        return redirect()->route('customers.edit',[$pet_info->user_id])->with('success', 'Pet info updated successfully.');
    }

    public function updateCustomerPets(CustomerPetRequest $request, $id)
    {
        $processing_checklist = array();
        $pet_info = UserPetInfo::findOrFail($id);
        if(!$pet_info){
            return redirect()->route('customers.index')->with('error', 'User Not Found.');
        }
        if($request->processing_checklist){
            if(count($request->processing_checklist) > 0){
                foreach($request->processing_checklist as $key => $checklist){
                    $processing_checklist[]['id'] = $checklist;
                    $processing_checklist[$key]['date'] = date('Y-m-d');
                    $processing_checklist[$key]['status'] = 1;
                }
                $processing_checklist = json_encode($processing_checklist);
            }
        }
        $urn_details = '';
        if($request->urn_details){
            if(count($request->urn_details) > 0){
                $urn_details = implode(", ", $request->urn_details);
            }
        }
        $additional_items = '';
        if($request->additional_items){ 
            if(count($request->additional_items) > 0){
                $additional_items = implode(", ", $request->additional_items);
            }
        }
        $pet_info->location = $request->location;
        $pet_info->invoice_no = $request->invoice_no;
        $pet_info->tag = $request->tag;
        $pet_info->pet_name = $request->pet_name;
        $pet_info->pet_type = $request->pet_type;
        $pet_info->pet_status = $request->pet_status;
        $pet_info->payment_status = $request->payment_status;
        $pet_info->gender = $request->gender;
        $pet_info->age = $request->age;
        $pet_info->weight = $request->weight;
        $pet_info->date_of_birth = $request->date_of_birth;
        $pet_info->breed_and_color = $request->breed_and_color;
        $pet_info->additional_pet_info = $request->additional_pet_info;
        $pet_info->date_received = $request->date_received;
        $pet_info->date_cremated = $request->date_cremated;
        $pet_info->date_delivered = $request->date_delivered;
        $pet_info->processing_checklist = $processing_checklist;
        $pet_info->cremation_type = $request->cremation_type;
        $pet_info->frame_color = $request->frame_color;
        $pet_info->urn_details = $urn_details;
        $pet_info->special_info = $request->special_info;
        $pet_info->additional_items = $additional_items;
        $pet_info->updated_by = Auth::user()->id;
        $pet_info->save();
        return redirect()->route('customers.edit',[$pet_info->user_id])->with('success', 'Pet info updated successfully.');
    }

    public function deleteCustomerPet($id)
    {
        $pet_info = UserPetInfo::findOrFail($id);
        if(!$pet_info){
            return response()->json(['data' => 'error', 'error' => 'Pet Not Found.', 'status' => 0], 400);
        }
        $pet_info->delete();
        return response()->json(['data' => 'success', 'success' => 'Pet Deleted Successfully.', 'status' => 1], 200);
    }
}
