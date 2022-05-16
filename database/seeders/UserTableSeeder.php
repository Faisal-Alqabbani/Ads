<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker= new Faker();
        for ($i = 0; $i < 5; $i++) {
            DB::table('users')->insert([
                'name' => "user".rand(1,5),
                'email' => "user".rand(1,100)."@gamil.com",
                'password' => bcrypt('password'),
                ]);
        }
    }
}
