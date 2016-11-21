<?php

namespace App\Models;


class Order extends BaseModel
{
	public function food()
	{
		return $this->hasOne('App\Models\Food','id','food_id');
	}

	public function waiter()
	{
		return $this->hasOne('App\Models\User','id','waiter_id');
	}
}
