<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Business_category;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;
use Illuminate\Support\Facades\Storage;
use Image;

class BusinessController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        Session::forget(['businessSortName', 'businessStatusName', 'businessCategory_id', 'businessNumberPerPage']);
        $page_title = 'Businesses';
        $crumbs = ['Businesses' ];
         return view('app-pages.admin.business.index', compact('page_title', 'crumbs'));
    }

    public  function create()
    {
        $page_title = 'Businesses';
        $crumbs = ['Businesses', 'Create New Business' ];
        $urls = ['Businesses' =>'/businesses' ];
        $businessCategories = Business_category::where('deactivated', false)->get();
        $vendors = User::where('deactivated', false)->where('role', 'vendor')->get();
        $subscriptions = Subscription::where('deactivated', false)->get();
        return view('app-pages.admin.business.create', compact('page_title', 'crumbs', 'urls', 'businessCategories', 'vendors', 'subscriptions'));
    }

    public  function store(Request $request)
    {
        Validator::make(request()->all(), [
             'name'=> 'required',
             'description'=> 'nullable',
             'vendor'=> 'required',
             'category'=> 'required',
             'subscription'=> 'required',
             'account_number'=> 'nullable',
             'account_name'=> 'nullable',
             'bank_name'=> 'nullable',
         ]);
        try {
            $business = new Business();
            $business->name = request()['name'];
            $business->description = request()['description'];
            $business->user_id = request()['vendor'];
            $business->business_category_id = request()['category'];
            $business->subscription_id = request()['subscription'];
            $business->bank_account_number = request()['account_number'];
            $business->bank_account_name = request()['account_name'];
            $business->bank_name = request()['bank_name'];
            $business->save();
    
            return response()->json([
                'message' => 'New Business created successfully',
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
        $page_title = 'Businesses';
        $crumbs = ['Businesses', 'Create New Business' ];
        $urls = ['Businesses' =>'/businesses' ];
        $business = Business::where('id', $id)->where('deactivated', false)->with('user')->with('business_category')->with('subscription')->first();
        // dd($business);
        
        if($request->edit){
            if(!$business){
                return response()->json([
                    'message' => 'Error! Invalid User'
                ], 400);
            }
            return response()->json([
                'business'=> $business
            ],200);
        }

        if(!$business){
            return redirect('/');
        }
         return view('app-pages.admin.business.show', compact('page_title', 'crumbs', 'business', 'urls'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_title = 'Businesses';
        $crumbs = ['Businesses', 'Create New Business' ];
        $urls = ['Businesses' =>'/businesses' ];
        $businessCategories = Business_category::where('deactivated', false)->get();
        $vendors = User::where('deactivated', false)->where('role', 'vendor')->get();
        $subscriptions = Subscription::where('deactivated', false)->get();
        return view('app-pages.admin.business.edit', compact('page_title', 'crumbs', 'urls', 'businessCategories', 'vendors', 'subscriptions', 'id'));
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
        $business = Business::where('id', $id)->where('deactivated', false)->with('user')->with('business_category')->with('subscription')->first();
        // dd($business);
        if(!$business){
            return response()->json([
                'message' => 'Something went wrong with your request!',
            ],202);
        }
        if(request()['type'] == 'save') {
            Validator::make(request()->all(), [
                'name'=> 'required',
                'description'=> 'nullable',
                // 'vendor'=> 'required',
                'category'=> 'required',
                'subscription'=> 'required',
                'account_number'=> 'nullable',
                'account_name'=> 'nullable',
                'bank_name'=> 'nullable',
                'logo'=> 'nullable',
            ]);
            if($request->logo) {
                $logo = $request->logo;
                //get filename with extension
                $filenamewithextension = $logo->getClientOriginalName();

                //get filename without extension
                $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

                //get file extension
                $extension = $logo->getClientOriginalExtension();

                //filename to store
                $filenametostore = $filename.'_'.uniqid().'.'.$extension;

                //Resize image here
                $thumbnailpath = public_path().'/images/business_logo/thumbnail/'.$filenametostore;
            
                $img = Image::make($logo->getRealPath(),array(

                    'width' => 200,

                    'height' => 200,

                    'grayscale' => false

                ));
                $img->save($thumbnailpath);

                // $path = $image->move(public_path().'/images/car_reports/', $filenametostore);

                $business->logo = $filenametostore;

            }

           $business->name = request()['name'];
           $business->description = request()['description'];
        //    $business->user_id = request()['vendor'];
           $business->business_category_id = request()['category'];
           $business->subscription_id = request()['subscription'];
           $business->bank_name = request()['bank_name'];
           $business->bank_account_name = request()['account_name'];
           $business->bank_account_number = request()['account_number'];
        } elseif(request()['type'] == 'deactivate') {
            $business->status = 'inactive';
        } elseif(request()['type'] == 'activate') {
            $business->status = 'active';       
        } elseif(request()['type'] == 'blacklist') {
            $business->status = 'blacklisted';       
        } elseif(request()['type'] == 'delete') {
            $business->deactivated = true;
        }
        $business->save();

       return response()->json([
           'message' => 'Business category updated successfully',
       ],200);
    }
    public function massUpdate(Request $request)
    {
        $ids = request()['ids'];
        $businesses = Business::whereIn('id', $ids)->where('deactivated', false)->with('user')->with('business_category')->with('subscription')->get();
        if(count($businesses) < 1){
            return response()->json(['message'=> 'Wrong request'],400);
        }
        
        if(request()['type'] == 'deactivate') {
            foreach ($businesses as $business) {
                # code...
                $business->status = 'inactive';
                $business->save();
            }         
        } elseif(request()['type'] == 'activate') {
            foreach ($businesses as $business) {
                $business->status = 'active';
                $business->save();
            }         
        }elseif(request()['type'] == 'delete') {
            foreach ($businesses as $business) {
                $business->deactivated = true;
                $business->save();
            }
        }

       return response()->json([
           'message' => 'Businesses updated successfully',
       ],200);
    }


    public  function refreshBusiness(Request $request)
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
        // $query = Business::has('user')->first();
        // dd($query->user->first_name);
        $query = Business::query()->with('user')->with('business_category')->with('subscription');
        // dd($query);
        $query2 = $query->where('deactivated', false);
            // If there is a search query in the request or in the session, get the result from database
        if (isset($search) &&  $request->search != '') {
            $query2->where(function($query2) use ($search){
                // $query2 = $query2->where('first_name', 'LIKE', "%{$search}%")->orWhere('last_name',  'LIKE', "%{$search}%")->orWhere('email',  'LIKE', "%{$search}%")->orWhere('phone_number',  'LIKE', "%{$search}%");
                $query2 = $query2->where('name', 'LIKE', "%{$search}%");
            });
        }

        // If there is a new filter or sorted query in the request, save them in the session and run the query through them
        if (isset($name) && $name != 'status' && $name != 'no_per_page' && $name != 'category_id' && $name != '') {
            // $request->session()->forget('adminStatusName');
            $request->session()->put('businessSortName', [$name, $direction ]);
            // $query2 = $query2->orderBy($name, $direction == 'down' ? 'desc' : 'asc');
        }elseif (isset($name) && $name == 'status') {
            $request->session()->forget('businessStatusName');
            $request->session()->put('businessStatusName', [$name, $direction ]);
            // $query2 = $query2->where('status', $direction);
        }elseif (isset($name) && $name == 'no_per_page') {
            $request->session()->put('businessNumberPerPage', [$name, $direction ]);
        }elseif (isset($name) && $name == 'category_id') {
            $request->session()->put('businessCategory_id', [$name, $direction ]);
        }
        elseif(isset($name) && $name == ''){
            $request->session()->put('businessStatusName', [$name, $direction ]);
        }

        if(Session::has('businessNumberPerPage')){
            if(empty($request->search) || $request->search == '') {
                // dd('hello1');
                $query2 = $query->where('deactivated', false);
            } else {
                // dd('hello2');
                $query2 = $query2;
            }
        } 

        if(Session::has('businessSortName')){
            $query2 = $query2->orderBy(Session::get('businessSortName.0'), Session::get('businessSortName.1') == 'down' ? 'desc' : 'asc');
        }
        if(Session::has('businessStatusName') && Session::get('businessStatusName.1') != '-'){
            $query2 = $query2->where('status', Session::get('businessStatusName.1'));
        } 
        if(Session::has('businessCategory_id') && Session::get('businessCategory_id.1') != '-'){
            $query2 = $query2->where('business_category_id', Session::get('businessCategory_id.1'));
        } 

        $businesses = $query2->paginate(Session::has('businessNumberPerPage') ? Session::get('businessNumberPerPage.1'): 20)->onEachSide(0);
        $businessCategories = Business_category::where('deactivated', false)->get();
        return response()->json([
            'businesses' => $businesses,
            'businessCategories' => $businessCategories
        ]); 
    }
}

