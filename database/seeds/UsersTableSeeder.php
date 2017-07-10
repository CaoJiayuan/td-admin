<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    \App\User::create([
      'name'     => 'Admin',
      'email'    => '1@admin.com',
      'password' => bcrypt(123456),
    ]);
  }
}
