<?php
namespace Modules\Product\Http\Requests;

use App\Http\Requests\Request;

class ProductRequest extends Request {

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
