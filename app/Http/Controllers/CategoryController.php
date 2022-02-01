<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function categoryProducts(Category $category)
     {
         $categoryProducts = $category->products;
        //  dd($categoryProducts);
         return view('web-pages.category-products', compact('categoryProducts', 'category'));
     }


     public  function index()
     {
         Session::forget(['PCSortName', 'PCStatusName', 'PCNumberPerPage']);
         $page_title = 'Product Categories';
         $crumbs = ['Product Categories' ];
          return view('app-pages.admin.product-category.index', compact('page_title', 'crumbs'));
     }
     
     public  function create()
     {
         $page_title = 'Product Categories';
         $crumbs = ['Product Categories', 'Create New Category' ];
         $urls = ['Product Categories' =>'/product-categories' ];
         return view('app-pages.admin.product-category.create', compact('page_title', 'crumbs', 'urls'));
     }
 
     public  function store(Request $request)
     {
         Validator::make(request()->all(), [
              'name'=> 'required',
              'description'=> 'nullable',
          ]);
         //  dd($request->all());
         $pc = new Category();
         $pc->name = request()['name'];
         $pc->description = request()['description'];
         $pc->slug = Str::slug(request()['name']);
         $pc->save();
 
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
         $page_title = 'Product Categories';
         $crumbs = ['Product Categories', 'View Category'];
         $urls = ['Product Categories' =>'/product-categories' ];
         $pc = Category::where('id', $id)->where('deactivated', false)->first();
         
         if($request->edit){
             if(!$pc){
                 return response()->json([
                     'message' => 'Error! Invalid Category'
                 ], 400);
             }
             return response()->json([
                 'productCategory'=> $pc
             ],200);
         }
 
         if(!$pc){
             return redirect('/');
         }
     }
 
     /**
      * Show the form for editing the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function edit($id)
     {
         $page_title = 'Product Categories';
         $crumbs = ['Product Categories', 'Edit Category'];
         $urls = ['Product Categories' =>'/product-categories' ];
         $pc = Category::where('id', $id)->where('deactivated', false)->first();
         if(!$pc){
             return redirect('/');
         }
          return view('app-pages.admin.product-category.edit', compact('page_title', 'crumbs', 'pc', 'id', 'urls'));
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
         $category = Category::where('id', $id)->where('deactivated', false)->first();
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
            'message' => 'Product category updated successfully',
        ],200);
     }
 
     public function massUpdate(Request $request)
     {
         $ids = request()['ids'];
         $productCategories = Category::whereIn('id', $ids)->where('deactivated', false)->get();
         if(count($productCategories) < 1){
             return response()->json(['message'=> 'Wrong request'],400);
         }
         
         if(request()['type'] == 'deactivate') {
             foreach ($productCategories as $category) {
                 # code...
                 $category->status = 'inactive';
                 $category->save();
             }         
         } elseif(request()['type'] == 'activate') {
             foreach ($productCategories as $category) {
                 $category->status = 'active';
                 $category->save();
             }         
         }elseif(request()['type'] == 'delete') {
             foreach ($productCategories as $category) {
                 $category->deactivated = true;
                 $category->save();
             }
         }
 
        return response()->json([
            'message' => 'Product Category updated successfully',
        ],200);
     }
 
     
 
     public  function refreshPC(Request $request)
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
         $query = Category::query();
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
             $request->session()->put('PCSortName', [$name, $direction ]);
         }elseif (isset($name) && $name == 'status') {
             $request->session()->forget('PCStatusName');
             $request->session()->put('PCStatusName', [$name, $direction ]);
         }elseif (isset($name) && $name == 'no_per_page') {
             $request->session()->put('PCNumberPerPage', [$name, $direction ]);
         }
         elseif(isset($name) && $name == ''){
             $request->session()->put('PCStatusName', [$name, $direction ]);
         }
 
         if(Session::has('PCNumberPerPage')){
             if(empty($request->search) || $request->search == '') {
                 $query2 = Category::where('deactivated', false);
             } else {
                 $query2 = $query2;
             }
         } 
 
         if(Session::has('PCSortName')){
             $query2 = $query2->orderBy(Session::get('PCSortName.0'), Session::get('PCSortName.1') == 'down' ? 'desc' : 'asc');
         }
         if(Session::has('PCStatusName') && Session::get('PCStatusName.1') != '-'){
             $query2 = $query2->where('status', Session::get('PCStatusName.1'));
         } 
 
         $productCategories = $query2->paginate(Session::has('PCNumberPerPage') ? Session::get('PCNumberPerPage.1'): 20)->onEachSide(0);
         
         return response()->json(['productCategories' => $productCategories]); 
     }
}
