<?php

namespace App\Http\Controllers;


use App\Models\Product;
use Illuminate\Http\Request;

use App\Models\Business;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Subscription;
use Illuminate\Support\Facades\Validator;
use Session;
use Illuminate\Support\Facades\Storage;
use Image;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        Session::forget(['productSortName', 'productStatusName', 'productCategory_id', 'productNumberPerPage','productStockStatusName', 'productPriceFilter']);
        $page_title = 'Products';
        $crumbs = ['Products' ];
         return view('app-pages.admin.product.index', compact('page_title', 'crumbs'));
    }

    public  function create(Request $request, Business $business)
    {
        if(!$business) {
            return back();
        }
        $businessId = $business->id;
        $page_title = 'Products';
        $crumbs = ['Products', 'Create New Product' ];
        $urls = ['Products' =>'/products' ];
        $categories = Category::where('deactivated', false)->get();
        // $business = Business::where('deactivated', false)->get();
        return view('app-pages.admin.product.create', compact('page_title', 'crumbs', 'urls', 'categories', 'businessId'));
    }

    public  function store(Request $request, Business $business)
    {
        Validator::make(request()->all(), [
             'name'=> 'required',
             'short_description'=> 'nullable',
             'description'=> 'nullable',
             'regular_price'=> 'required',
             'sale_price'=> 'nullable',
             'quantity'=> 'required|min:2',
             'category'=> 'nullable',
             
         ]);
        try {
            $array = [1,2,3,4,5,6,7,8,9,0,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
            $randomStr = Str::random(3);
            $rand = array_rand($array, 2);
            $random1 = $array[$rand[1]];
            $random2 = $array[$rand[0]];
            $t=time();
            $curentSec = date("s",$t);

            if(request()['quantity'] > 2) {
                $stock = 'in stock';
            } else if(request()['quantity'] < 1) {
                return response()->json([
                    'message' =>"Quantity must be greater 1"], 200);
            }else {
                $stock = 'low stock';
            }

            if(request()['sale_price']) {
                $sale_price = request()['sale_price'];
            } else {
                $sale_price = request()['regular_price'];
            }

            $product = new Product();
            $product->name = request()['name'];
            $product->slug = Str::slug(request()['name']);
            $product->description = request()['description'];
            $product->short_description = request()['short_description'];
            $product->regular_price = request()['regular_price'];
            $product->sale_price = $sale_price;
            $product->user_id = $business->user_id;
            $product->category_id = request()['category'];
            $product->product_specific_id = $randomStr.$curentSec.$random1.$random2;
            $product->stock_status = $stock;
            $product->quantity = request()['quantity'];
            $product->business_id = $business->id;
            $product->save();
    
            return response()->json([
                'message' => 'New Product created successfully',
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
        $page_title = 'Products';
        $crumbs = ['Products', ' Product' ];
        $urls = ['Products' =>'/products' ];
        $product = Product::where('id', $id)->where('deactivated', false)->with('business')->with('category')->first();
        // dd($business);
        
        if($request->edit){
            if(!$product){
                return response()->json([
                    'message' => 'Error! Invalid User'
                ], 400);
            }
            return response()->json([
                'product'=> $product
            ],200);
        }

        if(!$product){
            return redirect('/');
        }
         return view('app-pages.admin.product.show', compact('page_title', 'crumbs', 'product', 'urls'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_title = 'Products';
        $crumbs = ['Products', 'Edit Product' ];
        $urls = ['Products' =>'/products' ];
        $categories = Category::where('deactivated', false)->get();
        return view('app-pages.admin.product.edit', compact('page_title', 'crumbs', 'urls', 'categories', 'id'));
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
        $product = Product::where('id', $id)->where('deactivated', false)->with('business')->with('category')->first();
        // dd($business);
        if(!$product){
            return response()->json([
                'message' => 'Something went wrong with your request!',
            ],202);
        }
        if(request()['type'] == 'save') {
            Validator::make(request()->all(), [
                'name'=> 'required',
                'short_description'=> 'nullable',
                'description'=> 'nullable',
                'category_id'=> 'required',
                'business_id'=> 'required',
                'regular_price'=> 'required',
                'sale_price'=> 'required',
                'quantity'=> 'required',
                // 'logo'=> 'nullable',
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
            if(request()['quantity'] > 2) {
                $stock = 'in stock';
            } else if(request()['quantity'] < 1) {
                return response()->json([
                    'message' =>"Quantity must be greater 1"], 202);
            }else {
                $stock = 'low stock';
            }

            if(request()['sale_price']) {
                $sale_price = request()['sale_price'];
            } else {
                $sale_price = request()['regular_price'];
            }

            $product->name = request()['name'];
            $product->description = request()['description'];
            $product->short_description = request()['short_description'];
            $product->regular_price = request()['regular_price'];
            $product->sale_price = $sale_price;
            $product->category_id = request()['category'];
            $product->stock_status = $stock;
            $product->quantity = request()['quantity'];
            $product->save();

        } elseif(request()['type'] == 'deactivate') {
            $product->status = 'inactive';
        } elseif(request()['type'] == 'activate') {
            $product->status = 'active';       
        } elseif(request()['type'] == 'blacklist') {
            $product->status = 'blacklisted';       
        } elseif(request()['type'] == 'delete') {
            $product->deactivated = true;
        } 
        $product->save();

       return response()->json([
           'message' => 'Product category updated successfully',
       ],200);
    }
    public function massUpdate(Request $request)
    {
        $ids = request()['ids'];
        $products = Product::whereIn('id', $ids)->where('deactivated', false)->with('business')->with('category')->get();
        if(count($products) < 1){
            return response()->json(['message'=> 'Wrong request'],400);
        }
        
        if(request()['type'] == 'deactivate') {
            foreach ($products as $product) {
                # code...
                $product->status = 'inactive';
                $product->save();
            }         
        } elseif(request()['type'] == 'activate') {
            foreach ($products as $product) {
                $product->status = 'active';
                $product->save();
            }         
        }elseif(request()['type'] == 'delete') {
            foreach ($products as $product) {
                $product->deactivated = true;
                $product->save();
            }
        }elseif(request()['type'] == 'stock_status') {
            foreach ($products as $product) {
                $product->stock_status = request()['stock_status'];
                $product->save();
            }
        }

       return response()->json([
           'message' => 'Products updated successfully',
       ],200);
    }


    public  function refreshProduct(Request $request)
    {
        $direction = $request->direction;
        if (isset($request->name)){
            $name = $request->name;
        }
        if (isset($request->search)){
            $search = $request->search;
        }
        if (isset($request->price_filter)){
            $price_filter = $request->price_filter;
        }
        if (isset($request->direction)){
            $direction = $request->direction;
        }
        $query = Product::query();
        // dd($query->get());
        $query2 = $query->with('category')->with('business')->where('deactivated', false);
            // If there is a search query in the request or in the session, get the result from database
        if (isset($search) &&  $request->search != '') {
            $query2->where(function($query2) use ($search){
                // $query2 = $query2->where('first_name', 'LIKE', "%{$search}%")->orWhere('last_name',  'LIKE', "%{$search}%")->orWhere('email',  'LIKE', "%{$search}%")->orWhere('phone_number',  'LIKE', "%{$search}%");
                $query2 = $query2->where('name', 'LIKE', "%{$search}%")->orWhereHas('business', function($query2) use ($search){
                    $query2->where('name', 'LIKE', "%{$search}%");
                });
            });
        }

        if ((isset($price_filter) &&  $request->price_filter != '') || Session::has('productPriceFilter')) {
            if(isset($price_filter)){
                $request->session()->put('productPriceFilter', $price_filter);
            }
            $price_filterz = $request->session()->get('productPriceFilter');
            $priceFilters = explode("-",$price_filterz);
            $query2->where(function($query2) use ($priceFilters){
                if($priceFilters[0] > 0 && $priceFilters[1] > 0  ) {
                    $query2 = $query2->where('sale_price', '>=', $priceFilters[0])->where('sale_price', '<=', $priceFilters[1]);                  
                } elseif($priceFilters[0] > 0 ) {
                    $query2 = $query2->where('sale_price', '>=', $priceFilters[0]);                  
                }elseif($priceFilters[1] > 0 ) {
                    $query2 = $query2->where('sale_price', '<=', $priceFilters[1]);                  
                }elseif($priceFilters[0] == 0 && $priceFilters[1] == 0) {
                    $query2 = $query2;                  
                }
            });
        }
        // If there is a new filter or sorted query in the request, save them in the session and run the query through them
        if (isset($name) && $name != 'status' && $name != 'stock_status' && $name != 'no_per_page' && $name != 'category_id' && $name != '') {
            // $request->session()->forget('adminStatusName');
            $request->session()->put('productSortName', [$name, $direction ]);
            // $query2 = $query2->orderBy($name, $direction == 'down' ? 'desc' : 'asc');
        }elseif (isset($name) && $name == 'status') {
            $request->session()->forget('productStatusName');
            $request->session()->put('productStatusName', [$name, $direction ]);
            // $query2 = $query2->where('status', $direction);
        }elseif (isset($name) && $name == 'stock_status') {
            $request->session()->forget('productStockStatusName');
            $request->session()->put('productStockStatusName', [$name, $direction ]);
            // $query2 = $query2->where('status', $direction);
        }elseif (isset($name) && $name == 'no_per_page') {
            $request->session()->put('productNumberPerPage', [$name, $direction ]);
        }elseif (isset($name) && $name == 'category_id') {
            $request->session()->put('productCategory_id', [$name, $direction ]);
        }
        elseif(isset($name) && $name == ''){
            $request->session()->put('productStatusName', [$name, $direction ]);
        }

        if(Session::has('productNumberPerPage')){
            if(empty($request->search) || $request->search == '') {
                // dd('hello1');
                $query2 = $query->where('deactivated', false);
            } else {
                // dd('hello2');
                $query2 = $query2;
            }
        } 

        if(Session::has('productSortName')){
            $query2 = $query2->orderBy(Session::get('productSortName.0'), Session::get('productSortName.1') == 'down' ? 'desc' : 'asc');
        }
        if(Session::has('productStatusName') && Session::get('productStatusName.1') != '-'){
            $query2 = $query2->where('status', Session::get('productStatusName.1'));
        } 
        if(Session::has('productStockStatusName') && Session::get('productStockStatusName.1') != '-'){
            $query2 = $query2->where('stock_status', Session::get('productStockStatusName.1'));
        } 
        if(Session::has('productCategory_id') && Session::get('productCategory_id.1') != '-'){
            $query2 = $query2->where('category_id', Session::get('productCategory_id.1'));
        } 

        $products = $query2->paginate(Session::has('productNumberPerPage') ? Session::get('productNumberPerPage.1'): 20)->onEachSide(0);
        $categories = Category::where('deactivated', false)->get();
        return response()->json([
            'products' => $products,
            'categories' => $categories
        ]); 
    }
}
