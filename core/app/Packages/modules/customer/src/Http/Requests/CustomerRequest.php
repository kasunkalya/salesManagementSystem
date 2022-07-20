<?php
namespace Modules\Customer\Http\Requests;

use App\Http\Requests\Request;

class CustomerRequest extends Request {

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
