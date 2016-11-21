<?php

namespace App\Http\Controllers;

use App\Http\Support\TableLayout;
use App\Models\Order;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class CookController extends Controller
{
    public function index(Order $orders)
    {
	    $user = Auth::user();

	    $orders = $orders::all()->sortBy('status');
	    $content = '';

	    if($orders)
	    {

		    $table = new TableLayout();
		    $headers = collect([
			    trans('app.orderNumber'),
			    trans('app.table'),
			    trans('app.food'),
			    trans('app.time'),
			    trans('app.waiter'),
			    trans('app.status'),


		    ]);

		    $rows = collect();

		    /*foreach ($orders as $order) {

			    $rows->push([
				    ['class' => 'order-table', 'value' => $order->table],
				    ['class' => 'order-food', 'value' => $order->food->name],
				    ['class' => 'order-time', 'value' => "0:00"],
				    ['class' => 'order-waiter', 'value' => $order->waiter->name],
				    ['class' => 'order-status '.status_id_food($order->status), 'value' => status_label_food($order->status)],

			    ]);
		    }*/

		    $content = $table->headers($headers)
			    ->rows($rows)
			    ->render();
	    }


      return view('cook.content',compact('content'));
    }
}
