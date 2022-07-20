<?php
namespace Modules\Product\Http\Controllers;

use Modules\Permissions\Models\Permission;

use App\Http\Controllers\Controller;
use Modules\Permissions\Http\Requests\PermissionRequest;
use Illuminate\Http\Request;
use Modules\Product\Models\Product;
use Modules\Product\Http\Requests\ProductRequest;
use Sentinel;
use Response;
use Hash;
use Activation;
use GuzzleHttp;
use DB;

class ProductController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Permission Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('guest');
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function addView()
	{

                return view( 'product::add' );
	
	}

	/**
	 * Add new menu data to database
	 *
	 * @return Redirect to menu add
	 */
	public function add(ProductRequest $request)
	{
                $user = Sentinel::getUser();
                $product= Product::where('product_Name','=',$request->productName)->get();

                if($product){
                        return redirect( 'product/add' )->with([ 'warning' => true,
			'warning.message' => 'This product already added!',
			'warning.title'   => 'Error' ]);
                }else{
                        $transportaRoute= Product::create([
                            'product_Name'=>$request->productName,  
							'unit_Price'=>$request->unitPrice,                         
                            'created_by'=>$user->id		

                        ]);              
		       return redirect( 'product/add' )->with([ 'success' => true,
			'success.message' => 'Product added successfully!',
			'success.title'   => 'Well Done!' ]);
                }
                   
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function listView()
	{
		return view( 'product::list' );
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function jsonList(Request $request)
	{
		//if($request->ajax()){
			$data = Product::all();
			$jsonList = array();
			$i=1;
			foreach ($data as $value) {
				$rowData= array();
                                array_push($rowData,$i);  
				array_push($rowData,$value->product_Name);
				array_push($rowData,$value->unit_Price);

				$permissions = Permission::whereIn('name', ['product.edit', 'admin'])->where('status', '=', 1)->lists('name');

				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('product/edit/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="Edit Product"><i class="fa fa-pencil"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-pencil"></i></a>');
				}
                                
                                $permissions = Permission::whereIn('name', ['product.view', 'admin'])->where('status', '=', 1)->lists('name');

				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('product/view/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="View Product"><i class="fa fa-eye"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="View Disabled"><i class="fa fa-eye"></i></a>');
				}                                  
				$permissions = Permission::whereIn('name', ['product.delete', 'admin'])->where('status', '=', 1)->lists('name');
				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="red type-delete" data-id="' . $value->id . '" data-toggle="tooltip" data-placement="top" title="Delete Product"><i class="fa fa-trash-o"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Delete Disabled"><i class="fa fa-trash-o"></i></a>');
				}

				array_push($jsonList, $rowData);
				$i++;

			}
			return Response::json(array('data' => $jsonList));

		//}else{
			//return Response::json(array('data'=>[]));
		//}
	}



	/**
	 * Delete a Menu
	 * @param  Request $request menu id
	 * @return Json           	json object with status of success or failure
	 */
	public function delete(Request $request)
	{
		if($request->ajax()){
			$id = $request->input('id');

			$product = product::find($id);
			if($product){
				$product->delete();
				return response()->json(['status' => 'success']);
			}else{
				return response()->json(['status' => 'invalid_id']);
			}
		}else{
			return response()->json(['status' => 'not_ajax']);
		}
	}

	/**
	 * Show the menu edit screen to the user.
	 *
	 * @return Response
	 */
	public function editView($id)
	{	
		
                $product= Product::where('id','=',$id)->get();
		if($product){
                            return view( 'product::edit' )->with([
                                'product' =>$product
                            ]);
		}else{
			return view( 'errors.404' )->with(['product' => $product ]);
		}
	}

	/** 
	 * Add new menu data to database
	 *
	 * @return Redirect to menu add
	 */
	public function edit(ProductRequest $request, $id)
	{
		  
                $productIsIn= Product::where('product_Name','=',$request->productName)->where('id','!=',$id)->get();
   
                if($productIsIn->count() != 0){
                        return redirect( 'product/edit/'.$id )->with([ 'warning' => true,
			            'warning.message' => 'This product already added!',
			            'warning.title'   => 'Error' ]);
                }else{
                        $user = Sentinel::getUser();  
                        $product = Product::find($id); 
                        $product->product_Name= $request->productName;    
                        $product->unit_Price= $request->unitPrice;    
                        $product->created_by=$user->id;	               
		                $product->save();    
		return redirect('product/list')->with([ 'success' => true,
			'success.message'=> 'Product Update successfully!',
			'success.title' => 'Well Done!']);
                }
	}
        
           
        /**
	 * Show the menu edit screen to the user.
	 *
	 * @return Response
	 */
	public function viewView($id)
	{	
                $product= Product::where('id','=',$id)->get();
		if($product){
                            return view( 'product::view' )->with([
                                'product' =>$product
                            ]);
		}else{
			return view( 'errors.404' )->with(['product' => $product ]);
		}
	}
        
      /**
	 * Show the menu edit screen to the user.
	 *
	 * @return Response
	 */
	public function details(ProductRequest $request)
	{	
		
        $product= Product::where('id','=',$request->id)->get();
		if($product){
			return Response::json( $product);
          
		}
	}
        
}
