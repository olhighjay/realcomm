<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Session;
use Image;

class VendorController extends Controller
{
    public function dashboard()
    {
        return view('app-pages.vendor.dashboard');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::forget(['vendorSortName', 'vendorStatusName', 'vendorNumberPerPage']);
        $page_title = 'Vendors';
        $crumbs = ['Vendors' ];
         return view('app-pages.admin.vendor.index', compact('page_title', 'crumbs'));
    }
    
    public  function create()
    {
        $page_title = 'Vendors';
        $crumbs = ['Vendors', 'Create New Vendor' ];
        $urls = ['Vendors' =>'/vendors' ];
        return view('app-pages.admin.vendor.create', compact('page_title', 'crumbs', 'urls'));
    }

    public  function store(Request $request)
    {
        Validator::make(request()->all(), [
             'first_name'=> 'required',
             'middle_name'=> 'nullable',
             'last_name'=> 'required',
             'email'=> 'unique'|'required',
             'phone_number'=> 'required',
             'gender'=> 'required',
             'address'=> 'required',
             'state'=> 'required',
             'dob'=> 'nullable',
         ]);
        try {
            $vendor = new User();
            $vendor->first_name = request()['first_name'];
            $vendor->middle_name = request()['middle_name'];
            $vendor->last_name = request()['last_name'];
            $vendor->email = request()['email'];
            $vendor->phone_number = request()['phone_number'];
            $vendor->gender = request()['gender'];
            $vendor->role = 'vendor';
            $vendor->address = request()['address'];
            $vendor->state = request()['state'];
            $vendor->dob = request()['dob'];
            $vendor->password = Hash::make('password');
            $vendor->save();
    
            return response()->json([
                'message' => 'New User created successfully',
                'location' => 'everywhere you go'
            ],201);    
            
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    
    public function show(Request $request, $id)
    {
        $page_title = 'Vendors';
        $crumbs = ['Vendors', 'View Vendor'];
        $urls = ['Vendors' =>'/vendors' ];
        $vendor = User::where('id', $id)->where('role', 'vendor')->where('deactivated', false)->with('businesses', function($q){
            $q->where('deactivated', false);
        })->first();
        // dd($vendor->businesses[0]);
        if($request->edit){
            if(!$vendor){
                return response()->json([
                    'message' => 'Error! Invalid User'
                ], 400);
            }
            return response()->json([
                'vendor'=> $vendor
            ],200);
        }

        if(!$vendor){
            return redirect('/');
        }
         return view('app-pages.admin.vendor.show', compact('page_title', 'crumbs', 'vendor', 'urls'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_title = 'Vendors';
        $crumbs = ['Vendors', 'Edit Vendor'];
        $urls = ['Vendors' =>'/vendors' ];
        $vendor = User::where('id', $id)->where('role', 'vendor')->where('deactivated', false)->first();
        if(!$vendor){
            return redirect('/');
        }
         return view('app-pages.admin.vendor.edit', compact('page_title', 'crumbs', 'vendor', 'id', 'urls'));
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
        $vendor = User::where('id', $id)->where('role', 'vendor')->where('deactivated', false)->first();
        if(!$vendor){
            return redirect('/');
        }
        if(request()['type'] == 'save') {
            Validator::make(request()->all(), [
                'first_name'=> 'required',
                'middle_name'=> 'nullable',
                'last_name'=> 'required',
                'email'=> 'unique'|'required',
                'phone_number'=> 'required',
                'gender'=> 'required',
                'address'=> 'required',
                'state'=> 'required',
                'dob'=> 'nullable',
            ]);

            if($request->profile_picture) {
                $image = $request->profile_picture;
                //get filename with extension
                $filenamewithextension = $image->getClientOriginalName();

                //get filename without extension
                $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

                //get file extension
                $extension = $image->getClientOriginalExtension();

                //filename to store
                $filenametostore = $filename.'_'.uniqid().'.'.$extension;

                //Resize image here
                $thumbnailpath = public_path().'/images/vendor_profile_picture/thumbnail/'.$filenametostore;
            
                $img = Image::make($image->getRealPath(),array(

                    'width' => 100,

                    'height' => 100,

                    'grayscale' => false

                ));
                $img->save($thumbnailpath);

                // $path = $image->move(public_path().'/images/car_reports/', $filenametostore);

                $vendor->profile_picture = $filenametostore;

            }
            
           $vendor->first_name = request()['first_name'];
           $vendor->middle_name = request()['middle_name'];
           $vendor->last_name = request()['last_name'];
           $vendor->email = request()['email'];
           $vendor->phone_number = request()['phone_number'];
           $vendor->gender = request()['gender'];
           $vendor->address = request()['address'];
           $vendor->state = request()['state'];
           $vendor->dob = request()['dob'];
        } elseif(request()['type'] == 'deactivate') {
            $vendor->status = 'inactive';
        } elseif(request()['type'] == 'activate') {
            $vendor->status = 'active';       
        } elseif(request()['type'] == 'delete') {
            $vendor->deactivated = true;
        }
        $vendor->save();

       return response()->json([
           'message' => 'User updated successfully',
           'location' => 'everywhere you go'
       ],200);
    }

    public function massUpdate(Request $request)
    {
        $ids = request()['ids'];
        $vendors = User::whereIn('id', $ids)->where('role', 'vendor')->where('deactivated', false)->get();
        if(count($vendors) < 1){
            return response()->json(['message'=> 'Wrong request'],400);
        }
        
        if(request()['type'] == 'deactivate') {
            foreach ($vendors as $vendor) {
                # code...
                $vendor->status = 'inactive';
                $vendor->save();
            }         
        } elseif(request()['type'] == 'activate') {
            foreach ($vendors as $vendor) {
                $vendor->status = 'active';
                $vendor->save();
            }         
        }elseif(request()['type'] == 'delete') {
            foreach ($vendors as $vendor) {
                $vendor->deactivated = true;
                $vendor->save();
            }
        }

       return response()->json([
           'message' => 'Users updated successfully',
           'location' => 'everywhere you go'
       ],200);
    }


    public  function refreshVendor(Request $request)
    {
        $direction = $request->direction;
        if (isset($request->name)){
            $name = $request->name;
        }
        if (isset($request->search)){
            $search = $request->search;
        }
        if (isset($request->direction)){
            $direction = $request->direction;
        }
        $query = User::query();
        $query2 = $query->where('deactivated', false)->where('role', 'vendor');
            // If there is a search query in the request or in the session, get the result from database
        if (isset($search) &&  $request->search != '') {
            $query2->where(function($query2) use ($search){
                $query2 = $query2->where('first_name', 'LIKE', "%{$search}%")->orWhere('last_name',  'LIKE', "%{$search}%")->orWhere('email',  'LIKE', "%{$search}%")->orWhere('phone_number',  'LIKE', "%{$search}%");
            });
        }

        // If there is a new filter or sorted query in the request, save them in the session and run the query through them
        $filterComponents = ['status', 'role', 'gender', 'state'];
        if (isset($name) && !in_array($name, $filterComponents) && $name != 'no_per_page' && $name != '') {;
            $request->session()->put('vendorSortName', [$name, $direction ]);
        }elseif (isset($name) && $name == 'status') {
            $request->session()->forget('vendorStatusName');
            $request->session()->put('vendorStatusName', [$name, $direction ]);
        }elseif (isset($name) && $name == 'state') {
            $request->session()->forget('vendorStateName');
            $request->session()->put('vendorStateName', [$name, $direction ]);
        }elseif (isset($name) && $name == 'gender') {
            $request->session()->forget('vendorGenderName');
            $request->session()->put('vendorGenderName', [$name, $direction ]);
        }elseif (isset($name) && $name == 'role') {
            $request->session()->forget('vendorRoleName');
            $request->session()->put('vendorRoleName', [$name, $direction ]);
        }elseif (isset($name) && $name == 'no_per_page') {
            $request->session()->put('vendorNumberPerPage', [$name, $direction ]);
        }
        elseif(isset($name) && $name == ''){
            $request->session()->put('vendorStatusName', [$name, $direction ]);
        }
        if(Session::has('vendorNumberPerPage')){
            if(empty($request->search) || $request->search == '') {
                $query2 = User::where('deactivated', false)->where('role', 'vendor');
            } else {
                $query2 = $query2;
            }
        } 

        if(Session::has('vendorSortName')){
            $query2 = $query2->orderBy(Session::get('vendorSortName.0'), Session::get('vendorSortName.1') == 'down' ? 'desc' : 'asc');
        } 
        if(Session::has('vendorStatusName') && Session::get('vendorStatusName.1') != '-'){
            $query2 = $query2->where('status', Session::get('vendorStatusName.1'));
        }  
        if(Session::has('vendorStateName') && Session::get('vendorStateName.1') != '-'){
            $query2 = $query2->where('state', Session::get('vendorStateName.1'));
        }  
        if(Session::has('vendorGenderName') && Session::get('vendorGenderName.1') != '-'){
            $query2 = $query2->where('gender', Session::get('vendorGenderName.1'));
        }  
        if(Session::has('vendorRoleName') && Session::get('vendorRoleName.1') != '-'){
            $query2 = $query2->where('role', Session::get('vendorRoleName.1'));
        } 

        $vendors = $query2->paginate(Session::has('vendorNumberPerPage') ? Session::get('vendorNumberPerPage.1'): 20)->onEachSide(0);
        
        return response()->json(['vendors' => $vendors]); 
    }
 
}
