<?php

define('ROLE_ADMIN',1);
define('ROLE_WAITER',2);
define('ROLE_COOK',3);

define('STATUS_PREPARING',0);
define('STATUS_READY',1);
define('STATUS_WAITING',-1);

if(!function_exists('to_select_range')) {

	function to_select_range($start,$finish) {

		$result = [];
		$result[null] = trans('app.select');

		for($i = $start; $i <= $finish; $i++) {

			$result[$i] = $i;
		}

		return $result;

	}

}

if(!function_exists('status_label_food')) {

	function status_label_food($status) {

		$result = '';
		switch($status) {
			case STATUS_PREPARING:
				$result = trans('app.preparing');
				break;
			case STATUS_READY:
				$result = trans('app.ready');
				break;
			case STATUS_WAITING:
				$result = trans('app.waiting');
				break;
		}

		return $result;

	}

}

if(!function_exists('status_id_food')) {

	function status_id_food($status){
		$result = '';
		switch($status) {
			case STATUS_PREPARING:
				$result = 'info';
				break;
			case STATUS_READY:
				$result = 'success';
				break;
			case STATUS_WAITING:
				$result = 'warning';
				break;
		}

		return $result;
	}
}

if(!function_exists('status_button_food')) {
	function status_button_food($status) {

		$data_source = link_to(route('home'));

		return '<button data-source="'.$data_source.'" data-status="'.status_id_food($status).'" type="button" class="btn btn-'.status_id_food($status).' btn-xs">'.status_label_food($status).'</button>';
	}
}

if(!function_exists('send_order_button')) {
	function send_order_button($number,$table,$food,$waiter) {

		return '<button data-number="'.$number.'" data-table="'.$table.'" data-food="'.$food.'" data-waiter="'.$waiter.'" type="button" class="send-order btn btn-default btn-xs">'.trans('app.send').'</button>';
}
}