<?php namespace App\Http\Controllers;

use App\Models\Menu;
use Sentinel;
use Modules\Product\Models\Product;
use Response;
use DB;


class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
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
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
                $years = array();
                for($i = date('Y');$i>=2000 ;$i--)
                {             
                    $years["$i"] = $i; 
                }
                
            $product = Product::all()->lists('product_Name' , 'id' )->prepend('All Products','all');	
		return view( 'dashboard' )->with([            
                    'product' => $product,
                    'year'=>  $years
		]);
    	
	}
        
        
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

	public function test()
	{
		return 'Hooray';
		//return Menu::create(['label'=>'Add Menu','link'=>'menu/add','icon'=>'','parent'=>'2','menu_sort'=>2,'level'=>1,'permissions'=>'["menu.add"]']);
		//return Sentinel::registerAndActivate(['username'=>'super.admin','password'=>'123456','email'=>'admin@admin.lk','first_name'=>'Super','last_name'=>'Administrator']);
	}



}
