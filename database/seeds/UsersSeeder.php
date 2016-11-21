<?php


use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
          'id' => 1,
          'name' => 'admin',
          'email' => 'admin@i.ua',
          'password' => bcrypt('admin'),
          'role_id' => 1,
        ]);

      User::create([
        'id' => 2,
        'name' => 'waiter',
        'email' => 'waiter@i.ua',
        'password' => bcrypt('waiter'),
        'role_id' => 2,
      ]);

      User::create([
        'id' => 3,
        'name' => 'cook',
        'email' => 'cook@i.ua',
        'password' => bcrypt('cook'),
        'role_id' => 3,
      ]);
    }
}
