<?php

namespace App\Http\Controllers;

use App\Http\Support\TableLayout;
use App\Models\Food;
use App\Models\Order;
use Form;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;



class OrderController extends Controller
{

  public function index(Order $orders)
  {

    $orders = $orders::all()->sortBy('status');
    $content = '';

    if($orders)
    {
      $table = new TableLayout();
      $headers = collect([
        trans('app.orderNumber'),
        trans('app.table'),
        trans('app.food'),
        trans('app.status'),
        trans('app.waiter'),
        //trans('app.updated'),
        trans('app.edit'),
      ]);

      $rows = collect();

      foreach ($orders as $order) {

	      $status_form = Form::model($order, array('url' => route('order.changeStatus'), 'data-status' => status_id_food($order->status), 'class' => 'status-form', 'id' => 'status-form-'.$order->id));
	      $status_form .= Form::hidden('id',$order->id);
	      $status_form .= Form::hidden('status',$order->status);
	      $status_form .= Form::button(
		      status_label_food($order->status),
		      array(
			      'class' => 'btn btn-'.status_id_food($order->status).' btn-xs',
			      'type' => 'submit',
			      //'onclick' => 'send()'
		      )
	      );
	      $status_form .= Form::close();

        $rows->push([
	        ['class' => 'order-number', 'value' => $order->id],
	        ['class' => 'order-table', 'value' => $order->table],
	        ['class' => 'order-food', 'value' => $order->food->name],
	        ['class' => 'order-status', 'value' => $status_form],
	        ['class' => 'order-waiter', 'value' => $order->waiter->name],
	        //'class' => 'order-updated_at', 'value' => $order->updated_at],
	        ['class' => 'order-link', 'value' => link_to(route('order.edit',[$order->id]),trans('app.edit'))],

        ]);
      }

      $content = $table->headers($headers)
        ->rows($rows)
        ->render();
    }

	  $title = trans('app.orderList');


    return view('order.list',compact('content','title'));


  }

  public function create()
  {
    $order = new Order();
    $foods = Food::toSelect(false);
    $uid = Auth::user()->id;
    return view('order.create', compact('order','foods','uid'));
  }

  public function store(Request $request)
  {
    //dd($user);
    $this->validate($request, [
      'table' => 'required',
      'food_id' => 'required',
    ]);

    $order = new Order();
    $order->table = $request->table;
    $order->food_id = $request->food_id;
    $order->status = STATUS_PREPARING;
    $order->waiter_id = $request->waiter_id;
    $order->save();

	  $role = Auth::user()->role_id;
	  if($role == ROLE_ADMIN) {
		  return redirect(route('order.list'));
	  }
	  elseif ($role == ROLE_WAITER) {

		  return redirect(route('waiter.list'));
	  }


  }

  public function edit($order)
  {
    $foods = Food::toSelect(false);
    $uid = Auth::user()->id;
    return view('order.edit',compact('order','foods','uid'));
  }

  public function update(Request $request,$order)
  {
    $this->validate($request, [
      'table' => 'required',
      'food_id' => 'required',
    ]);

    $order->table = $request->table;
    $order->food_id = $request->food_id;
    $order->waiter_id = $request->waiter_id;
    $order->update();

    return redirect(route('order.list'));

  }

	public function changeStatus(Request $request)
	{
		$order = Order::find($request->id);

		switch($request->status) {
			case STATUS_WAITING:
				$order->status = STATUS_PREPARING;
				break;
			case STATUS_PREPARING:
				$order->status = STATUS_READY;
				break;
			case STATUS_READY:
				$order->status = STATUS_WAITING;
				break;

		}

		$order->update();
		return redirect(route('order.list'));
	}

}
