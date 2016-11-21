<?php

use App\Models\Role;
use Illuminate\Database\Seeder;


class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
          'id' => 1,
          'name' => 'administrator',
        ]);

        Role::create([
          'id' => 2,
          'name' => 'waiter',
        ]);

        Role::create([
          'id' => 3,
          'name' => 'cook',
        ]);
    }
}
