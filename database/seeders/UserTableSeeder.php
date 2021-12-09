<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username'      => 'admin',
            'employee_id' => 0,
            'level' => 0,
            'password'  => bcrypt('123456'),
            'creator' => 'admin', 
            'editor' => 'admin', 
        ]);
    }
}
