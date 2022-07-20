<?php namespace Modules\Orders\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * Permission Model Class
 *
 *
 * @category   Models
 * @package    Model
 * @author     Kasun Kalya <kasun.kalya@gmail.com>
 * @copyright  Copyright (c) 2015, Kasun Kalya
 * @version    v1.0.0
 */
class OrdersDetails extends Model{


	/**
	 * table row delete
	 */
	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sales_order_detail';

	/**
	 * The attributes that are not assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = ['deleted_at'];

	/**
	 * get customer each outlet
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
//    public function comments()
//    {
//        return $this->hasMany('App\Comment');
//    }

}
