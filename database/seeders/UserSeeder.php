<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserRole;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
			[
				'id' => 1,
				'name' => 'Admin',
				'email' => 'admin@admin.com',
				'status' => 1,
				'password' => \Hash::make('password'),
				'remember_token' => null,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			],
		];
		if (User::insert($users)) {
			$newUser = UserRole::updateOrCreate([
				'user_id' => 1,
			], [
				'role_id' => 1,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			]);
		}
    }
}
