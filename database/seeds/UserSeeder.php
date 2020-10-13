<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::whereEmail('admin@gmail.com')->first();
        if(is_null($user)){
        	$user = User::create([
        		'name' => 'admin',
				'email' => 'admin@gmail.com',
				'password' => \Illuminate\Support\Facades\Hash::make(Str::random(24))
			]);
        	$user->save();
		}
    }
}
