<?php
namespace Modules\Orders\Http\Requests;

use App\Http\Requests\Request;

class OrdersRequest extends Request {

	public function authorize(){
		return true;
	}

	public function rules(){
		$rules = [
//			'code' => 'required',
//			'name' => 'required'
			];
		return $rules;
	}

}
