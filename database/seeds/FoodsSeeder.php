<?php

use App\Models\Food;
use Illuminate\Database\Seeder;

class FoodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Food::create([
          'name' => 'Борщ по Украински',
        ]);
        Food::create([
          'name' => 'Суп Харче',
        ]);
        Food::create([
          'name' => 'Пюре картофельное',
        ]);
        Food::create([
          'name' => 'Салат Оливье',
        ]);
        Food::create([
          'name' => 'Греческий салат',
        ]);

    }
}
