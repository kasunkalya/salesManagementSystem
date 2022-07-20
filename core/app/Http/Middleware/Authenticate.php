<?php namespace App\Http\Middleware;

use Closure;
use Sentinel;
use Session;
use Route;
use Request;
use Modules\MenuManage\Models\Menu;
use Modules\Permissions\Models\Permission;
use App\Classes\DynamicMenu;
class Authenticate {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		try{
			if (!Sentinel::check())
	    	{
					Session::put('loginRedirect', $request->url());
					return redirect()->route('user.login');;
			}else{
				$user = Sentinel::getUser();
				$action = Route::currentRouteName();
				$permissions = Permission::whereIn('name',[$action,'admin'])->where('status','=',1)->lists('name');
				if (!$user->hasAnyAccess($permissions)) {
					return response()->view('errors.restricted');
				}
			}
		}catch(\Exception $e){
			Session::put('loginRedirect', $request->url());
			return redirect()->route('user.login');;
		}

	    $menu = Menu::where('label', '=', 'Root Menu')->first()->getDescendants()->toHierarchy(); // Get all menus
	    $currentMenu = Menu::where('link','=',Request::path())->where('status','=',1)->first(); //Get the id of Current Route Url

	    if($currentMenu)
	      $aa = DynamicMenu::generateMenu(0,$menu,0,$currentMenu,Sentinel::getUser()->id); //Generate Menu with current url id
	    else
	      $aa = DynamicMenu::generateMenu(0,$menu,0,null,Sentinel::getUser()->id); //Generate Menu without current url id

	    view()->share('menu',$aa); //Share the generated menu with all views
	    view()->share('user',$user);

		return $next($request);
	}

}
