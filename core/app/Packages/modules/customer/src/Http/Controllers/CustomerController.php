<?php
namespace Modules\Customer\Http\Controllers;

use Modules\Permissions\Models\Permission;

use App\Http\Controllers\Controller;
use Modules\Permissions\Http\Requests\PermissionRequest;
use Illuminate\Http\Request;
use Modules\Customer\Models\Customer;
use Modules\Customer\Http\Requests\CustomerRequest;
use Sentinel;
use Response;
use Hash;
use Activation;
use GuzzleHttp;
use DB;

class CustomerController extends Controller {

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

                return view( 'customer::add' );

	}

	/**
	 * Add new menu data to database
	 *
	 * @return Redirect to menu add
	 */
	public function add(CustomerRequest $request)
	{
                $user = Sentinel::getUser();
                $customer= Customer::where('email','=',$request->customerEmail)->get();

                if($customer->count() != 0){
                        return redirect( 'customer/add' )->with([ 'warning' => true,
			'warning.message' => 'This customer already added!',
			'warning.title'   => 'Error' ]);
                }else{
                        $customerRoute= Customer::create([
                            'customer_Name'=>$request->customerName,  
							'email'=>$request->customerEmail,
							'mobile'=>$request->customerMobile,                         
                            'created_by'=>$user->id		

                        ]);              
		       return redirect( 'customer/add' )->with([ 'success' => true,
			'success.message' => 'Customer added successfully!',
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
		return view( 'customer::list' );
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function jsonList(Request $request)
	{
		//if($request->ajax()){
			$data = Customer::all();
			$jsonList = array();
			$i=1;
			foreach ($data as $value) {
				$rowData= array();
                array_push($rowData,$i);  
				array_push($rowData,$value->customer_Name);
				array_push($rowData,$value->email);
				array_push($rowData,$value->mobile);
				$permissions = Permission::whereIn('name', ['customer.edit', 'admin'])->where('status', '=', 1)->lists('name');

				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('customer/edit/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="Edit Product"><i class="fa fa-pencil"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-pencil"></i></a>');
				}
                                
                $permissions = Permission::whereIn('name', ['customer.view', 'admin'])->where('status', '=', 1)->lists('name');

				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('customer/view/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="View Product"><i class="fa fa-eye"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="View Disabled"><i class="fa fa-eye"></i></a>');
				}                                  
				$permissions = Permission::whereIn('name', ['customer.delete', 'admin'])->where('status', '=', 1)->lists('name');
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

			$customer = Customer::find($id);
			if($customer){
				$customer->delete();
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
		
        $customer= Customer::where('id','=',$id)->get();
		if($customer){
                    return view( 'customer::edit' )->with([
                        'customer' =>$customer
                    ]);
		}else{
			return view( 'errors.404' )->with(['customer' => $customer ]);
		}
	}

	/** 
	 * Add new menu data to database
	 *
	 * @return Redirect to menu add
	 */
	public function edit(CustomerRequest $request, $id)
	{
                $customerIsIn= Customer::where('email','=',$request->customerEmail)->where('id','!=',$id)->get();
  
                if($customerIsIn->count() != 0){
                        return redirect( 'customer/edit/'.$id )->with([ 'warning' => true,
			            'warning.message' => 'This customer already added!',
			            'warning.title'   => 'Error' ]);
                }else{
                        $user = Sentinel::getUser();  
                        $customer = Customer::find($id); 

                            $customer->customer_Name= $request->customerName;                            
                            $customer->email=$request->customerEmail;		
							$customer->mobile=$request->customerMobile;
							$customer->created_by=$user->id;
		                    $customer->save();    
		    return redirect('customer/list')->with([ 'success' => true,
			'success.message'=> 'Customer Update successfully!',
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
        $customer= Customer::where('id','=',$id)->get();
		if($customer){
                            return view( 'customer::view' )->with([
                                'customer' =>$customer
                            ]);
		}else{
			return view( 'errors.404' )->with(['customer' => $customer ]);
		}
	}
        
      
        
}
