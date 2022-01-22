<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Session;
use Image;

class BuyerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function dashboard()
    {
        return view('app-pages.customer.dashboard');
    }

    public function index()
    {
        Session::forget(['buyerSortName', 'buyerStatusName', 'buyerGenderName', 'buyerRoleName', 'buyerStateName', 'buyerNumberPerPage']);
        $page_title = 'Buyers';
        $crumbs = ['Buyers' ];
         return view('app-pages.admin.buyer.index', compact('page_title', 'crumbs'));
    }

    public  function create()
    {
        $page_title = 'Buyers';
        $crumbs = ['Buyers', 'Create New Buyer' ];
        $urls = ['Buyers' =>'/buyers' ];
        return view('app-pages.admin.buyer.create', compact('page_title', 'crumbs', 'urls'));
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
             'role'=> 'required',
             'state'=> 'required',
             'dob'=> 'nullable',
         ]);
        try {
            $buyer = new User();
            $buyer->first_name = request()['first_name'];
            $buyer->middle_name = request()['middle_name'];
            $buyer->last_name = request()['last_name'];
            $buyer->email = request()['email'];
            $buyer->phone_number = request()['phone_number'];
            $buyer->gender = request()['gender'];
            $buyer->role = request()['role'];
            $buyer->address = request()['address'];
            $buyer->state = request()['state'];
            $buyer->dob = request()['dob'];
            $buyer->password = Hash::make('password');
            $buyer->save();
    
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
        $page_title = 'Buyers';
        $crumbs = ['Buyers', 'View Buyer'];
        $urls = ['Buyers' =>'/buyers' ];
        $buyer = User::where('id', $id)->where('role', '!=', 'vendor')->where('deactivated', false)->first();
        
        if($request->edit){
            if(!$buyer){
                return response()->json([
                    'message' => 'Error! Invalid User'
                ], 400);
            }
            return response()->json([
                'buyer'=> $buyer
            ],200);
        }

        if(!$buyer){
            return redirect('/');
        }
         return view('app-pages.admin.buyer.show', compact('page_title', 'crumbs', 'buyer', 'urls'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_title = 'Buyers';
        $crumbs = ['Buyers', 'Edit Buyer'];
        $urls = ['Buyers' =>'/buyers' ];
        $buyer = User::where('id', $id)->where('role', '!=', 'vendor')->where('deactivated', false)->first();
        if(!$buyer){
            return redirect('/');
        }
         return view('app-pages.admin.buyer.edit', compact('page_title', 'crumbs', 'buyer', 'id', 'urls'));
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
        $buyer = User::where('id', $id)->where('role', '!=', 'vendor')->where('deactivated', false)->first();
        if(!$buyer){
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
                'role'=> 'required',
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
                $thumbnailpath = public_path().'/images/buyer_profile_picture/thumbnail/'.$filenametostore;
            
                $img = Image::make($image->getRealPath(),array(

                    'width' => 100,

                    'height' => 100,

                    'grayscale' => false

                ));
                $img->save($thumbnailpath);

                // $path = $image->move(public_path().'/images/car_reports/', $filenametostore);

                $buyer->profile_picture = $filenametostore;

            }
            
           $buyer->first_name = request()['first_name'];
           $buyer->middle_name = request()['middle_name'];
           $buyer->last_name = request()['last_name'];
           $buyer->email = request()['email'];
           $buyer->phone_number = request()['phone_number'];
           $buyer->role = request()['role'];
           $buyer->gender = request()['gender'];
           $buyer->address = request()['address'];
           $buyer->state = request()['state'];
           $buyer->dob = request()['dob'];
        } elseif(request()['type'] == 'deactivate') {
            $buyer->status = 'inactive';
        } elseif(request()['type'] == 'activate') {
            $buyer->status = 'active';       
        } elseif(request()['type'] == 'delete') {
            $buyer->deactivated = true;
        }
        $buyer->save();

       return response()->json([
           'message' => 'User updated successfully',
           'location' => 'everywhere you go'
       ],200);
    }

    public function massUpdate(Request $request)
    {
        $ids = request()['ids'];
        $buyers = User::whereIn('id', $ids)->where('role', '!=', 'vendor')->where('deactivated', false)->get();
        if(count($buyers) < 1){
            return response()->json(['message'=> 'Wrong request'],400);
        }
        
        if(request()['type'] == 'deactivate') {
            foreach ($buyers as $buyer) {
                # code...
                $buyer->status = 'inactive';
                $buyer->save();
            }         
        } elseif(request()['type'] == 'activate') {
            foreach ($buyers as $buyer) {
                $buyer->status = 'active';
                $buyer->save();
            }         
        }elseif(request()['type'] == 'delete') {
            foreach ($buyers as $buyer) {
                $buyer->deactivated = true;
                $buyer->save();
            }
        }

       return response()->json([
           'message' => 'Users updated successfully',
           'location' => 'everywhere you go'
       ],200);
    }


    public  function refreshBuyer(Request $request)
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
        $query2 = $query->where('deactivated', false)->where('role', '!=', 'vendor');
            // If there is a search query in the request or in the session, get the result from database
        if (isset($search) &&  $request->search != '') {
            $query2->where(function($query2) use ($search){
                $query2 = $query2->where('first_name', 'LIKE', "%{$search}%")->orWhere('last_name',  'LIKE', "%{$search}%")->orWhere('email',  'LIKE', "%{$search}%")->orWhere('phone_number',  'LIKE', "%{$search}%");
            });
        }

        // If there is a new filter or sorted query in the request, save them in the session and run the query through them
        $filterComponents = ['status', 'role', 'gender', 'state'];
        if (isset($name) && !in_array($name, $filterComponents) && $name != 'no_per_page' && $name != '') {;
            $request->session()->put('buyerSortName', [$name, $direction ]);
        }elseif (isset($name) && $name == 'status') {
            $request->session()->forget('buyerStatusName');
            $request->session()->put('buyerStatusName', [$name, $direction ]);
        }elseif (isset($name) && $name == 'state') {
            $request->session()->forget('buyerStateName');
            $request->session()->put('buyerStateName', [$name, $direction ]);
        }elseif (isset($name) && $name == 'gender') {
            $request->session()->forget('buyerGenderName');
            $request->session()->put('buyerGenderName', [$name, $direction ]);
        }elseif (isset($name) && $name == 'role') {
            $request->session()->forget('buyerRoleName');
            $request->session()->put('buyerRoleName', [$name, $direction ]);
        }elseif (isset($name) && $name == 'no_per_page') {
            $request->session()->put('buyerNumberPerPage', [$name, $direction ]);
        }
        elseif(isset($name) && $name == ''){
            $request->session()->put('buyerStatusName', [$name, $direction ]);
        }
        if(Session::has('buyerNumberPerPage')){
            if(empty($request->search) || $request->search == '') {
                $query2 = User::where('deactivated', false)->where('role', '!=', 'vendor');
            } else {
                $query2 = $query2;
            }
        } 

        if(Session::has('buyerSortName')){
            $query2 = $query2->orderBy(Session::get('buyerSortName.0'), Session::get('buyerSortName.1') == 'down' ? 'desc' : 'asc');
        } 
        if(Session::has('buyerStatusName') && Session::get('buyerStatusName.1') != '-'){
            $query2 = $query2->where('status', Session::get('buyerStatusName.1'));
        }  
        if(Session::has('buyerStateName') && Session::get('buyerStateName.1') != '-'){
            $query2 = $query2->where('state', Session::get('buyerStateName.1'));
        }  
        if(Session::has('buyerGenderName') && Session::get('buyerGenderName.1') != '-'){
            $query2 = $query2->where('gender', Session::get('buyerGenderName.1'));
        }  
        if(Session::has('buyerRoleName') && Session::get('buyerRoleName.1') != '-'){
            $query2 = $query2->where('role', Session::get('buyerRoleName.1'));
        } 

        $buyers = $query2->paginate(Session::has('buyerNumberPerPage') ? Session::get('buyerNumberPerPage.1'): 20)->onEachSide(0);
        
        return response()->json(['buyers' => $buyers]); 
    }
}
