<?php
namespace Modules\UserManage\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\UserManage\Models\User;
use Modules\UserRoles\Models\UserRole;
use Modules\permissions\Models\Permission;
use Modules\UserManage\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Response;
use Sentinel;
use Hash;
use Activation;


class UserController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| User Controller
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
	 * Show the User add screen to the user.
	 *
	 * @return Response
	 */
	public function addView()
	{
		$user = User::all()->lists('full_name' , 'id' );
		$roles = UserRole::all()->lists('name' , 'id' );		
		return view( 'userManage::user.add' )->with([ 'users' => $user,
			'roles' => $roles
		 ]);;
	}

	/**
	 * Add new user data to database
	 *
	 * @return Redirect to menu add
	 */
	public function add(UserRequest $request)
	{
		
		
		$credentials = [
		    'first_name'    => $request->get( 'first_name' ),
		    'last_name' => $request->get('last_name' ),
		    'email' => $request->get('email' ),
		    'username' => $request->get('username' ),
		    'password' => $request->get('password' ),
		];

		$user = Sentinel::registerAndActivate($credentials);	
		foreach ($request->get( 'roles' ) as $key => $value) {
			$role = Sentinel::findRoleById($value);
	   	    $role->users()->attach($user);
		}
		return redirect('user/add')->with([ 'success' => true,
			'success.message'=> 'User added successfully!',
			'success.title' => 'Well Done!']);
	}

	/**
	 * Show the user add screen to the user.
	 *
	 * @return Response
	 */
	public function listView()
	{
		return view( 'userManage::user.list' );
	}

	/**
	 * Show the user add screen to the user.
	 *
	 * @return Response
	 */
	public function jsonList(Request $request)
	{
		if($request->ajax()){
			 $data= User::get();			
			$jsonList = array();
			$i=1;
			foreach ($data as $key => $user) {
				$dd = array();
				array_push($dd, $i);
				
				if($user->first_name != ""){
					array_push($dd, $user->first_name);
				}else{
					array_push($dd, "-");
				}
				if($user->last_name != ""){
					array_push($dd, $user->last_name);
				}else{
					array_push($dd, "-");
				}

				if($user->email != ""){
					array_push($dd, $user->email);
				}else{
					array_push($dd, "-");
				}
				if($user->username != ""){
					array_push($dd, $user->username);
				}else{
					array_push($dd, "-");
				}
			

				if($user->status == 1){
					array_push($dd, '<label class="switch switch-sm" data-toggle="tooltip" data-placement="top" title="Deactivate"><input class="user-activate" type="checkbox" checked value="'.$user->id.'"><span style="position:inherit;"><i class="handle" style="position:inherit;"></i></span></label>');
				}else{
					array_push($dd, '<label class="switch switch-sm" data-toggle="tooltip" data-placement="top" title="Activate"><input class="user-activate" type="checkbox" value="'.$user->id.'"><span style="position:inherit;"><i class="handle" style="position:inherit;"></i></span></label>');
				}

				$permissions = Permission::whereIn('name',['user.edit','admin'])->where('status','=',1)->lists('name');
				if(Sentinel::hasAnyAccess($permissions)){
					array_push($dd, '<a href="#" class="blue" onclick="window.location.href=\''.url('user/edit/'.$user->id).'\'" data-toggle="tooltip" data-placement="top" title="Edit Menu"><i class="fa fa-pencil"></i></a>');
				}else{
					array_push($dd, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-pencil"></i></a>');
				}

				$permissions = Permission::whereIn('name',['user.delete','admin'])->where('status','=',1)->lists('name');
				if(Sentinel::hasAnyAccess($permissions)){
					array_push($dd, '<a href="#" class="red user-delete" data-id="'.$user->id.'" data-toggle="tooltip" data-placement="top" title="Delete User"><i class="fa fa-trash-o"></i></a>');
				}else{
					array_push($dd, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Delete Disabled"><i class="fa fa-trash-o"></i></a>');
				}

				array_push($jsonList, $dd);
				$i++;
			}
			return Response::json(array('data'=>$jsonList));
		}else{
			return Response::json(array('data'=>[]));
		}
	}


	/**
	 * Activate or Deactivate User
	 * @param  Request $request user id with status to change
	 * @return json object with status of success or failure
	 */
	public function status(Request $request)
	{
		if($request->ajax()){
			$id = $request->input('id');
			$status = $request->input('status');

			$user = User::find($id);
			if($user){
				$user->status = $status;
				$user->save();
				return response()->json(['status' => 'success']);
			}else{
				return response()->json(['status' => 'invalid_id']);
			}
		}else{
			return response()->json(['status' => 'not_ajax']);
		}
	}

	/**
	 * Delete a User
	 * @param  Request $request user id
	 * @return Json           	json object with status of success or failure
	 */
	public function delete(Request $request)
	{
		if($request->ajax()){
			$id = $request->input('id');

			$user = User::find($id);
			if($user){
				$user->delete();
				return response()->json(['status' => 'success']);
			}else{
				return response()->json(['status' => 'invalid_id']);
			}
		}else{
			return response()->json(['status' => 'not_ajax']);
		}
	}

	/**
	 * Show the user edit screen to the user.
	 *
	 * @return Response
	 */
	public function editView($id)
	{
		$user = User::all()->lists('full_name' , 'id' );
	    $curUserold = User::with(['roles'])->where('id',$id)->take(1)->get();;
	    $curUser=$curUserold[0];  
	    $srole = array();
	    foreach ($curUser->roles as $key => $value) {
	    	array_push($srole, $value->id);
	    }
	  

	    $roles = UserRole::all()->lists('name' , 'id' );
		if($curUser){
			return view( 'userManage::user.edit' )->with([ 
				'curUser' => $curUser,
				'users'=>$user,
				'roles'=>$roles,
				'srole'=>$srole

				 ]);
		}else{
			return view( 'errors.404' );
		}
	}

	/**
	 * Add new user data to database
	 *
	 * @return Redirect to menu add
	 */
	public function edit(UserRequest $request, $id)
	{
		//return $request->get('email' );
		$emailcount= User::where('id', '!=', $id)->where('email', '=',$request->get('email' ))->count();
		$usercount= User::where('id', '!=', $id)->where('username', '=',$request->get('username' ))->count();
		if($emailcount==0){
			if($usercount==0){
				$userOld =  User::with(['roles'])->where('id',$id)->take(1)->get();
				$user=$userOld[0];			
				$user->first_name = $request->get('first_name');
				$user->last_name = $request->get('last_name');
				$user->email = $request->get('email' );
				$user->username	=$request->get('username' );	
				foreach ($user->roles as $key => $value) {
					$role = Sentinel::findRoleById($value->id);
					$role->users()->detach($user);				
				}			
			   	
				$user->save();
				//attach user for role
				foreach ($request->get( 'roles' ) as $key => $value) {
					$role = Sentinel::findRoleById($value);
			   	    $role->users()->attach($user);
				}
				return redirect( 'user/list' )->with([ 'success' => true,
					'success.message'=> 'User updated successfully!',
					'success.title' => 'Good Job!' ]);
			}else{
				return redirect('user/edit/'.$id)->with([ 'error' => true,
				'error.message'=> 'User Already Exsist!',
				'error.title' => 'Duplicate!']);
			}

		}else{
				return redirect('user/edit/'.$id)->with([ 'error' => true,
				'error.message'=> 'Email Already Exsist!',
				'error.title' => 'Duplicate!']);
		}
   
		
	}
}
