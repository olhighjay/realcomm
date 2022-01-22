<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Session;
use Image;

class AdminController extends Controller
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

    public function dashboard()
    {
        $page_title = 'Dashboard';
        $crumbs = [ ];
        return view('app-pages.admin.dashboard', compact('page_title', 'crumbs'));
    }

    
    public  function index()
    {
        Session::forget(['adminSortName', 'adminStatusName', 'adminNumberPerPage']);
        $page_title = 'Admins';
        $crumbs = ['Admins' ];
         return view('app-pages.admin.admin.index', compact('page_title', 'crumbs'));
    }
    
    public  function create()
    {
        $page_title = 'Admins';
        $crumbs = ['Admins', 'Create New Admin' ];
        $urls = ['Admins' =>'/admins' ];
        return view('app-pages.admin.admin.create', compact('page_title', 'crumbs', 'urls'));
    }

    public  function store(Request $request)
    {
        Validator::make(request()->all(), [
             'first_name'=> 'required',
             'last_name'=> 'nullable',
             'email'=> 'unique:admin'|'required',
         ]);
        //  dd($request->all());
        $admin = new Admin();
        $admin->first_name = request()['first_name'];
        $admin->last_name = request()['last_name'];
        $admin->email = request()['email'];
        $admin->role = 'admin';
        $admin->password = Hash::make('password');
        $admin->save();

        return response()->json([
            'message' => 'New User created successfully',
            'location' => 'everywhere you go'
        ],201);

        //  return redirect('/')->with('success', 'Admin created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    
    public function show(Request $request, $id)
    {
        $page_title = 'Admins';
        $crumbs = ['Admins', 'View Admin'];
        $urls = ['Admins' =>'/admins' ];
        $admin = Admin::where('id', $id)->where('role', 'admin')->where('deactivated', false)->first();
        
        if($request->edit){
            if(!$admin){
                return response()->json([
                    'message' => 'Error! Invalid User'
                ], 400);
            }
            return response()->json([
                'admin'=> $admin
            ],200);
        }

        if(!$admin){
            return redirect('/');
        }
         return view('app-pages.admin.admin.show', compact('page_title', 'crumbs', 'admin', 'urls'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_title = 'Admins';
        $crumbs = ['Admins', 'Edit Admin'];
        $urls = ['Admins' =>'/admins' ];
        $admin = Admin::where('id', $id)->where('role', 'admin')->where('deactivated', false)->first();
        if(!$admin){
            return redirect('/');
        }
         return view('app-pages.admin.admin.edit', compact('page_title', 'crumbs', 'admin', 'id', 'urls'));
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
        $admin = Admin::where('id', $id)->where('role', 'admin')->where('deactivated', false)->first();
        if(!$admin){
            return redirect('/');
        }
        if(request()['type'] == 'save') {
            Validator::make(request()->all(), [
                'first_name'=> 'required',
                'last_name'=> 'nullable',
                'email'=> 'unique:admin'|'required',
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
                $thumbnailpath = public_path().'/images/admin_profile_picture/thumbnail/'.$filenametostore;
            
                $img = Image::make($image->getRealPath(),array(

                    'width' => 100,

                    'height' => 100,

                    'grayscale' => false

                ));
                $img->save($thumbnailpath);

                // $path = $image->move(public_path().'/images/car_reports/', $filenametostore);

                $admin->profile_picture = $filenametostore;

            }
            
           $admin->first_name = request()['first_name'];
           $admin->last_name = request()['last_name'];
           $admin->email = request()['email'];
        } elseif(request()['type'] == 'deactivate') {
            $admin->status = 'inactive';
        } elseif(request()['type'] == 'activate') {
            $admin->status = 'active';       
        } elseif(request()['type'] == 'delete') {
            $admin->deactivated = true;
        }
        $admin->save();

       return response()->json([
           'message' => 'Admin updated successfully',
           'location' => 'everywhere you go'
       ],200);
    }

    public function massUpdate(Request $request)
    {
        $ids = request()['ids'];
        $admins = Admin::whereIn('id', $ids)->where('role', 'admin')->where('deactivated', false)->get();
        if(count($admins) < 1){
            return response()->json(['message'=> 'Wrong request'],400);
        }
        
        if(request()['type'] == 'deactivate') {
            foreach ($admins as $admin) {
                # code...
                $admin->status = 'inactive';
                $admin->save();
            }         
        } elseif(request()['type'] == 'activate') {
            foreach ($admins as $admin) {
                $admin->status = 'active';
                $admin->save();
            }         
        }elseif(request()['type'] == 'delete') {
            foreach ($admins as $admin) {
                $admin->deactivated = true;
                $admin->save();
            }
        }

       return response()->json([
           'message' => 'Admin updated successfully',
           'location' => 'everywhere you go'
       ],200);
    }

    

    public  function refreshAdmin(Request $request)
    {
        $direction = $request->direction;
        if (isset($request->name)){
            $name = $request->name;
        }
        if (isset($request->search)){
            $search = $request->search;
            // $request->session()->put('adminSearchQuery', $search );
        }
        if (isset($request->direction)){
            $direction = $request->direction;
        }
        $query = Admin::query();
        $query2 = $query->where('deactivated', false)->where('role', 'admin');
        // $query2 = $query1;
            // If there is a search query in the request or in the session, get the result from database
        if (isset($search) &&  $request->search != '') {
            // if there is no search query in the request, then we use the search query in the session
            // if(!isset($search)) {
            //     $search = Session::get('adminSearchQuery');
            // }
            $query2->where(function($query2) use ($search){
                $query2 = $query2->where('first_name', 'LIKE', "%{$search}%")->orWhere('last_name',  'LIKE', "%{$search}%")->orWhere('email',  'LIKE', "%{$search}%");
            });
            // If there is a filtered or sorted results/data already, only run the search query through the data
            // if(Session::has('adminSortName') && $direction != '-'){
            //     $query2 = $query2->orderBy(Session::get('adminSortName.0'), Session::get('adminSortName.1') == 'down' ? 'desc' : 'asc');
            // } elseif(Session::has('adminStatusName') && $direction != '-'){
            //     $query2 = $query2->where('status', Session::get('adminStatusName.1'));
            // }
        }

        // If there is a new filter or sorted query in the request, save them in the session and run the query through them
        if (isset($name) && $name != 'status' && $name != 'no_per_page' && $name != '') {
            // $request->session()->forget('adminStatusName');
            $request->session()->put('adminSortName', [$name, $direction ]);
            // $query2 = $query2->orderBy($name, $direction == 'down' ? 'desc' : 'asc');
        }elseif (isset($name) && $name == 'status') {
            $request->session()->forget('adminStatusName');
            $request->session()->put('adminStatusName', [$name, $direction ]);
            // $query2 = $query2->where('status', $direction);
        }elseif (isset($name) && $name == 'no_per_page') {
            $request->session()->put('adminNumberPerPage', [$name, $direction ]);
            // if(empty($request->search) || $request->search == '') {
            //     // Session::forget('adminSearchQuery');
            //     $query2 = Admin::where('deactivated', false)->where('role', 'admin');
            //     // Session::forget('adminStatusName');
            // } else {
            //     $query2 = $query2;
            // }
        }
        elseif(isset($name) && $name == ''){
            $request->session()->put('adminStatusName', [$name, $direction ]);
        }
        // else {
        //     if(empty($request->search) || $request->search == '') {
        //         // Session::forget('adminSearchQuery');
        //         $query2 = Admin::where('deactivated', false)->where('role', 'admin');
        //         // Session::forget('adminStatusName');
        //     } else {
        //         $query2 = $query2;
        //     }
        // }
        // else {
        //     // If there is no search query in the request or the search query is empty, probably the search field was cleared after typing sth earlier, get all the data unfiltered
        //     // else get the filtered data
        //     if(Session::has('adminSortName') && $direction != '-'){
        //         if(empty($request->search) || $request->search == '') {
        //             // Session::forget('adminSearchQuery');
        //             $query2 = Admin::where('deactivated', false)->where('role', 'admin');
        //             Session::forget('adminSortName');
        //         } else {
        //             $query2 = $query2->orderBy(Session::get('adminSortName.0'), Session::get('adminSortName.1') == 'down' ? 'desc' : 'asc');
        //         }
        //     } elseif(Session::has('adminStatusName') && $direction != '-'){
        //         if(empty($request->search) || $request->search == '') {
        //             // Session::forget('adminSearchQuery');
        //             $query2 = Admin::where('deactivated', false)->where('role', 'admin');
        //             Session::forget('adminStatusName');
        //         } else {
        //             $query2 = $query2->where('status', Session::get('adminStatusName.1'));
        //         }
        //     } elseif(Session::has('adminNumberPerPage') && $direction != '-'){
        //         if(empty($request->search) || $request->search == '') {
        //             // dd('hello1');
        //             $query2 = Admin::where('deactivated', false)->where('role', 'admin');
        //         } else {
        //             // dd('hello2');
        //             $query2 = $query2;
        //         }
        //     } elseif(empty($request->search) || $request->search == '') {
        //         // Session::forget('adminSearchQuery');
        //         $query2 = Admin::where('deactivated', false)->where('role', 'admin');
        //     }
        // }
        if(Session::has('adminNumberPerPage')){
            if(empty($request->search) || $request->search == '') {
                // dd('hello1');
                $query2 = Admin::where('deactivated', false)->where('role', 'admin');
            } else {
                // dd('hello2');
                $query2 = $query2;
            }
        } 

        if(Session::has('adminSortName')){
            // if(empty($request->search) || $request->search == '') {
            //     // Session::forget('adminSearchQuery');
            //     $query2 = Admin::where('deactivated', false)->where('role', 'admin');
            //     Session::forget('adminSortName');
            // } else {
                $query2 = $query2->orderBy(Session::get('adminSortName.0'), Session::get('adminSortName.1') == 'down' ? 'desc' : 'asc');
                // if(empty($request->search) || $request->search == '') {}
            // }
        } 
        if(Session::has('adminStatusName') && Session::get('adminStatusName.1') != '-'){
            // dd(Session::get('adminStatusName.1'));

            // if(empty($request->search) || $request->search == '') {
            //     // Session::forget('adminSearchQuery');
            //     $query2 = Admin::where('deactivated', false)->where('role', 'admin');
            //     Session::forget('adminStatusName');
            // } else {
                // if(Session::get('adminStatusName.1') == '-'){
                //     // dd('here');
                //     $query2 = $query2;
                // } else {                
                    $query2 = $query2->where('status', Session::get('adminStatusName.1'));
                // }
            // }
        } 
        // elseif(empty($request->search) || $request->search == '') {
        //     // Session::forget('adminSearchQuery');
        //     $query2 = Admin::where('deactivated', false)->where('role', 'admin');
        // }

        $admins = $query2->paginate(Session::has('adminNumberPerPage') ? Session::get('adminNumberPerPage.1'): 20)->onEachSide(0);
        
        return response()->json(['admins' => $admins]); 
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
