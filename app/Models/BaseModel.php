<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public static function toSelect($trans = true)
    {
        $all = self::all();
        $result = [];

        $result[null] = trans('app.select');

        foreach($all as $item) {
            $result[$item->id] = $trans ? trans('app.'.$item->name) : $item->name;
        }

        return $result;
    }
}