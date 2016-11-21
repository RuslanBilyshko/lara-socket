<?php

namespace App\Http\Controllers;

use App\Http\Support\TableLayout;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Requests;

class WaiterController extends Controller
{
    public function index(Order $orders)
    {
	    $user = Auth::user();

	    $orders = $orders::all()->where('waiter_id',$user->id)->sortBy('status');
	    $content = '';

	    if($orders)
	    {

		    $table = new TableLayout();
		    $headers = collect([
			    trans('app.orderNumber'),
			    trans('app.table'),
			    trans('app.food'),
			    trans('app.status'),
			    trans('app.time'),
			    trans('app.send'),

		    ]);

		    $rows = collect();

		    foreach ($orders as $order) {

			    $rows->push([
				    ['class' => 'order-number order-'.$order->id, 'value' => $order->id],
				    ['class' => 'order-table', 'value' => $order->table],
				    ['class' => 'order-food', 'value' => $order->food->name],
				    ['class' => 'order-status '.status_id_food($order->status), 'value' => status_label_food($order->status)],
				    ['class' => 'order-time', 'value' => "0:00"],
				    ['class' => 'send', 'value' => send_order_button($order->id,$order->table,$order->food->name,$order->waiter->name)]
			    ]);
		    }

		    $content = $table->headers($headers)
			    ->rows($rows)
			    ->render();
	    }





      return view('waiter.content',compact('content'));

    }
}
