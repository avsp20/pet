<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UrnDisplay;
use Auth;
use App\Http\Requests\UrnDisplayRequest;
use DataTables;

class UrnDisplayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $breadcrumbs = [['link' => "admin/urn-display", 'name' => "URNs Display"], ['name' => "URNs Display List"]];
        if ($request->ajax()) {
            if(Auth::user()->user_role->role_id == 1){
                $urns = UrnDisplay::latest()->get();
            }
            return DataTables::of($urns)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    $date = '-';
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
                ->addColumn('image', function ($row) {
                    $image = '';
                    if($row->image != null){
                        $path = url('/public/images/urns/');
                        $image = '<img class="urn-img" src="' .$path. '/' .$row->image. '">';
                    }
                    return $image;
                })
                ->addColumn('action', function ($row) {
                    $action = '';
                    $action .= '<a href="' . url()->current() . '/' . $row->id . '/edit" class="action-btn" data-toggle="tooltip" data-placement="bottom" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>';
                    if(Auth::user()->user_role->role_id == 1){
                        $action .= '<a onclick="deleteUrnDisplay(' .$row->id. ')" class="action-btn" data-toggle="tooltip" data-placement="bottom" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>';
                    }
                    return $action;
                })
            ->rawColumns(['created_at','action','status','image'])
            ->make(true);
        }
        return view('/content/apps/urn-display/urn-display-list', ['breadcrumbs' => $breadcrumbs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [['link' => "admin/urn-display", 'name' => "URNs"], ['name' => "Create"]];
        return view('/content/apps/urn-display/urn-display-add', ['breadcrumbs' => $breadcrumbs]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UrnDisplayRequest $request)
    {
        $urn_display = new UrnDisplay();
        $urn_display->title = $request->title;
        $urn_display->status = $request->status;
        $urn_display->content = $request->content;
        if ($request->file('image')) {
            $imageName = $request->image->getClientOriginalName();
            $request->image->move(public_path('/images/urns/'), $imageName);
            $urn_display->image = $imageName;
        }
        if($urn_display->save()){
            return redirect()->route('urn-display.index')->with('success', 'URN added successfully.');
        }else{
            return redirect()->route('urn-display.index')->with('error', 'Something went wrong, try again later.');
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
        $urn_display = UrnDisplay::findOrFail($id);
        if (!$urn_display) {
            return redirect()->route('urn-display.index')->with('error', 'URN Not Found.');
        }
        $breadcrumbs = [['link' => "admin/urn-display", 'name' => "URNs"], ['name' => "Edit"]];
        return view('/content/apps/urn-display/urn-display-edit', ['breadcrumbs' => $breadcrumbs, 'urn_display' => $urn_display]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UrnDisplayRequest $request, $id)
    {
        $urn_display = UrnDisplay::findOrFail($id);
        if(!$urn_display){
            return redirect()->route('urn-display.index')->with('error', 'URN Not Found.');
        }
        $urn_display->title = $request->title;
        $urn_display->status = $request->status;
        $urn_display->content = $request->content;
        if ($request->file('image')) {
            $imageName = $request->image->getClientOriginalName();
            $request->image->move(public_path('/images/urns/'), $imageName);
            $urn_display->image = $imageName;
        }
        if($urn_display->save()){
            return redirect()->route('urn-display.index')->with('success', 'URN updated successfully.');
        }else{
            return redirect()->route('urn-display.index')->with('error', 'Something went wrong, try again later.');
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
        $urn_display = UrnDisplay::findOrFail($id);
        if(!$urn_display){
            return response()->json(['data' => 'error', 'error' => 'URN Not Found.', 'status' => 0], 400);
        }
        $urn_display->delete();
        return response()->json(['data' => 'success', 'success' => 'URN Deleted Successfully.', 'status' => 1], 200);
    }
}
