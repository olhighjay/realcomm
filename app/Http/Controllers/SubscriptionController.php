<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Session;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public  function index()
    {
        Session::forget(['subSortName', 'subStatusName', 'subNumberPerPage']);
        $page_title = 'Subscriptions';
        $crumbs = ['Subscriptions' ];
         return view('app-pages.admin.subscription.index', compact('page_title', 'crumbs'));
    }
    
    public  function create()
    {
        $page_title = 'Subscriptions';
        $crumbs = ['Subscriptions', 'Create New Subscription' ];
        $urls = ['Subscriptions' =>'/subscriptions' ];
        return view('app-pages.admin.subscription.create', compact('page_title', 'crumbs', 'urls'));
    }

    public  function store(Request $request)
    {
        Validator::make(request()->all(), [
             'name'=> 'required',
             'description'=> 'nullable',
         ]);
        //  dd($request->all());
        $sub = new Subscription();
        $sub->name = request()['name'];
        $sub->description = request()['description'];
        $sub->slug = Str::slug(request()['name']);
        $sub->save();

        return response()->json([
            'message' => 'New Subscription created successfully',
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    
    public function show(Request $request, $id)
    {
        $page_title = 'Subscriptions';
        $crumbs = ['Subscriptions', 'Edit Subscription'];
        $urls = ['Subscriptions' =>'/subscriptions' ];
        $subscription = Subscription::where('id', $id)->where('deactivated', false)->first();
        
        // if($request->edit){
            if(!$subscription){
                return response()->json([
                    'message' => 'Error! Invalid User'
                ], 400);
            }
            return response()->json([
                'subscription'=> $subscription
            ],200);
        // }

        if(!$subscription){
            return redirect('/');
        }
        //  return view('app-pages.admin.admin.show', compact('page_title', 'crumbs', 'admin', 'urls'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_title = 'Subscriptions';
        $crumbs = ['Subscriptions', 'Edit Subscription'];
        $urls = ['Subscriptions' =>'/subscriptions' ];
        $subscription = Subscription::where('id', $id)->where('deactivated', false)->first();
        if(!$subscription){
            return redirect('/');
        }
         return view('app-pages.admin.subscription.edit', compact('page_title', 'crumbs', 'subscription', 'id', 'urls'));
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
        $subscription = Subscription::where('id', $id)->where('deactivated', false)->first();
        if(!$subscription){
            return redirect('/');
        }
        if(request()['type'] == 'save') {
            Validator::make(request()->all(), [
                'name'=> 'required',
                'description'=> 'nullable',
            ]);
            
           $subscription->name = request()['name'];
           $subscription->description = request()['description'];
           $subscription->slug = Str::slug(request()['name']);
        } elseif(request()['type'] == 'deactivate') {
            $subscription->status = 'inactive';
        } elseif(request()['type'] == 'activate') { 
            $subscription->status = 'active';       
        } elseif(request()['type'] == 'delete') {
            $subscription->deactivated = true;
        }
        $subscription->save();

       return response()->json([
           'message' => 'Subscription updated successfully',
       ],200);
    }

    public function massUpdate(Request $request)
    {
        $ids = request()['ids'];
        $subscriptions = Subscription::whereIn('id', $ids)->where('deactivated', false)->get();
        if(count($subscriptions) < 1){
            return response()->json(['message'=> 'Wrong request'],400);
        }
        
        if(request()['type'] == 'deactivate') {
            foreach ($subscriptions as $subscription) {
                # code...
                $subscription->status = 'inactive';
                $subscription->save();
            }         
        } elseif(request()['type'] == 'activate') {
            foreach ($subscriptions as $subscription) {
                $subscription->status = 'active';
                $subscription->save();
            }         
        }elseif(request()['type'] == 'delete') {
            foreach ($subscriptions as $subscription) {
                $subscription->deactivated = true;
                $subscription->save();
            }
        }

       return response()->json([
           'message' => 'Subscription updated successfully',
       ],200);
    }

    

    public  function refreshSub(Request $request)
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
        $query = Subscription::query();
        $query2 = $query->where('deactivated', false);
        // $query2 = $query1;
            // If there is a search query in the request or in the session, get the result from database
        if (isset($search) &&  $request->search != '') {
            // if there is no search query in the request, then we use the search query in the session
            $query2->where(function($query2) use ($search){
                $query2 = $query2->where('name', 'LIKE', "%{$search}%");
            });
        }

        // If there is a new filter or sorted query in the request, save them in the session and run the query through them
        if (isset($name) && $name != 'status' && $name != 'no_per_page' && $name != '') {
            // $request->session()->forget('adminStatusName');
            $request->session()->put('subSortName', [$name, $direction ]);
            // $query2 = $query2->orderBy($name, $direction == 'down' ? 'desc' : 'asc');
        }elseif (isset($name) && $name == 'status') {
            $request->session()->forget('subStatusName');
            $request->session()->put('subStatusName', [$name, $direction ]);
            // $query2 = $query2->where('status', $direction);
        }elseif (isset($name) && $name == 'no_per_page') {
            $request->session()->put('subNumberPerPage', [$name, $direction ]);
        }
        elseif(isset($name) && $name == ''){
            $request->session()->put('subStatusName', [$name, $direction ]);
        }

        if(Session::has('subNumberPerPage')){
            if(empty($request->search) || $request->search == '') {
                // dd('hello1');
                $query2 = Subscription::where('deactivated', false);
            } else {
                // dd('hello2');
                $query2 = $query2;
            }
        } 

        if(Session::has('subSortName')){
            $query2 = $query2->orderBy(Session::get('subSortName.0'), Session::get('subSortName.1') == 'down' ? 'desc' : 'asc');
        }
        if(Session::has('subStatusName') && Session::get('subStatusName.1') != '-'){
            $query2 = $query2->where('status', Session::get('subStatusName.1'));
        } 

        $subscriptions = $query2->paginate(Session::has('subNumberPerPage') ? Session::get('subNumberPerPage.1'): 20)->onEachSide(0);
        
        return response()->json(['subscriptions' => $subscriptions]); 
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
