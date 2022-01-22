<?php

namespace App\Http\Controllers;

use App\Models\Business_category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Session;

class BusinessCategoryController extends Controller
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
        Session::forget(['BCSortName', 'BCStatusName', 'BCNumberPerPage']);
        $page_title = 'Business Categories';
        $crumbs = ['Business Categories' ];
         return view('app-pages.admin.business-category.index', compact('page_title', 'crumbs'));
    }
    
    public  function create()
    {
        $page_title = 'Business Categories';
        $crumbs = ['Business Categories', 'Create New Category' ];
        $urls = ['Business Categories' =>'/business-categories' ];
        return view('app-pages.admin.business-category.create', compact('page_title', 'crumbs', 'urls'));
    }

    public  function store(Request $request)
    {
        Validator::make(request()->all(), [
             'name'=> 'required',
             'description'=> 'nullable',
         ]);
        //  dd($request->all());
        $bc = new Business_category();
        $bc->name = request()['name'];
        $bc->description = request()['description'];
        $bc->slug = Str::slug(request()['name']);
        $bc->save();

        return response()->json([
            'message' => 'New Category created successfully',
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
        $page_title = 'Business Categories';
        $crumbs = ['Business Categories', 'View Category'];
        $urls = ['Business Categories' =>'/business-categories' ];
        $bc = Business_category::where('id', $id)->where('deactivated', false)->first();
        
        if($request->edit){
            if(!$bc){
                return response()->json([
                    'message' => 'Error! Invalid Category'
                ], 400);
            }
            return response()->json([
                'businessCategory'=> $bc
            ],200);
        }

        if(!$admin){
            return redirect('/');
        }
        //  return view('app-pages.admin.business-category.show', compact('page_title', 'crumbs', 'bc', 'urls'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_title = 'Business Categories';
        $crumbs = ['Business Categories', 'Edit Category'];
        $urls = ['Business Categories' =>'/business-categories' ];
        $bc = Business_category::where('id', $id)->where('deactivated', false)->first();
        if(!$bc){
            return redirect('/');
        }
         return view('app-pages.admin.business-category.edit', compact('page_title', 'crumbs', 'bc', 'id', 'urls'));
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
        $category = Business_category::where('id', $id)->where('deactivated', false)->first();
        if(!$category){
            return redirect('/');
        }
        if(request()['type'] == 'save') {
            Validator::make(request()->all(), [
                'name'=> 'required',
                'description'=> 'nullable',
            ]);
            
           $category->name = request()['name'];
           $category->description = request()['description'];
            $category->slug = Str::slug(request()['name']);
        } elseif(request()['type'] == 'deactivate') {
            $category->status = 'inactive';
        } elseif(request()['type'] == 'activate') {
            $category->status = 'active';       
        } elseif(request()['type'] == 'delete') {
            $category->deactivated = true;
        }
        $category->save();

       return response()->json([
           'message' => 'Business category updated successfully',
       ],200);
    }

    public function massUpdate(Request $request)
    {
        $ids = request()['ids'];
        $businessCategories = Business_category::whereIn('id', $ids)->where('deactivated', false)->get();
        if(count($businessCategories) < 1){
            return response()->json(['message'=> 'Wrong request'],400);
        }
        
        if(request()['type'] == 'deactivate') {
            foreach ($businessCategories as $category) {
                # code...
                $category->status = 'inactive';
                $category->save();
            }         
        } elseif(request()['type'] == 'activate') {
            foreach ($businessCategories as $category) {
                $category->status = 'active';
                $category->save();
            }         
        }elseif(request()['type'] == 'delete') {
            foreach ($businessCategories as $category) {
                $category->deactivated = true;
                $category->save();
            }
        }

       return response()->json([
           'message' => 'Business Category updated successfully',
       ],200);
    }

    

    public  function refreshBC(Request $request)
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
        $query = Business_category::query();
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
            $request->session()->put('BCSortName', [$name, $direction ]);
            // $query2 = $query2->orderBy($name, $direction == 'down' ? 'desc' : 'asc');
        }elseif (isset($name) && $name == 'status') {
            $request->session()->forget('BCStatusName');
            $request->session()->put('BCStatusName', [$name, $direction ]);
            // $query2 = $query2->where('status', $direction);
        }elseif (isset($name) && $name == 'no_per_page') {
            $request->session()->put('BCNumberPerPage', [$name, $direction ]);
        }
        elseif(isset($name) && $name == ''){
            $request->session()->put('BCStatusName', [$name, $direction ]);
        }

        if(Session::has('BCNumberPerPage')){
            if(empty($request->search) || $request->search == '') {
                // dd('hello1');
                $query2 = Business_category::where('deactivated', false);
            } else {
                // dd('hello2');
                $query2 = $query2;
            }
        } 

        if(Session::has('BCSortName')){
            $query2 = $query2->orderBy(Session::get('BCSortName.0'), Session::get('BCSortName.1') == 'down' ? 'desc' : 'asc');
        }
        if(Session::has('BCStatusName') && Session::get('BCStatusName.1') != '-'){
            $query2 = $query2->where('status', Session::get('BCStatusName.1'));
        } 

        $businessCategories = $query2->paginate(Session::has('BCNumberPerPage') ? Session::get('BCNumberPerPage.1'): 20)->onEachSide(0);
        
        return response()->json(['businessCategories' => $businessCategories]); 
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
