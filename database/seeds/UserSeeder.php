<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $first_user_name = "fist_user";
        $first_user_password = Str::random(10);
        $first_user_api_token = Str::random(60);

        User::create([
            'name' => $first_user_name,
            'password' => $first_user_password,
            'api_token' => $first_user_api_token,
        ]);
    }
}
