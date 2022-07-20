<?php
namespace Modules\Orders\Http\Controllers;

use Modules\Permissions\Models\Permission;

use App\Http\Controllers\Controller;
use Modules\Permissions\Http\Requests\PermissionRequest;
use Illuminate\Http\Request;
use Modules\Product\Models\Product;
use Modules\Customer\Models\Customer;

use Modules\Orders\Models\OrdersDetails;
use Modules\Orders\Models\Orders;
use Modules\Product\Http\Requests\ProductRequest;
use Modules\Orders\Http\Requests\OrdersRequest;
use Sentinel;
use Response;
use Hash;
use Activation;
use GuzzleHttp;
use DB;

class OrdersController extends Controller {

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
		$customer = Customer::all()->lists('customer_Name' , 'id' );
		$product = Product::all();
	
		return view( 'orders::add' )->with([
                    'customer' => $customer,	
                    'product' => $product
		]);
	
	}

	/**
	 * Add new menu data to database
	 *
	 * @return Redirect to menu add
	 */
	public function add(OrdersRequest $request)
	{
                $user = Sentinel::getUser();
               
                        $order= Orders::create([
                            'customer'=>$request->customer,   
                            'order_Date'=>$request->orderDate,                        
                            'created_by'=>$user->id		

                        ]);          
						$orderId=$order->id;

						for ($i = 0; $i < sizeof($request->quantity); $i++) {							
							if($request->quantity[$i] !=0){
								$orderList= OrdersDetails::create([
									'orderId'=>$orderId,   
									'products'=>$request->product[$i],     
									'itemCount'=>$request->quantity[$i],  
									'unitPrice'=>$request->unitprice[$i]		
								]);  
							}
						};
					
					

		       return redirect( 'orders/edit/'.$orderId )->with([ 'success' => true,
			'success.message' => 'Product added successfully!',
			'success.title'   => 'Well Done!' ]);
                
                   
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function listView()
	{
		return view( 'orders::list' );
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function jsonList(Request $request)
	{
		//if($request->ajax()){
			$data = DB::table('sale_orders')
			->join('customer', 'customer.id', '=', 'sale_orders.customer')
			->select('sale_orders.*', 'customer.customer_Name')
			->get();
			$jsonList = array();
			$i=1;
			foreach ($data as $value) {
				$rowData= array();
                array_push($rowData,$i);  
				array_push($rowData,$value->customer_Name);
                array_push($rowData,$value->order_Date);
				$permissions = Permission::whereIn('name', ['order.edit', 'admin'])->where('status', '=', 1)->lists('name');

				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('orders/edit/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="Edit Order"><i class="fa fa-pencil"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-pencil"></i></a>');
				}
                                
                                $permissions = Permission::whereIn('name', ['order.view', 'admin'])->where('status', '=', 1)->lists('name');

				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('orders/view/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="View Order"><i class="fa fa-eye"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="View Disabled"><i class="fa fa-eye"></i></a>');
				}                                  
				$permissions = Permission::whereIn('name', ['order.delete', 'admin'])->where('status', '=', 1)->lists('name');
				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="red type-delete" data-id="' . $value->id . '" data-toggle="tooltip" data-placement="top" title="Delete Order"><i class="fa fa-trash-o"></i></a>');
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
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function jsonorderList($year,$product)
	{
         $fromDate=$year.'-01-01';
         $toDate=$year.'-12-31';
		//if($request->ajax()){
			$data = DB::table('sale_orders')
			->join('sales_order_detail', 'sales_order_detail.orderId', '=', 'sale_orders.id')
			->select(           
                            DB::raw("(COUNT(*)) as count"),    
                            DB::raw("MONTHNAME(sale_orders.order_Date) as month_name"),'sales_order_detail.products');
                        
                        if($product !='all'){
                            $data =$data->where('sales_order_detail.products',$product);
                        }
                        $data =$data->whereBetween('sale_orders.order_Date', [$fromDate, $toDate]);
                        $data =$data->groupBy('month_name')                        
			->get();
			$jsonList = array();
			$i=1;
			foreach ($data as $value) {
				$rowData= array();
                                array_push($rowData,$i);  
                                array_push($rowData,$value->month_name);
                                array_push($rowData,$value->count);
                                array_push($rowData,$value->products);	
                                
				array_push($jsonList, $rowData);
				$i++;

			}
                        
			return Response::json($jsonList);

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
			$product = DB::table('sale_orders')->where('id', '=', $id)->delete();
			if($product){			
				$deleted = DB::table('sales_order_detail')->where('orderId', '=', $id)->delete();
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

		$customer = Customer::all()->lists('customer_Name' , 'id' );
		$product = Product::all();	
			
		$orders= DB::table('sale_orders')->where('id','=',$id)->get();
		$orderList= DB::table('sales_order_detail')->where('orderId','=',$id)->get();
		if($product){     
							return view( 'orders::edit' )->with([
								'orders' => $orders,
								'orderList' => $orderList,	
								'customer' => $customer,	
								'product' => $product
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
	public function edit(OrdersRequest $request, $id)
	{           


		$user = Sentinel::getUser();
     
		$affected = DB::table('sale_orders')
		->where('id', $id)
		->update(['customer' => $request->customer,'order_Date'=> $request->orderDate,'created_by'=>$user->id]);

		$deleted = DB::table('sales_order_detail')->where('orderId', '=', $id)->delete();

		for ($i = 0; $i < sizeof($request->quantity); $i++) {							
			if($request->quantity[$i] !=0){
				$orderList= OrdersDetails::create([
					'orderId'=>$id,   
					'products'=>$request->product[$i],     
					'itemCount'=>$request->quantity[$i],  
					'unitPrice'=>$request->unitprice[$i]		
				]);  
			}
		};       
                         
		return redirect('orders/edit/'.$id)->with([ 'success' => true,
			'success.message'=> 'Order Update successfully!',
			'success.title' => 'Well Done!']);
           
	}
        
           
        /**
	 * Show the menu edit screen to the user.
	 *
	 * @return Response
	 */
	public function viewView($id)
	{	
                $customer = Customer::all()->lists('customer_Name' , 'id' );
		$product = Product::all();	
			
		$orders= DB::table('sale_orders')->where('id','=',$id)->get();
		$orderList= DB::table('sales_order_detail')->where('orderId','=',$id)->get();
		if($product){     
							return view( 'orders::view' )->with([
								'orders' => $orders,
								'orderList' => $orderList,	
								'customer' => $customer,	
								'product' => $product
							]);
		}else{
			return view( 'errors.404' )->with(['product' => $product ]);
		}
	}
        
      
        
	/**
	 * Delete a Menu
	 * @param  Request $request menu id
	 * @return Json           	json object with status of success or failure
	 */
	public function deleteitem(Request $request)
	{
		if($request->ajax()){
			$id = $request->input('id');
			$product = DB::table('sales_order_detail')->where('id', '=', $id)->delete();$deleted = DB::table('sales_order_detail')->where('orderId', '=', $id)->delete();
			
			if($product){			
				return response()->json(['status' => 'success']);
			}else{
				return response()->json(['status' => 'invalid_id']);
			}
		}else{
			return response()->json(['status' => 'not_ajax']);
		}
	}
        
}
